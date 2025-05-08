<div class="modal fade" id="deleteTask-<?= $task['id'] ?>" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar eliminación</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body">
        ¿Estás seguro de que deseas eliminar esta tarea? Esta acción no se puede deshacer.
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>

        <?= form_open('task/delete/' . $task['id']) ?>
          <button type="submit" class="btn btn-danger">Eliminar</button>
        <?= form_close() ?>
      </div>

    </div>
  </div>
</div>
