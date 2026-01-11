@extends('layouts.app')

@section('title', 'Vozači')

@section('content')
@php
    $sortBy = $sortBy ?? 'id';
    $sortOrder = $sortOrder ?? 'asc';
@endphp

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Vozači</h1>
    <a href="{{ route('drivers.create') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
        + Dodaj Vozača
    </a>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slika</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ime</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nacionalnost</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Broj</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tim</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <a href="{{ route('drivers.index', ['sort_by' => 'points', 'sort_order' => $sortBy === 'points' && $sortOrder === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center space-x-1 hover:text-gray-700 cursor-pointer">
                        <span>Poeni</span>
                        @if($sortBy === 'points')
                            @if($sortOrder === 'asc')
                                <span class="text-red-600">↑</span>
                            @else
                                <span class="text-red-600">↓</span>
                            @endif
                        @else
                            <span class="text-gray-400">⇅</span>
                        @endif
                    </a>
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Datum Rođenja</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Akcije</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($drivers as $driver)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($driver->photo)
                            <img src="{{ Storage::url($driver->photo) }}" alt="{{ $driver->name }}" class="w-12 h-12 rounded-full object-cover">
                        @else
                            <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center">
                                <span class="text-lg">🏎️</span>
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $driver->name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">{{ $driver->nationality }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">#{{ $driver->driver_number ?? 'N/A' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">{{ $driver->team->name ?? 'N/A' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-semibold text-red-600">{{ $driver->points }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">{{ $driver->date_of_birth->format('d.m.Y') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('drivers.show', $driver->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Prikaži</a>
                        <a href="{{ route('drivers.edit', $driver->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Uredi</a>
                        <form action="{{ route('drivers.destroy', $driver->id) }}" method="POST" class="inline" onsubmit="return confirm('Da li ste sigurni da želite obrisati ovog vozača?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Obriši</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                        Nema vozača. <a href="{{ route('drivers.create') }}" class="text-blue-600 hover:underline">Dodaj prvog vozača</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-4">
    {{ $drivers->links() }}
</div>
@endsection

