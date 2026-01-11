<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nationality',
        'date_of_birth',
        'team_id',
        'points',
        'photo',
        'driver_number',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function fantasyTeams(): BelongsToMany
    {
        return $this->belongsToMany(FantasyTeam::class, 'fantasy_team_drivers')
            ->withPivot('points')
            ->withTimestamps();
    }
}
