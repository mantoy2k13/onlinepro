<?php namespace Tests\Repositories;

use App\Models\Teacher;
use Tests\TestCase;

class TeacherRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\TeacherRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeacherRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $teachers = factory(Teacher::class, 3)->create();
        $teacherIds = $teachers->pluck('id')->toArray();

        /** @var  \App\Repositories\TeacherRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeacherRepositoryInterface::class);
        $this->assertNotNull($repository);

        $teachersCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(Teacher::class, $teachersCheck[0]);

        $teachersCheck = $repository->getByIds($teacherIds);
        $this->assertEquals(3, count($teachersCheck));
    }

    public function testFind()
    {
        $teachers = factory(Teacher::class, 3)->create();
        $teacherIds = $teachers->pluck('id')->toArray();

        /** @var  \App\Repositories\TeacherRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeacherRepositoryInterface::class);
        $this->assertNotNull($repository);

        $teacherCheck = $repository->find($teacherIds[0]);
        $this->assertEquals($teacherIds[0], $teacherCheck->id);
    }

    public function testCreate()
    {
        $teacherData = factory(Teacher::class)->make();

        /** @var  \App\Repositories\TeacherRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeacherRepositoryInterface::class);
        $this->assertNotNull($repository);

        $teacherCheck = $repository->create($teacherData->toArray());
        $this->assertNotNull($teacherCheck);
    }

    public function testUpdate()
    {
        $teacherData = factory(Teacher::class)->create();

        /** @var  \App\Repositories\TeacherRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeacherRepositoryInterface::class);
        $this->assertNotNull($repository);

        $teacherCheck = $repository->update($teacherData, $teacherData->toArray());
        $this->assertNotNull($teacherCheck);
    }

    public function testDelete()
    {
        $teacherData = factory(Teacher::class)->create();

        /** @var  \App\Repositories\TeacherRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeacherRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($teacherData);

        $teacherCheck = $repository->find($teacherData->id);
        $this->assertNull($teacherCheck);
    }

}
