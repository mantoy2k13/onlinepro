<?php

return [
    'clientId' => env('PAYPAL_CLIENT_ID', ''),
    'secret' => env('PAYPAL_SECRET', ''),
    'email' => env('PAYPAL_EMAIL', ''),
    'mode' => env('PAYPAL_MODE', 'sandbox'),
];
