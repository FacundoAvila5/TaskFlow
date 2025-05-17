<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <h2 class="mb-4">Tareas Archivadas</h2>
        
        <?php if (empty($tasks)): ?>
            <div class="alert alert-info">No hay tareas archivadas.</div>
        <?php else: ?>
            <?php foreach ($tasks as $task): ?>
                <div class="card task-card mb-3" style="border-left: 5px solid <?= $task['color'] ?>">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge <?= $task['prioridad'] == 0 ? 'bg-danger' : ($task['prioridad'] == 1 ? 'bg-warning text-dark' : 'bg-success') ?> me-2">
                                    <?= $task['prioridad'] == 0 ? 'Alta' : ($task['prioridad'] == 1 ? 'Normal' : 'Baja') ?>
                                </span>
                                <span class="badge <?= $task['estatus'] == 0 ? 'bg-info text-dark' : ($task['estatus'] == 1 ? 'bg-success' : 'bg-warning text-dark') ?>">
                                    <?= $task['estatus'] == 0 ? 'Definido' : ($task['estatus'] == 1 ? 'Completada' : 'En proceso') ?>
                                </span>
                            </div>
                            <span class="badge bg-secondary">Archivada</span>
                        </div>
                        
                        <h5 class="mt-2"><?= esc($task['asunto']) ?></h5>
                        
                        <?php if (!empty($task['descripcion'])): ?>
                            <p class="card-text"><?= esc($task['descripcion']) ?></p>
                        <?php endif; ?>
                        
                        <?php if (!empty($task['fechaVencimiento'])): ?>
                            <div class="d-flex align-items-center text-muted mb-2">
                                <i class="bi bi-calendar me-1"></i>
                                <span>
                                    Vencimiento: <?= date('d M, Y', strtotime($task['fechaVencimiento'])) ?>
                                    <?php if (date('Y-m-d') > $task['fechaVencimiento']): ?>
                                        <span class="badge bg-danger ms-2">Vencida</span>
                                    <?php endif; ?>
                                </span>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($task['subtasks'])): ?>
                            <div class="subtasks-section mt-3">
                                <h6 class="text-muted mb-2">
                                    <i class="bi bi-list-check me-1"></i> Subtareas (<?= count($task['subtasks']) ?>)
                                </h6>
                                
                                <ul class="list-group list-group-flush">
                                    <?php foreach ($task['subtasks'] as $subtask): ?>
                                        <li class="list-group-item bg-light">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <span class="<?= $subtask['estatus'] == 1 ? 'text-decoration-line-through' : '' ?>">
                                                        <?= esc($subtask['asunto']) ?>
                                                    </span>
                                                    <?php if (!empty($subtask['fechaVencimiento'])): ?>
                                                        <div class="text-muted small mt-1">
                                                            <i class="bi bi-calendar me-1"></i>
                                                            Vencimiento: <?= date('d M, Y', strtotime($subtask['fechaVencimiento'])) ?>
                                                            <?php if (date('Y-m-d') > $subtask['fechaVencimiento'] && $subtask['estatus'] != 1): ?>
                                                                <span class="badge bg-danger ms-2">Vencida</span>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <span class="badge <?= $subtask['estatus'] == 1 ? 'bg-success' : 'bg-secondary' ?>">
                                                    <?= $subtask['estatus'] == 1 ? 'Completada' : 'Pendiente' ?>
                                                </span>
                                            </div>
                                            <?php if (!empty($subtask['descripcion'])): ?>
                                                <small class="text-muted d-block mt-1"><?= esc($subtask['descripcion']) ?></small>
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>