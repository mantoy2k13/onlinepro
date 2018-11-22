<?php namespace Tests\Models;

use App\Models\TeacherServiceAuthentication;
use Tests\TestCase;

class TeacherServiceAuthenticationTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\TeacherServiceAuthentication $teacherServiceAuthentication */
        $teacherServiceAuthentication = new TeacherServiceAuthentication();
        $this->assertNotNull($teacherServiceAuthentication);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\TeacherServiceAuthentication $teacherServiceAuthentication */
        $teacherServiceAuthenticationModel = new TeacherServiceAuthentication();

        $teacherServiceAuthenticationData = factory(TeacherServiceAuthentication::class)->make();
        foreach( $teacherServiceAuthenticationData->toArray() as $key => $value ) {
            $teacherServiceAuthenticationModel->$key = $value;
        }
        $teacherServiceAuthenticationModel->save();

        $this->assertNotNull(TeacherServiceAuthentication::find($teacherServiceAuthenticationModel->id));
    }

}
