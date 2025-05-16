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
                 $modalsData = [
            'task' => $task,
            'subtasks' => $task['subtasks'],
            'users' => $users 
        ];
                $priorityClass = '';
                $priorityBadge = '';
                $statusBadge = '';
                $isCompleted = ($task['estatus'] == 1);
                
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
                        $statusBadge = 'bg-success';
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
                                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" 
                                    data-bs-target="#deleteTask-<?= $task['id'] ?>">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                <?php else: ?>
                                    <button class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-arrow-counterclockwise"></i> Archivar
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
                            
                            <a href="#subtasks-<?= $task['id'] ?>" class="text-muted text-decoration-none" 
                               data-bs-toggle="collapse" aria-expanded="false" 
                               aria-controls="subtasks-<?= $task['id'] ?>">
                                <i class="bi bi-list-check me-1"></i> 
                                <?= count($task['subtasks'] ?? []) ?> subtareas
                            </a>
                        </div>
                        
                        <!-- Subtareas (colapsable) -->
                        <div class="collapse mt-3" id="subtasks-<?= $task['id'] ?>">
                            <div class="card card-body bg-light p-0">
                                <?php if (!empty($task['subtasks'])): ?>
                                    
                                        <?php foreach ($task['subtasks'] as $subtask): ?>
                                            <?php
                                                $subtaskBadge = '';
                                                switch ($subtask['prioridad']) {
                                                    case 0:
                                                        $subtaskBadge = 'bg-danger';
                                                        break;
                                                    case 1:
                                                        $subtaskBadge = 'bg-warning text-dark';
                                                        break;
                                                    case 2:
                                                        $subtaskBadge = 'bg-success';
                                                        break;
                                                }
                                            ?>
                                            <div class="card m-2">
                                                <div class="card-body d-flex">
                                                    <!-- Checkbox a la izquierda -->
                                                    
                                                        <div class="d-flex align-items-center justify-content-center pe-2 border-end" style="min-width: 50px;">
                                                            <div class="form-check m-0">
                                                                <form method="post" action="<?= base_url('subtask/updateEstado') ?>">
                                                                    <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                                                                    <input class="form-check-input" type="checkbox" 
                                                                        name="completed[<?= $subtask['id'] ?>]" 
                                                                        value="1" 
                                                                        <?= $subtask['completed'] ? 'checked' : '' ?>
                                                                        onchange="this.form.submit()">
                                                                </form>
                                                            </div>
                                                        </div>
                                                        
                                                    <!-- Contenido de la subtarea a la derecha -->
                                                    <div class="flex-grow-1 ps-3">
                                                        <div class="d-flex justify-content-between align-items-start">
                                                            <div>
                                                                <span class="badge <?= $subtaskBadge ?> me-2">
                                                                    <?= $subtask['prioridad'] == 0 ? 'Alta' : ($subtask['prioridad'] == 1 ? 'Normal' : 'Baja') ?>
                                                                </span>
                                                            </div>
                                                            <?php if (!$isCompleted): ?>
                                                                <div class="btn-group">
                                                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" 
                                                                            data-bs-target="#editSubtask-<?= $subtask['id'] ?>">
                                                                        <i class="bi bi-pencil"></i>
                                                                    </button>
                                                                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" 
                                                                            data-bs-target="#deleteSubtask-<?= $subtask['id'] ?>">
                                                                        <i class="bi bi-trash"></i>
                                                                    </button>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>

                                                        <!-- Asunto -->
                                                        <h6 class="mt-2 <?= $subtask['completed'] ? 'text-decoration-line-through text-muted' : '' ?>">
                                                            <?= $subtask['completed'] ? '<s>' . esc($subtask['title']) . '</s>' : esc($subtask['title']) ?>
                                                        </h6>

                                                        <!-- Descripción -->
                                                        <?php if (!empty($subtask['description'])): ?>
                                                            <p class="mb-0 <?= $subtask['completed'] ? 'text-decoration-line-through text-muted' : '' ?>">
                                                                <?= esc($subtask['description']) ?>
                                                            </p>
                                                        <?php endif; ?>

                                                        <!-- Fecha de vencimiento -->
                                                        <?php if (!empty($subtask['fechaVencimiento'])): ?>
                                                            <div class="d-flex align-items-center mt-2">
                                                                <span class="text-muted me-3">
                                                                    <i class="bi bi-calendar me-1"></i> 
                                                                    Vence: <?= date('d M, Y', strtotime($subtask['fechaVencimiento'])) ?>
                                                                </span>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>

                                <?php else: ?>
                                    <div class="p-3 text-center text-muted">
                                        No hay subtareas para esta tarea.
                                    </div>
                                <?php endif; ?>
                                <!-- Botón para agregar nueva subtarea -->
                                <div class="p-3 border-top">
                                    <button class="btn btn-primary w-100" type="button" data-bs-toggle="modal" data-bs-target="#createSubtask">
                                        <i class="bi bi-plus-circle"></i> Agregar Subtarea
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?= view('subtasks/createSubtask', ['task' => $task]) ?>
                <?= view('tasks/editTask', ['task' => $task]) ?>
                <?= view('tasks/deleteTask', ['task' => $task]) ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('modals') ?>
    <?php foreach ($tasks as $task): ?>
        <?php if (!empty($task['subtasks'])): ?>
            <?php foreach ($task['subtasks'] as $subtask): ?>
                <?= view('subtasks/editSubtask', [
                    'task' => $task,
                    'subtask' => $subtask,
                    'modalId' => "editSubtask-{$subtask['id']}"
                ]) ?>
                <?= view('subtasks/deleteSubtask', [
                    'subtask' => $subtask,
                    'modalId' => "deleteSubtask-{$subtask['id']}"
                ]) ?>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endforeach; ?>
<?= $this->endSection() ?>