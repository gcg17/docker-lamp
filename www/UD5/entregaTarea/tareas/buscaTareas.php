<?php
#verificar si se ha iniciado sesión
session_start();
include_once ('tareas.php');
include_once ('../usuarios/usuario.php');

if (!isset($_SESSION['usuario'])) {
    header("Location: ../sesiones/login.php");
    exit();
}

#Rediriigir si no es administrador
if ($_SESSION ['usuario']['rol'] != 1) {
    header("Location: ../index.php");
    exit();
}

#verificar si hay un tema guardado en las cookies sino se establece el tema por defecto
$tema = $_COOKIE['tema'] ?? 'light';
?>

<!--buscaTareas.php -->
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
    <title>Lista de Tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <?php include_once ('../componentes/header.php'); ?>
        <div class="row">
            <?php include_once ('../componentes/menu.php'); ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
              <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2>Buscador de tareas</h2>
              </div>
                <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                <form action="buscador.php" method="GET" class="mb-5 w-50">
                   <div class="mb-3">
                   <label for="id_usuario" class="form-label">Usuario</label>
                        <select name="id_usuario" id="id_usuario" class="form-select">
                        <option value=""selected disabled>Selecciona un usuario</option>
                        <?php 

                            if (isset($_SESSION['usuario'])) {
                                $id = (int)$_SESSION['usuario']['id'];
                             }
            
                            #crear objeto current user (usuario logueado) - mirasr cual es el error
                            $currentUser = Usuario::seleccionarPorId($id);

                            #verificar si es administrador o usuario normal
                            if ($currentUser->getRol() == 1) {

                            #listar todos los usuarios si es administrador          
                            $usuarios = $currentUser::listarUsuarios();
                            } else {

                            #listar solo el usuario logueado si es usuario normal
                            $usuarios = array($currentUser);
                            }

                            #Recorrer los usuarios y mostrarlos en el select
                            foreach ($usuarios as $usuario){ ?>
                            <option value="<?php echo $usuario->getId(); ?>">
                                <?php echo $usuario->getUsername(); ?>
                            </option>

                        <?php } ?>
                        </select>
                            <?php if ($currentUser -> getRol() != 1): ?>
                                <input type="hidden" name="id_usuario" value="<?php echo $_SESSION['usuario']['id']; ?>">
                                <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select name="estado" id="estado" class="form-select">
                            <option value="pendiente">Pendiente</option>
                            <option value="en_proceso">En proceso</option>
                            <option value="completada">Completada</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>
              </div>
            </main>
        </div>
    </div>
    <?php include ('../componentes/footer.php'); ?>
</body>
</html>
