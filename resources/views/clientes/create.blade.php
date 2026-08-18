@extends('layouts.app')

@section('title', 'Novo cliente')

@section('content')
    <h1 class="text-xl font-semibold mb-6">Novo cliente</h1>

    <form method="POST" action="{{ route('clientes.store') }}" enctype="multipart/form-data" class="max-w-lg">
        @include('clientes._form')
    </form>
@endsection
