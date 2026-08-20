const TYPE_STYLES = {
    success: 'bg-green-600',
    error: 'bg-red-600',
    warning: 'bg-amber-500',
    info: 'bg-blue-600',
};

const TIMEOUT = 10000;
const HIDE_DURATION = 300;

function getContainer() {
    let container = document.getElementById('toast-container');

    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'fixed bottom-4 right-4 z-50 flex w-80 max-w-[calc(100vw-2rem)] flex-col gap-2';
        document.body.appendChild(container);
    }

    return container;
}

function escapeHtml(value) {
    const div = document.createElement('div');
    div.textContent = value;
    return div.innerHTML;
}

function findExisting(container, type, message) {
    return [...container.children].find(
        (el) => el.dataset.toastType === type && el.dataset.toastMessage === message
    );
}

function pulse(toastEl) {
    toastEl.classList.add('ring-2', 'ring-white');
    setTimeout(() => toastEl.classList.remove('ring-2', 'ring-white'), 300);
}

export function showToast(type, message) {
    const container = getContainer();
    const bg = TYPE_STYLES[type] || TYPE_STYLES.info;

    const existing = findExisting(container, type, message);
    if (existing) {
        pulse(existing);
        return;
    }

    const toast = document.createElement('div');
    toast.dataset.toastType = type;
    toast.dataset.toastMessage = message;
    toast.className = `${bg} pointer-events-auto overflow-hidden rounded-lg text-white shadow-lg transition-all duration-300 ease-out translate-x-4 opacity-0`;
    toast.innerHTML = `
        <div class="flex items-start gap-3 px-4 py-3">
            <p class="flex-1 text-sm">${escapeHtml(message)}</p>
            <button type="button" class="shrink-0 text-white/80 hover:text-white" aria-label="Fechar">&times;</button>
        </div>
        <div class="h-1 bg-white/30">
            <div class="h-full bg-white/70" style="width: 100%"></div>
        </div>
    `;

    container.appendChild(toast);

    requestAnimationFrame(() => {
        toast.classList.remove('translate-x-4', 'opacity-0');
    });

    const progressBar = toast.querySelector(':scope > div:last-child > div');
    let timer;

    function startTimer() {
        progressBar.style.transition = 'none';
        progressBar.style.width = '100%';
        // Força um reflow síncrono: sem isso o navegador pode nunca chegar a pintar
        // esse frame de reset antes da transition ser reativada, e a barra continua
        // de onde estava em vez de reiniciar do zero.
        void progressBar.offsetWidth;
        progressBar.style.transition = `width ${TIMEOUT}ms linear`;
        progressBar.style.width = '0%';

        timer = setTimeout(remove, TIMEOUT);
    }

    function pauseTimer() {
        clearTimeout(timer);
        // Captura a largura ANTES de zerar a transition: remover a transition com uma
        // animação em andamento colapsa o elemento pro valor alvo (0%) na hora.
        const currentWidth = getComputedStyle(progressBar).width;
        progressBar.style.transition = 'none';
        progressBar.style.width = currentWidth;
    }

    function remove() {
        clearTimeout(timer);
        toast.classList.add('opacity-0', 'translate-x-4');
        setTimeout(() => toast.remove(), HIDE_DURATION);
    }

    toast.addEventListener('mouseenter', pauseTimer);
    toast.addEventListener('mouseleave', startTimer);
    toast.querySelector('button').addEventListener('click', remove);

    startTimer();
}
