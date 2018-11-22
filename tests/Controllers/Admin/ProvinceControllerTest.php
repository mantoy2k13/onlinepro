<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class ProvinceControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\ProvinceController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\ProvinceController::class);
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
        $response = $this->action('GET', 'Admin\ProvinceController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\ProvinceController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $province = factory(\App\Models\Province::class)->make();
        $this->action('POST', 'Admin\ProvinceController@store', [
                '_token' => csrf_token(),
            ] + $province->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $province = factory(\App\Models\Province::class)->create();
        $this->action('GET', 'Admin\ProvinceController@show', [$province->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $province = factory(\App\Models\Province::class)->create();

        $name = $faker->name;
        $id = $province->id;

        $province->country_code = $name;

        $this->action('PUT', 'Admin\ProvinceController@update', [$id], [
                '_token' => csrf_token(),
            ] + $province->toArray());
        $this->assertResponseStatus(302);

        $newProvince = \App\Models\Province::find($id);
        $this->assertEquals($name, $newProvince->country_code);
    }

    public function testDeleteModel()
    {
        $province = factory(\App\Models\Province::class)->create();

        $id = $province->id;

        $this->action('DELETE', 'Admin\ProvinceController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkProvince = \App\Models\Province::find($id);
        $this->assertNull($checkProvince);
    }

}
