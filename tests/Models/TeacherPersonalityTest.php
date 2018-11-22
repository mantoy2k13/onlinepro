<?php namespace Tests\Models;

use App\Models\TeacherPersonality;
use Tests\TestCase;

class TeacherPersonalityTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\TeacherPersonality $teacherPersonality */
        $teacherPersonality = new TeacherPersonality();
        $this->assertNotNull($teacherPersonality);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\TeacherPersonality $teacherPersonality */
        $teacherPersonalityModel = new TeacherPersonality();

        $teacherPersonalityData = factory(TeacherPersonality::class)->make();
        foreach( $teacherPersonalityData->toArray() as $key => $value ) {
            $teacherPersonalityModel->$key = $value;
        }
        $teacherPersonalityModel->save();

        $this->assertNotNull(TeacherPersonality::find($teacherPersonalityModel->id));
    }

}
