<?php

namespace App\Interfaces;

interface Repository
{
    public function all();
    public function get($id);
    public function update($id, array $attributes);
    public function delete($id);
}