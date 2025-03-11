<?php
#verificar si se ha iniciado sesión
session_start();
require_once ('../usuarios/usuario.php');
require_once ('tareas.php');

if (!isset($_SESSION['usuario'])) {
    header("Location: ../sesiones/login.php");
    exit();
}

echo "Request Method: " . $_SERVER['REQUEST_METHOD'];
var_dump($_POST);

#verificar si hay un tema guardado en las cookies sino se establece el tema por defecto
$tema = $_COOKIE['tema'] ?? 'light';
?>

<!--editaTarea.php -->
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
    <title>Tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <?php include ('../componentes/header.php'); ?>
        <div class="row">
            <?php include ('../componentes/menu.php'); ?>
            <main class="col-md-9 ms-s require_once('../utils.php');m-auto col-lg-10 px-md-4">
            <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2>Editar Tarea</h2>
            </div>
            <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    #Seleccionar el id de la tarea a editar
                    $tarea = Tarea::seleccionarPorIdTarea((int)$_POST['id']);

                    if ($tarea) {
                        $tarea->setId(htmlspecialchars((int)$_POST['id']));
                        $tarea->setTitulo(htmlspecialchars($_POST['titulo']));
                        $tarea->setDescripcion(htmlspecialchars($_POST['descripcion']));
                        $tarea->setEstado(htmlspecialchars($_POST['estado']));  
                        
                        if ($tarea->actualizarTarea()) {  
                            echo '<div class="alert alert-success">Tarea actualizada correctamente</div>';
                         } else { 
                            echo '<div class="alert alert-danger">Error al actualizar la tarea</div>';
                        }
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

