<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'asc');
        
        $query = Team::withCount('drivers');
        
        if ($sortBy === 'total_points') {
            $query->orderBy('total_points', $sortOrder);
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }
        
        $teams = $query->paginate(10)->appends($request->query());
        
        // Return JSON for API requests
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json($teams);
        }
        
        return view('teams.index', compact('teams', 'sortBy', 'sortOrder'));
    }

    public function create()
    {
        return view('teams.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'founded_year' => 'required|integer|min:1900|max:' . date('Y'),
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'total_points' => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('teams', 'public');
            $validated['logo'] = $path;
        }

        Team::create($validated);

        return redirect()->route('teams.index')
            ->with('success', 'Tim je uspješno kreiran.');
    }

    public function show(Request $request, string $id)
    {
        $team = Team::with('drivers')->findOrFail($id);
        
        // Return JSON for API requests
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json($team);
        }
        
        return view('teams.show', compact('team'));
    }

    public function edit(string $id)
    {
        $team = Team::findOrFail($id);
        return view('teams.edit', compact('team'));
    }

    public function update(Request $request, string $id)
    {
        $team = Team::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'country' => 'sometimes|required|string|max:255',
            'founded_year' => 'sometimes|required|integer|min:1900|max:' . date('Y'),
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'total_points' => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('logo')) {
            if ($team->logo) {
                Storage::disk('public')->delete($team->logo);
            }
            $path = $request->file('logo')->store('teams', 'public');
            $validated['logo'] = $path;
        }

        $team->update($validated);

        return redirect()->route('teams.index')
            ->with('success', 'Tim je uspješno ažuriran.');
    }

    public function destroy(string $id)
    {
        $team = Team::findOrFail($id);

        if ($team->logo) {
            Storage::disk('public')->delete($team->logo);
        }

        $team->delete();

        return redirect()->route('teams.index')
            ->with('success', 'Tim je uspješno obrisan.');
    }
}
