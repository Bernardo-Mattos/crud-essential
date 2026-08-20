@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold">Clientes</h1>
        <a href="{{ route('clientes.create') }}" class="bg-gray-900 text-white px-4 py-2 rounded">Novo cliente</a>
    </div>

    <table id="clientes-table" data-action="{{ route('clientes.all') }}"
        class="w-full bg-white rounded shadow-sm overflow-hidden">
        <thead class="text-left text-sm">
            <tr>
                <th class="px-4 py-2">Foto</th>
                <th class="px-4 py-2">Nome</th>
                <th class="px-4 py-2">E-mail</th>
                <th class="px-4 py-2">Telefone</th>
                <th class="px-4 py-2">Ações</th>
            </tr>
        </thead>
        <tbody class="divide-y"></tbody>
    </table>

    <div id="delete-modal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center px-4">
        <div class="bg-white p-6 rounded max-w-sm w-full">
            <p id="delete-modal-body" class="mb-4"></p>
            <div class="flex justify-end gap-2">
                <button type="button" id="delete-cancel-btn" class="px-4 py-2 rounded border">Cancelar</button>
                <button type="button" id="delete-confirm-btn" class="px-4 py-2 rounded bg-red-600 text-white">Confirmar exclusão</button>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    @vite(['resources/js/clientes/index.js'])
@endsection
