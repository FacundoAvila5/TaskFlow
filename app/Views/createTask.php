<div class="modal" id="createTask" tabindex="-1" aria-labelledby="nuevaTareaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nuevaTareaModalLabel">Nueva Tarea</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <?php if (session('success_task')): ?>
                <div class="alert alert-success alert-dismissible fade show m-3">
                    <?= session('success_task') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <?= form_open('task/create', ['id' => 'taskForm']) ?>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="asunto" class="form-label">Asunto <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?= session('errors.asunto') ? 'is-invalid' : '' ?>" 
                               id="asunto" name="asunto" value="<?= old('asunto') ?>">
                        <?php if (session('errors.asunto')): ?>
                            <div class="invalid-feedback"><?= session('errors.asunto') ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control <?= session('errors.descripcion') ? 'is-invalid' : '' ?>" 
                                  id="descripcion" name="descripcion" rows="3"><?= old('descripcion') ?></textarea>
                        <?php if (session('errors.descripcion')): ?>
                            <div class="invalid-feedback"><?= session('errors.descripcion') ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-3">
                        <label for="prioridad" class="form-label">Prioridad <span class="text-danger">*</span></label>
                        <select class="form-select <?= session('errors.prioridad') ? 'is-invalid' : '' ?>" 
                                id="prioridad" name="prioridad" required>
                            <option value=0 <?= old('prioridad') == 0 ? 'selected' : '' ?>>Alta</option>
                            <option value=1 <?= !old('prioridad') || old('prioridad') == 1 ? 'selected' : '' ?>>Normal</option>
                            <option value=2 <?= old('prioridad') == 2 ? 'selected' : '' ?>>Baja</option>
                        </select>
                        <?php if (session('errors.prioridad')): ?>
                            <div class="invalid-feedback"><?= session('errors.prioridad') ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-3">
                        <label for="vencimiento" class="form-label">Fecha de vencimiento</label>
                        <input type="date" class="form-control <?= session('errors.vencimiento') ? 'is-invalid' : '' ?>" 
                               id="vencimiento" name="vencimiento" value="<?= old('vencimiento') ?>">
                        <?php if (session('errors.vencimiento')): ?>
                            <div class="invalid-feedback"><?= session('errors.vencimiento') ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="recordatorio" class="form-label">Fecha de Recordatorio</label>
                        <input type="date" class="form-control <?= session('errors.recordatorio') ? 'is-invalid' : '' ?>" 
                               id="recordatorio" name="recordatorio" value="<?= old('recordatorio') ?>">
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
                            $selectedColor = old('color');
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
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Guardar
                    </button>
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
            var modal = bootstrap.Modal.getOrCreateInstance(modalElement);
            modal.show();
        } else {
            console.error('No se encontró el modal con ID:', modalId);
        }
    });
</script>
<?php endif; ?>


