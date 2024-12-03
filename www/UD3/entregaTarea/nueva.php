<!-- nueva.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <?php include 'header.php'; ?>
        <div class="row">
            <?php include 'menu.php'; ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2>Gestión de tarea</h2>
            </div>
            <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                <?php
                include 'utils.php';
                
                $descripcion = $_POST['descripcion'] ?? '';
                $estado = $_POST['estado'] ?? '';
                
                if (guardarTarea($descripcion, $estado)){
                    echo "<p>Tarea guardada con éxito</p>";
                    echo "<p><a href='listaTareas.php'> <button type='submit' class='btn btn-primary'> Lista de tareas actualizada </button> </a> </p>";
                }else {
                    echo "<p>Error: Verifica los datos e intenta nuevamente.</p>";
                }
            ?>
            </div>
            </main>
        </div>
        <?php include_once('footer.php'); ?>
    </div>
</body>
</html>
