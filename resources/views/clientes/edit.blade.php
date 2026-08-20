@extends('layouts.app')

@section('title', 'Clientes - Editar')
@section('back', route('clientes.index'))

@section('content')
    <form method="POST" action="{{ route('clientes.update', $cliente) }}" enctype="multipart/form-data" class="max-w-lg">
        @include('clientes._form')
    </form>
@endsection
