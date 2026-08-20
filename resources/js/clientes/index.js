document.addEventListener('DOMContentLoaded', () => {
    const tableEl = document.getElementById('clientes-table');

    if (!tableEl) {
        return;
    }

    const dataTable = $(tableEl).DataTable({
        serverSide: true,
        processing: true,
        responsive: true,
        pageLength: 10,
        order: [[1, 'asc']],
        ajax: {
            url: tableEl.dataset.action,
        },
        columns: [
            { data: 'foto', name: 'foto', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'phone', name: 'phone' },
            { data: 'acoes', name: 'acoes', orderable: false, searchable: false },
        ],
        language: {
            emptyTable: 'Nenhum cliente cadastrado.',
            zeroRecords: 'Nenhum cliente encontrado.',
            info: 'Exibindo _START_-_END_ de _TOTAL_',
            infoEmpty: 'Nenhum registro',
            infoFiltered: '(filtrado de _MAX_ registros)',
            lengthMenu: '_MENU_ por página',
            processing: 'Carregando...',
            search: 'Buscar:',
            paginate: {
                first: 'Primeiro',
                last: 'Último',
                next: 'Próximo',
                previous: 'Anterior',
            },
        },
    });

    const modal = document.getElementById('delete-modal');
    const body = document.getElementById('delete-modal-body');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    let targetId = null;

    // Delegado no document: as linhas são recriadas a cada redraw do DataTable (AJAX).
    document.addEventListener('click', async (event) => {
        const btn = event.target.closest('[data-delete-url]');

        if (!btn) {
            return;
        }

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
            dataTable.draw(false);
        }

        modal.classList.add('hidden');
        targetId = null;
    });
});
