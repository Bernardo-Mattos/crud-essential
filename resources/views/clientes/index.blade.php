@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold">Clientes</h1>
        <a href="{{ route('clientes.create') }}" class="bg-gray-900 text-white px-4 py-2 rounded">Novo cliente</a>
    </div>

    <table class="w-full bg-white rounded shadow-sm overflow-hidden">
        <thead class="bg-gray-100 text-left text-sm">
            <tr>
                <th class="px-4 py-2">Foto</th>
                <th class="px-4 py-2">Nome</th>
                <th class="px-4 py-2">E-mail</th>
                <th class="px-4 py-2">Telefone</th>
                <th class="px-4 py-2">Ações</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse ($clientes as $cliente)
                <tr id="cliente-row-{{ $cliente->id }}">
                    <td class="px-4 py-2">
                        @if ($cliente->photo_url)
                            <img src="{{ $cliente->photo_url }}" alt="Foto de {{ $cliente->name }}"
                                class="h-10 w-10 rounded-full object-cover">
                        @else
                            <span class="h-10 w-10 rounded-full bg-gray-200 inline-block"></span>
                        @endif
                    </td>
                    <td class="px-4 py-2">{{ $cliente->name }}</td>
                    <td class="px-4 py-2">{{ $cliente->email }}</td>
                    <td class="px-4 py-2">{{ $cliente->phone }}</td>
                    <td class="px-4 py-2 space-x-2">
                        <a href="{{ route('clientes.edit', $cliente) }}" class="text-blue-600">Editar</a>
                        <button type="button" class="text-red-600" data-delete-url="{{ route('clientes.api.confirmar-exclusao', $cliente) }}">Excluir</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-gray-500">Nenhum cliente cadastrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $clientes->links() }}
    </div>

    <div id="delete-modal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center px-4">
        <div class="bg-white p-6 rounded max-w-sm w-full">
            <p id="delete-modal-body" class="mb-4"></p>
            <div class="flex justify-end gap-2">
                <button type="button" id="delete-cancel-btn" class="px-4 py-2 rounded border">Cancelar</button>
                <button type="button" id="delete-confirm-btn" class="px-4 py-2 rounded bg-red-600 text-white">Confirmar exclusão</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('delete-modal');
            const body = document.getElementById('delete-modal-body');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            let targetId = null;

            document.querySelectorAll('[data-delete-url]').forEach((btn) => {
                btn.addEventListener('click', async () => {
                    const response = await fetch(btn.dataset.deleteUrl, {
                        headers: { Accept: 'application/json' },
                    });
                    const json = await response.json();

                    if (!json.success) {
                        return;
                    }

                    targetId = json.data.id;
                    body.textContent = `Excluir ${json.data.name} (${json.data.email})? Esta ação não pode ser desfeita.`;
                    modal.classList.remove('hidden');
                });
            });

            document.getElementById('delete-cancel-btn').addEventListener('click', () => {
                modal.classList.add('hidden');
                targetId = null;
            });

            document.getElementById('delete-confirm-btn').addEventListener('click', async () => {
                if (!targetId) {
                    return;
                }

                const response = await fetch(`/clientes/${targetId}`, {
                    method: 'DELETE',
                    headers: {
                        Accept: 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                });
                const json = await response.json();

                if (json.success) {
                    document.getElementById(`cliente-row-${targetId}`)?.remove();
                }

                modal.classList.add('hidden');
                targetId = null;
            });
        });
    </script>
@endsection
