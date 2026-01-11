@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Dashboard</h1>
    <p class="text-gray-600">Pregled statistike F1 Fantasy aplikacije</p>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Drivers -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Ukupno Vozača</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalDrivers }}</p>
            </div>
            <div class="bg-blue-100 rounded-full p-3">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Teams -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Ukupno Timova</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalTeams }}</p>
            </div>
            <div class="bg-green-100 rounded-full p-3">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Races -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Ukupno Trka</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalRaces }}</p>
            </div>
            <div class="bg-yellow-100 rounded-full p-3">
                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Fantasy Teams -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Fantasy Timovi</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalFantasyTeams }}</p>
            </div>
            <div class="bg-purple-100 rounded-full p-3">
                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Top Performers -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Top Driver -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">🏆 Najbolji Vozač</h2>
        @if($topDriver)
            <div class="flex items-center space-x-4">
                @if($topDriver->photo)
                    <img src="{{ Storage::url($topDriver->photo) }}" alt="{{ $topDriver->name }}" class="w-20 h-20 rounded-full object-cover">
                @else
                    <div class="w-20 h-20 rounded-full bg-gray-300 flex items-center justify-center">
                        <span class="text-2xl">🏎️</span>
                    </div>
                @endif
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">{{ $topDriver->name }}</h3>
                    <p class="text-gray-600">{{ $topDriver->team->name ?? 'N/A' }}</p>
                    <p class="text-red-600 font-bold text-xl">{{ $topDriver->points }} poena</p>
                </div>
            </div>
            <a href="{{ route('drivers.show', $topDriver->id) }}" class="mt-4 inline-block text-blue-600 hover:text-blue-800">Vidi detalje →</a>
        @else
            <p class="text-gray-500">Nema podataka</p>
        @endif
    </div>

    <!-- Top Team -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">🏆 Najbolji Tim</h2>
        @if($topTeam)
            <div class="flex items-center space-x-4">
                @if($topTeam->logo)
                    <img src="{{ Storage::url($topTeam->logo) }}" alt="{{ $topTeam->name }}" class="w-20 h-20 rounded-full object-cover">
                @else
                    <div class="w-20 h-20 rounded-full bg-gray-300 flex items-center justify-center">
                        <span class="text-2xl">🏁</span>
                    </div>
                @endif
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">{{ $topTeam->name }}</h3>
                    <p class="text-gray-600">{{ $topTeam->country }}</p>
                    <p class="text-red-600 font-bold text-xl">{{ $topTeam->total_points }} poena</p>
                </div>
            </div>
            <a href="{{ route('teams.show', $topTeam->id) }}" class="mt-4 inline-block text-blue-600 hover:text-blue-800">Vidi detalje →</a>
        @else
            <p class="text-gray-500">Nema podataka</p>
        @endif
    </div>
</div>

<!-- Fantasy Teams Statistics -->
<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-xl font-bold text-gray-800 mb-4">📊 Statistika Fantasy Timova</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-gray-50 p-4 rounded">
            <p class="text-gray-600 text-sm">Ukupno Poena</p>
            <p class="text-2xl font-bold text-gray-800">{{ $totalFantasyPoints }}</p>
        </div>
        <div class="bg-gray-50 p-4 rounded">
            <p class="text-gray-600 text-sm">Prosječno Poena</p>
            <p class="text-2xl font-bold text-gray-800">{{ $averageFantasyPoints > 0 ? number_format($averageFantasyPoints, 2) : 0 }}</p>
        </div>
        <div class="bg-gray-50 p-4 rounded">
            <p class="text-gray-600 text-sm">Najbolji Fantasy Tim</p>
            <p class="text-lg font-semibold text-gray-800">
                @if($topFantasyTeam)
                    {{ $topFantasyTeam->name }} ({{ $topFantasyTeam->total_points }} pts)
                @else
                    N/A
                @endif
            </p>
        </div>
    </div>
</div>
@endsection

