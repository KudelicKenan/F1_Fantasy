@extends('layouts.app')

@section('title', 'Fantasy Timovi')

@section('content')
@php
    $sortBy = $sortBy ?? 'id';
    $sortOrder = $sortOrder ?? 'asc';
@endphp

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Fantasy Timovi</h1>
    <a href="{{ route('fantasy-teams.create') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
        + Dodaj Fantasy Tim
    </a>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ime</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Korisnik</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <a href="{{ route('fantasy-teams.index', ['sort_by' => 'total_points', 'sort_order' => $sortBy === 'total_points' && $sortOrder === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center space-x-1 hover:text-gray-700 cursor-pointer">
                        <span>Ukupno Poena</span>
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
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Broj Vozača</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kreiran</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Akcije</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($fantasyTeams as $fantasyTeam)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $fantasyTeam->name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">{{ $fantasyTeam->user->name ?? 'N/A' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-semibold text-red-600">{{ $fantasyTeam->total_points }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">{{ $fantasyTeam->drivers_count ?? $fantasyTeam->drivers->count() }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">{{ $fantasyTeam->created_at->format('d.m.Y') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('fantasy-teams.show', $fantasyTeam->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Prikaži</a>
                        <a href="{{ route('fantasy-teams.edit', $fantasyTeam->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Uredi</a>
                        <form action="{{ route('fantasy-teams.destroy', $fantasyTeam->id) }}" method="POST" class="inline" onsubmit="return confirm('Da li ste sigurni da želite obrisati ovaj fantasy tim?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Obriši</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        Nema fantasy timova. <a href="{{ route('fantasy-teams.create') }}" class="text-blue-600 hover:underline">Dodaj prvi fantasy tim</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-4">
    {{ $fantasyTeams->links() }}
</div>
@endsection

