<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="filter-section mb-4">
    <div class="row g-3">
        <div class="col-md-3">
            <select class="form-select">
                <option selected>Prioridad: Todas</option>
                <option>Alta</option>
                <option>Normal</option>
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
    </div>
</div>

<div class="row">
    <div class="col-12">
        <?php if (empty($tasks)): ?>
            <div class="alert alert-info">No tienes tareas registradas aún.</div>
        <?php else: ?>
            <?php foreach ($tasks as $task): ?>

                <?php
                $priorityClass = '';
                $priorityBadge = '';
                $statusBadge = '';
                $isCompleted = ($task['estatus'] == 2);
                
                switch ($task['prioridad']) {
                    case 0:
                        $priorityClass = 'high-priority';
                        $priorityBadge = 'bg-danger';
                        break;
                    case 1:
                        $priorityClass = 'medium-priority';
                        $priorityBadge = 'bg-warning text-dark';
                        break;
                    case 2:
                        $priorityClass = 'low-priority';
                        $priorityBadge = 'bg-success';
                        break;
                }
                
                switch ($task['estatus']) {
                    case 0: // Definido
                        $statusBadge = 'bg-info text-dark';
                        break;
                    case 1: // Completado
                        $statusBadge = 'bg-secondary';
                        $priorityClass .= ' completed-task';
                        break;
                    case 2: // En proceso
                        $statusBadge = 'bg-warning text-dark';
                        break;
                }
                ?>
                
                <div class="card task-card mb-3 <?= $task['prioridad'] == 0 ? 'prioridad-alta' : '' ?>" style="border-left: 5px solid <?= $task['color'] ?>">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge <?= $priorityBadge ?> me-2"><?= $task['prioridad'] == 1 ? 'Normal' : ($task['prioridad'] == 2 ? 'Baja' : 'Alta') ?></span>
                                <span class="badge <?= $statusBadge ?>">
                                    <?= $task['estatus'] == 1 ? 'Completada' : ($task['estatus'] == 2 ? 'En proceso' : 'Definido') ?>
                                </span>
                            </div>
                            <div>
                                <?php if (!$isCompleted): ?>
                                    <button class="btn btn-sm btn-outline-secondary me-2" data-bs-toggle="modal" 
                                    data-bs-target="#editTask-<?= $task['id'] ?>">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-success me-2">
                                        <i class="bi bi-check-circle"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" 
                                    data-bs-target="#deleteTask-<?= $task['id'] ?>">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                <?php else: ?>
                                    <button class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-arrow-counterclockwise"></i> Reabrir
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <h5 class="mt-2 <?= $isCompleted ? 'text-decoration-line-through' : '' ?>">
                            <?= $isCompleted ? '<s>' . esc($task['asunto']) . '</s>' : esc($task['asunto']) ?>
                        </h5>
                        
                        <?php if (!empty($task['descripcion'])): ?>
                            <p class="card-text <?= $isCompleted ? 'text-decoration-line-through' : '' ?>">
                                <?= $isCompleted ? '<s>' . esc($task['descripcion']) . '</s>' : esc($task['descripcion']) ?>
                            </p>
                        <?php endif; ?>
                        
                        <div class="d-flex align-items-center">
                            <?php if ($task['fechaVencimiento']): ?>
                                <span class="text-muted me-3">
                                    <i class="bi bi-calendar me-1"></i> 
                                    Vence: <?= date('d M, Y', strtotime($task['fechaVencimiento'])) ?>
                                </span>
                            <?php endif; ?>
                            
                            <!-- <span class="text-muted"><i class="bi bi-list-check me-1"></i> 3 subtareas</span> -->
                        </div>
                    </div>
                </div>
                <?= view('tasks/editTask', ['task' => $task]) ?>
                <?= view('tasks/deleteTask', ['task' => $task]) ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
