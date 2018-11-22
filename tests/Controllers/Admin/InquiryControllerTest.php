<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class InquiryControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\InquiryController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\InquiryController::class);
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
        $response = $this->action('GET', 'Admin\InquiryController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\InquiryController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $inquiry = factory(\App\Models\Inquiry::class)->make();
        $this->action('POST', 'Admin\InquiryController@store', [
                '_token' => csrf_token(),
            ] + $inquiry->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $inquiry = factory(\App\Models\Inquiry::class)->create();
        $this->action('GET', 'Admin\InquiryController@show', [$inquiry->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $inquiry = factory(\App\Models\Inquiry::class)->create();

        $name = $faker->name;
        $id = $inquiry->id;

        $inquiry->name = $name;

        $this->action('PUT', 'Admin\InquiryController@update', [$id], [
                '_token' => csrf_token(),
            ] + $inquiry->toArray());
        $this->assertResponseStatus(302);

        $newInquiry = \App\Models\Inquiry::find($id);
        $this->assertEquals($name, $newInquiry->name);
    }

    public function testDeleteModel()
    {
        $inquiry = factory(\App\Models\Inquiry::class)->create();

        $id = $inquiry->id;

        $this->action('DELETE', 'Admin\InquiryController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkInquiry = \App\Models\Inquiry::find($id);
        $this->assertNull($checkInquiry);
    }

}
