<?php

namespace Juzaweb\Balance\Http\Controllers\Frontend;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Juzaweb\Balance\Events\WithdrawRequestSuccess;
use Juzaweb\Balance\Repositories\WithdrawRequestRepository;
use Juzaweb\CMS\Http\Controllers\FrontendController;
use Juzaweb\CMS\Models\User;
use Juzaweb\Juzacms\Http\Requests\Frontend\Profile\WithdrawRequest;
use Juzaweb\Juzacms\Repositories\Presenters\WithdrawRequestPresenter;

class WithdrawController extends FrontendController
{
    public function __construct(protected WithdrawRequestRepository $withdrawRequestRepository)
    {
    }

    public function index(Request $request, $page)
    {
        $withdrawRequests = $this->withdrawRequestRepository
            ->setPresenter(WithdrawRequestPresenter::class)
            ->scopeQuery(fn($q) => $q->where(['user_id' => $request->user()->id]))
            ->paginate(10);

        $title = $page['title'];

        return $this->view(
            'theme::profile.withdraw.index',
            compact('title', 'withdrawRequests')
        );
    }

    public function withdraw(Request $request)
    {
        $title = __('New Withdraw Request');

        return $this->view(
            'theme::profile.withdraw.create',
            compact('title')
        );
    }

    /**
     * @throws \Throwable
     */
    public function doWithdraw(WithdrawRequest $request): JsonResponse|RedirectResponse
    {
        DB::transaction(fn() => $this->createNewWithdrawRequest($request));

        return $this->success(
            [
                'message' => __('Withdraw Request successful'),
                'redirect' => route('profile', ['withdraw'])
            ]
        );
    }

    protected function createNewWithdrawRequest(Request $request): void
    {
        /**
         * @var User $user
         */
        $user = $request->user();
        $data = $request->only(['amount', 'payment_email']);
        $data['user_id'] = $user->id;

        $withdraw = $this->withdrawRequestRepository->create($data);
        $user->decrement('balance', $withdraw->amount);

        event(new WithdrawRequestSuccess($withdraw));
    }
}
