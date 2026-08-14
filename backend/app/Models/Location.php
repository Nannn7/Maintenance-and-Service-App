<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['building_name', 'floor', 'room_name', 'description'])]
class Location extends Model
{
    use HasFactory;

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
