<?php

namespace App\Providers;

use Exception;
use ReflectionClass;
use Illuminate\Support\ServiceProvider;
use Composer\Autoload\ClassMapGenerator;

class BaseServiceProvider extends ServiceProvider
{
    protected function getClassesFromPath($path)
    {
        $classPaths = ClassMapGenerator::createMap($path);
        $classes = array();
        foreach ($classPaths as $class => $path) {
            array_push($classes, $class);
        }

        return $classes;
    }

    protected function getModelNamespaceFromClass($classString)
    {
        $class = new ReflectionClass($classString);
        try {
            $namespace = $class->getStaticPropertyValue('modelNamespace');
        } catch (Exception $e) {
            return null;
        }

        return $namespace;
    }

    protected function getModelNameFromClass($class, $modelNamespace = "App\Models")
    {
        $segments = explode('\\', $class);
        $className = $segments[count($segments)-1];
        $classSegments = preg_split('/(?=[A-Z])/', $className);
        $modelSegments = $this->removeLastElementFromArray($classSegments);
        $modelName = join($modelSegments);
        if (!$modelName) {
            return null;
        }

        $modelName = $modelNamespace.'\\'.$modelName;

        return $modelName;
    }

    private function removeLastElementFromArray($array)
    {
        array_pop($array);

        return $array;
    }

}
