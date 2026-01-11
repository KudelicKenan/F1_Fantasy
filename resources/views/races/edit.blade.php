@extends('layouts.app')

@section('title', 'Uredi Trku')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Uredi Trku: {{ $race->name }}</h1>
    <p class="text-gray-600 mt-2">Ažurirajte informacije o trci</p>
</div>

<div class="bg-white rounded-lg shadow-md p-6">
    <form action="{{ route('races.update', $race->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Ime *</label>
                <input type="text" name="name" id="name" value="{{ old('name', $race->name) }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Location -->
            <div>
                <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Lokacija (Grad) *</label>
                <input type="text" name="location" id="location" value="{{ old('location', $race->location) }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500"
                    placeholder="npr. Monaco, Singapore, Abu Dhabi">
                <p class="mt-1 text-sm text-gray-500">⚠️ Koristite ime grada (npr. "Singapore" umjesto "Marina Bay") za Weather API kompatibilnost</p>
                @error('location')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Circuit Name -->
            <div>
                <label for="circuit_name" class="block text-sm font-medium text-gray-700 mb-2">Ime Staze *</label>
                <input type="text" name="circuit_name" id="circuit_name" value="{{ old('circuit_name', $race->circuit_name) }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
                @error('circuit_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Race Date -->
            <div>
                <label for="race_date" class="block text-sm font-medium text-gray-700 mb-2">Datum Trke *</label>
                <input type="date" name="race_date" id="race_date" value="{{ old('race_date', $race->race_date->format('Y-m-d')) }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
                @error('race_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Laps -->
            <div>
                <label for="laps" class="block text-sm font-medium text-gray-700 mb-2">Broj Krugova</label>
                <input type="number" name="laps" id="laps" value="{{ old('laps', $race->laps) }}" min="1"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
                @error('laps')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Weather -->
            <div>
                <label for="weather" class="block text-sm font-medium text-gray-700 mb-2">Vremenske Prilike</label>
                <input type="text" name="weather" id="weather" value="{{ old('weather', $race->weather) }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
                <p class="mt-1 text-sm text-gray-500">Možete ažurirati ručno ili koristiti Weather API</p>
                @error('weather')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-4">
            <a href="{{ route('races.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                Otkaži
            </a>
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Ažuriraj
            </button>
        </div>
    </form>
</div>
@endsection

