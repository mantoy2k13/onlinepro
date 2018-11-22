<?php

// Home
Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->push(trans('user.breadcrumbs.home'), action('User\IndexController@index'));
});

Breadcrumbs::register('beginner', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('user.breadcrumbs.beginner'), action('User\StaticPageController@beginner'));
});


Breadcrumbs::register('booking_confirm', function($breadcrumbs, $timeSlotId)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('user.breadcrumbs.booking_confirm'), action('User\BookingController@index', $timeSlotId));
});

Breadcrumbs::register('booking_success', function($breadcrumbs, $timeSlotId)
{
    $breadcrumbs->parent('booking_confirm', $timeSlotId);
    $breadcrumbs->push(trans('user.breadcrumbs.booking_completed'), action('User\BookingController@success', $timeSlotId));
});

Breadcrumbs::register('terms', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('user.breadcrumbs.terms'), action('User\StaticPageController@terms'));
});

Breadcrumbs::register('privacy', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('user.breadcrumbs.privacy'), action('User\StaticPageController@privacy'));
});

Breadcrumbs::register('faq', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Q &amp; A', action('User\StaticPageController@faq'));
});

Breadcrumbs::register('contacts', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('user.breadcrumbs.contacts'), action('User\ContactController@contactUs'));
});

Breadcrumbs::register('signup', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('user.breadcrumbs.signup'), action('User\AuthController@getSignUp'));
});

Breadcrumbs::register('signin', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('user.breadcrumbs.signin'), action('User\AuthController@getSignIn'));
});

Breadcrumbs::register('forgot-password', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('user.breadcrumbs.forgot_password'), action('User\PasswordController@getForgotPassword'));
});

Breadcrumbs::register('favorites', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('user.breadcrumbs.favorites'), action('User\IndexController@favoriteTeachers'));
});


Breadcrumbs::register('profile', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('user.breadcrumbs.profile'), action('User\ProfileController@show'));
});
Breadcrumbs::register('notice', function($breadcrumbs, $notice)
{
    $breadcrumbs->push($notice->title, action('User\ProfileController@showNotification', $notice->id));
});

Breadcrumbs::register('point', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('user.breadcrumbs.point'), action('User\ProfileController@show'));
});

Breadcrumbs::register('user-reservations', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('user.breadcrumbs.list_bookings'), action('User\BookingController@getReservations'));
});

Breadcrumbs::register('history-bookings', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('user.breadcrumbs.booking_history'), action('User\BookingController@getBookingHistories'));
});

Breadcrumbs::register('reviews-edit', function($breadcrumbs, $bookingId)
{
    $breadcrumbs->parent('history-bookings', $bookingId);
    $breadcrumbs->push(trans('user.breadcrumbs.review_edit'), action('User\ReviewController@writeReviewForm', $bookingId));
});

Breadcrumbs::register('reviews-complete', function($breadcrumbs, $bookingId)
{
    $breadcrumbs->parent('reviews-edit', $bookingId);
    $breadcrumbs->push(trans('user.breadcrumbs.review_complete'), action('User\ReviewController@complete', $bookingId));
});

Breadcrumbs::register('reviews-confirm', function($breadcrumbs, $bookingId)
{
    $breadcrumbs->parent('reviews-edit', $bookingId);
    $breadcrumbs->push(trans('user.breadcrumbs.review_confirm'), action('User\ReviewController@confirm', $bookingId));
});

Breadcrumbs::register('reviews-log', function($breadcrumbs, $reviewId)
{
    $breadcrumbs->parent('history-bookings', $reviewId);
    $breadcrumbs->push(trans('user.breadcrumbs.review_log'), action('User\ReviewController@reviewLogByTeacher', $reviewId));
});

Breadcrumbs::register('text-books', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('user.breadcrumbs.textbook'), action('User\TextBookController@index'));
});


Breadcrumbs::register('category', function($breadcrumbs, $category)
{
    $breadcrumbs->parent('home', $category->id);
    $breadcrumbs->push($category->present()->name, action('User\CategoryController@index', $category->slug));
});

Breadcrumbs::register('teacher-profile', function($breadcrumbs, $teacher)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('user.pages.category.teacher.teacher_profile'), action('User\CategoryController@teacher', $teacher->id));
});





