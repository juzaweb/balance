<?php

namespace Juzaweb\Balance\Providers;

use Juzaweb\Balance\Actions\BalanceAction;
use Juzaweb\Balance\Models\WithdrawRequest;
use Juzaweb\Balance\Repositories\WithdrawRequestRepository;
use Juzaweb\Balance\Repositories\WithdrawRequestRepositoryEloquent;
use Juzaweb\CMS\Facades\MacroableModel;
use Juzaweb\CMS\Models\User;
use Juzaweb\CMS\Support\ServiceProvider;

class BalanceServiceProvider extends ServiceProvider
{
    public array $bindings = [
        WithdrawRequestRepository::class => WithdrawRequestRepositoryEloquent::class,
    ];

    public function boot(): void
    {
        $this->registerHookActions([BalanceAction::class]);

        MacroableModel::addMacro(
            User::class,
            'balanceWithdrawRequests',
            function () {
                /**
                 * @var User $this
                 */
                return $this->hasMany(WithdrawRequest::class, 'user_id', 'id');
            }
        );
    }

    public function register()
    {
        //
    }
}
