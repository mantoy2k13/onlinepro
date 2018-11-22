<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class CategoryControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\CategoryController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\CategoryController::class);
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
        $response = $this->action('GET', 'Admin\CategoryController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\CategoryController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $category = factory(\App\Models\Category::class)->make();
        $this->action('POST', 'Admin\CategoryController@store', [
                '_token' => csrf_token(),
            ] + $category->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $category = factory(\App\Models\Category::class)->create();
        $this->action('GET', 'Admin\CategoryController@show', [$category->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $category = factory(\App\Models\Category::class)->create();

        $name = $faker->name;
        $id = $category->id;

        $category->name_en = $name;

        $this->action('PUT', 'Admin\CategoryController@update', [$id], [
                '_token' => csrf_token(),
            ] + $category->toArray());
        $this->assertResponseStatus(302);

        $newCategory = \App\Models\Category::find($id);
        $this->assertEquals($name, $newCategory->name_en);
    }

    public function testDeleteModel()
    {
        $category = factory(\App\Models\Category::class)->create();

        $id = $category->id;

        $this->action('DELETE', 'Admin\CategoryController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkCategory = \App\Models\Category::find($id);
        $this->assertNull($checkCategory);
    }

}
