@extends('layouts.app')

@section('title', 'Dodaj Tim')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Dodaj Novi Tim</h1>
    <p class="text-gray-600 mt-2">Popunite formu za dodavanje novog tima</p>
</div>

<div class="bg-white rounded-lg shadow-md p-6">
    <form action="{{ route('teams.store') }}" method="POST" enctype="multipart/form-data">
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

            <!-- Country -->
            <div>
                <label for="country" class="block text-sm font-medium text-gray-700 mb-2">Država *</label>
                <input type="text" name="country" id="country" value="{{ old('country') }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
                @error('country')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Founded Year -->
            <div>
                <label for="founded_year" class="block text-sm font-medium text-gray-700 mb-2">Godina Osnivanja *</label>
                <input type="number" name="founded_year" id="founded_year" value="{{ old('founded_year') }}" min="1900" max="{{ date('Y') }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
                @error('founded_year')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Total Points -->
            <div>
                <label for="total_points" class="block text-sm font-medium text-gray-700 mb-2">Poeni</label>
                <input type="number" name="total_points" id="total_points" value="{{ old('total_points', 0) }}" min="0"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
                @error('total_points')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Logo -->
            <div class="md:col-span-2">
                <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">Logo</label>
                <input type="file" name="logo" id="logo" accept="image/*"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
                <p class="mt-1 text-sm text-gray-500">PNG, JPG, GIF do 2MB</p>
                @error('logo')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-4">
            <a href="{{ route('teams.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                Otkaži
            </a>
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Sačuvaj
            </button>
        </div>
    </form>
</div>
@endsection

