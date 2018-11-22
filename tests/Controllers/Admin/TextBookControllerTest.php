<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class TextBookControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\TextBookController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\TextBookController::class);
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
        $response = $this->action('GET', 'Admin\TextBookController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\TextBookController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $textBook = factory(\App\Models\TextBook::class)->make();
        $this->action('POST', 'Admin\TextBookController@store', [
                '_token' => csrf_token(),
            ] + $textBook->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $textBook = factory(\App\Models\TextBook::class)->create();
        $this->action('GET', 'Admin\TextBookController@show', [$textBook->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $textBook = factory(\App\Models\TextBook::class)->create();

        $name = $faker->name;
        $id = $textBook->id;

        $textBook->title = $name;

        $this->action('PUT', 'Admin\TextBookController@update', [$id], [
                '_token' => csrf_token(),
            ] + $textBook->toArray());
        $this->assertResponseStatus(302);

        $newTextBook = \App\Models\TextBook::find($id);
        $this->assertEquals($name, $newTextBook->title);
    }

    public function testDeleteModel()
    {
        $textBook = factory(\App\Models\TextBook::class)->create();

        $id = $textBook->id;

        $this->action('DELETE', 'Admin\TextBookController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkTextBook = \App\Models\TextBook::find($id);
        $this->assertNull($checkTextBook);
    }

}
