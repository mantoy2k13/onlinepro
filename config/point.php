<?php

return [
    'validityInDays' => 30,
    'package' => [
        'light' => [
            'name' => 'user.pages.points.package.light',
            'value' => ['point' => 15, 'amount' => 6780]
        ],
        'basic' => [
            'name' => 'user.pages.points.package.basic',
            'value' => ['point' => 30, 'amount' => 10780]
        ],
        'premium' => [
            'name' => 'user.pages.points.package.premium',
            'value' => ['point' => 60, 'amount' => 14780]
        ],
    ],
    'default_amount' => 6780,
    'currency_code' => 'JPY',
    'point_per_booking' => 1,
    'point_per_refund' => 1,
];
