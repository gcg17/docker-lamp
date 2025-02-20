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

<!--nueva.php -->
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
    <title>Nueva Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
                include '../conexiones/pdo.php';

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    try {
                        $titulo = htmlspecialchars($_POST['titulo']);
                        $descripcion = htmlspecialchars($_POST['descripcion']);
                        $estado = htmlspecialchars($_POST['estado']);
                        $id_usuario = htmlspecialchars($_POST['id_usuario']);
                        
                        $pdo = getPDOConnection();
                        
                        $sql = "INSERT INTO tareas (titulo, descripcion, estado, id_usuario) VALUES (?, ?, ?, ?)";

                        $stmt = $pdo->prepare($sql);
                        if ($stmt->execute([$titulo, $descripcion, $estado, $id_usuario])) {
                            echo '<div class="alert alert-success">Tarea añadida correctamente</div>';
                        }
                    } catch(PDOException $e) {
                        echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
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
