<div class="modal fade" id="invitarColaboradores-<?= $task['id'] ?>" tabindex="-1" aria-labelledby="invitarColaboradorLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="invitarColaboradorLabel">Invitar Colaborador</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <?= form_open('task/invite/'.$task['id'], ['id' => 'formInvitarColaborador-'.$task['id']]) ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <?= form_label('Email del colaborador', 'emailColaborador', ['class' => 'form-label']) ?>
                        <?= form_input([
                            'type' => 'email',
                            'name' => 'email',
                            'id' => 'emailColaborador-'.$task['id'],
                            'class' => 'form-control '.(session('errors.email') ? 'is-invalid' : ''),
                            'placeholder' => 'Ingrese el email del colaborador',
                            'value' => old('email'),
                            'required' => true
                        ]) ?>
                        <?php if (session('errors.email')): ?>
                            <div class="invalid-feedback"><?= session('errors.email') ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <?= form_hidden('task_id', $task['id']) ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <?= form_submit('submit', 'Enviar Invitación', [
                        'class' => 'btn btn-primary',
                        'id' => 'btnEnviarInvitacion'
                    ]) ?>
                </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<?php if (session()->has('errors')) :  ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modalElement = document.getElementById('<?= session('modalTarget') ?>');
        if (modalElement) {
            var modal = new bootstrap.Modal(modalElement);
            modal.show();
        }
    });
</script>
<?php endif; ?>