<?php

namespace App\Factories;

use Illuminate\Database\Eloquent\Model;
use App\Interfaces\Factory as FactoryInterface;

abstract class Factory implements FactoryInterface
{
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create(array $attributes)
    {
        $model = $this->model;
        $attributes = $this->setRole($model, $attributes);
        $model->fill($attributes);
        $model->save();

        $this->clean();

        return $model;
    }

    protected function setRole($model, array $attributes)
    {
        if (array_key_exists('role', $attributes)) {
            $model->assignRole($attributes['role']);
            unset($attributes['role']);
        }

        return $attributes;
    }

    protected function cleanAttributes(array &$attributes)
    {
    }

    protected function clean()
    {
        $this->cleanModel();
    }

    protected function cleanModel()
    {
        $modelClass = get_class($this->model);
        $this->model = app()->make($modelClass);
    }
}