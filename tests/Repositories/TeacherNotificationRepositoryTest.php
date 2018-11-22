<?php namespace Tests\Repositories;

use App\Models\TeacherNotification;
use Tests\TestCase;

class TeacherNotificationRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\TeacherNotificationRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeacherNotificationRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $teacherNotifications = factory(TeacherNotification::class, 3)->create();
        $teacherNotificationIds = $teacherNotifications->pluck('id')->toArray();

        /** @var  \App\Repositories\TeacherNotificationRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeacherNotificationRepositoryInterface::class);
        $this->assertNotNull($repository);

        $teacherNotificationsCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(TeacherNotification::class, $teacherNotificationsCheck[0]);

        $teacherNotificationsCheck = $repository->getByIds($teacherNotificationIds);
        $this->assertEquals(3, count($teacherNotificationsCheck));
    }

    public function testFind()
    {
        $teacherNotifications = factory(TeacherNotification::class, 3)->create();
        $teacherNotificationIds = $teacherNotifications->pluck('id')->toArray();

        /** @var  \App\Repositories\TeacherNotificationRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeacherNotificationRepositoryInterface::class);
        $this->assertNotNull($repository);

        $teacherNotificationCheck = $repository->find($teacherNotificationIds[0]);
        $this->assertEquals($teacherNotificationIds[0], $teacherNotificationCheck->id);
    }

    public function testCreate()
    {
        $teacherNotificationData = factory(TeacherNotification::class)->make();

        /** @var  \App\Repositories\TeacherNotificationRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeacherNotificationRepositoryInterface::class);
        $this->assertNotNull($repository);

        $teacherNotificationCheck = $repository->create($teacherNotificationData->toArray());
        $this->assertNotNull($teacherNotificationCheck);
    }

    public function testUpdate()
    {
        $teacherNotificationData = factory(TeacherNotification::class)->create();

        /** @var  \App\Repositories\TeacherNotificationRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeacherNotificationRepositoryInterface::class);
        $this->assertNotNull($repository);

        $teacherNotificationCheck = $repository->update($teacherNotificationData, $teacherNotificationData->toArray());
        $this->assertNotNull($teacherNotificationCheck);
    }

    public function testDelete()
    {
        $teacherNotificationData = factory(TeacherNotification::class)->create();

        /** @var  \App\Repositories\TeacherNotificationRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeacherNotificationRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($teacherNotificationData);

        $teacherNotificationCheck = $repository->find($teacherNotificationData->id);
        $this->assertNull($teacherNotificationCheck);
    }

}
