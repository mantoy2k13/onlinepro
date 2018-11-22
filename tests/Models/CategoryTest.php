<?php namespace Tests\Models;

use App\Models\Category;
use Tests\TestCase;

class CategoryTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\Category $category */
        $category = new Category();
        $this->assertNotNull($category);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\Category $category */
        $categoryModel = new Category();

        $categoryData = factory(Category::class)->make();
        foreach( $categoryData->toArray() as $key => $value ) {
            $categoryModel->$key = $value;
        }
        $categoryModel->save();

        $this->assertNotNull(Category::find($categoryModel->id));
    }

}
