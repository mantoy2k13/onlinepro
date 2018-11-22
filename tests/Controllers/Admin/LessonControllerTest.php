<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class LessonControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\LessonController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\LessonController::class);
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
        $response = $this->action('GET', 'Admin\LessonController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\LessonController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $lesson = factory(\App\Models\Lesson::class)->make();
        $this->action('POST', 'Admin\LessonController@store', [
                '_token' => csrf_token(),
            ] + $lesson->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $lesson = factory(\App\Models\Lesson::class)->create();
        $this->action('GET', 'Admin\LessonController@show', [$lesson->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $lesson = factory(\App\Models\Lesson::class)->create();

        $name = $faker->name;
        $id = $lesson->id;

        $lesson->name_en = $name;

        $this->action('PUT', 'Admin\LessonController@update', [$id], [
                '_token' => csrf_token(),
            ] + $lesson->toArray());
        $this->assertResponseStatus(302);

        $newLesson = \App\Models\Lesson::find($id);
        $this->assertEquals($name, $newLesson->name_en);
    }

    public function testDeleteModel()
    {
        $lesson = factory(\App\Models\Lesson::class)->create();

        $id = $lesson->id;

        $this->action('DELETE', 'Admin\LessonController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkLesson = \App\Models\Lesson::find($id);
        $this->assertNull($checkLesson);
    }

}
