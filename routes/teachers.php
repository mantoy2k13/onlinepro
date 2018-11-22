<?php

\Route::group(['middleware' => ['teacher.values']], function () {
    \Route::get('/', 'Teacher\IndexController@index');

    \Route::group(['middleware' => ['teacher.guest']], function () {
        \Route::get('signin', 'Teacher\AuthController@getSignIn');
        \Route::post('signin', 'Teacher\AuthController@postSignIn');

        \Route::get('signin/facebook', 'Teacher\FacebookServiceAuthController@redirect');
        \Route::get('signin/facebook/callback', 'Teacher\FacebookServiceAuthController@callback');

        \Route::get('forgot-password', 'Teacher\PasswordController@getForgotPassword');
        \Route::post('forgot-password', 'Teacher\PasswordController@postForgotPassword');

        \Route::get('reset-password/{token}', 'Teacher\PasswordController@getResetPassword');
        \Route::post('reset-password', 'Teacher\PasswordController@postResetPassword');

        \Route::get('signup', 'Teacher\AuthController@getSignUp');
        \Route::post('signup', 'Teacher\AuthController@postSignUp');

    });

    \Route::group(['middleware' => ['teacher.auth']], function () {
        \Route::post('signout', 'Teacher\AuthController@postSignOut');
        \Route::get('profile', 'Teacher\ProfileController@show');
        \Route::put('profile', 'Teacher\ProfileController@updateProfile');

        \Route::get('time-slots/{date}', 'Teacher\IndexController@timeSlot');
        \Route::post('time-slots-update', 'Teacher\IndexController@openCloseTimeSlot');
        \Route::post('time-slots-update-all', 'Teacher\IndexController@openCloseAllTimeSlot');
        \Route::get('calendar-registration/{date}', 'Teacher\IndexController@calendarRegistration');
        \Route::get('reservations', 'Teacher\IndexController@getReservations');
        \Route::delete('reservations/{booking_id}', 'Teacher\IndexController@cancelReservation');
        \Route::post('reviews', 'Teacher\IndexController@writeReview');
    });
});
