<?php namespace Tests\Services;

use App\Models\Lesson;
use Tests\TestCase;

class LessonTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\Category $category */
        $category = new Lesson();
        $this->assertNotNull($category);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\Category $category */
        $lessonModel = new Lesson();

        $lessonData = factory(Lesson::class)->make();
        foreach( $lessonData->toArray() as $key => $value ) {
            $lessonModel->$key = $value;
        }
        $lessonModel->save();

        $this->assertNotNull(Lesson::find($lessonModel->id));
    }

}
