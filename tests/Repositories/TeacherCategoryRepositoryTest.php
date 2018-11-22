<?php namespace Tests\Repositories;

use App\Models\TeacherCategory;
use Tests\TestCase;

class TeacherCategoryRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\TeacherCategoryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeacherCategoryRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $teacherCategories = factory(TeacherCategory::class, 3)->create();
        $teacherCategoryIds = $teacherCategories->pluck('id')->toArray();

        /** @var  \App\Repositories\TeacherCategoryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeacherCategoryRepositoryInterface::class);
        $this->assertNotNull($repository);

        $teacherCategoriesCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(TeacherCategory::class, $teacherCategoriesCheck[0]);

        $teacherCategoriesCheck = $repository->getByIds($teacherCategoryIds);
        $this->assertEquals(3, count($teacherCategoriesCheck));
    }

    public function testFind()
    {
        $teacherCategories = factory(TeacherCategory::class, 3)->create();
        $teacherCategoryIds = $teacherCategories->pluck('id')->toArray();

        /** @var  \App\Repositories\TeacherCategoryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeacherCategoryRepositoryInterface::class);
        $this->assertNotNull($repository);

        $teacherCategoryCheck = $repository->find($teacherCategoryIds[0]);
        $this->assertEquals($teacherCategoryIds[0], $teacherCategoryCheck->id);
    }

    public function testCreate()
    {
        $teacherCategoryData = factory(TeacherCategory::class)->make();

        /** @var  \App\Repositories\TeacherCategoryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeacherCategoryRepositoryInterface::class);
        $this->assertNotNull($repository);

        $teacherCategoryCheck = $repository->create($teacherCategoryData->toArray());
        $this->assertNotNull($teacherCategoryCheck);
    }

    public function testUpdate()
    {
        $teacherCategoryData = factory(TeacherCategory::class)->create();

        /** @var  \App\Repositories\TeacherCategoryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeacherCategoryRepositoryInterface::class);
        $this->assertNotNull($repository);

        $teacherCategoryCheck = $repository->update($teacherCategoryData, $teacherCategoryData->toArray());
        $this->assertNotNull($teacherCategoryCheck);
    }

    public function testDelete()
    {
        $teacherCategoryData = factory(TeacherCategory::class)->create();

        /** @var  \App\Repositories\TeacherCategoryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeacherCategoryRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($teacherCategoryData);

        $teacherCategoryCheck = $repository->find($teacherCategoryData->id);
        $this->assertNull($teacherCategoryCheck);
    }

}
