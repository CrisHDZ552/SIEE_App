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
    <div class="search-container d-flex align-items-center gap-2">
        <div class="input-group search-input-group flex-grow-1">
            <span class="input-group-text bg-transparent border-0 d-flex align-items-center">
                <i class="bi bi-search text-muted"></i>
            </span>
            <input type="text" id="search-input" class="form-control" placeholder="Buscar escuela...">
            <button class="btn btn-filter dropdown-toggle d-flex align-items-center gap-2" type="button"
                data-bs-toggle="dropdown" aria-expanded="false" id="filter-dropdown-btn">
                <i class="bi bi-sliders"></i> <span id="filter-btn-text">Filtrar</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom border-0 shadow mt-2">
                <li>
                    <h6 class="dropdown-header fw-bold text-dark">Filtrar por: </h6>
                </li>
                <li>
                    <a class="dropdown-item dropdown-item-custom" href="#" data-filter="ctt" id="filter-ctt-item">
                        <i class="bi bi-card-text me-2 text-primary"></i> CTT
                    </a>
                </li>
                <li>
                    <a class="dropdown-item dropdown-item-custom" href="#" data-filter="numero_escuela" id="filter-numero-item">
                        <i class="bi bi-hash me-2 text-success"></i> Número de Escuela
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <a class="dropdown-item dropdown-item-custom text-danger fw-semibold" href="#" data-filter="all" id="filter-clear-item">
                        <i class="bi bi-trash me-2"></i> Limpiar Filtros
                    </a>
                </li>
            </ul>
        </div>
        <!--boton para crear carpetas -->
        <div class="d-flex align-items-center gap-0">
            <a href="{{ route('escuelas.creaRR') }}" class="btn btn-filter" type="button" style="border-radius: 15px;" title="Agregar nueva escuela">
                <span id="aggregate-btn-text"></span>
                <i class="bi bi-folder-plus fs-3 text-primary"></i>
            </a>
        </div>
    </div>
    <div id="schools-container" class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-4 justify-content-center">
        @forelse ($escuelas as $escuela)
        <div class="col school-card-wrapper">
            <div class="card folder-card h-100 position-relative shadow-sm border-0 text-center bg-white">
                <div class="card-body py-4 d-flex flex-column align-items-center justify-content-center">
                    <div class="position-relative d-inline-block">
                        <i class="bi bi-folder-fill" style="font-size: 4.5rem; color: rgba(7, 0, 147, 0.59);"></i>
                    </div>
                    <span class="text-muted fw-bold mt-2" style="font-size: 0.75rem; letter-spacing: 0.5px;">ESCUELA
                        <strong>{{ $escuela->numero_escuela }}</strong></span>
                    <span class="text-muted mt-1 d-block" style="font-size: 0.7rem; opacity: 0.85;">CTT: {{ $escuela->ctt }}</span>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5 w-100" id="no-results-box">
            <i class="bi bi-folder-x text-muted" style="font-size: 4rem;"></i>
            <p class="text-muted mt-3 fw-medium">No se encontraron escuelas con la información proporcionada.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-input');
        const filterDropdownBtn = document.getElementById('filter-dropdown-btn');
        const filterBtnText = document.getElementById('filter-btn-text');
        const schoolsContainer = document.getElementById('schools-container');

        const filterCttItem = document.getElementById('filter-ctt-item');
        const filterNumeroItem = document.getElementById('filter-numero-item');
        const filterClearItem = document.getElementById('filter-clear-item');

        let activeFilter = 'all';
        let searchQuery = '';
        let debounceTimeout = null;

        function setFilter(filterType) {
            activeFilter = filterType;

            filterCttItem.classList.remove('active');
            filterNumeroItem.classList.remove('active');

            if (filterType === 'ctt') {
                filterCttItem.classList.add('active');
                filterBtnText.textContent = 'Filtro: CTT';
                filterDropdownBtn.classList.add('btn-filter-active');
                searchInput.placeholder = 'Buscar por CTT (ej. Ct2514c51)...';
            } else if (filterType === 'numero_escuela') {
                filterNumeroItem.classList.add('active');
                filterBtnText.textContent = 'Filtro: N° Escuela';
                filterDropdownBtn.classList.add('btn-filter-active');
                searchInput.placeholder = 'Buscar por Número de Escuela (ej. 14984984)...';
            } else {
                filterBtnText.textContent = 'Filtrar';
                filterDropdownBtn.classList.remove('btn-filter-active');
                searchInput.placeholder = 'Buscar escuela...';
            }

            performSearch();
        }

        filterCttItem.addEventListener('click', function(e) {
            e.preventDefault();
            setFilter('ctt');
        });

        filterNumeroItem.addEventListener('click', function(e) {
            e.preventDefault();
            setFilter('numero_escuela');
        });

        filterClearItem.addEventListener('click', function(e) {
            e.preventDefault();
            setFilter('all');
        });

        searchInput.addEventListener('input', function() {
            searchQuery = this.value;

            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(() => {
                performSearch();
            }, 300);
        });

        function showSkeletons() {
            let skeletonsHtml = '';
            for (let i = 0; i < 5; i++) {
                skeletonsHtml += `
                    <div class="col skeleton-card">
                        <div class="card folder-card h-100 border-0 text-center bg-white shadow-sm">
                            <div class="card-body py-4 d-flex flex-column align-items-center justify-content-center">
                                <div class="placeholder-glow w-100 text-center">
                                    <div class="skeleton-icon mb-2 placeholder"></div>
                                    <div class="placeholder col-8 bg-secondary mt-2" style="height: 14px; opacity: 0.15;"></div>
                                    <div class="placeholder col-5 bg-secondary mt-1" style="height: 10px; opacity: 0.15;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }
            schoolsContainer.innerHTML = skeletonsHtml;
        }

        function performSearch() {
            showSkeletons();

            const params = new URLSearchParams({
                query: searchQuery,
                filter: activeFilter
            });

            fetch(`/escuelas/search?${params.toString()}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    schoolsContainer.innerHTML = '';

                    if (data.length === 0) {
                        schoolsContainer.innerHTML = `
                        <div class="col-12 text-center py-5 w-100" id="no-results-box">
                            <i class="bi bi-folder-x text-muted" style="font-size: 4rem;"></i>
                            <p class="text-muted mt-3 fw-medium">No se encontraron escuelas con la información proporcionada.</p>
                        </div>
                    `;
                        return;
                    }

                    data.forEach((escuela, index) => {
                        const cardHtml = `
                        <div class="col school-card-wrapper" style="animation-delay: ${index * 0.05}s">
                            <div class="card folder-card h-100 position-relative shadow-sm border-0 text-center bg-white">
                                <div class="card-body py-4 d-flex flex-column align-items-center justify-content-center">
                                    <div class="position-relative d-inline-block">
                                        <i class="bi bi-folder-fill" style="font-size: 4.5rem; color: rgba(7, 0, 147, 0.59);"></i>
                                    </div>
                                    <span class="text-muted fw-bold mt-2" style="font-size: 0.75rem; letter-spacing: 0.5px;">ESCUELA
                                        <strong>${escuela.numero_escuela}</strong></span>
                                    <span class="text-muted mt-1 d-block" style="font-size: 0.7rem; opacity: 0.85;">CTT: ${escuela.ctt}</span>
                                </div>
                            </div>
                        </div>
                    `;
                        schoolsContainer.insertAdjacentHTML('beforeend', cardHtml);
                    });
                })
                .catch(error => {
                    console.error('Error fetching search results:', error);
                    schoolsContainer.innerHTML = `
                    <div class="col-12 text-center py-5 w-100">
                        <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 3rem;"></i>
                        <p class="text-danger mt-3 fw-medium">Ocurrió un error al buscar las escuelas. Por favor, intente de nuevo.</p>
                    </div>
                `;
                });
        }
    });
</script>
@endpush