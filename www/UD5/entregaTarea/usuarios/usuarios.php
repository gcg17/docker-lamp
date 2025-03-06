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

<!-- borrarUsuario.php -->
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
    <title>Lista de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <?php include_once ('../componentes/header.php'); ?>
        <div class="row">
            <?php include_once ('../componentes/menu.php'); ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
              <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h2>Usuarios</h2>
              </div>
              <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                <table class="table table-striped table-hover">
                    <thead class="thread">
                        <tr>
                            <th>Identificador</th>
                            <th>Usuario</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once ('../conexiones/pdo.php');
                        #Obtener los usuarios desde la base de datos e imprimirlos en la tabla
                        $usuarios = Usuario::listarUsuarios();

                        foreach ($usuarios as $usuario) {
                            echo "<tr>
                            <td>{$usuario->getId()}</td>
                            <td>{$usuario->getUsername()}</td>
                            <td>{$usuario->getNombre()}</td>
                            <td>{$usuario->getApellidos()}</td>
                            <td>" . ($usuario->getRol() == 1 ? 'Administrador' : 'Usuario') . "</td>
                            <td>
                            <a class='btn btn-sm btn-outline-success' href='editaUsuarioForm.php?id={$usuario->getId()}' role ='buttom'> Editar </a>
                            <a class='btn btn-sm btn-outline-danger' href='borraUsuario.php?id={$usuario->getId()}' role ='buttom'> Borrar </a>
                            </td>
                            </tr>";
                        }

                        ?>
                    </tbody>
                </table>
            </div>
            </main>
        </div>
        <?php include_once ('../componentes/footer.php'); ?>
    </div>
</body>
</html>