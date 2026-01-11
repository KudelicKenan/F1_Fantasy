@extends('layouts.app')

@section('title', 'Uredi Fantasy Tim')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Uredi Fantasy Tim: {{ $fantasyTeam->name }}</h1>
    <p class="text-gray-600 mt-2">Ažurirajte informacije o fantasy timu</p>
</div>

<div class="bg-white rounded-lg shadow-md p-6">
    <form action="{{ route('fantasy-teams.update', $fantasyTeam->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Ime *</label>
                <input type="text" name="name" id="name" value="{{ old('name', $fantasyTeam->name) }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Total Points -->
            <div>
                <label for="total_points" class="block text-sm font-medium text-gray-700 mb-2">Ukupno Poena</label>
                <input type="number" name="total_points" id="total_points" value="{{ old('total_points', $fantasyTeam->total_points) }}" min="0"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
                @error('total_points')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Drivers Selection -->
        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Vozači u Timu</label>
            <div class="border border-gray-300 rounded-md p-4 max-h-96 overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="drivers-container">
                    @foreach($drivers as $index => $driver)
                        @php
                            $isSelected = $fantasyTeam->drivers->contains($driver->id);
                            $driverPoints = $isSelected ? $fantasyTeam->drivers->find($driver->id)->pivot->points : 0;
                        @endphp
                        <div class="flex items-center space-x-3 p-3 border border-gray-200 rounded hover:bg-gray-50">
                            <input type="checkbox" 
                                   name="drivers[]" 
                                   value="{{ $driver->id }}" 
                                   id="driver_{{ $driver->id }}"
                                   class="driver-checkbox rounded border-gray-300 text-red-600 focus:ring-red-500"
                                   {{ $isSelected ? 'checked' : '' }}
                                   onchange="toggleDriverPoints(this, {{ $driver->id }})">
                            <label for="driver_{{ $driver->id }}" class="flex-1 cursor-pointer">
                                <div class="flex items-center space-x-3">
                                    @if($driver->photo)
                                        <img src="{{ Storage::url($driver->photo) }}" alt="{{ $driver->name }}" class="w-10 h-10 rounded-full object-cover">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center">
                                            <span>🏎️</span>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-900">{{ $driver->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $driver->team->name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </label>
                            <input type="number" 
                                   name="driver_points[{{ $driver->id }}]" 
                                   id="points_{{ $driver->id }}"
                                   value="{{ $driverPoints }}" 
                                   min="0"
                                   placeholder="Poeni"
                                   class="driver-points w-20 px-2 py-1 border border-gray-300 rounded text-sm {{ $isSelected ? '' : 'hidden' }}"
                                   {{ $isSelected ? '' : 'disabled' }}>
                        </div>
                    @endforeach
                </div>
            </div>
            <p class="mt-2 text-sm text-gray-500">Izaberite vozače i unesite poene za svakog</p>
            @error('drivers')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-6 flex justify-end space-x-4">
            <a href="{{ route('fantasy-teams.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                Otkaži
            </a>
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Ažuriraj
            </button>
        </div>
    </form>
</div>

<script>
function toggleDriverPoints(checkbox, driverId) {
    const pointsInput = document.getElementById('points_' + driverId);
    if (checkbox.checked) {
        pointsInput.classList.remove('hidden');
        pointsInput.disabled = false;
        pointsInput.required = true;
    } else {
        pointsInput.classList.add('hidden');
        pointsInput.disabled = true;
        pointsInput.required = false;
        pointsInput.value = 0;
    }
}
</script>
@endsection

