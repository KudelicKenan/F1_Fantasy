@extends('layouts.app')

@section('title', 'Dodaj Vozača')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Dodaj Novog Vozača</h1>
    <p class="text-gray-600 mt-2">Popunite formu za dodavanje novog vozača</p>
</div>

<div class="bg-white rounded-lg shadow-md p-6">
    <form action="{{ route('drivers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Ime *</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nationality -->
            <div>
                <label for="nationality" class="block text-sm font-medium text-gray-700 mb-2">Nacionalnost *</label>
                <input type="text" name="nationality" id="nationality" value="{{ old('nationality') }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
                @error('nationality')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Date of Birth -->
            <div>
                <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">Datum Rođenja *</label>
                <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
                @error('date_of_birth')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Team -->
            <div>
                <label for="team_id" class="block text-sm font-medium text-gray-700 mb-2">Tim *</label>
                <select name="team_id" id="team_id" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
                    <option value="">Izaberi tim</option>
                    @foreach($teams as $team)
                        <option value="{{ $team->id }}" {{ old('team_id') == $team->id ? 'selected' : '' }}>
                            {{ $team->name }}
                        </option>
                    @endforeach
                </select>
                @error('team_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Driver Number -->
            <div>
                <label for="driver_number" class="block text-sm font-medium text-gray-700 mb-2">Broj Vozača</label>
                <input type="number" name="driver_number" id="driver_number" value="{{ old('driver_number') }}" min="1" max="99"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
                @error('driver_number')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Points -->
            <div>
                <label for="points" class="block text-sm font-medium text-gray-700 mb-2">Poeni</label>
                <input type="number" name="points" id="points" value="{{ old('points', 0) }}" min="0"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
                @error('points')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Photo -->
            <div class="md:col-span-2">
                <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">Slika</label>
                <input type="file" name="photo" id="photo" accept="image/*"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
                <p class="mt-1 text-sm text-gray-500">PNG, JPG, GIF do 2MB</p>
                @error('photo')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-4">
            <a href="{{ route('drivers.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                Otkaži
            </a>
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Sačuvaj
            </button>
        </div>
    </form>
</div>
@endsection

