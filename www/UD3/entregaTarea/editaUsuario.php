<!-- borrarUsuario.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <?php include 'header.php'; ?>
        <div class="row">
            <?php include 'menu.php'; ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2>Ediar usuario</h2>
            </div>
            <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                <?php
                require 'pdo.php';

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $id = (int)$_POST['id'];
                    $username = htmlspecialchars($_POST['username']);
                    $nombre = htmlspecialchars($_POST['nombre']);
                    $apellidos = htmlspecialchars($_POST['apellidos']);
                
                    $pdo = getPDOConnection();
                    $sql = "UPDATE usuarios SET username = ?, nombre = ?, apellidos = ? WHERE id = ?";
                    
                    $stmt = $pdo->prepare($sql);
                    if ($stmt->execute([$username, $nombre, $apellidos, $id])) {
                        echo "Usuario actualizado correctamente";
                    } else {
                        echo "Error al actualizar el usuario.";
                    }
                }
                ?>
            </div>
            </main>
        </div>
        <?php include_once('footer.php'); ?>
    </div>
</body>
</html>

