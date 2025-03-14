<?php
#verificar si se ha iniciado sesión
session_start();
require_once ('tareas.php');

if (!isset($_SESSION['usuario'])) {
    header("Location: ../sesiones/login.php");
    exit();
}

#verificar si hay un tema guardado en las cookies sino se establece el tema por defecto
$tema = $_COOKIE['tema'] ?? 'light';
?>

<!-- editaUsuarioForm.php -->
<!DOCTYPE html>
<?php
#setear el tema en el head
if ($tema == 'dark') {
    echo '<html lang="es" data-bs-theme="dark">';
}else{
    echo '<html lang="es">';
}?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <?php include ('../componentes/header.php'); ?>
        <div class="row">
            <?php include ('../componentes/menu.php'); ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
              <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h2>Editar Tarea</h2>
              </div>
              <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                <?php
                if (isset($_GET['id'])) {
                    $id = (int)$_GET['id'];;

                    #ejecutar el metodo para seleccionar la tarea por id_usuario
                    $tarea = Tarea::seleccionarPorIdTarea($id);
                ?>
                <form action="editaTarea.php" method="POST" class="mb-5">
                    <input type="hidden" name="id" value="<?php echo $tarea->getId(); ?>">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Titulo</label>
                        <input type="text" name="titulo" id="titulo" class="form-control" value="<?php echo $tarea->getTitulo(); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="apellidos" class="form-label">Descripcion</label>
                        <input type="text" name="descripcion" id="descripcion" class="form-control" value="<?php echo $tarea->getDescripcion(); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select name="estado" id="estado" class="form-select" required>
                            <option value="pendiente" <?php echo ($tarea-> getEstado() == 'pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                            <option value="en_proceso" <?php echo ($tarea-> getEstado() == 'en_proceso') ? 'selected' : ''; ?>>En proceso</option>
                            <option value="completada" <?php echo ($tarea-> getEstado() == 'completada') ? 'selected' : ''; ?>>Completada</option>
                        </select>
                    </div>  
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" id="username" class="form-control bg-light text-secondary fw-bold border-secondary" value="<?php echo $tarea->getUsuario()-> getUsername(); ?>" readonly>
                    </div>
                    <button type="submit" class="btn btn-primary">Actualizar tarea</button>
                </form>
                <?php
                } else {
                    echo '<div class="alert alert-danger">No se especificó tarea para editar</div>';
                }
                ?>
              </div>
            </main>
        </div>
        <?php include ('../componentes/footer.php'); ?>
    </div>
</body>
</html>