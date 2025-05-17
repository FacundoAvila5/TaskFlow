<div class="modal fade" id="cambiarContrasenia" tabindex="-1" aria-labelledby="cambiarContraseniaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cambiarContraseniaLabel">Cambiar Contraseña</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('auth/actualizarContrasenia', ['id' => 'formCambiarContrasenia']) ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <?= form_label('Contraseña Actual', 'current_password', ['class' => 'form-label']) ?>
                        <?= form_password([
                            'name' => 'current_password',
                            'id' => 'current_password',
                            'class' => 'form-control '.(session('errors.current_password') ? 'is-invalid' : ''),
                            'required' => true
                        ]) ?>
                        <?php if (session('errors.current_password')): ?>
                            <div class="invalid-feedback"><?= session('errors.current_password') ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-3">
                        <?= form_label('Nueva Contraseña', 'new_password', ['class' => 'form-label']) ?>
                        <?= form_password([
                            'name' => 'new_password',
                            'id' => 'new_password',
                            'class' => 'form-control '.(session('errors.new_password') ? 'is-invalid' : ''),
                            'required' => true
                        ]) ?>
                        <small class="text-muted">Mínimo 8 caracteres, con mayúscula, número y carácter especial</small>
                        <?php if (session('errors.new_password')): ?>
                            <div class="invalid-feedback"><?= session('errors.new_password') ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-3">
                        <?= form_label('Confirmar Nueva Contraseña', 'confirm_password', ['class' => 'form-label']) ?>
                        <?= form_password([
                            'name' => 'confirm_password',
                            'id' => 'confirm_password',
                            'class' => 'form-control '.(session('errors.confirm_password') ? 'is-invalid' : ''),
                            'required' => true
                        ]) ?>
                        <?php if (session('errors.confirm_password')): ?>
                            <div class="invalid-feedback"><?= session('errors.confirm_password') ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
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