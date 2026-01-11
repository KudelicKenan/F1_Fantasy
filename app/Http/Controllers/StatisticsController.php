<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\FantasyTeam;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    /**
     * Display overall statistics combining multiple tables.
     */
    public function index()
    {
        $stats = [
            'total_drivers' => Driver::count(),
            'total_teams' => Team::count(),
            'total_fantasy_teams' => FantasyTeam::count(),
            'top_driver' => Driver::with('team')->orderBy('points', 'desc')->first(),
            'top_team' => Team::orderBy('total_points', 'desc')->first(),
            'top_fantasy_team' => FantasyTeam::with('user')->orderBy('total_points', 'desc')->first(),
            'average_driver_points' => Driver::avg('points'),
            'average_team_points' => Team::avg('total_points'),
        ];

        return response()->json($stats);
    }

    /**
     * Get driver statistics with team information.
     */
    public function driverStats()
    {
        $driverStats = Driver::with('team')
            ->select('drivers.*', 'teams.name as team_name', 'teams.country as team_country')
            ->join('teams', 'drivers.team_id', '=', 'teams.id')
            ->orderBy('drivers.points', 'desc')
            ->get();

        $stats = [
            'drivers' => $driverStats,
            'total_points' => Driver::sum('points'),
            'top_5_drivers' => Driver::with('team')->orderBy('points', 'desc')->limit(5)->get(),
        ];

        return response()->json($stats);
    }

    /**
     * Get team statistics with driver information.
     */
    public function teamStats()
    {
        $teamStats = Team::with('drivers')
            ->withCount('drivers')
            ->withSum('drivers', 'points')
            ->orderBy('total_points', 'desc')
            ->get();

        $stats = [
            'teams' => $teamStats,
            'total_teams' => Team::count(),
            'top_3_teams' => Team::orderBy('total_points', 'desc')->limit(3)->get(),
        ];

        return response()->json($stats);
    }

    /**
     * Get fantasy team statistics with drivers and user information.
     */
    public function fantasyTeamStats()
    {
        $fantasyTeamStats = FantasyTeam::with(['user', 'drivers'])
            ->withCount('drivers')
            ->orderBy('total_points', 'desc')
            ->get();

        // Calculate average points per driver for each fantasy team
        foreach ($fantasyTeamStats as $team) {
            $team->average_driver_points = $team->drivers->count() > 0 
                ? $team->drivers->sum('pivot.points') / $team->drivers->count() 
                : 0;
        }

        $stats = [
            'fantasy_teams' => $fantasyTeamStats,
            'total_fantasy_teams' => FantasyTeam::count(),
            'top_5_fantasy_teams' => FantasyTeam::with('user')->orderBy('total_points', 'desc')->limit(5)->get(),
            'total_fantasy_points' => FantasyTeam::sum('total_points'),
        ];

        return response()->json($stats);
    }
}
