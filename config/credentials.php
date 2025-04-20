<?php

return [
    'agora' => [
        'org_name' => env('AGORA_SDK_ORG_NAME'),
        'app_url' => env('AGORA_SDK_APP_URL'),
        'app_id' => env('AGORA_SDK_APP_ID'),
        'app_name' => env('AGORA_SDK_APP_NAME'),
        'lifetime' => env('AGORA_SDK_LIFETIME', 86400),
        'certificate' => env('AGORA_SDK_CERTIFICATE'),
        'service' => env('CALLING_SERVICE_URL'),
    ],
];

