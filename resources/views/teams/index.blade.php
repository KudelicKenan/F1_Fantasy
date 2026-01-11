@extends('layouts.app')

@section('title', 'Timovi')

@section('content')
@php
    $sortBy = $sortBy ?? 'id';
    $sortOrder = $sortOrder ?? 'asc';
@endphp

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Timovi</h1>
    <a href="{{ route('teams.create') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
        + Dodaj Tim
    </a>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Logo</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ime</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Država</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Godina Osnivanja</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <a href="{{ route('teams.index', ['sort_by' => 'total_points', 'sort_order' => $sortBy === 'total_points' && $sortOrder === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center space-x-1 hover:text-gray-700 cursor-pointer">
                        <span>Poeni</span>
                        @if($sortBy === 'total_points')
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
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vozači</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Akcije</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($teams as $team)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($team->logo)
                            <img src="{{ Storage::url($team->logo) }}" alt="{{ $team->name }}" class="w-12 h-12 rounded-full object-cover">
                        @else
                            <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center">
                                <span class="text-lg">🏁</span>
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $team->name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">{{ $team->country }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">{{ $team->founded_year }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-semibold text-red-600">{{ $team->total_points }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">{{ $team->drivers_count ?? $team->drivers->count() }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('teams.show', $team->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Prikaži</a>
                        <a href="{{ route('teams.edit', $team->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Uredi</a>
                        <form action="{{ route('teams.destroy', $team->id) }}" method="POST" class="inline" onsubmit="return confirm('Da li ste sigurni da želite obrisati ovaj tim?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Obriši</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                        Nema timova. <a href="{{ route('teams.create') }}" class="text-blue-600 hover:underline">Dodaj prvi tim</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-4">
    {{ $teams->links() }}
</div>
@endsection

