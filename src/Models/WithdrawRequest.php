<?php

namespace Juzaweb\Balance\Models;

use Juzaweb\CMS\Models\Model;
use Juzaweb\CMS\Repositories\Traits\PresentableTrait;
use Juzaweb\CMS\Traits\UUIDPrimaryKey;

/**
 * Juzaweb\Balance\Models\WithdrawRequest
 *
 * @property string $id
 * @property int $user_id
 * @property float $amount
 * @property string|null $note
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $status_label
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawRequest whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawRequest whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawRequest whereUserId($value)
 * @property string|null $payment_method
 * @property string|null $payment_email
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawRequest wherePaymentEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawRequest wherePaymentMethod($value)
 * @mixin \Eloquent
 */
class WithdrawRequest extends Model
{
    use PresentableTrait, UUIDPrimaryKey;

    protected $keyType = 'string';

    protected $table = 'balance_withdraw_requests';

    protected $fillable = [
        'user_id',
        'amount',
        'status',
        'note',
        'payment_method',
        'payment_email',
    ];

    protected $casts = ['amount' => 'float'];
    protected $appends = ['status_label'];

    public const STATUS_PENDING = 'pending';
    public const STATUS_PAID = 'paid';
    public const STATUS_DENY = 'deny';

    public function getAmount(): string
    {
        return "$" . $this->amount;
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            static::STATUS_PAID => __('Paid'),
            self::STATUS_DENY => __('Deny'),
            default => __('Pending'),
        };
    }
}
