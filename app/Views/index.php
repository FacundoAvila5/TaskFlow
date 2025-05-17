<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="filter-section mb-4">
    <?= form_open('index', ['method' => 'get']) ?>
        <div class="row g-3 align-items-center">
            <div class="col-md-3">
                <?= form_label('Prioridad', 'filter_priority', ['class' => 'form-label']) ?>
                <?= form_dropdown(
                    'priority',
                    [
                        '' => 'Todas',
                        '0' => 'Alta',
                        '1' => 'Normal', 
                        '2' => 'Baja'
                    ],
                    $currentPriority ?? '',
                    [
                        'class' => 'form-select',
                        'id' => 'filter_priority'
                    ]
                ) ?>
            </div>
            
            <div class="col-md-3">
                <?= form_label('Estado', 'filter_status', ['class' => 'form-label']) ?>
                <?= form_dropdown(
                    'status',
                    [
                        '' => 'Todos',
                        '0' => 'Definido',
                        '1' => 'Completado',
                        '2' => 'En proceso'
                    ],
                    $currentStatus ?? '',
                    [
                        'class' => 'form-select',
                        'id' => 'filter_status'
                    ]
                ) ?>
            </div>
            
            <div class="col-md-1 ms-auto">
                <div class="d-grid">
                    <?= form_submit('filter', 'Aplicar', [
                        'class' => 'btn btn-primary'
                    ]) ?>
                </div>
            </div>
        </div>
    <?= form_close() ?>
</div>

<div class="row">
    <div class="col-12">
        <?php if (empty($tasks)): ?>
            <div class="alert alert-info">No se han encontrado resultados disponibles.</div>
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
                                    <?php if($task['userId'] == session()->get('user_id')) :?>
                                    <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" 
                                            data-bs-target="#invitarColaboradores-<?= $task['id'] ?>">
                                        <i class="bi bi-person-plus-fill"></i>
                                    </button>
                                    <?php endif ?>
                                    <button class="btn btn-sm btn-outline-secondary me-2" data-bs-toggle="modal" 
                                    data-bs-target="#editTask-<?= $task['id'] ?>">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <?php if($task['userId'] == session()->get('user_id')) :?>
                                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" 
                                    data-bs-target="#deleteTask-<?= $task['id'] ?>">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                    <?php endif ?>
                                <?php else: ?>
                                    <?php if($task['userId'] == session()->get('user_id')) :?>
                                    <form action="<?= site_url('task/archivar/'.$task['id']) ?>" method="post" style="display: inline;">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-archive"></i> Archivar
                                        </button>
                                    </form>
                                    <?php endif; ?>
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
                        
                        <div class="collapse mt-3" id="subtasks-<?= $task['id'] ?>">
                            <div class="card card-body bg-light p-0">
                                <?php if (!empty($task['subtasks'])): ?>
                                    
                                        <?php foreach ($task['subtasks'] as $subtask): ?>
                                            <?php
                                                $subtaskBadge = '';
                                                $isSubtaskCompleted = ($subtask['completed'] ?? false);
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
                                                    
                                                        <form method="post" action="<?= base_url('subtask/updateEstado') ?>" class="d-flex align-items-center justify-content-center pe-2 border-end" style="min-width: 50px;">
                                                            <?= csrf_field() ?>
                                                            <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                                                            <input type="hidden" name="subtask_id" value="<?= $subtask['id'] ?>">
                                                            <div class="form-check m-0">
                                                                <input class="form-check-input" type="checkbox" 
                                                                    name="completed" 
                                                                    value="1" 
                                                                    <?= $isSubtaskCompleted ? 'checked' : '' ?>
                                                                    onchange="this.form.submit()"
                                                                    <?= (($task['estatus'] == 1 && $task['userId'] != session()->get('user_id')) || $subtask['responsableId'] != session()->get('user_id') ? 'disabled' : '' )?>>
                                                            </div>
                                                        </form>
                                                        
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
                                                                    <?php if($task['userId'] == session()->get('user_id')) :?>
                                                                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" 
                                                                            data-bs-target="#deleteSubtask-<?= $subtask['id'] ?>">
                                                                        <i class="bi bi-trash"></i>
                                                                    </button>
                                                                    <?php endif; ?>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>

                                                        <h6 class="mt-2 <?= $subtask['completed'] ? 'text-decoration-line-through text-muted' : '' ?>">
                                                            <?= $subtask['completed'] ? '<s>' . esc($subtask['title']) . '</s>' : esc($subtask['title']) ?>
                                                        </h6>

                                                        <?php if (!empty($subtask['description'])): ?>
                                                            <p class="mb-0 <?= $subtask['completed'] ? 'text-decoration-line-through text-muted' : '' ?>">
                                                                <?= esc($subtask['description']) ?>
                                                            </p>
                                                        <?php endif; ?>

                                                        <?php if (!empty($subtask['fechaVencimiento'])): ?>
                                                            <div class="d-flex align-items-center mt-2">
                                                                <span class="text-muted me-3">
                                                                    <i class="bi bi-calendar me-1"></i> 
                                                                    Vence: <?= date('d M, Y', strtotime($subtask['fechaVencimiento'])) ?>
                                                                </span>
                                                            </div>
                                                        <?php endif; ?>

                                                        <?php if (!empty($subtask['responsableId'])): ?>
                                                            <div class="mt-2">
                                                                <small class="text-muted">Responsable:</small>
                                                                <?php 
                                                                    $responsable = array_filter($users, function($user) use ($subtask) {
                                                                        return $user['id'] == $subtask['responsableId'];
                                                                    });
                                                                    $responsable = reset($responsable);
                                                                ?>
                                                                <?php if ($responsable): ?>
                                                                    <span class="badge bg-info text-dark ms-2">
                                                                        <?= esc($responsable['nombreUsuario']) ?>
                                                                    </span>
                                                                <?php endif; ?>
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
                <?= view('invitarColaborador', ['task' => $task]) ?>
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