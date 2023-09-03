<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\Balance\Repositories\Transformers;

use Juzaweb\Balance\Models\WithdrawRequest;
use League\Fractal\TransformerAbstract;

class WithdrawRequestTransformer extends TransformerAbstract
{
    public function transform(WithdrawRequest $withdrawRequest): array
    {
        return [
            'id' => $withdrawRequest->id,
            'amount' => $withdrawRequest->getAmount(),
            'note' => $withdrawRequest->note,
            'status' => $withdrawRequest->status,
            'status_label' => $withdrawRequest->status_label,
            'created_at' => jw_date_format($withdrawRequest->created_at),
        ];
    }
}
