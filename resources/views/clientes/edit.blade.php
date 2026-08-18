@extends('layouts.app')

@section('title', 'Editar cliente')

@section('content')
    <h1 class="text-xl font-semibold mb-6">Editar cliente</h1>

    <form method="POST" action="{{ route('clientes.update', $cliente) }}" enctype="multipart/form-data" class="max-w-lg">
        @include('clientes._form')
    </form>
@endsection
