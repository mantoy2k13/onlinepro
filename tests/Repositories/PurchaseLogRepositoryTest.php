<?php namespace Tests\Repositories;

use App\Models\PurchaseLog;
use Tests\TestCase;

class PurchaseLogRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\PurchaseLogRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PurchaseLogRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $purchaseLogs = factory(PurchaseLog::class, 3)->create();
        $purchaseLogIds = $purchaseLogs->pluck('id')->toArray();

        /** @var  \App\Repositories\PurchaseLogRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PurchaseLogRepositoryInterface::class);
        $this->assertNotNull($repository);

        $purchaseLogsCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(PurchaseLog::class, $purchaseLogsCheck[0]);

        $purchaseLogsCheck = $repository->getByIds($purchaseLogIds);
        $this->assertEquals(3, count($purchaseLogsCheck));
    }

    public function testFind()
    {
        $purchaseLogs = factory(PurchaseLog::class, 3)->create();
        $purchaseLogIds = $purchaseLogs->pluck('id')->toArray();

        /** @var  \App\Repositories\PurchaseLogRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PurchaseLogRepositoryInterface::class);
        $this->assertNotNull($repository);

        $purchaseLogCheck = $repository->find($purchaseLogIds[0]);
        $this->assertEquals($purchaseLogIds[0], $purchaseLogCheck->id);
    }

    public function testCreate()
    {
        $purchaseLogData = factory(PurchaseLog::class)->make();

        /** @var  \App\Repositories\PurchaseLogRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PurchaseLogRepositoryInterface::class);
        $this->assertNotNull($repository);

        $purchaseLogCheck = $repository->create($purchaseLogData->toArray());
        $this->assertNotNull($purchaseLogCheck);
    }

    public function testUpdate()
    {
        $purchaseLogData = factory(PurchaseLog::class)->create();

        /** @var  \App\Repositories\PurchaseLogRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PurchaseLogRepositoryInterface::class);
        $this->assertNotNull($repository);

        $purchaseLogCheck = $repository->update($purchaseLogData, $purchaseLogData->toArray());
        $this->assertNotNull($purchaseLogCheck);
    }

    public function testDelete()
    {
        $purchaseLogData = factory(PurchaseLog::class)->create();

        /** @var  \App\Repositories\PurchaseLogRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PurchaseLogRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($purchaseLogData);

        $purchaseLogCheck = $repository->find($purchaseLogData->id);
        $this->assertNull($purchaseLogCheck);
    }

}
