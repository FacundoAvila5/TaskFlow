<!-- Modal para Nueva Tarea -->
<div class="modal fade" id="editSubtask-<?= $task['id'] ?>-<?= $subtask['id'] ?>" tabindex="-1" aria-labelledby="editarSubtareaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarSubtareaModalLabel">Editar Subtarea</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <?php if (session('success_task')): ?>
                <div class="alert alert-success alert-dismissible fade show m-3">
                    <?= session('success_task') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <?= form_open('subtask/update/'.$subtask['id'], ['id' => 'editTaskForm-'.$subtask['id']]) ?>
                <div class="modal-body">
                    <input type="hidden" name="task_id" value="<?= $task['id'] ?>">

                    <div class="mb-3">
                        <?= form_label('Asunto', 'asunto', ['class' => 'form-label']) ?>
                        <?= form_input([
                            'name' => 'asunto',
                            'id' => 'asunto',
                            'class' => 'form-control ' . (session('errors.asunto') ? 'is-invalid' : ''),
                            'value' => old('asunto', $subtask['title']),
                        ]) ?>
                        <?php if (session('errors.asunto')): ?>
                            <div class="invalid-feedback"><?= session('errors.asunto') ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-3">
                        <?= form_label('Descripción', 'descripcion', ['class' => 'form-label']) ?>
                        <?= form_textarea([
                            'name' => 'descripcion',
                            'id' => 'descripcion',
                            'class' => 'form-control ' . (session('errors.descripcion') ? 'is-invalid' : ''),
                            'rows' => 3,
                            'value' => old('descripcion', $subtask['description'])
                        ]) ?>
                        <?php if (session('errors.descripcion')): ?>
                            <div class="invalid-feedback"><?= session('errors.descripcion') ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-3">
                        <?= form_label('Prioridad', 'prioridad', ['class' => 'form-label']) ?>
                        <?= form_dropdown(
                            'prioridad',
                            [
                                '0' => 'Alta',
                                '1' => 'Normal',
                                '2' => 'Baja'
                            ],
                            old('prioridad', $subtask['prioridad']) ?? '1',
                            [
                                'class' => 'form-select ' . (session('errors.prioridad') ? 'is-invalid' : ''),
                                'id' => 'prioridad',
                                'required' => true
                            ]
                        ) ?>
                        <?php if (session('errors.prioridad')): ?>
                            <div class="invalid-feedback"><?= session('errors.prioridad') ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-3">
                        <?= form_label('Fecha de vencimiento', 'vencimiento', ['class' => 'form-label']) ?>
                        <?= form_input([
                            'type' => 'date',
                            'name' => 'vencimiento',
                            'id' => 'vencimiento',
                            'class' => 'form-control ' . (session('errors.vencimiento') ? 'is-invalid' : ''),
                            'value' => old('vencimiento', $subtask['fechaVencimiento'])
                        ]) ?>
                        <?php if (session('errors.vencimiento')): ?>
                            <div class="invalid-feedback"><?= session('errors.vencimiento') ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="responsable" class="form-label">Responsable <span class="text-danger">*</span></label>
                        <select class="form-select <?= session('errors.responsable') ? 'is-invalid' : '' ?>" 
                                id="responsable" name="responsable" required>
                            <option value="">Seleccionar responsable</option>
                            <?php foreach ($users as $usuario): ?>
                                <option value="<?= $usuario['id'] ?>" 
                                    <?= old('responsable', $subtask['responsableId'] ?? null) == $usuario['id'] ? 'selected' : '' ?>>
                                    <?= esc($usuario['nombreUsuario']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (session('errors.responsable')): ?>
                            <div class="invalid-feedback"><?= session('errors.responsable') ?></div>
                        <?php endif; ?>
                    </div>
                    

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <?= form_submit('submit', 'Guardar Tarea', [
                        'class' => 'btn btn-primary',
                        'id' => 'btnGuardar'
                    ]) ?>
                </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    <?php if (session('errors.descripcion') || session('errors.asunto')) { ?>
        var modal = new bootstrap.Modal(document.getElementById('editSubtask-<?= $task['id'] ?>-<?= $subtask['id'] ?>'));
        modal.show();
    <?php } ?>
});

</script>