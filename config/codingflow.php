<?php

return [
    /*
    |--------------------------------------------------------------------------
    | CodingFlow Configuratie
    |--------------------------------------------------------------------------
    |
    | Dit bestand bepaalt welke componenten CodingFlow genereert en hoe.
    |
    */

    // ✨ Overschrijf bestaande bestanden automatisch?
    'overwrite_existing_files' => false,

    // 🏗️ Welke onderdelen moeten automatisch gegenereerd worden?
    'generators' => [
        'repositories' => true,
        'services' => true,
        'dtos' => true,
        'api_resources' => true,
        'feature_tests' => true,
        'observers' => true,
    ],

    // 🗂️ Bestandenstructuur
    'paths' => [
        'repositories' => app_path('Repositories'),
        'services' => app_path('Services'),
        'dtos' => app_path('DTOs'),
        'api_resources' => app_path('Http/Resources'),
        'feature_tests' => base_path('tests/Feature'),
        'observers' => app_path('Observers'),
    ],

    // 🛠 Blueprint monitoring
    'watch_blueprint' => true,

    // 🛡️ Code kwaliteit checks
    'code_quality' => [
        'phpstan' => true,
        'pint' => true,
        'rector' => true,
    ],
];
