<?php

\Route::group(['middleware' => ['user.values']], function () {
    \Route::get('/', 'User\IndexController@index');
    \Route::get('beginner', 'User\StaticPageController@beginner');
    \Route::get('faq', 'User\StaticPageController@faq');
    \Route::get('terms', 'User\StaticPageController@terms');
    \Route::get('privacy', 'User\StaticPageController@privacy');

    \Route::get('verifyChangeEmail/{validation_code}', 'User\AuthController@verifyChangeEmail');

    \Route::group(['middleware' => ['user.guest']], function () {
        \Route::get('signin', 'User\AuthController@getSignIn');
        \Route::post('signin', 'User\AuthController@postSignIn');
        \Route::post('signin-popup', 'User\AuthController@postSignInPopUp');


        \Route::get('signin/facebook', 'User\FacebookServiceAuthController@redirect');
        \Route::get('signin/facebook/callback', 'User\FacebookServiceAuthController@callback');

        \Route::get('signin/google', 'User\GoogleServiceAuthController@redirect');
        \Route::get('signin/google/callback', 'User\GoogleServiceAuthController@callback');

        \Route::get('forgot-password', 'User\PasswordController@getForgotPassword');
        \Route::post('forgot-password', 'User\PasswordController@postForgotPassword');

        \Route::get('reset-password/{token}', 'User\PasswordController@getResetPassword');
        \Route::post('reset-password', 'User\PasswordController@postResetPassword');

        \Route::get('signup', 'User\AuthController@getSignUp');
        \Route::post('signup', 'User\AuthController@postSignUp');

        \Route::get('verify/{validation_code}', 'User\AuthController@verify');
        \Route::get('signup-successful', 'User\AuthController@signUpSuccessful');
    });

    \Route::group(['prefix' => 'contacts'], function() {
        \Route::get('/', 'User\ContactController@contactUs');
        \Route::post('/confirm', 'User\ContactController@confirmContact');
        \Route::post('/', 'User\ContactController@postContact');
        \Route::get('/complete', 'User\ContactController@completeContact');
    });

    \Route::group(['prefix' => 'category'], function() {
        \Route::get('/{id}', 'User\CategoryController@index');

    });

    \Route::group(['prefix' => 'categories'], function() {
        \Route::get('/{slug}', 'User\CategoryController@index');
        \Route::get('/{id}/teachers', 'User\CategoryController@teacher');

    });



    \Route::group(['middleware' => ['user.auth']], function () {
        \Route::post('signout', 'User\AuthController@postSignOut');

        \Route::get('me', 'User\ProfileController@index');
        \Route::get('me/notifications/{notification_id}', 'User\ProfileController@showNotification');

        \Route::post('/{teacher_id}/favorites', 'User\IndexController@addFavoriteTeacher');
        \Route::delete('/{teacher_id}/favorites', 'User\IndexController@removeFavoriteTeacher');
        \Route::get('/favorites', 'User\IndexController@favoriteTeachers');
        \Route::get('/{teacher_id}/teacher-profile', 'User\IndexController@teacherProfile');

        \Route::get('profile', 'User\ProfileController@show');
        \Route::put('profile', 'User\ProfileController@updateProfile');

        \Route::group(['prefix' => 'bookings'], function() {
            \Route::get('/', 'User\BookingController@getBookingHistories');
            \Route::get('/{id}/success', 'User\BookingController@success');
            \Route::get('/{id}', 'User\BookingController@index');
            \Route::post('/{id}', 'User\BookingController@booking');

        });
        \Route::group(['prefix' => 'text-books'], function() {
            \Route::get('/', 'User\TextBookController@index');
        });

        \Route::group(['prefix' => 'reviews'], function() {
            \Route::get('/{review_id}/log', 'User\ReviewController@reviewLogByTeacher');
            \Route::get('/{booking_id}/write', 'User\ReviewController@writeReviewForm');
            \Route::post('/{booking_id}/confirm', 'User\ReviewController@confirm');
            \Route::post('/{booking_id}/complete', 'User\ReviewController@complete');
            \Route::get('/{booking_id}/complete', 'User\ReviewController@completeReview');
        });

        \Route::group(['prefix' => 'point'], function() {

            \Route::get('/', 'User\PointController@index');
            \Route::post('confirm', 'User\PointController@confirmPurchase');
            \Route::get('success', 'User\PointController@purchaseSuccessful');
            \Route::get('complete', 'User\PointController@completePurchase');
        });


        \Route::get('reservations', 'User\BookingController@getReservations');
        \Route::delete('reservations/{booking_id}', 'User\BookingController@cancelReservation');

    });
});
