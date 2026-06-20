@extends('partials.head')
@section('title', 'SIIE')

@section('contentido')
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center">SIIE - Evaluación</h1>
            </div>
        </div>
    </div>
    <div class="container my-4">
        <div class="search-container">
            <div class="input-group search-input-group">
                <span class="input-group-text bg-transparent border-0 d-flex align-items-center">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" class="form-control" placeholder="Buscar escuela...">
                <button class="btn btn-filter dropdown-toggle d-flex align-items-center gap-2" type="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-sliders"></i> Filtrar
                </button>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom border-0 shadow mt-2">
                    <li>
                        <h6 class="dropdown-header fw-bold text-dark">Filtrar por:</h6>
                    </li>
                    <li><a class="dropdown-item dropdown-item-custom" href="#"><i
                                class="bi bi-card-text me-2 text-primary"></i> CTT</a></li>
                    <li><a class="dropdown-item dropdown-item-custom" href="#"><i
                                class="bi bi-hash me-2 text-success"></i> Numero de Escuela</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item dropdown-item-custom text-danger fw-semibold" href="#"><i
                                class="bi bi-trash me-2"></i> Limpiar Filtros</a></li>
                </ul>
            </div>
        </div>
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-4 justify-content-center">
            @for ($i = 0; $i < 800; $i++)
                <div class="col">
                    <div class="card folder-card h-100 position-relative shadow-sm border-0 text-center bg-white">
                        <div class="card-body py-4 d-flex flex-column align-items-center justify-content-center">
                            <div class="position-relative d-inline-block">
                                <i class="bi bi-folder-fill" style="font-size: 4.5rem; color: rgba(7, 0, 147, 0.59);"></i>
                            </div>
                            <span class="text-muted fw-bold mt-2" style="font-size: 0.75rem; letter-spacing: 0.5px;">ESCUELA
                                <strong>{{ sprintf('%04d', $i + 1) }}</strong></span>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
@endsection 