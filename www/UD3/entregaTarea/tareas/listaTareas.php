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
        <?php include_once ('../componentes/header.php'); ?>
        <div class="row">
            <?php include_once ('../componentes/menu.php'); ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
              <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h2>Mis Tareas</h2>
              </div>
              <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                <table class="table table-striped table-hover">
                    <thead class="thread">
                        <tr>
                            <th>Identificador</th>
                            <th>Título</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Usuario</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //revisar bien cual es el error
                        require_once ('../conexiones/mysqli.php');
                        $conexion = getMysqliConnection();
                        $row = $conexion -> query("SELECT * FROM tareas");
                        $row = array();
                        while ($row -> fetch_assoc()) {
                            echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['titulo']}</td>
                            <td>{$row['descripcion']}</td>
                            <td>{$row['estado']}</td>
                            <td>{$row['id_usuario']}</td>
                            <td>
                            <a class='btn btn-sm btn-outline-success' href='editaUsuarioForm.php?id={$row['id']}' role ='buttom'> Editar </a>
                            <a class='btn btn-sm btn-outline-danger ms-2' href='borraUsuario.php?id={$row['id']}' role ='buttom'> Borrar </a>
                            </td>
                            </tr>";
                        }

                        /*error me devuelve boolean mirar como se hace asi
                        if (is_array($tareas) && count($tareas) > 0){
                        foreach ($tareas as $tarea) {
                            echo "<tr><td>{$tarea['id']}</td>
                                  <td>{$tarea['titulo']}</td>
                                  <td>{$tarea['descripcion']}</td>
                                  <td>{$tarea['estado']}</td>
                                  <td>{$tarea['id_usuario']}</td></tr>";
                          }
                        } else{
                            echo '<tr><td colspan="100">No hay tareas</td></tr>';
                        }*/
                        ?>
                    </tbody>
                </table>
            </div>
            </main>
        </div>
        <?php include_once ('../componentes/footer.php'); ?>
    </div>
</body>
</html>
