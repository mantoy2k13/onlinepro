<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Models\User::class, function(Faker\Generator $faker) {
    return [
        'name'                 => $faker->name,
        'email'                => $faker->email,
        'password'             => bcrypt(str_random(10)),
        'remember_token'       => str_random(10),
        'locale'               => $faker->languageCode,
        'last_notification_id' => 0,
        'profile_image_id'     => 0,
        'points'               => 0,
        'skype_id'             => $faker->userName,
        'gender'               => 'male',
        'year_of_birth'        => $faker->year,
        'living_country_code'  => $faker->countryCode,
        'living_city_id'       => 0,
        'status'            => 0,
        'validation_code'    => '',
    ];
});

$factory->define(App\Models\AdminUser::class, function(Faker\Generator $faker) {
    return [
        'name'                 => $faker->name,
        'email'                => $faker->email,
        'password'             => bcrypt(str_random(10)),
        'remember_token'       => str_random(10),
        'locale'               => $faker->languageCode,
        'status'               => 1,
        'last_notification_id' => 0,
        'api_access_token'     => '',
        'profile_image_id'     => 0,
    ];
});

$factory->define(App\Models\SiteConfiguration::class, function(Faker\Generator $faker) {
    return [
        'locale'                => 'ja',
        'name'                  => $faker->name,
        'title'                 => $faker->sentence,
        'keywords'              => implode(',', $faker->words(5)),
        'description'           => $faker->sentences(3, true),
        'ogp_image_id'          => 0,
        'twitter_card_image_id' => 0,
    ];
});

$factory->define(App\Models\Image::class, function(Faker\Generator $faker) {
    return [
        'url'                => $faker->imageUrl(),
        'title'              => $faker->sentence,
        'is_local'           => false,
        'entity_type'        => '',
        'entity_id'          => 0,
        'file_category_type' => '',
        's3_key'             => '',
        's3_bucket'          => '',
        's3_region'          => '',
        's3_extension'       => '',
        'media_type'         => 'image/png',
        'format'             => 'png',
        'file_size'          => 0,
        'width'              => 100,
        'height'             => 100,
        'is_enabled'         => true,
    ];
});

$factory->define(App\Models\Article::class, function(Faker\Generator $faker) {
    return [
        'slug'               => $faker->word,
        'title'              => $faker->sentence,
        'keywords'           => implode(',', $faker->words(5)),
        'description'        => $faker->sentences(3, true),
        'content'            => $faker->sentences(3, true),
        'cover_image_id'     => 0,
        'locale'             => 'ja',
        'is_enabled'         => true,
        'publish_started_at' => $faker->dateTime->format('Y-m-d H:i:s'),
        'publish_ended_at'   => null,
    ];
});

$factory->define(App\Models\UserNotification::class, function(Faker\Generator $faker) {
    return [
        'user_id'       => \App\Models\UserNotification::BROADCAST_USER_ID,
        'category_type' => \App\Models\UserNotification::CATEGORY_TYPE_SYSTEM_MESSAGE,
        'type'          => \App\Models\UserNotification::TYPE_GENERAL_MESSAGE,
        'data'          => '',
        'locale'        => 'en',
        'title'         => '',
        'content'       => 'TEST',
        'read'          => false,
        'sent_at'       => $faker->dateTime,
    ];
});

$factory->define(App\Models\AdminUserNotification::class, function(Faker\Generator $faker) {
    return [
        'user_id'       => \App\Models\AdminUserNotification::BROADCAST_USER_ID,
        'category_type' => \App\Models\AdminUserNotification::CATEGORY_TYPE_SYSTEM_MESSAGE,
        'type'          => \App\Models\AdminUserNotification::TYPE_GENERAL_MESSAGE,
        'title'         => '',
        'data'          => '',
        'locale'        => 'en',
        'content'       => 'TEST',
        'read'          => false,
        'sent_at'       => $faker->dateTime,
    ];
});

$factory->define(App\Models\Teacher::class, function(Faker\Generator $faker) {
    return [
        'name'                          => $faker->name,
        'email'                         => $faker->email,
        'password'                      => $faker->md5,
        'skype_id'                      => $faker->userName,
        'rating'                        => 3,
        'locale'                        => $faker->locale,
        'last_notification_id'          => 0,
        'profile_image_id'              => 0,
        'year_of_birth'                 => $faker->year,
        'gender'                        => 'male',
        'status'                        => 1,
        'living_country_code'           => 'th',
        'living_city_id'                => 0,
        'living_start_date'             => $faker->date(),
        'self_introduction'             => '',
        'introduction_from_admin'       => '',
        'hobby'                         => '',
        'nationality_country_code'      => 'jp',
        'home_province_id'              => 0,
        'bank_account_info'             => '',
        'remember_token'                => '',
    ];
});

$factory->define(App\Models\TimeSlot::class, function(Faker\Generator $faker) {
    return [
        'teacher_id' => 0,
        'start_at'   => $faker->dateTime,
        'end_at'     => $faker->dateTime,
    ];
});

$factory->define(App\Models\Booking::class, function(Faker\Generator $faker) {
    return [
        'user_id'        => 0,
        'teacher_id'     => 0,
        'time_slot_id'   => 0,
        'category_id'    => 0,
        'status'         => '',
        'message'        => $faker->sentence,
        'payment_log_id' => 0,
    ];
});


$factory->define(App\Models\PurchaseLog::class, function(Faker\Generator $faker) {
    return [
        'user_id'                => 0,
        'purchase_method_type'   => 'paypal',
        'point_amount'           => $faker->numberBetween(10, 100),
        'purchase_info'          => '',
        'point_expired_at'       => $faker->dateTimeThisMonth,
        'remaining_point_amount' => 0,
    ];
});

$factory->define(App\Models\PointLog::class, function(Faker\Generator $faker) {
    return [
        'user_id'         => 1,
        'point_amount'    => $faker->numberBetween(0, 100),
        'type'            => 'booking',
        'description'     => '',
        'booking_id'      => 1,
        'purchase_log_id' => 1,
    ];
});

$factory->define(App\Models\Review::class, function(Faker\Generator $faker) {
    return [
        'target'     => 'user',
        'user_id'    => 0,
        'teacher_id' => 0,
        'booking_id' => 0,
        'rating'     => 5,
        'content'    => $faker->sentence,
    ];
});

$factory->define(App\Models\FavoriteTeacher::class, function(Faker\Generator $faker) {
    return [
        'user_id'    => 0,
        'teacher_id' => 0,
    ];
});

$factory->define(App\Models\PaymentLog::class, function(Faker\Generator $faker) {
    return [
        'teacher_id'     => 0,
        'status'         => 'paid',
        'paid_amount'    => 1,
        'paid_for_month' => $faker->date('Y-m', 'now'),
        'paid_at'        => $faker->date('Y-m-d'),
        'note'           => '',
    ];
});

$factory->define(App\Models\Province::class, function(Faker\Generator $faker) {
    return [
        'country_code' => $faker->countryCode,
        'name_en'      => $faker->city,
        'name_ja'      => $faker->city,
        'order'        => 0,
    ];
});

$factory->define(App\Models\TeacherNotification::class, function(Faker\Generator $faker) {
    return [
        'user_id'       => 0,
        'category_type' => '',
        'title'         => $faker->sentence,
        'type'          => '',
        'data'          => '',
        'content'       => $faker->sentence,
        'locale'        => 'ja',
        'read'          => false,
        'sent_at'       => $faker->dateTime,
    ];
});

$factory->define(App\Models\TeacherServiceAuthentication::class, function(Faker\Generator $faker) {
    return [
        'user_id'    => 0,
        'name'       => $faker->name,
        'email'      => $faker->email,
        'service'    => '',
        'service_id' => 0,
    ];
});

$factory->define(App\Models\Country::class, function(Faker\Generator $faker) {
    return [
        'code'    => $faker->countryCode,
        'name_en' => $faker->country,
        'name_ja' => $faker->country,
        'order'   => 0,
    ];
});

$factory->define(App\Models\Category::class, function(Faker\Generator $faker) {
    return [
        'name_ja'        => $faker->name,
        'name_en'        => $faker->name,
        'slug'           => $faker->word,
        'image_id'       => 0,
        'description_ja' => $faker->sentences(3, true),
        'description_en' => $faker->sentences(3, true),
        'order'          => 0,
    ];
});

$factory->define(App\Models\TeacherCategory::class, function(Faker\Generator $faker) {
    return [
        'teacher_id'  => 0,
        'category_id' => 0,
    ];
});

$factory->define(App\Models\Personality::class, function(Faker\Generator $faker) {
    return [
        'name_en' => $faker->name,
        'name_ja' => $faker->name,
        'name_vi' => $faker->name,
        'name_zh' => $faker->name,
        'name_ru' => $faker->name,
        'name_ko' => $faker->name,
        'order'   => 0,
    ];
});

$factory->define(App\Models\City::class, function(Faker\Generator $faker) {
    return [
        'name_en'      => $faker->city,
        'name_ja'      => $faker->city,
        'country_code' => $faker->countryCode,
        'order'        => 0,
    ];
});

$factory->define(App\Models\TeacherPersonality::class, function(Faker\Generator $faker) {
    return [
        'teacher_id'     => 0,
        'personality_id' => 0,
    ];
});

$factory->define(App\Models\Inquiry::class, function(Faker\Generator $faker) {
    return [
        'type'                => 'contact',
        'user_id'             => 0,
        'name'                => $faker->name,
        'email'               => $faker->email,
        'living_country_code' => $faker->countryCode,
        'content'             => $faker->sentences(5, true),
    ];
});

$factory->define(App\Models\EmailLog::class, function (Faker\Generator $faker) {
    return [
        'new_email' => $faker->email,
        'old_email' => 'old_'.$faker->email,
        'user_id' => 0,
        'status' => 0,
        'validation_code' => '',
    ];
});

$factory->define(App\Models\Lesson::class, function (Faker\Generator $faker) {
    return [
        'name_ja'        => $faker->name,
        'name_en'        => $faker->name,
        'slug'           => $faker->word,
        'image_id'       => 0,
        'description_ja' => $faker->sentences(3, true),
        'description_en' => $faker->sentences(3, true),
        'order'          => 0,
    ];
});

$factory->define(App\Models\TeacherLesson::class, function (Faker\Generator $faker) {
    return [
        'teacher_id' => 0,
        'lesson_id' => 0,
    ];
});

$factory->define(App\Models\TextBook::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->name,
        'level' => '',
        'file_id' => 0,
        'content' => '',
        'order' => 0,
    ];
});

/* NEW MODEL FACTORY */
