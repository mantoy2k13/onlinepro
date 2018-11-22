<?php namespace Tests\Repositories;

use App\Models\PointLog;
use Tests\TestCase;

class PointLogRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\PointLogRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PointLogRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $pointLogs = factory(PointLog::class, 3)->create();
        $pointLogIds = $pointLogs->pluck('id')->toArray();

        /** @var  \App\Repositories\PointLogRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PointLogRepositoryInterface::class);
        $this->assertNotNull($repository);

        $pointLogsCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(PointLog::class, $pointLogsCheck[0]);

        $pointLogsCheck = $repository->getByIds($pointLogIds);
        $this->assertEquals(3, count($pointLogsCheck));
    }

    public function testFind()
    {
        $pointLogs = factory(PointLog::class, 3)->create();
        $pointLogIds = $pointLogs->pluck('id')->toArray();

        /** @var  \App\Repositories\PointLogRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PointLogRepositoryInterface::class);
        $this->assertNotNull($repository);

        $pointLogCheck = $repository->find($pointLogIds[0]);
        $this->assertEquals($pointLogIds[0], $pointLogCheck->id);
    }

    public function testCreate()
    {
        $pointLogData = factory(PointLog::class)->make();

        /** @var  \App\Repositories\PointLogRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PointLogRepositoryInterface::class);
        $this->assertNotNull($repository);

        $pointLogCheck = $repository->create($pointLogData->toArray());
        $this->assertNotNull($pointLogCheck);
    }

    public function testUpdate()
    {
        $pointLogData = factory(PointLog::class)->create();

        /** @var  \App\Repositories\PointLogRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PointLogRepositoryInterface::class);
        $this->assertNotNull($repository);

        $pointLogCheck = $repository->update($pointLogData, $pointLogData->toArray());
        $this->assertNotNull($pointLogCheck);
    }

    public function testDelete()
    {
        $pointLogData = factory(PointLog::class)->create();

        /** @var  \App\Repositories\PointLogRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PointLogRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($pointLogData);

        $pointLogCheck = $repository->find($pointLogData->id);
        $this->assertNull($pointLogCheck);
    }

}
