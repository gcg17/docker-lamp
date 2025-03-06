<?php
#verificar si se ha iniciado sesión
session_start();
require_once ('usuario.php');

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
    <title>Editar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <?php include ('../componentes/header.php'); ?>
        <div class="row">
            <?php include ('../componentes/menu.php'); ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
              <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h2>Editar Usuario</h2>
              </div>
              <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                <?php
                if (isset($_GET['id'])) {
                    $id = (int)$_GET['id'];

                    #ejecutar el metodo para seleccionar el usuario por id
                    $usuario = Usuario::seleccionarPorId($id);
                ?>
                <form action="editaUsuario.php" method="POST" class="mb-5">
                    <input type="hidden" name="id" value="<?php echo $usuario->getId(); ?>">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" id="username" class="form-control" value="<?php echo $usuario->getUsername(); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo $usuario->getNombre(); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="apellidos" class="form-label">Apellidos</label>
                        <input type="text" name="apellidos" id="apellidos" class="form-control" value="<?php echo $usuario->getApellidos(); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="rol" class="form-label">Rol</label>
                        <select name="rol" id="rol" class="form-select" required>
                            <option value="0" <?php echo ($usuario->getRol() == 0) ? 'selected' : ''; ?>>0 - Usuario</option>
                            <option value="1" <?php echo ($usuario->getRol() == 1) ? 'selected' : ''; ?>>1 - Administrador</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Actualizar usuario</button>
                </form>
                <?php
                } else {
                    echo '<div class="alert alert-danger">No se especificó un usuario para editar</div>';
                }
                ?>
              </div>
            </main>
        </div>
        <?php include ('../componentes/footer.php'); ?>
    </div>
</body>
</html>