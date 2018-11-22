<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class TeacherNotificationControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\TeacherNotificationController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\TeacherNotificationController::class);
        $this->assertNotNull($controller);
    }

    public function setUp()
    {
        parent::setUp();
        $authUser = \App\Models\AdminUser::first();
        $this->be($authUser, 'admins');
    }

    public function testGetList()
    {
        $response = $this->action('GET', 'Admin\TeacherNotificationController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\TeacherNotificationController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $teacherNotification = factory(\App\Models\TeacherNotification::class)->make();
        $this->action('POST', 'Admin\TeacherNotificationController@store', [
                '_token' => csrf_token(),
            ] + $teacherNotification->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $teacherNotification = factory(\App\Models\TeacherNotification::class)->create();
        $this->action('GET', 'Admin\TeacherNotificationController@show', [$teacherNotification->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $teacherNotification = factory(\App\Models\TeacherNotification::class)->create();

        $name = $faker->name;
        $id = $teacherNotification->id;

        $teacherNotification->title = $name;

        $this->action('PUT', 'Admin\TeacherNotificationController@update', [$id], [
                '_token' => csrf_token(),
            ] + $teacherNotification->toArray());
        $this->assertResponseStatus(302);

        $newTeacherNotification = \App\Models\TeacherNotification::find($id);
        $this->assertEquals($name, $newTeacherNotification->title);
    }

    public function testDeleteModel()
    {
        $teacherNotification = factory(\App\Models\TeacherNotification::class)->create();

        $id = $teacherNotification->id;

        $this->action('DELETE', 'Admin\TeacherNotificationController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkTeacherNotification = \App\Models\TeacherNotification::find($id);
        $this->assertNull($checkTeacherNotification);
    }

}
