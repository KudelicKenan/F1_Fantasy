<?php

namespace App\Http\Controllers;

use App\Models\FantasyTeam;
use App\Models\User;
use Illuminate\Http\Request;

class FantasyTeamController extends Controller
{
    public function index(Request $request)
    {
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'asc');
        
        $query = FantasyTeam::with('user')->withCount('drivers');
        
        if ($sortBy === 'total_points') {
            $query->orderBy('total_points', $sortOrder);
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }
        
        $fantasyTeams = $query->paginate(10)->appends($request->query());
        
        return view('fantasy-teams.index', compact('fantasyTeams', 'sortBy', 'sortOrder'));
    }

    public function create()
    {
        $users = User::all();
        $drivers = \App\Models\Driver::with('team')->get();
        return view('fantasy-teams.create', compact('users', 'drivers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'total_points' => 'nullable|integer|min:0',
            'drivers' => 'nullable|array',
            'drivers.*' => 'exists:drivers,id',
            'driver_points' => 'nullable|array',
        ]);

        $fantasyTeam = FantasyTeam::create($validated);

        // Attach drivers if provided
        if ($request->has('drivers') && is_array($request->drivers)) {
            $driversData = [];
            foreach ($request->drivers as $driverId) {
                $points = $request->input("driver_points.{$driverId}", 0);
                $driversData[$driverId] = ['points' => $points];
            }
            $fantasyTeam->drivers()->attach($driversData);
        }

        return redirect()->route('fantasy-teams.index')
            ->with('success', 'Fantasy tim je uspješno kreiran.');
    }

    public function show(string $id)
    {
        $fantasyTeam = FantasyTeam::with('user', 'drivers')->findOrFail($id);
        return view('fantasy-teams.show', compact('fantasyTeam'));
    }

    public function edit(string $id)
    {
        $fantasyTeam = FantasyTeam::with('drivers')->findOrFail($id);
        $drivers = \App\Models\Driver::with('team')->get();
        return view('fantasy-teams.edit', compact('fantasyTeam', 'drivers'));
    }

    public function update(Request $request, string $id)
    {
        $fantasyTeam = FantasyTeam::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'total_points' => 'nullable|integer|min:0',
            'drivers' => 'nullable|array',
            'drivers.*' => 'exists:drivers,id',
            'driver_points' => 'nullable|array',
        ]);

        $fantasyTeam->update($validated);

        // Sync drivers if provided
        if ($request->has('drivers') && is_array($request->drivers)) {
            $driversData = [];
            foreach ($request->drivers as $driverId) {
                $points = $request->input("driver_points.{$driverId}", 0);
                $driversData[$driverId] = ['points' => $points];
            }
            $fantasyTeam->drivers()->sync($driversData);
        } else {
            // If no drivers selected, remove all
            $fantasyTeam->drivers()->sync([]);
        }

        return redirect()->route('fantasy-teams.show', $fantasyTeam->id)
            ->with('success', 'Fantasy tim je uspješno ažuriran.');
    }

    public function destroy(string $id)
    {
        $fantasyTeam = FantasyTeam::findOrFail($id);
        $fantasyTeam->delete();

        return redirect()->route('fantasy-teams.index')
            ->with('success', 'Fantasy tim je uspješno obrisan.');
    }

    public function removeDriver(Request $request, string $id, string $driverId)
    {
        $fantasyTeam = FantasyTeam::findOrFail($id);
        $fantasyTeam->drivers()->detach($driverId);

        return redirect()->route('fantasy-teams.show', $fantasyTeam->id)
            ->with('success', 'Vozač je uspješno uklonjen iz fantasy tima.');
    }
}
