<?php namespace Tests\Repositories;

use App\Models\FavoriteTeacher;
use Tests\TestCase;

class FavoriteTeacherRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\FavoriteTeacherRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\FavoriteTeacherRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $favoriteTeachers = factory(FavoriteTeacher::class, 3)->create();
        $favoriteTeacherIds = $favoriteTeachers->pluck('id')->toArray();

        /** @var  \App\Repositories\FavoriteTeacherRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\FavoriteTeacherRepositoryInterface::class);
        $this->assertNotNull($repository);

        $favoriteTeachersCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(FavoriteTeacher::class, $favoriteTeachersCheck[0]);

        $favoriteTeachersCheck = $repository->getByIds($favoriteTeacherIds);
        $this->assertEquals(3, count($favoriteTeachersCheck));
    }

    public function testFind()
    {
        $favoriteTeachers = factory(FavoriteTeacher::class, 3)->create();
        $favoriteTeacherIds = $favoriteTeachers->pluck('id')->toArray();

        /** @var  \App\Repositories\FavoriteTeacherRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\FavoriteTeacherRepositoryInterface::class);
        $this->assertNotNull($repository);

        $favoriteTeacherCheck = $repository->find($favoriteTeacherIds[0]);
        $this->assertEquals($favoriteTeacherIds[0], $favoriteTeacherCheck->id);
    }

    public function testCreate()
    {
        $favoriteTeacherData = factory(FavoriteTeacher::class)->make();

        /** @var  \App\Repositories\FavoriteTeacherRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\FavoriteTeacherRepositoryInterface::class);
        $this->assertNotNull($repository);

        $favoriteTeacherCheck = $repository->create($favoriteTeacherData->toArray());
        $this->assertNotNull($favoriteTeacherCheck);
    }

    public function testUpdate()
    {
        $favoriteTeacherData = factory(FavoriteTeacher::class)->create();

        /** @var  \App\Repositories\FavoriteTeacherRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\FavoriteTeacherRepositoryInterface::class);
        $this->assertNotNull($repository);

        $favoriteTeacherCheck = $repository->update($favoriteTeacherData, $favoriteTeacherData->toArray());
        $this->assertNotNull($favoriteTeacherCheck);
    }

    public function testDelete()
    {
        $favoriteTeacherData = factory(FavoriteTeacher::class)->create();

        /** @var  \App\Repositories\FavoriteTeacherRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\FavoriteTeacherRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($favoriteTeacherData);

        $favoriteTeacherCheck = $repository->find($favoriteTeacherData->id);
        $this->assertNull($favoriteTeacherCheck);
    }

}
