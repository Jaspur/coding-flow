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
    'overwrite_existing_files' => true, // @todo implement

    // 🏗️ Welke onderdelen moeten automatisch gegenereerd worden?
    'generators' => [
        'repositories' => true,
        'services' => true,
        'dtos' => false, // @todo implement
        'api_resources' => true,  // @todo implement
        'feature_tests' => true,
        'observers' => true,
        'controllers' => true,
    ],

    // 🛠 Blueprint monitoring
    'watch_blueprint' => true, // @todo implement

    // 🛡️ Code kwaliteit checks // @todo implement
    'code_quality' => [
        'phpstan' => true,
        'pint' => true,
        'rector' => true,
    ],
];
