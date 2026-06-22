@extends('partials.head')

@section('contentido')
<style>
    .file-card {
        border: 1px solid #e9ecef;
        border-radius: 0.75rem;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .file-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    .file-icon {
        font-size: 3rem;
    }
    .folder-icon {
        color: #5d78ff;
    }
    .file-generic-icon {
        color: #6c757d;
    }
    .card-title {
        font-weight: 500;
        font-size: 0.9rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

<div class="container mt-4">
    <div class="d-flex align-items-center mb-4">
        <a href="/" class="btn btn-light me-3" title="Atrás">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h2 class="mb-0">Escuela {{ $escuela->numero_escuela }}</h2>
            <span class="text-muted">CTT: {{ $escuela->ctt }}</span>
        </div>
    </div>

    @if(empty($contenido))
        <div class="text-center py-5 my-5">
            <i class="bi bi-folder-x text-muted" style="font-size: 5rem;"></i>
            <h3 class="mt-3 text-muted">Esta carpeta está vacía</h3>
            <p class="text-muted">Aún no se han agregado archivos o carpetas.</p>
        </div>
    @else
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-3">
            @foreach($contenido as $item)
                <div class="col">
                    <div class="card file-card h-100 text-center">
                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                            @if($item['tipo'] == 'dir')
                                <i class="bi bi-folder-fill file-icon folder-icon mb-2"></i>
                                <div class="card-title mt-2" title="{{ $item['nombre'] }}">{{ $item['nombre'] }}</div>
                                <span class="badge bg-primary-subtle text-primary-emphasis rounded-pill fw-normal" style="font-size: 0.7rem;">Carpeta</span>
                            @else
                                <i class="bi bi-file-earmark-text file-icon file-generic-icon mb-2"></i>
                                <div class="card-title mt-2" title="{{ $item['nombre'] }}">{{ $item['nombre'] }}</div>
                                <a href="{{ asset($item['ruta']) }}" target="_blank" class="btn btn-sm btn-outline-secondary mt-2" title="Abrir archivo">
                                    <i class="bi bi-box-arrow-up-right"></i> Ver
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
