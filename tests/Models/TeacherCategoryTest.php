<?php namespace Tests\Models;

use App\Models\TeacherCategory;
use Tests\TestCase;

class TeacherCategoryTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\TeacherCategory $teacherCategory */
        $teacherCategory = new TeacherCategory();
        $this->assertNotNull($teacherCategory);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\TeacherCategory $teacherCategory */
        $teacherCategoryModel = new TeacherCategory();

        $teacherCategoryData = factory(TeacherCategory::class)->make();
        foreach( $teacherCategoryData->toArray() as $key => $value ) {
            $teacherCategoryModel->$key = $value;
        }
        $teacherCategoryModel->save();

        $this->assertNotNull(TeacherCategory::find($teacherCategoryModel->id));
    }

}
