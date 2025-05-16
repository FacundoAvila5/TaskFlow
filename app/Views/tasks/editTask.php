<div class="modal fade" id="editTask-<?= $task['id'] ?>" tabindex="-1" aria-labelledby="editarTareaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarTareaModalLabel">Editar Tarea</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <?php if (session('success_task')): ?>
                <div class="alert alert-success alert-dismissible fade show m-3">
                    <?= session('success_task') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <?= form_open('task/update/'.$task['id'], ['id' => 'editTaskForm-'.$task['id']]) ?>
                <div class="modal-body">

                    <div class="mb-3">
                        <?= form_label('Asunto', 'asunto', ['class' => 'form-label']) ?>
                        <?= form_input([
                            'name' => 'asunto',
                            'id' => 'asunto',
                            'class' => 'form-control ' . (session('errors.asunto') ? 'is-invalid' : ''),
                            'value' => old('asunto', $task['asunto']),
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
                            'value' => old('descripcion', $task['descripcion'])
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
                            old('prioridad', $task['prioridad']) ?? '1',
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
                            'value' => old('vencimiento', $task['fechaVencimiento'])
                        ]) ?>
                        <?php if (session('errors.vencimiento')): ?>
                            <div class="invalid-feedback"><?= session('errors.vencimiento') ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <?= form_label('Fecha de recordatorio', 'recordatorio', ['class' => 'form-label']) ?>
                        <?= form_input([
                            'type' => 'date',
                            'name' => 'recordatorio',
                            'id' => 'recordatorio',
                            'class' => 'form-control ' . (session('errors.recordatorio') ? 'is-invalid' : ''),
                            'value' => old('recordatorio', $task['fechaRecordatorio'])
                        ]) ?>
                        <?php if (session('errors.recordatorio')): ?>
                            <div class="invalid-feedback"><?= session('errors.recordatorio') ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Color <span class="text-danger">*</span></label>
                        <div class="d-flex gap-2">
                            <?php 
                            $colors = [
                                '#0d6efd' => 'Primary (Azul)',
                                '#dc3545' => 'Danger (Rojo)',
                                '#ffc107' => 'Warning (Amarillo)',
                                '#28a745' => 'Success (Verde)',
                                '#6f42c1' => 'Violeta'
                            ];
                            $selectedColor = old('color', $task['color']);
                            ?>

                            <?php foreach ($colors as $hex => $name): ?>
                                <label class="color-radio" title="<?= $name ?>">
                                    <input type="radio" name="color" value="<?= $hex ?>" <?= $selectedColor == $hex ? 'checked' : '' ?>>
                                    <span class="color-swatch" style="background-color: <?= $hex ?>;"></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                        <?php if (session('errors.color')): ?>
                            <div class="text-danger small mt-1"><?= session('errors.color') ?></div>
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

<?php if (session()->has('errors')) : ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modalId = '<?= session('modalTarget') ?>';
        var modalElement = document.getElementById(modalId);
        if (modalElement) {
            var modal = new bootstrap.Modal(modalElement);
            modal.show();
        } else {
            console.error('No se encontró el modal con ID:', modalId);
        }
    });
</script>
<?php endif; ?>
