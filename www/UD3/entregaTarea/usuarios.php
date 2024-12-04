<!-- usuarios.php -->
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
              <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h2>Usuarios</h2>
              </div>
              <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                <table class="table table-striped table-hover">
                    <thead class="thread">
                        <tr>
                            <th>Identificador</th>
                            <th>Usuario</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require 'pdo.php';
                        $pdo = getPDOConnection();
                        $stmt = $pdo->query("SELECT * FROM usuarios");
                        
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            
                            echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['username']}</td>
                            <td>{$row['nombre']}</td>
                            <td>{$row['apellidos']}</td>
                            <td>
                            <a href='editaUsuarioForm.php?id={$row['id']}'>Editar</a> | <a href='borraUsuario.php?id={$row['id']}'>Borrar</a>
                            </td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            </main>
        </div>
        <?php include 'footer.php'; ?>
    </div>
</body>
</html>