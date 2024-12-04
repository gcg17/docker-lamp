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
                    <h2>Usuarios</h2>
            </div>
            <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                <?php
                require 'pdo.php';

                if (isset($_GET['id'])) {
                    $id = (int)$_GET['id'];
                    $pdo = getPDOConnection();
                
                    // Borrar tareas asociadas al usuario
                    $pdo->prepare("DELETE FROM tareas WHERE id_usuario = ?")->execute([$id]);
                
                    // Borrar usuario
                    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
                    if ($stmt->execute([$id])) {
                        echo "Usuario y sus tareas asociadas borrados correctamente";
                    } else {
                        echo "Error al borrar el usuario.";
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
