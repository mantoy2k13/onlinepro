<?php

\Route::group(['prefix' => 'admin', 'middleware' => ['admin.values']], function () {

    \Route::group(['middleware' => ['admin.guest']], function () {
        \Route::get('signin', 'Admin\AuthController@getSignIn');
        \Route::post('signin', 'Admin\AuthController@postSignIn');
        \Route::get('forgot-password', 'Admin\PasswordController@getForgotPassword');
        \Route::post('forgot-password', 'Admin\PasswordController@postForgotPassword');
        \Route::get('reset-password/{token}', 'Admin\PasswordController@getResetPassword');
        \Route::post('reset-password', 'Admin\PasswordController@postResetPassword');
    });

    \Route::group(['middleware' => ['admin.auth']], function () {
        \Route::get('bookings-export-excel', 'Admin\BookingController@exportExcel');
        \Route::put('bookings-cancel/{id}', 'Admin\BookingController@cancelBooking');
        \Route::get('teachers/export', 'Admin\TeacherController@exportExcel');
        \Route::get('users/export', 'Admin\UserController@exportExcel');
        \Route::get('reviews/export', 'Admin\ReviewController@exportExcel');
        \Route::get('paymentlogs/export', 'Admin\PaymentLogController@exportExcel');
        \Route::get('purchaselogs/export', 'Admin\PurchaseLogController@exportExcel');
        \Route::get('pointlogs/export', 'Admin\PointLogController@exportExcel');

        \Route::get('/', 'Admin\IndexController@index');
        \Route::get('/me', 'Admin\MeController@index');
        \Route::put('/me', 'Admin\MeController@update');
        \Route::get('/me/notifications', 'Admin\MeController@notifications');
        \Route::post('signout', 'Admin\AuthController@postSignOut');
        \Route::resource('users', 'Admin\UserController');
        \Route::resource('admin-users', 'Admin\AdminUserController');
        \Route::resource('site-configurations', 'Admin\SiteConfigurationController');
        \Route::post('articles/preview', 'Admin\ArticleController@preview');
        \Route::get('articles/images', 'Admin\ArticleController@getImages');
        \Route::post('articles/images', 'Admin\ArticleController@postImage');
        \Route::delete('articles/images', 'Admin\ArticleController@deleteImage');
        \Route::resource('articles', 'Admin\ArticleController');
        \Route::delete('images/delete', 'Admin\ImageController@deleteByUrl');
        \Route::resource('images', 'Admin\ImageController');
        \Route::resource('user-notifications', 'Admin\UserNotificationController');
        \Route::resource('admin-user-notifications', 'Admin\AdminUserNotificationController');
        \Route::resource('images', 'Admin\ImageController');
        \Route::resource('bookings', 'Admin\BookingController');
        \Route::resource('personalities', 'Admin\PersonalityController');
        \Route::resource('categories', 'Admin\CategoryController');
        \Route::resource('countries', 'Admin\CountryController');
        \Route::resource('provinces', 'Admin\ProvinceController');
        \Route::resource('payment-logs', 'Admin\PaymentLogController');
        \Route::resource('cities', 'Admin\CityController');
        \Route::resource('reviews', 'Admin\ReviewController');
        \Route::resource('inquiries', 'Admin\InquiryController');
        \Route::resource('purchase-logs', 'Admin\PurchaseLogController');

        \Route::resource('teachers', 'Admin\TeacherController');
        \Route::resource('point-logs', 'Admin\PointLogController');
        \Route::resource('teacher-notifications', 'Admin\TeacherNotificationController');
        \Route::resource('email-logs', 'Admin\EmailLogController');
        \Route::resource('lessons', 'Admin\LessonController');
        \Route::resource('text-books', 'Admin\TextBookController');
    });

});
