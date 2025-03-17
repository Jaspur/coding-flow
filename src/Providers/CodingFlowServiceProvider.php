<?php

declare(strict_types=1);

namespace Jaspur\CodingFlow\Providers;

use Jaspur\CodingFlow\Console\GenerateAPIResources;
use Jaspur\CodingFlow\Console\GenerateDTOs;
use Jaspur\CodingFlow\Console\GenerateFeatureTests;
use Jaspur\CodingFlow\Console\GenerateObservers;
use Jaspur\CodingFlow\Console\GenerateRepositories;
use Jaspur\CodingFlow\Console\GenerateServices;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CodingFlowServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('codingflow')
            ->hasConfigFile()
            ->hasCommands([
                GenerateRepositories::class,
                GenerateServices::class,
                GenerateDTOs::class,
                GenerateAPIResources::class,
                GenerateFeatureTests::class,
                GenerateObservers::class,
            ])
            ->hasInstallCommand(function (InstallCommand $command): void {
                $command
                    ->publishConfigFile()
                    ->copyAndRegisterServiceProviderInApp()
                    ->askToStarRepoOnGitHub('Jaspur/coding-flow');
            });

    }
}
