<?php namespace Tests\Repositories;

use App\Models\TeacherLesson;
use Tests\TestCase;

class TeacherLessonRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\TeacherLessonRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeacherLessonRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $teacherLessons = factory(TeacherLesson::class, 3)->create();
        $teacherLessonIds = $teacherLessons->pluck('id')->toArray();

        /** @var  \App\Repositories\TeacherLessonRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeacherLessonRepositoryInterface::class);
        $this->assertNotNull($repository);

        $teacherLessonsCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(TeacherLesson::class, $teacherLessonsCheck[0]);

        $teacherLessonsCheck = $repository->getByIds($teacherLessonIds);
        $this->assertEquals(3, count($teacherLessonsCheck));
    }

    public function testFind()
    {
        $teacherLessons = factory(TeacherLesson::class, 3)->create();
        $teacherLessonIds = $teacherLessons->pluck('id')->toArray();

        /** @var  \App\Repositories\TeacherLessonRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeacherLessonRepositoryInterface::class);
        $this->assertNotNull($repository);

        $teacherLessonCheck = $repository->find($teacherLessonIds[0]);
        $this->assertEquals($teacherLessonIds[0], $teacherLessonCheck->id);
    }

    public function testCreate()
    {
        $teacherLessonData = factory(TeacherLesson::class)->make();

        /** @var  \App\Repositories\TeacherLessonRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeacherLessonRepositoryInterface::class);
        $this->assertNotNull($repository);

        $teacherLessonCheck = $repository->create($teacherLessonData->toFillableArray());
        $this->assertNotNull($teacherLessonCheck);
    }

    public function testUpdate()
    {
        $teacherLessonData = factory(TeacherLesson::class)->create();

        /** @var  \App\Repositories\TeacherLessonRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeacherLessonRepositoryInterface::class);
        $this->assertNotNull($repository);

        $teacherLessonCheck = $repository->update($teacherLessonData, $teacherLessonData->toFillableArray());
        $this->assertNotNull($teacherLessonCheck);
    }

    public function testDelete()
    {
        $teacherLessonData = factory(TeacherLesson::class)->create();

        /** @var  \App\Repositories\TeacherLessonRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeacherLessonRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($teacherLessonData);

        $teacherLessonCheck = $repository->find($teacherLessonData->id);
        $this->assertNull($teacherLessonCheck);
    }

}
