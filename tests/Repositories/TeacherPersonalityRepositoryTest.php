<?php namespace Tests\Repositories;

use App\Models\TeacherPersonality;
use Tests\TestCase;

class TeacherPersonalityRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\TeacherPersonalityRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeacherPersonalityRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $teacherPersonalities = factory(TeacherPersonality::class, 3)->create();
        $teacherPersonalityIds = $teacherPersonalities->pluck('id')->toArray();

        /** @var  \App\Repositories\TeacherPersonalityRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeacherPersonalityRepositoryInterface::class);
        $this->assertNotNull($repository);

        $teacherPersonalitiesCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(TeacherPersonality::class, $teacherPersonalitiesCheck[0]);

        $teacherPersonalitiesCheck = $repository->getByIds($teacherPersonalityIds);
        $this->assertEquals(3, count($teacherPersonalitiesCheck));
    }

    public function testFind()
    {
        $teacherPersonalities = factory(TeacherPersonality::class, 3)->create();
        $teacherPersonalityIds = $teacherPersonalities->pluck('id')->toArray();

        /** @var  \App\Repositories\TeacherPersonalityRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeacherPersonalityRepositoryInterface::class);
        $this->assertNotNull($repository);

        $teacherPersonalityCheck = $repository->find($teacherPersonalityIds[0]);
        $this->assertEquals($teacherPersonalityIds[0], $teacherPersonalityCheck->id);
    }

    public function testCreate()
    {
        $teacherPersonalityData = factory(TeacherPersonality::class)->make();

        /** @var  \App\Repositories\TeacherPersonalityRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeacherPersonalityRepositoryInterface::class);
        $this->assertNotNull($repository);

        $teacherPersonalityCheck = $repository->create($teacherPersonalityData->toArray());
        $this->assertNotNull($teacherPersonalityCheck);
    }

    public function testUpdate()
    {
        $teacherPersonalityData = factory(TeacherPersonality::class)->create();

        /** @var  \App\Repositories\TeacherPersonalityRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeacherPersonalityRepositoryInterface::class);
        $this->assertNotNull($repository);

        $teacherPersonalityCheck = $repository->update($teacherPersonalityData, $teacherPersonalityData->toArray());
        $this->assertNotNull($teacherPersonalityCheck);
    }

    public function testDelete()
    {
        $teacherPersonalityData = factory(TeacherPersonality::class)->create();

        /** @var  \App\Repositories\TeacherPersonalityRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeacherPersonalityRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($teacherPersonalityData);

        $teacherPersonalityCheck = $repository->find($teacherPersonalityData->id);
        $this->assertNull($teacherPersonalityCheck);
    }

}
