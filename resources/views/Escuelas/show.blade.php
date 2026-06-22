@extends('partials.head')


@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>
                <a href="/" class="btn btn-sm btn-outline-secondary">← Atrás</a>
                Escuela {{ $escuela->numero_escuela }} (CTT: {{ $escuela->ctt }})
            </h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @if(empty($contenido))
                <div class="alert alert-info text-center">
                    <i class="bi bi-folder-x" style="font-size: 2rem;"></i>
                    <p class="mt-2">La carpeta está vacía</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Archivo</th>
                                <th>Tipo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contenido as $archivo)
                                <tr>
                                    <td>
                                        <i class="bi bi-file"></i>
                                        {{ $archivo['nombre'] }}
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ strtoupper($archivo['tipo']) }}</span>
                                    </td>
                                    <td>
                                        <a href="/{{ $archivo['ruta'] }}" target="_blank" class="btn btn-sm btn-primary" title="Abrir archivo">
                                            <i class="bi bi-download"></i> Descargar
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
