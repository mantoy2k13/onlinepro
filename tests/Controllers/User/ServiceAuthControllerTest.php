<?php

namespace tests\Controllers\User;

use App\Models\User;
use Tests\TestCase;

/**
 * @group dev
 * */
class ServiceAuthControllerTest extends TestCase
{
    protected $useDatabase = true;

    public function testPostSignUpSuccess()
    {
        \Session::start();

        $faker = \Faker\Factory::create();
        $currentUserCount = User::count();

        $password = $faker->password;

        $this->post(action('User\AuthController@postSignUp'), [
            'email' => $faker->email,
            'password' => $password,
            'password_confirmation' => $password,
            'name' => $faker->name,
            'accept_terms_and_privacy_policy' => 1,
            '_token' => csrf_token(),
        ])->assertRedirectedToAction('User\AuthController@signUpSuccessful');

        $this->assertEquals($currentUserCount+1, User::count());
    }

    public function testPostSignUpWithExistUser()
    {
        \Session::start();

        $faker = \Faker\Factory::create();


        $email = $faker->email;

        factory(User::class)->create([
           'email' => $email,
        ]);

        $currentUserCount = User::count();

        $this->post(action('User\AuthController@postSignUp'), [
            'email' => $email,
            'password' => $faker->password,
            '_token' => csrf_token(),
        ])->assertRedirectedToAction('User\AuthController@getSignUp');

        $this->assertEquals($currentUserCount, User::count());
    }
}
