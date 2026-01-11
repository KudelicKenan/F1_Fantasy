<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'race_date',
        'circuit_name',
        'weather',
        'laps',
    ];

    protected $casts = [
        'race_date' => 'date',
    ];
}
