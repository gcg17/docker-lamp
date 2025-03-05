<!-- Formulario para subir archivos -->
<form action="../ficheros/subidaFichProc.php" method="POST" class="mb-5" enctype="multipart/form-data">
  <input type="hidden" name="id_tarea" value="<?php echo $idTarea; ?>">
  <div class="mb-3">
      <label for="nombre" class="form-label">Nombre</label>
      <input type="text" class="form-control" id="nombre" name="nombre" required>
  </div>
  <div class="mb-3">
      <label for="descripcion" class="form-label">Descripción</label>
      <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
  </div>
  <div class="mb-3">
      <label for="archivo" class="form-label">Seleccionar archivo</label>
      <input class="form-control" type="file" id="archivo" name="archivo" required>
  </div>
  <button type="submit" name="subir_archivo" class="btn btn-primary">Subir archivo</button>
</form>