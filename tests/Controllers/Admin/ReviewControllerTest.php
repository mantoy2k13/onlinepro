<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class ReviewControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\ReviewController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\ReviewController::class);
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
        $response = $this->action('GET', 'Admin\ReviewController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\ReviewController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $review = factory(\App\Models\Review::class)->make();
        $this->action('POST', 'Admin\ReviewController@store', [
                '_token' => csrf_token(),
            ] + $review->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $review = factory(\App\Models\Review::class)->create();
        $this->action('GET', 'Admin\ReviewController@show', [$review->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $review = factory(\App\Models\Review::class)->create();

        $name = $faker->name;
        $id = $review->id;

        $review->content = $name;

        $this->action('PUT', 'Admin\ReviewController@update', [$id], [
                '_token' => csrf_token(),
            ] + $review->toArray());
        $this->assertResponseStatus(302);

        $newReview = \App\Models\Review::find($id);
        $this->assertEquals($name, $newReview->content);
    }

    public function testDeleteModel()
    {
        $review = factory(\App\Models\Review::class)->create();

        $id = $review->id;

        $this->action('DELETE', 'Admin\ReviewController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkReview = \App\Models\Review::find($id);
        $this->assertNull($checkReview);
    }

}
