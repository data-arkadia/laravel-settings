<?php

return [
    'useCache' => env('LARAVEL_SETTING_USE_CACHE', true),

    'storeSettingValuesPerUser' => true,

    'nova' => [
        'settingsShowAllFields' => env('SETTING_NOVA_SETTINGS_SHOW_ALL_FIELDS', false),
    ],
];
