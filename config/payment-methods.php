<?php

return [

    'enabled' => [
        'mercadopago',
    ],

    'use_sandbox' => env('MP_MODE_SANDBOX', true),

    'mercadopago' => [
        // 'logo' => '/img/payment/mercadopago.png',
        'display' => 'MercadoPago',
        'client' => env('MP_CLIENT'),
        'secret' => env('MP_SECRET'),
        'access_token' => env('MP_TOKEN'),
    ],



];