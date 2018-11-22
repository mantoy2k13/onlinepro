<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class TeacherControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\TeacherController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\TeacherController::class);
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
        $response = $this->action('GET', 'Admin\TeacherController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\TeacherController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $teacher = factory(\App\Models\Teacher::class)->make();
        $this->action('POST', 'Admin\TeacherController@store', [
                '_token' => csrf_token(),
            ] + $teacher->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $teacher = factory(\App\Models\Teacher::class)->create();
        $this->action('GET', 'Admin\TeacherController@show', [$teacher->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $teacher = factory(\App\Models\Teacher::class)->create();

        $name = $faker->name;
        $id = $teacher->id;

        $teacher->name = $name;

        $this->action('PUT', 'Admin\TeacherController@update', [$id], [
                '_token' => csrf_token(),
            ] + $teacher->toArray());
        $this->assertResponseStatus(302);

        $newTeacher = \App\Models\Teacher::find($id);
        $this->assertEquals($name, $newTeacher->name);
    }

    public function testDeleteModel()
    {
        $teacher = factory(\App\Models\Teacher::class)->create();

        $id = $teacher->id;

        $this->action('DELETE', 'Admin\TeacherController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkTeacher = \App\Models\Teacher::find($id);
        $this->assertNull($checkTeacher);
    }

}
