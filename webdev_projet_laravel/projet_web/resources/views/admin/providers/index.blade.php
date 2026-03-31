
@extends('layouts.default')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Gestion des Prestataires</h1>
        <div class="text-sm text-gray-500">Total : {{ $prestataires->total() }} membres</div>
    </div>

    @if(session('status'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm">
            {{ session('status') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 border-b">
                <tr class="text-xs uppercase text-gray-500 font-bold">
                    <th class="p-4">Logo</th>
                    <th class="p-4">Nom / Email</th>
                    <th class="p-4">TVA</th>
                    <th class="p-4">Inscription</th>
                    <th class="p-4">Statut</th>
                    <th class="p-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @foreach($prestataires as $p)
                <tr class="hover:bg-gray-50 transition {{ $p->est_banni ? 'bg-red-50' : '' }}">
                    <td class="p-4">
                        <img src="{{ $p->logo ? asset('storage/'.$p->logo) : 'https://ui-avatars.com>nom }}" 
                             class="w-10 h-10 rounded-full object-cover border">
                    </td>
                    <td class="p-4">
                        <div class="font-bold text-gray-800">{{ $p->nom }}</div>
                        <div class="text-xs text-gray-500">{{ $p->email }}</div>
                    </td>
                    <td class="p-4 font-mono text-xs">{{ $p->tva ?? 'N/A' }}</td>
                    <td class="p-4 text-gray-600">{{ $p->created_at->format('d/m/Y') }}</td>
                    <td class="p-4">
                        @if($p->est_banni)
                            <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-[10px] font-bold uppercase">Banni</span>
                        @else
                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-bold uppercase">Actif</span>
                        @endif
                    </td>
                    <td class="p-4 text-right space-x-2">
                        <!-- Voir le profil public -->
                        <a href="{{ route('categories.show', $p->id) }}" class="text-indigo-600 hover:underline font-bold text-xs" target="_blank">Voir</a>

                        <!-- Action de Bannissement -->
                        <form action="{{ route('admin.prestataires.toggle-ban', $p->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="font-bold text-xs uppercase {{ $p->est_banni ? 'text-green-600' : 'text-red-600' }}">
                                {{ $p->est_banni ? 'Débannir' : 'Bannir' }}
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $prestataires->links() }}
    </div>
</div>
@endsection
