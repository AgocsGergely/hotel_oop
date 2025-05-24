<?php

namespace App\Models;

class GuestsModel extends Model
{
    public string|null $name = null;
    protected static $table = 'guests';
    public int|null $age = null;
    public function __construct(?string $name = null, ?int $age = null) 
    {
        parent::__construct();
        if ($name) $this->name = $name;
        if ($age) $this->age = $age;
    }
}