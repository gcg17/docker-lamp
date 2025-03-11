<?php
#verificar si se ha iniciado sesión
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../sesiones/login.php");
    exit();
}

require_once ('tareas.php');

#verificar si hay un tema guardado en las cookies sino se establece el tema por defecto
$tema = $_COOKIE['tema'] ?? 'light';
?>

<!--listaTarea.php -->
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
                <h2>Mis Tareas</h2>
              </div>
              <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
              <div class="table">
                <table class="table table-striped table-hover">
                    <thead class="thead">
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Usuario</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once ('../conexiones/mysqli.php');
                        #obtener las tareas desde la base de datos e imprimirlas
                        $resultados = null;
                        if ($_SESSION['usuario']['rol'] == 1) {    
                            $resultados = Tarea :: listarTareas();
                        } else {
                            $resultados = Tarea :: listarTareasUsuario($_SESSION['usuario']['id']);
                        }
                        foreach ($resultados as $resultado) {
                            echo "<tr>
                                  <td>{$resultado -> getId()}</td>
                                  <td>{$resultado -> getTitulo()}</td>
                                  <td>{$resultado -> getDescripcion()}</td>
                                  <td>{$resultado -> getEstado()}</td>
                                  <td>{$resultado -> getUsuario()->getUsername()}</td>
                                  <td>
                                  <a class='btn btn-sm btn-primary' href='tarea.php?id={$resultado->getId()}' role ='buttom'> Mostrar </a>
                                  <a class='btn btn-sm btn-outline-success' href='editarTareaForm.php?id={$resultado->getId()}' role ='buttom'> Editar </a>
                                  <a class='btn btn-sm btn-outline-danger ms-2' href='borrarTarea.php?id={$resultado->getId()}' role ='buttom'> Borrar </a>
                                  </td>
                                  </tr>";
                             }
                        ?>
                    </tbody>
                </table>
            </div>
          </div>
            </main>
        </div>
        <?php include_once ('../componentes/footer.php'); ?>
    </div>
</body>
</html>
