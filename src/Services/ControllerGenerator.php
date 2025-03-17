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
        use App\Http\Requests\\{$model}StoreRequest;
        use App\Http\Requests\\{$model}UpdateRequest;
        use App\Http\Resources\\{$model}Resource;
        use Illuminate\Http\Response;
        use Illuminate\Http\Resources\Json\AnonymousResourceCollection as {$model}Collection;

        class {$model}Controller extends Controller
        {
            public function __construct(
                private readonly {$model}Service \$service
            ) {}

            /**
             * Retrieve a list of {$model}s.
             *
             * This method retrieves all the {$model}s in the database.
             *
             * @return {$model}Collection
             */
            public function index(): {$model}Collection
            {
                return {$model}Resource::collection(\$this->service->getAll());
            }

            /**
             * Retrieve a single {$model}.
             *
             * This method fetches a {$model} based on the provided data, typically from a unique identifier or other criteria. 
             * If no {$model} is found matching the provided data, the method may throw a not found exception.
             *
             * @param non-empty-string \$id
             * @return {$model}Resource
             */
            public function show(string \$id): {$model}Resource
            {
                return new {$model}Resource(\$this->service->getById(\$id));
            }

            /**
             * Create a new {$model} in the database.
             *
             * This method accepts the {$model} data and creates a new entry in the database. 
             * It will validate the input before creating the record, and then return the newly created {$model}.
             *
             * @param {$model}StoreRequest \$request
             * @return {$model}Resource
             */
            public function store({$model}StoreRequest \$request): {$model}Resource
            {
                return new {$model}Resource(
                    \$this->service->create(\$request->validated())
                );
            }

            /**
              * Update an existing {$model} with new data.
             *
             * This method allows you to update an existing {$model} record. It accepts the new data, validates it, 
             * and applies the changes to the corresponding {$model} record in the database. 
             * If the {$model} doesn't exist, an exception will be thrown.
             *
             * @param {$model}UpdateRequest \$request
             * @param non-empty-string \$id
             * @return {$model}Resource
             */
            public function update({$model}UpdateRequest \$request, string \$id): {$model}Resource
            {
                return new {$model}Resource(
                    \$this->service->update(\$id, \$request->validated())
                );
            }

            /**
              * Delete an existing {$model} from the database.
             *
             * This method deletes a {$model} from the database based on the provided data. 
             * It will return a no-content HTTP response (204) to indicate that the deletion was successful, 
             * with no additional data included in the response body.
             *
             * @param non-empty-string \$id
             * @return Response
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
