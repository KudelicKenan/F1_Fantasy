<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'asc');
        
        $query = Driver::with('team');
        
        if ($sortBy === 'points') {
            $query->orderBy('points', $sortOrder);
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }
        
        $drivers = $query->paginate(10)->appends($request->query());
        
        // Return JSON for API requests
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json($drivers);
        }
        
        return view('drivers.index', compact('drivers', 'sortBy', 'sortOrder'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teams = Team::all();
        return view('drivers.create', compact('teams'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nationality' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'team_id' => 'required|exists:teams,id',
            'points' => 'nullable|integer|min:0',
            'driver_number' => 'nullable|integer|min:1|max:99',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('drivers', 'public');
            $validated['photo'] = $path;
        }

        $driver = Driver::create($validated);

        // Return JSON for API requests
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => 'Vozač je uspješno kreiran.',
                'driver' => $driver->load('team')
            ], 201);
        }

        return redirect()->route('drivers.index')
            ->with('success', 'Vozač je uspješno kreiran.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $driver = Driver::with('team', 'fantasyTeams')->findOrFail($id);
        
        // Return JSON for API requests
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json($driver);
        }
        
        return view('drivers.show', compact('driver'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $driver = Driver::with('team')->findOrFail($id);
        $teams = Team::all();
        return view('drivers.edit', compact('driver', 'teams'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $driver = Driver::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'nationality' => 'sometimes|required|string|max:255',
            'date_of_birth' => 'sometimes|required|date',
            'team_id' => 'sometimes|required|exists:teams,id',
            'points' => 'nullable|integer|min:0',
            'driver_number' => 'nullable|integer|min:1|max:99',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($driver->photo) {
                Storage::disk('public')->delete($driver->photo);
            }
            $path = $request->file('photo')->store('drivers', 'public');
            $validated['photo'] = $path;
        }

        $driver->update($validated);

        // Return JSON for API requests
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => 'Vozač je uspješno ažuriran.',
                'driver' => $driver->load('team')
            ]);
        }

        return redirect()->route('drivers.index')
            ->with('success', 'Vozač je uspješno ažuriran.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $driver = Driver::findOrFail($id);

        // Delete photo if exists
        if ($driver->photo) {
            Storage::disk('public')->delete($driver->photo);
        }

        $driver->delete();

        // Return JSON for API requests
        if (request()->expectsJson() || request()->is('api/*')) {
            return response()->json([
                'message' => 'Vozač je uspješno obrisan.'
            ]);
        }

        return redirect()->route('drivers.index')
            ->with('success', 'Vozač je uspješno obrisan.');
    }
}
