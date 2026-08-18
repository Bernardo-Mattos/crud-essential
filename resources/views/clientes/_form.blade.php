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

<div class="mb-6">
    <label for="photo"
           class="block text-sm font-medium mb-1">Foto</label>
    @if (isset($cliente) && $cliente->photo_url)
        <img src="{{ $cliente->photo_url }}"
             alt="Foto de {{ $cliente->name }}"
             class="h-16 w-16 rounded-full object-cover mb-2">
    @endif
    <input type="file"
           id="photo"
           name="photo"
           accept="image/*"
           class="block">
    @error('photo')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="flex gap-2">
    <button type="submit"
            class="bg-gray-900 text-white px-4 py-2 rounded">Salvar</button>
    <a href="{{ route('clientes.index') }}"
       class="px-4 py-2 rounded border">Cancelar</a>
</div>
