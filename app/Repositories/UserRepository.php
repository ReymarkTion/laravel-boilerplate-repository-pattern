<?php

namespace App\Repositories;

class UserRepository extends Repository
{
    public function update($id, $attributes)
    {
        $password = $this->encryptPassword($attributes['password']);
        $attributes['password'] = $password;

        return parent::update($id, $attributes);
    }

    public function encryptPassword($password)
    {
        $password = bcrypt($password);

        return $password;
    }
}