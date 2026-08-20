@csrf
@if (isset($cliente))
    @method('PUT')
@endif

<div class="mb-4">
    <label for="name"
           class="block text-sm font-medium mb-1">Nome</label>
    <input type="text"
           id="name"
           name="name"
           value="{{ old('name', $cliente->name ?? '') }}"
           class="w-full rounded border-gray-300 shadow-sm px-3 py-2 border">
    @error('name')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label for="email"
           class="block text-sm font-medium mb-1">E-mail</label>
    <input type="email"
           id="email"
           name="email"
           value="{{ old('email', $cliente->email ?? '') }}"
           class="w-full rounded border-gray-300 shadow-sm px-3 py-2 border">
    @error('email')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label for="phone"
           class="block text-sm font-medium mb-1">Telefone</label>
    <input type="text"
           id="phone"
           name="phone"
           value="{{ old('phone', $cliente->phone ?? '') }}"
           placeholder="DDD + número"
           class="w-full rounded border-gray-300 shadow-sm px-3 py-2 border">
    @error('phone')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

@php
    $hasExistingPhoto = isset($cliente) && $cliente->photo_url;
    $existingPhotoName = $hasExistingPhoto ? basename($cliente->photo_path) : null;
@endphp

<div class="mb-6">
    <label for="photo"
           class="block text-sm font-medium mb-1">Foto</label>

    <label for="photo"
           class="flex cursor-pointer items-center gap-4 rounded-lg border border-gray-300 p-3 hover:border-gray-400 hover:bg-gray-50">
        <img id="photo-preview"
             src="{{ $cliente->photo_url ?? '' }}"
             alt="Pré-visualização da foto"
             class="h-14 w-14 shrink-0 rounded-full object-cover {{ $hasExistingPhoto ? '' : 'hidden' }}">
        <span id="photo-placeholder"
              class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-gray-100 text-gray-400 {{ $hasExistingPhoto ? 'hidden' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg"
                 viewBox="0 0 24 24"
                 fill="currentColor"
                 class="h-6 w-6">
                <path fill-rule="evenodd"
                      d="M1.5 6A2.25 2.25 0 0 1 3.75 3.75h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6Zm18 3.75a.75.75 0 0 0-1.5 0v.041a5.25 5.25 0 0 1-1.183 3.311l-2.09 2.596-1.573-1.573a2.25 2.25 0 0 0-3.182 0l-4.5 4.5a.75.75 0 0 0 1.06 1.06l4.5-4.5a.75.75 0 0 1 1.061 0l1.94 1.94a.75.75 0 0 0 1.14-.094l2.635-3.272A6.75 6.75 0 0 0 19.5 9.79V9.75Z"
                      clip-rule="evenodd" />
            </svg>
        </span>

        <div class="min-w-0 flex-1">
            <input type="file"
                   id="photo"
                   name="photo"
                   accept="image/*"
                   class="sr-only">
            <p id="photo-filename"
               class="truncate text-sm text-gray-600">
                {{ $existingPhotoName ?? 'Nenhuma imagem selecionada' }}
            </p>
        </div>

        <button type="button"
                id="photo-remove"
                title="Remover seleção"
                class="shrink-0 rounded p-1 text-gray-400 hover:bg-gray-100 hover:text-red-600 {{ $hasExistingPhoto ? '' : 'hidden' }}">
            <svg xmlns="http://www.w3.org/2000/svg"
                 viewBox="0 0 20 20"
                 fill="currentColor"
                 class="h-5 w-5">
                <path
                      d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
            </svg>
        </button>
    </label>

    @error('photo')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

@section('scripts')
    @vite(['resources/js/clientes/form.js'])
@endsection

<div class="flex gap-2">
    <button type="submit"
            class="bg-gray-900 text-white px-4 py-2 rounded">Salvar</button>
    <a href="{{ route('clientes.index') }}"
       class="px-4 py-2 rounded border">Cancelar</a>
</div>
