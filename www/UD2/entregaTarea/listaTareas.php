<!-- listaTareas.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <?php include 'header.php'; ?>
        <div class="row">
            <?php include 'menu.php'; ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <h2>Mis Tareas</h2>
                <table class="table table-striped table-hover">
                    <thead class="thread">
                        <tr>
                            <th>Identificador</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'utils.php';
                        $tareas = obtenerTareas();
                        foreach ($tareas as $tarea) {
                            echo "<tr><td>{$tarea['id']}</td><td>{$tarea['descripcion']}</td><td>{$tarea['estado']}</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </main>
        </div>
        <?php include 'footer.php'; ?>
    </div>
</body>
</html>
        </div>
        <?php include 'footer.php'; ?>
    </div>
</body>
</html>