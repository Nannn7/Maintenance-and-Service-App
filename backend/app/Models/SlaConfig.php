<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['priority_level', 'response_time_minutes', 'resolution_time_minutes'])]
class SlaConfig extends Model
{
    use HasFactory;

    protected $table = 'sla_configs';
}
