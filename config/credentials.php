<?php

return [
    'agora' => [
        'app_id' => env('AGORA_SDK_APP_ID'),
        'lifetime' => env('AGORA_SDK_LIFETIME', 86400),
        'app_certificate' => env('AGORA_SDK_CERTIFICATE'),
        'org_name' => env('AGORA_SDK_ORG_NAME'),
        'app_name' => env('AGORA_SDK_APP_NAME'),
        'app_url' => env('AGORA_SDK_APP_URL'),
    ],
];

