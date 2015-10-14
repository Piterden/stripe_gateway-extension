<?php

return [
    'mode'         => [
        'type'   => 'anomaly.field_type.boolean',
        'config' => [
            'on_text'  => 'LIVE',
            'off_text' => 'TEST'
        ]
    ],
    'test_api_key' => [
        'required' => true,
        'type'     => 'anomaly.field_type.encrypted'
    ],
    'live_api_key' => [
        'required' => true,
        'type'     => 'anomaly.field_type.encrypted'
    ]
];
