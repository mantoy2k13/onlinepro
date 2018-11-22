<?php namespace Tests\Models;

use App\Models\TeacherLesson;
use Tests\TestCase;

class TeacherLessonTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\TeacherLesson $teacherLesson */
        $teacherLesson = new TeacherLesson();
        $this->assertNotNull($teacherLesson);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\TeacherLesson $teacherLesson */
        $teacherLessonModel = new TeacherLesson();

        $teacherLessonData = factory(TeacherLesson::class)->make();
        foreach( $teacherLessonData->toFillableArray() as $key => $value ) {
            $teacherLessonModel->$key = $value;
        }
        $teacherLessonModel->save();

        $this->assertNotNull(TeacherLesson::find($teacherLessonModel->id));
    }

}
