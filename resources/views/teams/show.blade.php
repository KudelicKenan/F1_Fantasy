@extends('layouts.app')

@section('title', $team->name)

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">{{ $team->name }}</h1>
        <p class="text-gray-600 mt-2">Detalji tima</p>
    </div>
    <div class="flex space-x-2">
        <a href="{{ route('teams.edit', $team->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
            Uredi
        </a>
        <a href="{{ route('teams.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
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
                <span class="text-gray-800">{{ $team->name }}</span>
            </div>
            
            <div class="flex items-center space-x-4">
                <span class="text-gray-600 font-medium w-32">Država:</span>
                <span class="text-gray-800">{{ $team->country }}</span>
            </div>
            
            <div class="flex items-center space-x-4">
                <span class="text-gray-600 font-medium w-32">Godina Osnivanja:</span>
                <span class="text-gray-800">{{ $team->founded_year }}</span>
            </div>
            
            <div class="flex items-center space-x-4">
                <span class="text-gray-600 font-medium w-32">Poeni:</span>
                <span class="text-red-600 font-bold text-xl">{{ $team->total_points }}</span>
            </div>
        </div>

        <!-- Drivers -->
        @if($team->drivers->count() > 0)
            <div class="mt-8">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Vozači ({{ $team->drivers->count() }})</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($team->drivers as $driver)
                        <div class="bg-gray-50 p-4 rounded-lg flex items-center space-x-4">
                            @if($driver->photo)
                                <img src="{{ Storage::url($driver->photo) }}" alt="{{ $driver->name }}" class="w-16 h-16 rounded-full object-cover">
                            @else
                                <div class="w-16 h-16 rounded-full bg-gray-300 flex items-center justify-center">
                                    <span class="text-2xl">🏎️</span>
                                </div>
                            @endif
                            <div>
                                <a href="{{ route('drivers.show', $driver->id) }}" class="text-blue-600 hover:underline font-medium">
                                    {{ $driver->name }}
                                </a>
                                <p class="text-sm text-gray-600">{{ $driver->points }} poena</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Logo -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Logo</h2>
        @if($team->logo)
            <img src="{{ Storage::url($team->logo) }}" alt="{{ $team->name }}" class="w-full rounded-lg object-cover">
        @else
            <div class="w-full h-64 bg-gray-300 rounded-lg flex items-center justify-center">
                <span class="text-6xl">🏁</span>
            </div>
        @endif
    </div>
</div>
@endsection

