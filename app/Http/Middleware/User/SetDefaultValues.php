<?php
namespace App\Http\Middleware\User;

use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\PurchaseLogRepositoryInterface;
use App\Services\UserServiceInterface;

class SetDefaultValues
{
    /** @var UserServiceInterface */
    protected $userService;

    /** @var CategoryRepositoryInterface */
    protected $categoryRepository;

    /** @var v */
    protected $purchaseLogRepository;

    /**
     * Create a new filter instance.
     *
     * @param UserServiceInterface $userService
     */
    public function __construct(
        UserServiceInterface $userService,
        CategoryRepositoryInterface $categoryRepository,
        PurchaseLogRepositoryInterface $purchaseLogRepository
    ) {
        $this->userService           = $userService;
        $this->categoryRepository    = $categoryRepository;
        $this->purchaseLogRepository = $purchaseLogRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        $user        = $this->userService->getUser();
        $expiredTime = '';

        if (!empty($user) && $user->points > 0) {
            $purchase = $this->purchaseLogRepository->findLastPurchaseByUserId($user->id);
            if (!empty($purchase)) {
                $expiredTime = $purchase->point_expired_at;
            }
        }
        \View::share('authUser', $user);
        \View::share('expiredTime', $expiredTime);
        $nameJa    = '';
        $nameEn    = '';
        $order     = 'id';
        $direction = 'asc';
        $offset    = 0;
        $limit     = 6;

        return $next($request);
    }
}
