@if ($cliente->photo_url)
    <img src="{{ $cliente->photo_url }}" alt="Foto de {{ $cliente->name }}"
        class="h-10 w-10 rounded-full object-cover">
@else
    <span class="h-10 w-10 rounded-full bg-gray-200 inline-block"></span>
@endif
