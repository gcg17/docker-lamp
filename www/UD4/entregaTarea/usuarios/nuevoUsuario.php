<!-- nueva.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <?php include ('../componentes/header.php'); ?>
        <div class="row">
            <?php include ('../componentes/menu.php'); ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2>Gestión de tarea</h2>
            </div>
            <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
            <?php
            
            require ('../conexiones/pdo.php');
            
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $username = htmlspecialchars($_POST['username']);
                $nombre = htmlspecialchars($_POST['nombre']);
                $apellidos = htmlspecialchars($_POST['apellidos']);
                $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
                
                $pdo = getPDOConnection();
                
                $sql = "INSERT INTO usuarios (username, nombre, apellidos, contrasena) VALUES (?, ?, ?, ?)";
                
                $stmt = $pdo->prepare($sql);
                if ($stmt->execute([$username, $nombre, $apellidos, $contrasena])) {
                    echo "Usuario añadido correctamente";
                } else {
                    echo "Error al añadir el usuario.";
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
