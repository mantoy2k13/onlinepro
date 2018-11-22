<?php namespace Tests\Models;

use App\Models\TeacherNotification;
use Tests\TestCase;

class TeacherNotificationTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\TeacherNotification $teacherNotification */
        $teacherNotification = new TeacherNotification();
        $this->assertNotNull($teacherNotification);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\TeacherNotification $teacherNotification */
        $teacherNotificationModel = new TeacherNotification();

        $teacherNotificationData = factory(TeacherNotification::class)->make();
        foreach( $teacherNotificationData->toArray() as $key => $value ) {
            $teacherNotificationModel->$key = $value;
        }
        $teacherNotificationModel->save();

        $this->assertNotNull(TeacherNotification::find($teacherNotificationModel->id));
    }

}
