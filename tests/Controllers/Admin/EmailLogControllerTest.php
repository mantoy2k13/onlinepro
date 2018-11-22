<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class EmailLogControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\EmailLogController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\EmailLogController::class);
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
        $response = $this->action('GET', 'Admin\EmailLogController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\EmailLogController@create');
        $this->assertResponseOk();
    }

    public function testEditModel()
    {
        $emailLog = factory(\App\Models\EmailLog::class)->create();
        $this->action('GET', 'Admin\EmailLogController@show', [$emailLog->id]);
        $this->assertResponseOk();
    }

    public function testDeleteModel()
    {
        $emailLog = factory(\App\Models\EmailLog::class)->create();

        $id = $emailLog->id;

        $this->action('DELETE', 'Admin\EmailLogController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkEmailLog = \App\Models\EmailLog::find($id);
        $this->assertNull($checkEmailLog);
    }

}
