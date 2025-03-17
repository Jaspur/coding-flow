<?php

declare(strict_types=1);

namespace Jaspur\CodingFlow\Services;

use Illuminate\Support\Facades\File;

class ControllerGenerator
{
    public function generate(string $model): void
    {
        $controllerPath = app_path("Http/Controllers/{$model}Controller.php");

        if (! config('codingflow.generators.controllers', true)) {
            return;
        }

        if (File::exists($controllerPath) && ! config('codingflow.overwrite_existing_files', false)) {
            return;
        }

        File::ensureDirectoryExists(dirname($controllerPath));
        File::put($controllerPath, $this->getStub($model));
    }

    private function getStub(string $model): string
    {
        return <<<PHP
        <?php

        declare(strict_types=1);

        namespace App\Http\Controllers;

        use App\Services\\{$model}Service;
        use App\Http\Requests\\{$model}Request;
        use App\Http\Resources\\{$model}Resource;
        use Illuminate\Http\Response;
        use Illuminate\Http\Resources\Json\AnonymousResourceCollection as {$model}Collection;

        class {$model}Controller extends Controller
        {
            public function __construct(
                private readonly {$model}Service \$service
            ) {}

            /**
             * Haal alle records op
             */
            public function index(): {$model}Collection
            {
                return {$model}Resource::collection(\$this->service->getAll());
            }

            /**
             * Haal een specifiek record op
             */
            public function show(string \$id): {$model}Resource
            {
                return new {$model}Resource(\$this->service->getById(\$id));
            }

            /**
             * Maak een nieuw record aan
             */
            public function store({$model}Request \$request): {$model}Resource
            {
                return new {$model}Resource(
                    \$this->service->create(\$request->validated())
                );
            }

            /**
             * Werk een bestaand record bij
             */
            public function update({$model}Request \$request, string \$id): {$model}Resource
            {
                return new {$model}Resource(
                    \$this->service->update(\$id, \$request->validated())
                );
            }

            /**
             * Verwijder een record
             */
            public function destroy(string \$id): Response
            {
                \$this->service->delete(\$id);
                return response()->noContent();
            }
        }
        PHP;
    }
}
