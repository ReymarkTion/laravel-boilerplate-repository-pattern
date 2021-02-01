<?php

namespace App\Providers;

use Exception;
use Illuminate\Database\Eloquent\Model;

class FactoryServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $path = $this->getFactoriesPath();
        $classes = $this->getClassesFromPath($path);
        foreach ($classes as $class) {
            try {
                if ($class == 'App\Factories\Factory') {
                    continue;
                }
                $modelNamespace = $this->getModelNamespaceFromClass($class);
                if(!$modelNamespace){
                    $modelNamespace = 'App\Models';
                }
                $model = $this->getModelNameFromClass($class, $modelNamespace);
                if ($model) {
                    $this->app->when($class)
                        ->needs(Model::class)
                        ->give(function() use ($model) {
                            return new $model;
                        });
                }
            } catch (Exception $e) {
                continue;
            }
        }
    }

    private function getFactoriesPath()
    {
        $path = app_path().'/Factories';
        return $path;
    }
}
