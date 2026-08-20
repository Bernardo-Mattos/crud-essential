<div class="flex flex-nowrap gap-2">
    <a href="{{ route('clientes.edit', $cliente) }}"
        class="rounded border border-gray-300 px-3 py-1 text-sm text-gray-700 hover:bg-gray-100">Editar</a>
    <button type="button"
        class="rounded border border-red-300 px-3 py-1 text-sm text-red-600 hover:bg-red-50"
        data-delete-url="{{ route('clientes.api.confirmar-exclusao', $cliente) }}">Excluir</button>
</div>
