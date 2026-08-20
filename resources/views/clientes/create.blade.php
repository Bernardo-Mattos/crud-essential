@extends('layouts.app')

@section('title', 'Clientes - Adicionar')
@section('back', route('clientes.index'))

@section('content')
    <form method="POST" action="{{ route('clientes.store') }}" enctype="multipart/form-data" class="max-w-lg">
        @include('clientes._form')
    </form>
@endsection
