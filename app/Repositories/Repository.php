<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use App\Interfaces\Repository as RepositoryInterface;

abstract class Repository implements RepositoryInterface
{
    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }

    public function all()
    {
        $builder = $this->builder;
        $model = $builder->get();

        return $model;
    }

    public function get($id)
    {
        $builder = $this->builder;
        $model = $builder->find($id);

        return $model;
    }

    public function update($id, array $attributes)
    {
        $model = $this->get($id);
        $model->fill($attributes);
        $this->setRelationships($model, $attributes);
        $model->save();

        return $model;
    }

    public function delete($id)
    {
        $model = $this->get($id);
        $model->delete();
    }

    protected function setRelationships($model, array $attributes)
    {
        if (method_exists($model, 'setRelationships')) {
            $model->setRelationships($attributes);
        }
    }

    protected function clean()
    {
        $this->cleanBuilder();
    }

    protected function cleanBuilder()
    {
        $this->builder = $this->builder->getModel()->query();
    }
}