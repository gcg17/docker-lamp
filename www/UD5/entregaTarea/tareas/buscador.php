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

<!-- buscador.php -->
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
    <title>Buscador de Tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <?php include_once ('../componentes/header.php'); ?>
        <div class="row">
            <?php include_once ('../componentes/menu.php'); ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2>Buscador de Tareas</h2>
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
                                require ('../conexiones/pdo.php');

                                if (isset($_GET['id_usuario']) && isset($_GET['estado'])) {
                                    $id = htmlspecialchars($_GET['id_usuario']);
                                    $estado = htmlspecialchars($_GET['estado']);    
                                 }
                                    #conexion con PDO
                                    $pdo = getPDOConnection();

                                    #ejecución de la consulta SQL
                                    try {
                                        try {
                                            $stmt2 = $pdo->prepare("SELECT t.*, u.username FROM tareas t INNER JOIN usuarios u ON t.id_usuario = u.id 
                                                                    WHERE t.id_usuario = ? AND t.estado = ?");
                                            $stmt2->execute([$id, $estado]);
                                            $tareas = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                                        
                                            if ($tareas) {
                                                foreach($tareas as $tarea) {
                                                    echo "<tr>
                                                    <td>{$tarea['id']}</td>
                                                    <td>{$tarea['titulo']}</td>
                                                    <td>{$tarea['descripcion']}</td>
                                                    <td>{$tarea['estado']}</td>
                                                    <td>{$tarea['username']}</td>
                                                    <td>
                                                    <a class='btn btn-sm btn-outline-success' href='editaUsuarioForm.php?id={$tarea['id']}' role='button'>Editar</a>
                                                    <a class='btn btn-sm btn-outline-danger ms-2' href='borraUsuario.php?id={$tarea['id']}' role='button'>Borrar</a>
                                                    </td>
                                                    </tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='6'>No se encontraron tareas que coincidan con los criterios de búsqueda</td></tr>";
                                            }
                                        } catch (PDOException $e) {
                                            echo "<tr><td colspan='6'>Error en la consulta: " . $e->getMessage() . "</td></tr>";
                                        }
                                    } catch (PDOException $e) {
                                        echo "<tr><td colspan='6'>Error en la consulta: " . $e->getMessage() . "</td></tr>";
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
