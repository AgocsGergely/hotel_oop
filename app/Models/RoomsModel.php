<?php

namespace App\Models;

class RoomsModel extends Model 
{
    public int|null $floor = null;
    public int|null $room_number = null;
    public int|null $capacity = null;
    public int|null $price = null;
    public string|null $notes = null;
    protected static $table = 'rooms';

    public function __construct(?int $floor = null, ?int $room_number = null, ?int $capacity = null, ?int $price = null, ?string $notes = null)
    {
        parent::__construct();
        if ($floor) $this->floor = $floor;
        if ($room_number) $this->room_number = $room_number;
        if ($capacity) $this->capacity = $capacity;
        if ($price) $this->price = $price;
        if ($notes) $this->notes = $notes;
    }
}