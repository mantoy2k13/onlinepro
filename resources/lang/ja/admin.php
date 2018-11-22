<?php

return [
    'menu'     => [
        'dashboard'          => 'Dashboard',
        'admin_users'        => 'Admin Users',
        'users'              => 'Users',
        'site-configuration' => 'Site Configuration',
    ],
    'messages' => [
        'general' => [
            'update_success' => 'Successfully updated.',
            'create_success' => 'Successfully created.',
            'delete_success' => 'Successfully deleted.',
            'cancel_success' => 'Successfully canceled.',
            'cancel_failed'  => 'Cancel failed.',
        ],
    ],
    'errors'   => [
        'general'  => [
            'save_failed' => 'Failed To Save. Please contact with developers',
        ],
        'requests' => [
            'me'        => [
                'email'    => [
                    'required' => 'Email Required',
                    'email'    => 'Email is not valid',
                ],
                'password' => [
                    'min' => 'Password need at least 6 letters',
                ],
            ],
            'point_log' => [
                'point_amount_min' => 'Point amount must at least :point_amount',
            ],
        ],
    ],
    'pages'    => [
        'common'                   => [
            'buttons' => [
                'create'          => 'Create New',
                'edit'            => 'Edit',
                'save'            => 'Save',
                'delete'          => 'Delete',
                'cancel'          => 'Cancel',
                'add'             => 'Add',
                'preview'         => 'Preview',
                'forgot_password' => 'Send Me Email!',
                'reset_password'  => 'Reset Password',
                'search'          => 'Search',
                'back'            => 'Back',
            ],
            'label'   => [
                'total_result' => 'Total',
            ],
        ],
        'auth'                     => [
            'buttons'  => [
                'sign_in'         => 'Sign In',
                'forgot_password' => 'Send Me Email!',
                'reset_password'  => 'Reset Password',
            ],
            'messages' => [
                'remember_me'     => 'Remember Me',
                'please_sign_in'  => 'Sign in to start your session',
                'forgot_password' => 'I forgot my password',
                'reset_password'  => 'Please enter your e-mail address and new password',
            ],
        ],
        'site-configurations'      => [
            'columns' => [
                'locale'                => 'Locale',
                'name'                  => 'Name',
                'title'                 => 'Title',
                'keywords'              => 'Keywords',
                'description'           => 'Descriptions',
                'ogp_image_id'          => 'OGP Image',
                'twitter_card_image_id' => 'Twitter Card Image',
            ],
        ],
        'articles'                 => [
            'columns' => [
                'slug'               => 'Slug',
                'title'              => 'Title',
                'keywords'           => 'Keywords',
                'description'        => 'Description',
                'content'            => 'Content',
                'cover_image_id'     => 'Cover Image',
                'locale'             => 'Locale',
                'is_enabled'         => 'Active',
                'publish_started_at' => 'Publish Started At',
                'publish_ended_at'   => 'Publish Ended At',
                'is_enabled_true'    => 'Enabled',
                'is_enabled_false'   => 'Disabled',

            ],
        ],
        'user-notifications'       => [
            'columns' => [
                'user_id'       => 'User',
                'category_type' => 'Category',
                'title'         => 'Title',
                'type'          => 'Type',
                'data'          => 'Data',
                'locale'        => 'Locale',
                'content'       => 'Content',
                'read'          => 'Read',
                'read_true'     => 'Read',
                'read_false'    => 'Unread',
                'sent_at'       => 'Sent At',
            ],
        ],
        'admin-user-notifications' => [
            'columns' => [
                'user_id'       => 'User',
                'category_type' => 'Category',
                'type'          => 'Type',
                'data'          => 'Data',
                'locale'        => 'Locale',
                'content'       => 'Content',
                'read'          => 'Read',
                'read_true'     => 'Read',
                'read_false'    => 'Unread',
                'sent_at'       => 'Sent At',
            ],
        ],
        'users'                    => [
            'columns' => [
                'name'           => 'Name',
                'email'          => 'Email',
                'skype_id'       => 'Skype',
                'living_city'    => 'Living city',
                'gender'         => 'Gender',
                'profile_image'  => 'Profile image',
                'living_country' => 'Living country',
                'year_of_birth'  => 'Year of birth',
                'points'         => 'Points',
                'register_type'  => 'Type',
                'created_at'     => 'Created at',
                'status'         => 'Status',
            ],
        ],
        'images'                   => [
            'columns' => [
                'url'                    => 'URL',
                'title'                  => 'Title',
                'is_local'               => '',
                'entity_type'            => 'EntityType',
                'entity_id'              => 'ID',
                'file_category_type'     => 'Category',
                's3_key'                 => '',
                's3_bucket'              => '',
                's3_region'              => '',
                's3_extension'           => '',
                'media_type'             => 'Media Type',
                'format'                 => 'Format',
                'file_size'              => 'File Size',
                'width'                  => 'Width',
                'height'                 => 'Height',
                'has_alternative'        => '',
                'alternative_media_type' => '',
                'alternative_format'     => '',
                'alternative_extension'  => '',
                'is_enabled'             => 'Status',
                'is_enabled_true'        => 'Enabled',
                'is_enabled_false'       => 'Disabled',
            ],
        ],
        'categories'               => [
            'columns' => [
                'name_ja'        => 'Japanese name',
                'name_en'        => 'English name',
                'image_id'       => 'Image',
                'description_ja' => 'Japanese description',
                'description_en' => 'English description',
                'order'          => 'Order',
                'slug'           => 'Slug',
            ],
        ],
        'countries'                => [
            'columns' => [
                'code'          => 'Code',
                'name_en'       => 'English name',
                'name_ja'       => 'Japanese name',
                'flag_image_id' => 'Flag image',
                'order'         => 'Order',
            ],
        ],
        'provinces'                => [
            'columns' => [
                'name_en'      => 'English name',
                'name_ja'      => 'Japanese name',
                'country_code' => 'Country code',
                'order'        => 'Order',
            ],
        ],
        'cities'                   => [
            'columns' => [
                'name_en'      => 'English name',
                'name_ja'      => 'Japanese name',
                'country_code' => 'Country code',
                'order'        => 'Order',
            ],
        ],
        'personalities'            => [
            'columns' => [
                'name_en' => 'English name',
                'name_ja' => 'Japanese name',
                'name_vi' => 'Vietnamese name',
                'name_zh' => 'Chinese name',
                'name_ru' => 'Russian name',
                'name_ko' => 'Korea name',
                'order'   => 'Order',
            ],
        ],
        'payment-logs'             => [
            'columns' => [
                'teacher_id'     => 'Teacher',
                'status'         => 'Status',
                'paid_amount'    => 'Paid amount',
                'note'           => 'Note',
                'paid_for_month' => 'Pay for month',
                'paid_at'        => 'Pay time',
            ],
        ],
        'reviews'                  => [
            'columns' => [
                'target'     => 'Target',
                'user_id'    => 'User',
                'teacher_id' => 'Teacher',
                'booking_id' => 'Booking',
                'rating'     => 'Rating',
                'content'    => 'Content',
            ],
        ],
        'inquiries'                => [
            'columns' => [
                'type'                => 'Type',
                'user_id'             => 'User',
                'name'                => 'Name',
                'email'               => 'Email',
                'living_country_code' => 'Living country',
                'content'             => 'Content',
            ],
        ],
        'purchase-logs'            => [
            'columns' => [
                'user_id'              => 'User id',
                'purchase_method_type' => 'Type',
                'point_amount'         => 'Point amount',
                'purchase_info'        => 'Purchase info',
                'user'                 => 'User',
                'created_at'           => 'Created at',
            ],
        ],
        'teachers'                 => [
            'columns' => [
                'name'                     => 'Name',
                'email'                    => 'Email',
                'password'                 => 'Password',
                'skype_id'                 => 'Skype',
                'locale'                   => 'Locale',
                'last_notification_id'     => 'Last notification',
                'profile_image_id'         => 'Profile image',
                'year_of_birth'            => 'Year of birth',
                'gender'                   => 'Gender',
                'living_country_code'      => 'Living country',
                'living_city_id'           => 'Living city',
                'living_start_date'        => 'Living start date',
                'self_introduction'        => 'Self introduction',
                'introduction_from_admin'  => 'OnlineProから一言',
                'hobby'                    => 'Hobby',
                'characteristic_id'        => 'Characteristic',
                'nationality_country_code' => 'Nationality country',
                'home_province_id'         => 'Home province',
                'bank_account_info'        => 'Bank account info',
                'personality_id'           => 'Personalities',
                'category_id'              => 'Categories',
                'lesson_id'                => 'Lessons',
                'remember_token'           => 'Remember',
                'status'                   => 'Status',
            ],
        ],
        'bookings'                 => [
            'columns' => [
                'user_id'               => 'Member',
                'teacher_id'            => 'Teacher',
                'time_slot_id'          => 'Time slot',
                'status'                => 'Status',
                'payment_log_id'        => 'Payment log',
                'message'               => 'Message',
                'date_from'             => 'Date from',
                'date_to'               => 'Date to',
                'counseling_start_time' => 'Counseling start time',
                'counseling_end_time'   => 'Counseling end time',
            ],
        ],
        'point-logs'               => [
            'columns' => [
                'user_id'      => 'User',
                'point_amount' => 'Point amount',
                'type'         => 'Type',
                'description'  => 'Description',
                'related_id'   => 'Booking',
                'expire_at'    => 'Expire at',
                'created_at'   => 'Created at',
            ],
        ],
        'teacher-notifications'    => [
            'columns' => [
                'user_id'       => 'Teacher',
                'category_type' => 'Category',
                'type'          => 'Type',
                'title'         => 'Title',
                'data'          => 'data',
                'locale'        => 'Locale',
                'content'       => 'Content',
                'read'          => 'Is read',
                'sent_at'       => 'Sent at',
            ],
        ],
        'email-logs'               => [
            'columns' => [
                'new_email'       => 'New email',
                'old_email'       => 'Old email',
                'user_id'         => 'User',
                'status'          => 'Status',
                'status_true'     => 'Verified',
                'status_false'    => 'Not verify',
                'validation_code' => 'Validation code',
            ],
        ],
        'lessons'                  => [
            'columns' => [
                'name_ja'        => 'Japanese Name',
                'name_en'        => 'English Name',
                'slug'           => 'Slug',
                'image_id'       => 'Image',
                'description_ja' => 'Description in Japanese',
                'description_en' => 'Description in English',
                'order'          => 'Order',
            ],
        ],
        'text-books'               => [
            'columns' => [
                'title'   => 'Title',
                'level'   => 'Level',
                'file_id' => 'File',
                'content' => 'Content',
                'order'   => 'Order',
            ],
        ],
        /* NEW PAGE STRINGS */
    ],
    'roles'    => [
        'super_user' => 'Super User',
        'site_admin' => 'Site Administrator',
    ],
];
