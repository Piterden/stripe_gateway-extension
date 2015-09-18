<?php

return [
    'live'         => [
        'type' => 'anomaly.field_type.boolean'
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
