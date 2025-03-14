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

<!--editaUsuario.php -->
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
            <main class="col-md-9 ms-s require_once('../utils.php');m-auto col-lg-10 px-md-4">
            <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2>Ediar usuario</h2>
            </div>
            <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                <?php
                require ('../conexiones/pdo.php');

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $id = (int)$_POST['id'];
                    $username = htmlspecialchars($_POST['username']);
                    $nombre = htmlspecialchars($_POST['nombre']);
                    $apellidos = htmlspecialchars($_POST['apellidos'])
                    $rol = htmlspecialchars($_POST['rol']);
                
                    $pdo = getPDOConnection();
                    $sql = "UPDATE usuarios SET username = ?, nombre = ?, apellidos = ?, rol=? WHERE id = ?";
                    
                    $stmt = $pdo->prepare($sql);
                    if ($stmt->execute([$username, $nombre, $apellidos, $id, $rol])) {
                        echo "Usuario actualizado correctamente";
                    } else {
                        echo "Error al actualizar el usuario";
                    }
                }
                ?>
            </div>
            </main>
        </div>
        <?php include_once('../componentes/footer.php'); ?>
    </div>
</body>
</html>

