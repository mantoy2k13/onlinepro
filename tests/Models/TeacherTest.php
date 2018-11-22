<?php namespace Tests\Models;

use App\Models\Teacher;
use Tests\TestCase;

class TeacherTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\Teacher $teacher */
        $teacher = new Teacher();
        $this->assertNotNull($teacher);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\Teacher $teacher */
        $teacherModel = new Teacher();

        $teacherData = factory(Teacher::class)->make();
        foreach( $teacherData->toArray() as $key => $value ) {
            $teacherModel->$key = $value;
        }
        $teacherModel->save();

        $this->assertNotNull(Teacher::find($teacherModel->id));
    }

}
