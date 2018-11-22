<?php namespace Tests\Repositories;

use App\Models\Category;
use Tests\TestCase;

class CategoryRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\CategoryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\CategoryRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $categories = factory(Category::class, 3)->create();
        $categoryIds = $categories->pluck('id')->toArray();

        /** @var  \App\Repositories\CategoryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\CategoryRepositoryInterface::class);
        $this->assertNotNull($repository);

        $categoriesCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(Category::class, $categoriesCheck[0]);

        $categoriesCheck = $repository->getByIds($categoryIds);
        $this->assertEquals(3, count($categoriesCheck));
    }

    public function testFind()
    {
        $categories = factory(Category::class, 3)->create();
        $categoryIds = $categories->pluck('id')->toArray();

        /** @var  \App\Repositories\CategoryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\CategoryRepositoryInterface::class);
        $this->assertNotNull($repository);

        $categoryCheck = $repository->find($categoryIds[0]);
        $this->assertEquals($categoryIds[0], $categoryCheck->id);
    }

    public function testCreate()
    {
        $categoryData = factory(Category::class)->make();

        /** @var  \App\Repositories\CategoryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\CategoryRepositoryInterface::class);
        $this->assertNotNull($repository);

        $categoryCheck = $repository->create($categoryData->toArray());
        $this->assertNotNull($categoryCheck);
    }

    public function testUpdate()
    {
        $categoryData = factory(Category::class)->create();

        /** @var  \App\Repositories\CategoryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\CategoryRepositoryInterface::class);
        $this->assertNotNull($repository);

        $categoryCheck = $repository->update($categoryData, $categoryData->toArray());
        $this->assertNotNull($categoryCheck);
    }

    public function testDelete()
    {
        $categoryData = factory(Category::class)->create();

        /** @var  \App\Repositories\CategoryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\CategoryRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($categoryData);

        $categoryCheck = $repository->find($categoryData->id);
        $this->assertNull($categoryCheck);
    }

}
