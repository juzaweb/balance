<?php

namespace Juzaweb\Balance\Actions;

use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\CMS\Models\User;

class BalanceAction extends Action
{
    /**
     * Execute the actions.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->addFilter('user.resouce_data', [$this, 'addBananceToTheme'], 20, 2);
    }

    public function addBananceToTheme(array $data, User $user): array
    {
        $data['balance'] = $user->balance;

        return $data;
    }
}
