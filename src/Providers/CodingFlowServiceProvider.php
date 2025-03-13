<?php

declare(strict_types=1);

namespace Jaspur\CodingFlow\Providers;

use Illuminate\Support\ServiceProvider;

class CodingFlowServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/codingflow.php', 'codingflow');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Jaspur\CodingFlow\Console\GenerateRepositories::class,
                \Jaspur\CodingFlow\Console\GenerateServices::class,
                \Jaspur\CodingFlow\Console\GenerateDTOs::class,
                \Jaspur\CodingFlow\Console\GenerateAPIResources::class,
                \Jaspur\CodingFlow\Console\GenerateFeatureTests::class,
                \Jaspur\CodingFlow\Console\GenerateObservers::class,
            ]);
        }

        $this->publishes([
            __DIR__.'/../../config/codingflow.php' => config_path('codingflow.php'),
        ], 'config');
    }
}
