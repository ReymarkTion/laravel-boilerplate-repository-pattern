<?php

namespace App\Providers;

use Exception;
use Illuminate\Database\Eloquent\Builder;

class RepositoryServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $path = $this->getRepositoriesPath();
        $classes = $this->getClassesFromPath($path);

        foreach ($classes as $class) {
            try {
                if ($class == 'App\Repositories\Repository') {
                    continue;
                }
                $modelNamespace = $this->getModelNamespaceFromClass($class);

                if(!$modelNamespace)
                {
                    $modelNamespace = 'App\Models';
                }

                $model = $this->getModelNameFromClass($class, $modelNamespace);

                if ($model) {
                    $this->app->when($class)
                        ->needs(Builder::class)
                        ->give(function() use ($model) {
                            return call_user_func($model.'::query');
                        });
                }
            } catch (Exception $e) {
                continue;
            }
        }
    }

    private function getRepositoriesPath()
    {
        $path = app_path().'/Repositories';

        return $path;
    }
}
