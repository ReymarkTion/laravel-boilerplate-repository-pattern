<?php

namespace App\Factories;

use Illuminate\Support\Arr;

class UserFactory extends Factory
{
    public function create($attributes)
    {
        $password = $this->encryptPassword($attributes['password']);
        $attributes = Arr::add($attributes, 'status', '0');
        $attributes['password'] = $password;

        return parent::create($attributes);
    }

    public function encryptPassword($password)
    {
        $password = bcrypt($password);

        return $password;
    }
}