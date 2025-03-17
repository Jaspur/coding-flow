<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use RectorLaravel\Set\LaravelSetList;

return static function (RectorConfig $rectorConfig): void {
    // ✅ Bepaal de paden voor de codebase
    $rectorConfig->paths([
        __DIR__.'/src',
        // __DIR__.'/tests',
    ]);

    // ✅ Minimale PHP-versie (8.4)
    $rectorConfig->phpVersion(80400);

    // ✅ Regels voor automatische Laravel en PHP code verbeteringen
    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_84, // Upgrade naar PHP 8.4 standaarden
        SetList::CODE_QUALITY,      // Algemene code quality verbeteringen
        SetList::DEAD_CODE,         // Verwijderen van overbodige code
        SetList::TYPE_DECLARATION,  // Voeg missende type hints toe
        LaravelSetList::LARAVEL_110, // Optimalisaties voor Laravel 11+
    ]);

    // ✅ Extra Rector-instellingen
    $rectorConfig->parallel(); // Versnel de verwerking door parallelle verwerking
    $rectorConfig->importNames(); // Gebruik volledige class imports
    $rectorConfig->importShortClasses(); // Maak korte imports waar mogelijk

    // ✅ Specifieke Rector-regels uitschakelen (indien nodig)
    $rectorConfig->skip([
        __DIR__.'/vendor',       // Geen bewerkingen in de vendor-map
        __DIR__.'/storage',      // Geen bewerkingen in storage-map
        __DIR__.'/bootstrap',    // Geen bewerkingen in bootstrap-map
    ]);
};
