<?php namespace Tests\Repositories;

use App\Models\TeacherServiceAuthentication;
use Tests\TestCase;

class TeacherServiceAuthenticationRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\TeacherServiceAuthenticationRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeacherServiceAuthenticationRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $teacherServiceAuthentications = factory(TeacherServiceAuthentication::class, 3)->create();
        $teacherServiceAuthenticationIds = $teacherServiceAuthentications->pluck('id')->toArray();

        /** @var  \App\Repositories\TeacherServiceAuthenticationRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeacherServiceAuthenticationRepositoryInterface::class);
        $this->assertNotNull($repository);

        $teacherServiceAuthenticationsCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(TeacherServiceAuthentication::class, $teacherServiceAuthenticationsCheck[0]);

        $teacherServiceAuthenticationsCheck = $repository->getByIds($teacherServiceAuthenticationIds);
        $this->assertEquals(3, count($teacherServiceAuthenticationsCheck));
    }

    public function testFind()
    {
        $teacherServiceAuthentications = factory(TeacherServiceAuthentication::class, 3)->create();
        $teacherServiceAuthenticationIds = $teacherServiceAuthentications->pluck('id')->toArray();

        /** @var  \App\Repositories\TeacherServiceAuthenticationRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeacherServiceAuthenticationRepositoryInterface::class);
        $this->assertNotNull($repository);

        $teacherServiceAuthenticationCheck = $repository->find($teacherServiceAuthenticationIds[0]);
        $this->assertEquals($teacherServiceAuthenticationIds[0], $teacherServiceAuthenticationCheck->id);
    }

    public function testCreate()
    {
        $teacherServiceAuthenticationData = factory(TeacherServiceAuthentication::class)->make();

        /** @var  \App\Repositories\TeacherServiceAuthenticationRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeacherServiceAuthenticationRepositoryInterface::class);
        $this->assertNotNull($repository);

        $teacherServiceAuthenticationCheck = $repository->create($teacherServiceAuthenticationData->toArray());
        $this->assertNotNull($teacherServiceAuthenticationCheck);
    }

    public function testUpdate()
    {
        $teacherServiceAuthenticationData = factory(TeacherServiceAuthentication::class)->create();

        /** @var  \App\Repositories\TeacherServiceAuthenticationRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeacherServiceAuthenticationRepositoryInterface::class);
        $this->assertNotNull($repository);

        $teacherServiceAuthenticationCheck = $repository->update($teacherServiceAuthenticationData, $teacherServiceAuthenticationData->toArray());
        $this->assertNotNull($teacherServiceAuthenticationCheck);
    }

    public function testDelete()
    {
        $teacherServiceAuthenticationData = factory(TeacherServiceAuthentication::class)->create();

        /** @var  \App\Repositories\TeacherServiceAuthenticationRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeacherServiceAuthenticationRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($teacherServiceAuthenticationData);

        $teacherServiceAuthenticationCheck = $repository->find($teacherServiceAuthenticationData->id);
        $this->assertNull($teacherServiceAuthenticationCheck);
    }

}
