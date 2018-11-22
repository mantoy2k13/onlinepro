<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class PersonalityControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\PersonalityController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\PersonalityController::class);
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
        $response = $this->action('GET', 'Admin\PersonalityController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\PersonalityController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $personality = factory(\App\Models\Personality::class)->make();
        $this->action('POST', 'Admin\PersonalityController@store', [
                '_token' => csrf_token(),
            ] + $personality->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $personality = factory(\App\Models\Personality::class)->create();
        $this->action('GET', 'Admin\PersonalityController@show', [$personality->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $personality = factory(\App\Models\Personality::class)->create();

        $name = $faker->name;
        $id = $personality->id;

        $personality->name_en = $name;

        $this->action('PUT', 'Admin\PersonalityController@update', [$id], [
                '_token' => csrf_token(),
            ] + $personality->toArray());
        $this->assertResponseStatus(302);

        $newPersonality = \App\Models\Personality::find($id);
        $this->assertEquals($name, $newPersonality->name_en);
    }

    public function testDeleteModel()
    {
        $personality = factory(\App\Models\Personality::class)->create();

        $id = $personality->id;

        $this->action('DELETE', 'Admin\PersonalityController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkPersonality = \App\Models\Personality::find($id);
        $this->assertNull($checkPersonality);
    }

}
