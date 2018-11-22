<?php namespace Tests\Services;

use Carbon\Carbon;
use Tests\TestCase;

class PointServiceTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Services\PointServiceInterface $service */
        $service = \App::make(\App\Services\PointServiceInterface::class);
        $this->assertNotNull($service);
    }

    public function testUpdateUserPoints()
    {
        /** @var  \App\Services\PointServiceInterface $service */
        $service = \App::make(\App\Services\PointServiceInterface::class);
        $userRepository = \App::make(\App\Repositories\UserRepositoryInterface::class);
        $user = factory(\App\Models\User::class)->create();

        $point01 = rand(1, 10);
        $point02 = rand(1, 10);

        $purchaseLog01 = factory(\App\Models\PurchaseLog::class)->create([
                'user_id'                => $user->id,
                'purchase_method_type'   => 'paypal',
                'point_amount'           => $point01,
                'purchase_info'          => '',
                'point_expired_at'       => Carbon::tomorrow('UTC'),
                'remaining_point_amount' => $point01,
            ]);
        $pointLog01 = factory(\App\Models\PointLog::class)->create([
                'user_id'         => $user->id,
                'point_amount'    => $point01,
                'type'            => \App\Models\PointLog::TYPE_PURCHASE,
                'purchase_log_id' => $purchaseLog01->id,

            ]);

        $purchaseLog02 = factory(\App\Models\PurchaseLog::class)->create([
                'user_id'                => $user->id,
                'purchase_method_type'   => 'paypal',
                'point_amount'           => $point02,
                'purchase_info'          => '',
                'point_expired_at'       => Carbon::tomorrow('UTC'),
                'remaining_point_amount' => $point02,
            ]);
        $pointLog02 = factory(\App\Models\PointLog::class)->create([
            'user_id'         => $user->id,
            'point_amount'    => $point02,
            'type'            => \App\Models\PointLog::TYPE_PURCHASE,
            'purchase_log_id' => $purchaseLog02->id,

        ]);

        $service->updateUserPoints($user->id);
        $user = $userRepository->find($user->id);
        $this->assertEquals($point01 + $point02, $user->points);
    }

    public function testPurchasePoints()
    {
        /** @var  \App\Services\PointServiceInterface $service */
        $service = \App::make(\App\Services\PointServiceInterface::class);
        $userRepository = \App::make(\App\Repositories\UserRepositoryInterface::class);
        $user = factory(\App\Models\User::class)->create();

        $point01 = rand(1, 10);
        $point02 = rand(1, 10);

        $pointLog01 = $service->purchasePoints($user->id, $point01, 'paypal', '');
        $pointLog02 = $service->purchasePoints($user->id, $point02, 'paypal', '');

        $user = $userRepository->find($user->id);
        $this->assertEquals($point01 + $point02, $user->points);
    }

    public function testConsumePoints()
    {
        /** @var  \App\Services\PointServiceInterface $service */
        $service = \App::make(\App\Services\PointServiceInterface::class);
        $purchaseLogRepository = \App::make(\App\Repositories\PurchaseLogRepositoryInterface::class);
        $pointLogRepository = \App::make(\App\Repositories\PointLogRepositoryInterface::class);

        $userRepository = \App::make(\App\Repositories\UserRepositoryInterface::class);
        $user = factory(\App\Models\User::class)->create();

        $point01 = rand(1, 10);
        $point02 = rand(1, 10);

        $pointLog01 = $service->purchasePoints($user->id, $point01, 'paypal', '');
        $pointLog02 = $service->purchasePoints($user->id, $point02, 'paypal', '');

        $user = $userRepository->find($user->id);
        $this->assertEquals($point01 + $point02, $user->points);

        $ret =  $service->consumePoints($user->id, 1, 0);
        $this->assertTrue($ret);

        $user = $userRepository->find($user->id);
        $this->assertEquals($point01 + $point02 - 1, $user->points);

        $purchaseLog01 = $purchaseLogRepository->find($pointLog01->purchase_log_id);
        $purchaseLog02 = $purchaseLogRepository->find($pointLog02->purchase_log_id);

        $this->assertEquals($point01, $purchaseLog01->point_amount);
        $this->assertEquals($point01-1, $purchaseLog01->remaining_point_amount);

        $this->assertEquals($point02, $purchaseLog02->point_amount);
        $this->assertEquals($point02, $purchaseLog02->remaining_point_amount);
    }

    public function testExpirePoints()
    {
        /** @var  \App\Services\PointServiceInterface $service */
        $service = \App::make(\App\Services\PointServiceInterface::class);
        $purchaseLogRepository = \App::make(\App\Repositories\PurchaseLogRepositoryInterface::class);
        $pointLogRepository = \App::make(\App\Repositories\PointLogRepositoryInterface::class);

        $userRepository = \App::make(\App\Repositories\UserRepositoryInterface::class);
        $user = factory(\App\Models\User::class)->create();

        $point01 = rand(1, 10);
        $point02 = rand(1, 10);

        $pointLog01 = $service->purchasePoints($user->id, $point01, 'paypal', '');
        $pointLog02 = $service->purchasePoints($user->id, $point02, 'paypal', '');

        $user = $userRepository->find($user->id);
        $this->assertEquals($point01 + $point02, $user->points);

        $purchaseLog01 = $purchaseLogRepository->find($pointLog01->purchase_log_id);
        $purchaseLog02 = $purchaseLogRepository->find($pointLog02->purchase_log_id);

        $purchaseLogRepository->update( $purchaseLog01, [
            'point_expired_at' => \DateTimeHelper::now()->subMonth(),
        ]);

        $service->expirePoints();

        $user = $userRepository->find($user->id);
        $this->assertEquals($point02, $user->points);

        $purchaseLog01 = $purchaseLogRepository->find($pointLog01->purchase_log_id);

        $this->assertEquals($point01, $purchaseLog01->point_amount);
        $this->assertEquals(0, $purchaseLog01->remaining_point_amount);

    }

}
