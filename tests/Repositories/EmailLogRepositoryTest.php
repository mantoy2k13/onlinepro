<?php namespace Tests\Repositories;

use App\Models\EmailLog;
use Tests\TestCase;

class EmailLogRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\EmailLogRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\EmailLogRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $emailLogs = factory(EmailLog::class, 3)->create();
        $emailLogIds = $emailLogs->pluck('id')->toArray();

        /** @var  \App\Repositories\EmailLogRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\EmailLogRepositoryInterface::class);
        $this->assertNotNull($repository);

        $emailLogsCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(EmailLog::class, $emailLogsCheck[0]);

        $emailLogsCheck = $repository->getByIds($emailLogIds);
        $this->assertEquals(3, count($emailLogsCheck));
    }

    public function testFind()
    {
        $emailLogs = factory(EmailLog::class, 3)->create();
        $emailLogIds = $emailLogs->pluck('id')->toArray();

        /** @var  \App\Repositories\EmailLogRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\EmailLogRepositoryInterface::class);
        $this->assertNotNull($repository);

        $emailLogCheck = $repository->find($emailLogIds[0]);
        $this->assertEquals($emailLogIds[0], $emailLogCheck->id);
    }

    public function testCreate()
    {
        $emailLogData = factory(EmailLog::class)->make();

        /** @var  \App\Repositories\EmailLogRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\EmailLogRepositoryInterface::class);
        $this->assertNotNull($repository);

        $emailLogCheck = $repository->create($emailLogData->toFillableArray());
        $this->assertNotNull($emailLogCheck);
    }

    public function testUpdate()
    {
        $emailLogData = factory(EmailLog::class)->create();

        /** @var  \App\Repositories\EmailLogRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\EmailLogRepositoryInterface::class);
        $this->assertNotNull($repository);

        $emailLogCheck = $repository->update($emailLogData, $emailLogData->toFillableArray());
        $this->assertNotNull($emailLogCheck);
    }

    public function testDelete()
    {
        $emailLogData = factory(EmailLog::class)->create();

        /** @var  \App\Repositories\EmailLogRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\EmailLogRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($emailLogData);

        $emailLogCheck = $repository->find($emailLogData->id);
        $this->assertNull($emailLogCheck);
    }

}
