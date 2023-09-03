<?php

namespace Juzaweb\Balance\Repositories;

use Juzaweb\Balance\Models\WithdrawRequest;
use Juzaweb\CMS\Repositories\BaseRepositoryEloquent;
use Juzaweb\CMS\Traits\Criterias\UseFilterCriteria;
use Juzaweb\CMS\Traits\Criterias\UseSortableCriteria;

class WithdrawRequestRepositoryEloquent extends BaseRepositoryEloquent implements WithdrawRequestRepository
{
    use UseFilterCriteria, UseSortableCriteria;

    protected array $filterableFields = ['user_id'];
    protected array $sortableDefaults = ['created_at' => 'DESC'];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return WithdrawRequest::class;
    }
}
