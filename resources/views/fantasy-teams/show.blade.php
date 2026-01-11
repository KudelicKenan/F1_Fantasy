@extends('layouts.app')

@section('title', $fantasyTeam->name)

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">{{ $fantasyTeam->name }}</h1>
        <p class="text-gray-600 mt-2">Detalji fantasy tima</p>
    </div>
    <div class="flex space-x-2">
        <a href="{{ route('fantasy-teams.edit', $fantasyTeam->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
            Uredi
        </a>
        <a href="{{ route('fantasy-teams.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
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
                <span class="text-gray-800">{{ $fantasyTeam->name }}</span>
            </div>
            
            <div class="flex items-center space-x-4">
                <span class="text-gray-600 font-medium w-32">Korisnik:</span>
                <span class="text-gray-800">{{ $fantasyTeam->user->name ?? 'N/A' }}</span>
            </div>
            
            <div class="flex items-center space-x-4">
                <span class="text-gray-600 font-medium w-32">Ukupno Poena:</span>
                <span class="text-red-600 font-bold text-xl">{{ $fantasyTeam->total_points }}</span>
            </div>
            
            <div class="flex items-center space-x-4">
                <span class="text-gray-600 font-medium w-32">Kreiran:</span>
                <span class="text-gray-800">{{ $fantasyTeam->created_at->format('d.m.Y H:i') }}</span>
            </div>
        </div>

        <!-- Drivers -->
        @if($fantasyTeam->drivers->count() > 0)
            <div class="mt-8">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Vozači ({{ $fantasyTeam->drivers->count() }})</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($fantasyTeam->drivers as $driver)
                        <div class="bg-gray-50 p-4 rounded-lg flex items-center space-x-4">
                            @if($driver->photo)
                                <img src="{{ Storage::url($driver->photo) }}" alt="{{ $driver->name }}" class="w-16 h-16 rounded-full object-cover">
                            @else
                                <div class="w-16 h-16 rounded-full bg-gray-300 flex items-center justify-center">
                                    <span class="text-2xl">🏎️</span>
                                </div>
                            @endif
                            <div class="flex-1">
                                <a href="{{ route('drivers.show', $driver->id) }}" class="text-blue-600 hover:underline font-medium">
                                    {{ $driver->name }}
                                </a>
                                <p class="text-sm text-gray-600">{{ $driver->team->name ?? 'N/A' }}</p>
                                <p class="text-sm font-semibold text-red-600">{{ $driver->pivot->points }} poena</p>
                            </div>
                            <form action="{{ route('fantasy-teams.remove-driver', [$fantasyTeam->id, $driver->id]) }}" method="POST" class="inline" onsubmit="return confirm('Da li ste sigurni da želite ukloniti ovog vozača?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Ukloni</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="mt-8 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <p class="text-yellow-800">Ovaj fantasy tim nema vozača. Dodajte vozače preko edit opcije.</p>
            </div>
        @endif
    </div>

    <!-- Stats -->
    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Statistika</h2>
            <div class="space-y-4">
                <div class="bg-gray-50 p-4 rounded">
                    <p class="text-sm text-gray-600">Prosječno Poena po Vozaču</p>
                    <p class="text-2xl font-bold text-gray-800">
                        {{ $fantasyTeam->drivers->count() > 0 ? number_format($fantasyTeam->drivers->sum('pivot.points') / $fantasyTeam->drivers->count(), 2) : 0 }}
                    </p>
                </div>
                <div class="bg-gray-50 p-4 rounded">
                    <p class="text-sm text-gray-600">Ukupno Poena od Vozača</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $fantasyTeam->drivers->sum('pivot.points') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

