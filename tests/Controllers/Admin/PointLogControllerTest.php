<?php  namespace Tests\Controllers\Admin;

use App\Models\Booking;
use App\Models\User;
use Tests\TestCase;

class PointLogControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\PointLogController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\PointLogController::class);
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
        $response = $this->action('GET', 'Admin\PointLogController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\PointLogController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $pointLog = factory(\App\Models\PointLog::class)->make();
        $booking = Booking::inRandomOrder()->first();
        $user = User::inRandomOrder()->first();
        $pointLog->user_id = $user->id;
        $pointLog->related_id = $booking->id;
        $this->action('POST', 'Admin\PointLogController@store', [
                '_token' => csrf_token(),
            ] + $pointLog->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $pointLog = factory(\App\Models\PointLog::class)->create();

        $this->action('GET', 'Admin\PointLogController@show', [$pointLog->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {

        $this->assertResponseOk();
    }

    public function testDeleteModel()
    {
        $this->assertResponseOk();
    }

}
