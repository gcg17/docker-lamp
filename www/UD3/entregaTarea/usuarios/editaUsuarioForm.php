<!-- editaUsuario.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <?php include ('../componentes/header.php'); ?>
        <div class="row">
            <?php include ('../componentes/menu.php'); ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
              <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h2>Editar Usuario</h2>
              </div>
              <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                <?php
                require ('../conexiones/pdo.php');
                if (isset($_GET['id'])) {
                    $id = (int)$_GET['id'];

                    #conectar a la base de datos
                    $pdo = getPDOConnection();
                    #preparar la consulta
                    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
                    #ejecutar la consulta
                    $stmt->execute([$id]);
                    $usuario = $stmt->fetch();
                ?>
                <form action="editaUsuario.php" method="POST" class="mb-5">
                    <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" id="username" class="form-control" value="<?php echo $usuario['username']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo $usuario['nombre']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="apellidos" class="form-label">Apellidos</label>
                        <input type="text" name="apellidos" id="apellidos" class="form-control" value="<?php echo $usuario['apellidos']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Actualizar usuario</button>
                </form>
                <?php
                } else {
                    echo '<div class="alert alert-danger">No se especificó un usuario para editar</div>';
                }
                ?>
              </div>
            </main>
        </div>
        <?php include ('../componentes/footer.php'); ?>
    </div>
</body>
</html>