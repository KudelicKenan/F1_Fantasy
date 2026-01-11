<?php

namespace App\Http\Controllers;

use App\Models\Race;
use Illuminate\Http\Request;

class RaceController extends Controller
{
    public function index(Request $request)
    {
        $races = Race::orderBy('race_date', 'desc')->paginate(10);
        
        // Return JSON for API requests
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json($races);
        }
        
        return view('races.index', compact('races'));
    }

    public function create()
    {
        return view('races.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'circuit_name' => 'required|string|max:255',
            'race_date' => 'required|date',
            'laps' => 'nullable|integer|min:1',
            'weather' => 'nullable|string|max:255',
        ]);

        Race::create($validated);

        return redirect()->route('races.index')
            ->with('success', 'Trka je uspješno kreirana.');
    }

    public function show(Request $request, string $id)
    {
        $race = Race::findOrFail($id);
        
        // Return JSON for API requests
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json($race);
        }
        
        return view('races.show', compact('race'));
    }

    public function edit(string $id)
    {
        $race = Race::findOrFail($id);
        return view('races.edit', compact('race'));
    }

    public function update(Request $request, string $id)
    {
        $race = Race::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'location' => 'sometimes|required|string|max:255',
            'circuit_name' => 'sometimes|required|string|max:255',
            'race_date' => 'sometimes|required|date',
            'laps' => 'nullable|integer|min:1',
            'weather' => 'nullable|string|max:255',
        ]);

        $race->update($validated);

        return redirect()->route('races.index')
            ->with('success', 'Trka je uspješno ažurirana.');
    }

    public function destroy(string $id)
    {
        $race = Race::findOrFail($id);
        $race->delete();

        return redirect()->route('races.index')
            ->with('success', 'Trka je uspješno obrisana.');
    }
}
