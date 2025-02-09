<?php
#verificar si se ha iniciado sesión
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: sesiones/login.php");
    exit();
}

#verificar si hay un tema guardado en las cookies sino se establece el tema por defecto
$tema = $_COOKIE['tema'] ?? 'light';
?>

<!--buscaTareas.php -->
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
    <title>Lista de Tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <?php include_once ('../componentes/header.php'); ?>
        <div class="row">
            <?php include_once ('../componentes/menu.php'); ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
              <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2>Buscador de tareas</h2>
              </div>
                <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                <form action="buscador.php" method="GET" class="mb-5 w-50">
                   <div class="mb-3">
                   <label for="id_usuario" class="form-label">Usuario</label>
                        <select name="id_usuario" id="id_usuario" class="form-select">
                        <?php require_once('../conexiones/mysqli.php');
                        $usuarios = listaTareas();
                        while ($row = $usuarios -> fetch_assoc()) { ?>    
                           <option value="<?php echo htmlspecialchars($row['id']); ?>">
                           <?php echo htmlspecialchars($row['username']); ?>
                           </option>
                           <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select name="estado" id="estado" class="form-select">
                            <option value="pendiente">Pendiente</option>
                            <option value="en_proceso">En proceso</option>
                            <option value="completada">Completada</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>
              </div>
            </main>
        </div>
    </div>
    <?php include ('../componentes/footer.php'); ?>
</body>
</html>
