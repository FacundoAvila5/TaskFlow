<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<!-- Filtros -->
<div class="filter-section mb-4">
    <div class="row g-3">
        <div class="col-md-3">
            <select class="form-select">
                <option selected>Vista: Lista</option>
                <option>Tarjetas</option>
                <option>Tablero</option>
            </select>
        </div>
        <div class="col-md-3">
            <select class="form-select">
                <option selected>Prioridad: Todas</option>
                <option>Alta</option>
                <option>Media</option>
                <option>Baja</option>
            </select>
        </div>
        <div class="col-md-3">
            <select class="form-select">
                <option selected>Estado: Todos</option>
                <option>En proceso</option>
                <option>Definido</option>
                <option>Completado</option>
            </select>
        </div>
        <div class="col-md-3">
            <select class="form-select">
                <option selected>Fecha: Esta semana</option>
                <option>Hoy</option>
                <option>Este mes</option>
                <option>Todos</option>
            </select>
        </div>
    </div>
</div>

<!-- Lista de Tareas -->
<div class="row">
    <div class="col-12">
        <!-- Tarea 1 - Alta Prioridad -->
        <div class="card task-card high-priority mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="badge bg-danger me-2">Alta</span>
                        <span class="badge bg-warning text-dark">En proceso</span>
                    </div>
                    <div>
                        <button class="btn btn-sm btn-outline-secondary me-2">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-success">
                            <i class="bi bi-check-circle"></i>
                        </button>
                    </div>
                </div>
                <h5 class="mt-2">Presentación para cliente Telefónica</h5>
                <p class="card-text">Preparar presentación de propuesta de diseño para la reunión con el equipo directivo de Telefónica.</p>
                <div class="d-flex align-items-center">
                    <span class="text-muted me-3"><i class="bi bi-calendar me-1"></i> Vence: 05 May, 2025</span>
                    <span class="text-muted"><i class="bi bi-list-check me-1"></i> 3 subtareas</span>
                </div>
            </div>
        </div>

        <!-- Tarea 2 - Normal Prioridad -->
        <div class="card task-card medium-priority mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="badge bg-warning text-dark me-2">Normal</span>
                        <span class="badge bg-info text-dark">Definido</span>
                    </div>
                    <div>
                        <button class="btn btn-sm btn-outline-secondary me-2">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-success">
                            <i class="bi bi-check-circle"></i>
                        </button>
                    </div>
                </div>
                <h5 class="mt-2">Actualizar documentación técnica</h5>
                <p class="card-text">Revisar y actualizar la documentación técnica del proyecto para incluir los últimos cambios en la API.</p>
                <div class="d-flex align-items-center">
                    <span class="text-muted me-3"><i class="bi bi-calendar me-1"></i> Vence: 10 May, 2025</span>
                    <span class="text-muted"><i class="bi bi-list-check me-1"></i> 1 subtarea</span>
                </div>
            </div>
        </div>

        <!-- Tarea 3 - Baja Prioridad (Completada) -->
        <div class="card task-card low-priority completed-task mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="badge bg-success me-2">Baja</span>
                        <span class="badge bg-secondary">Completada</span>
                    </div>
                    <div>
                        <button class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-arrow-counterclockwise"></i> Reabrir
                        </button>
                    </div>
                </div>
                <h5 class="mt-2"><s>Revisar correos pendientes</s></h5>
                <p class="card-text"><s>Revisar y responder a los correos pendientes del departamento de soporte técnico.</s></p>
                <div class="d-flex align-items-center">
                    <span class="text-muted"><i class="bi bi-check-circle me-1"></i> Completada: 01 May, 2025</span>
                </div>
            </div>
        </div>

        <!-- Tarea 4 - Alta Prioridad -->
        <div class="card task-card high-priority mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="badge bg-danger me-2">Alta</span>
                        <span class="badge bg-info text-dark">Definido</span>
                    </div>
                    <div>
                        <button class="btn btn-sm btn-outline-secondary me-2">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-success">
                            <i class="bi bi-check-circle"></i>
                        </button>
                    </div>
                </div>
                <h5 class="mt-2">Resolver error crítico en producción</h5>
                <p class="card-text">Investigar y solucionar el error crítico que afecta al módulo de pagos en el entorno de producción.</p>
                <div class="d-flex align-items-center">
                    <span class="text-muted me-3"><i class="bi bi-calendar me-1"></i> Vence: 04 May, 2025</span>
                    <span class="text-muted"><i class="bi bi-list-check me-1"></i> 2 subtareas</span>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>