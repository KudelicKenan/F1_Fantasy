@extends('layouts.app')

@section('title', $race->name)

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">{{ $race->name }}</h1>
        <p class="text-gray-600 mt-2">Detalji trke</p>
    </div>
    <div class="flex space-x-2">
        <a href="{{ route('races.edit', $race->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
            Uredi
        </a>
        <a href="{{ route('races.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
            Nazad
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Main Info -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Osnovne Informacije</h2>
        
        <div class="space-y-4">
            <div class="flex items-center space-x-4">
                <span class="text-gray-600 font-medium w-32">Ime:</span>
                <span class="text-gray-800">{{ $race->name }}</span>
            </div>
            
            <div class="flex items-center space-x-4">
                <span class="text-gray-600 font-medium w-32">Lokacija:</span>
                <span class="text-gray-800">{{ $race->location }}</span>
            </div>
            
            <div class="flex items-center space-x-4">
                <span class="text-gray-600 font-medium w-32">Staza:</span>
                <span class="text-gray-800">{{ $race->circuit_name }}</span>
            </div>
            
            <div class="flex items-center space-x-4">
                <span class="text-gray-600 font-medium w-32">Datum:</span>
                <span class="text-gray-800">{{ $race->race_date->format('d.m.Y') }}</span>
            </div>
            
            <div class="flex items-center space-x-4">
                <span class="text-gray-600 font-medium w-32">Krugovi:</span>
                <span class="text-gray-800">{{ $race->laps ?? 'N/A' }}</span>
            </div>
            
            <div class="flex items-center space-x-4">
                <span class="text-gray-600 font-medium w-32">Vremenske Prilike:</span>
                <span class="text-gray-800">
                    @if($race->weather)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            🌤️ {{ $race->weather }}
                        </span>
                    @else
                        <span class="text-gray-400">N/A - Nisu ažurirane</span>
                    @endif
                </span>
            </div>
        </div>

        <div class="mt-6 flex space-x-3">
            @if(!$race->weather)
                <form action="{{ route('races.weather', $race->id) }}" method="GET" class="inline">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center space-x-2">
                        <span>🌤️</span>
                        <span>Ažuriraj Vremenske Prilike (Weather API)</span>
                    </button>
                </form>
            @else
                <form action="{{ route('races.weather', $race->id) }}" method="GET" class="inline">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center space-x-2">
                        <span>🔄</span>
                        <span>Osveži Vremenske Prilike</span>
                    </button>
                </form>
            @endif
            <a href="https://openweathermap.org/api" target="_blank" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded flex items-center space-x-2">
                <span>ℹ️</span>
                <span>Weather API Info</span>
            </a>
        </div>
        
        @if(!config('services.openweathermap.api_key'))
            <div class="mt-4 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <p class="text-yellow-800 text-sm">
                    <strong>Napomena:</strong> Weather API key nije konfigurisan. Dodajte <code>WEATHER_API_KEY</code> u <code>.env</code> fajl da bi weather API funkcionisao.
                    <a href="https://openweathermap.org/api" target="_blank" class="text-blue-600 hover:underline ml-1">Registrujte se ovdje</a>.
                </p>
            </div>
        @endif
    </div>

    <!-- Additional Info -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Dodatne Informacije</h2>
        <div class="space-y-4">
            <div class="bg-gray-50 p-4 rounded">
                <p class="text-sm text-gray-600">Status</p>
                <p class="text-lg font-semibold text-gray-800">
                    @if($race->race_date->isPast())
                        <span class="text-red-600">Završena</span>
                    @elseif($race->race_date->isToday())
                        <span class="text-yellow-600">Danas</span>
                    @else
                        <span class="text-green-600">Nadolazeća</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

