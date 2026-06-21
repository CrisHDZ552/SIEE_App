@extends('partials.head')
@section('title', 'SIIE')

@section('contentido')
<link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
<h2 class="text-center mb-4">Nueva Escuela</h2>
    <div class="container mt-4">
        <form action="{{ route('escuelas.agg') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="numero_escuela" class="form-label">Numero de escuela</label>
                <input type="text" class="form-control" id="numero_escuela" name="numero_escuela" maxlength="15" required>
            </div>
            <div class="mb-3">
                <label for="ctt" class="form-label">CTT</label>
                <input type="text" class="form-control" id="ctt" name="ctt" maxlength="15" required>
            </div>
            <button type="submit" class="btn btn-primary">Crear</button>
        </form>
    </div>
@endsection

