<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'country',
        'founded_year',
        'logo',
        'total_points',
    ];

    public function drivers(): HasMany
    {
        return $this->hasMany(Driver::class);
    }
}
