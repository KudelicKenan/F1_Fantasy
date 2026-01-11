@extends('layouts.app')

@section('title', $driver->name)

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">{{ $driver->name }}</h1>
        <p class="text-gray-600 mt-2">Detalji vozača</p>
    </div>
    <div class="flex space-x-2">
        <a href="{{ route('drivers.edit', $driver->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
            Uredi
        </a>
        <a href="{{ route('drivers.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
            Nazad
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Info -->
    <div class="lg:col-span-2 bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Osnovne Informacije</h2>
        
        <div class="space-y-4">
            <div class="flex items-center space-x-4">
                <span class="text-gray-600 font-medium w-32">Ime:</span>
                <span class="text-gray-800">{{ $driver->name }}</span>
            </div>
            
            <div class="flex items-center space-x-4">
                <span class="text-gray-600 font-medium w-32">Nacionalnost:</span>
                <span class="text-gray-800">{{ $driver->nationality }}</span>
            </div>
            
            <div class="flex items-center space-x-4">
                <span class="text-gray-600 font-medium w-32">Datum Rođenja:</span>
                <span class="text-gray-800">{{ $driver->date_of_birth->format('d.m.Y') }}</span>
            </div>
            
            <div class="flex items-center space-x-4">
                <span class="text-gray-600 font-medium w-32">Broj Vozača:</span>
                <span class="text-gray-800">#{{ $driver->driver_number ?? 'N/A' }}</span>
            </div>
            
            <div class="flex items-center space-x-4">
                <span class="text-gray-600 font-medium w-32">Tim:</span>
                <span class="text-gray-800">
                    @if($driver->team)
                        <a href="{{ route('teams.show', $driver->team->id) }}" class="text-blue-600 hover:underline">
                            {{ $driver->team->name }}
                        </a>
                    @else
                        N/A
                    @endif
                </span>
            </div>
            
            <div class="flex items-center space-x-4">
                <span class="text-gray-600 font-medium w-32">Poeni:</span>
                <span class="text-red-600 font-bold text-xl">{{ $driver->points }}</span>
            </div>
        </div>
    </div>

    <!-- Photo & Stats -->
    <div class="space-y-6">
        <!-- Photo -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Slika</h2>
            @if($driver->photo)
                <div class="w-full flex justify-center">
                    <img src="{{ Storage::url($driver->photo) }}" alt="{{ $driver->name }}" class="max-w-full h-auto max-h-96 rounded-lg object-contain shadow-md" style="min-height: 200px;">
                </div>
            @else
                <div class="w-full h-64 bg-gray-300 rounded-lg flex items-center justify-center">
                    <span class="text-6xl">🏎️</span>
                </div>
            @endif
        </div>

        <!-- Fantasy Teams -->
        @if($driver->fantasyTeams->count() > 0)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Fantasy Timovi</h2>
                <div class="space-y-2">
                    @foreach($driver->fantasyTeams as $fantasyTeam)
                        <div class="flex justify-between items-center p-2 bg-gray-50 rounded">
                            <a href="{{ route('fantasy-teams.show', $fantasyTeam->id) }}" class="text-blue-600 hover:underline">
                                {{ $fantasyTeam->name }}
                            </a>
                            <span class="text-sm text-gray-600">{{ $fantasyTeam->pivot->points }} pts</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

