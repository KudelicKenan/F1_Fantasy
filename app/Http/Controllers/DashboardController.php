<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\FantasyTeam;
use App\Models\Race;
use App\Models\Team;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDrivers = Driver::count();
        $totalTeams = Team::count();
        $totalRaces = Race::count();
        $totalFantasyTeams = FantasyTeam::count();

        $topDriver = Driver::with('team')->orderBy('points', 'desc')->first();
        $topTeam = Team::orderBy('total_points', 'desc')->first();
        $topFantasyTeam = FantasyTeam::with('user')->orderBy('total_points', 'desc')->first();

        $totalFantasyPoints = FantasyTeam::sum('total_points');
        $averageFantasyPoints = FantasyTeam::avg('total_points');

        return view('dashboard', compact(
            'totalDrivers',
            'totalTeams',
            'totalRaces',
            'totalFantasyTeams',
            'topDriver',
            'topTeam',
            'topFantasyTeam',
            'totalFantasyPoints',
            'averageFantasyPoints'
        ));
    }
}
