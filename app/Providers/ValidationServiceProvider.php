<?php
namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;

class ValidationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Validator::extend('old_password', function ($attribute, $value) {
            $user = \Auth::user();
            if ($user instanceof User) {
                return \Hash::check($value, $user->password);
            }

            return false;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
