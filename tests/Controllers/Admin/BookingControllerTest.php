<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class BookingControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\BookingController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\BookingController::class);
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
        $response = $this->action('GET', 'Admin\BookingController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\BookingController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $booking = factory(\App\Models\Booking::class)->make();
        $this->action('POST', 'Admin\BookingController@store', [
                '_token' => csrf_token(),
            ] + $booking->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $booking = factory(\App\Models\Booking::class)->create();
        $this->action('GET', 'Admin\BookingController@show', [$booking->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $booking = factory(\App\Models\Booking::class)->create();

        $name = $faker->name;
        $id = $booking->id;

        $booking->status = $name;

        $this->action('PUT', 'Admin\BookingController@update', [$id], [
                '_token' => csrf_token(),
            ] + $booking->toArray());
        $this->assertResponseStatus(302);

        $newBooking = \App\Models\Booking::find($id);
        $this->assertEquals($name, $newBooking->status);
    }

    public function testDeleteModel()
    {
        $booking = factory(\App\Models\Booking::class)->create();

        $id = $booking->id;

        $this->action('DELETE', 'Admin\BookingController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkBooking = \App\Models\Booking::find($id);
        $this->assertNull($checkBooking);
    }

}
