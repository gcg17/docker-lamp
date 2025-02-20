<?php
#verificar si se ha iniciado sesión
session_start();
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
    <title>Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <?php include ('../componentes/header.php'); ?>
        <div class="row">
            <?php include ('../componentes/menu.php'); ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2>Usuarios</h2>
            </div>
            <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                <?php
                require ('../conexiones/pdo.php');

                if (isset($_GET['id'])) {
                    $id = (int)$_GET['id'];
                    $pdo = getPDOConnection();
                
                    // Borrar tareas asociadas al usuario
                    $pdo->prepare("DELETE FROM tareas WHERE id_usuario = ?")->execute([$id]);
                
                    // Borrar usuario
                    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
                    if ($stmt->execute([$id])) {
                        echo "Usuario y sus tareas asociadas borrados correctamente <br><br>";
                        echo "<a href='usuarios.php'> <button type='submit' class='btn btn-primary'> Lista de usuarios actualizada </button> </a>";
                    } else {
                        echo "Error al borrar el usuario";
                    }
                }
                ?>
            </div>
            </main>
        </div>
        <?php include_once ('../componentes/footer.php'); ?>
    </div>
</body>
</html>
