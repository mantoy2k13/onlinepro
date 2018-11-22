<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class PurchaseLogControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\PurchaseLogController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\PurchaseLogController::class);
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
        $response = $this->action('GET', 'Admin\PurchaseLogController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\PurchaseLogController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $purchaseLog = factory(\App\Models\PurchaseLog::class)->make();
        $this->action('POST', 'Admin\PurchaseLogController@store', [
                '_token' => csrf_token(),
            ] + $purchaseLog->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $purchaseLog = factory(\App\Models\PurchaseLog::class)->create();
        $this->action('GET', 'Admin\PurchaseLogController@show', [$purchaseLog->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $purchaseLog = factory(\App\Models\PurchaseLog::class)->create();

        $name = $faker->name;
        $id = $purchaseLog->id;

        $purchaseLog->purchase_info = $name;

        $this->action('PUT', 'Admin\PurchaseLogController@update', [$id], [
                '_token' => csrf_token(),
            ] + $purchaseLog->toArray());
        $this->assertResponseStatus(302);

        $newPurchaseLog = \App\Models\PurchaseLog::find($id);
        $this->assertEquals($name, $newPurchaseLog->purchase_info);
    }

    public function testDeleteModel()
    {
        $purchaseLog = factory(\App\Models\PurchaseLog::class)->create();

        $id = $purchaseLog->id;

        $this->action('DELETE', 'Admin\PurchaseLogController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkPurchaseLog = \App\Models\PurchaseLog::find($id);
        $this->assertNull($checkPurchaseLog);
    }

}
