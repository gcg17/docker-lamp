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
                        $conexion = getMysqliConnection();

                        //consulta sql de union entre dos tablas
                        $sql = "SELECT a.id, a.titulo, a.descripcion, a.estado, u.username 
                                FROM tareas a INNER JOIN usuarios u ON a.id_usuario = u.id";
                        $resultado = $conexion -> query($sql);
                        while ($row = $resultado -> fetch_assoc()) {
                            echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['titulo']}</td>
                            <td>{$row['descripcion']}</td>
                            <td>{$row['estado']}</td>
                            <td>{$row['username']}</td>
                            <td>
                            <a class='btn btn-sm btn-outline-success' href='editaUsuarioForm.php?id={$row['id']}' role ='buttom'> Editar </a>
                            <a class='btn btn-sm btn-outline-danger ms-2' href='borraUsuario.php?id={$row['id']}' role ='buttom'> Borrar </a>
                            </td>
                            </tr>";
                        }
                        
                        /*error me devuelve boolean mirar como se hace asi
                        $resultado = listaTareas();
                        while ($row = $resultado -> fetch_assoc()) {
                            echo "<tr><td>{$row['id']}</td>
                                  <td>{$row['titulo']}</td>
                                  <td>{$row['descripcion']}</td>
                                  <td>{$row['estado']}</td>
                                  <td>{$row['username']}</td></tr>
                                  <td>
                                  <a class='btn btn-sm btn-outline-success' href='editaUsuarioForm.php?id={$row['id']}' role ='buttom'> Editar </a>
                                  <a class='btn btn-sm btn-outline-danger ms-2' href='borraUsuario.php?id={$row['id']}' role ='buttom'> Borrar </a>
                                  </td>
                                  </tr>";
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
