<!--init.php-->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UD3. Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <?php include ('componentes/header.php'); ?>
        <div class="row">
            <?php include ('componentes/menu.php'); ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
            </div>
            <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
               <?php
                
                $con = new mysqli("db", "root", "test", null);
                
                // Comprobar la conexión
                if ($con->connect_error) {
                    die("Error de conexión: " . $con->connect_error);
                }
               
                // Crear base de datos si no existe
                $sqlDB = "CREATE DATABASE IF NOT EXISTS tareas";
                
                if ($con->query($sqlDB) === TRUE) { 
                    echo '<div class="alert alert-success" role="alert"> BBDD creada </div>';
                } else {
                    echo '<div class="alert alert-success" role="alert"> Error al crear la base de datos: " . $con->error . "-" <div/>';
                }
                
                $con->select_db("tareas");
                
                // Crear tabla usuarios
                $sqlUsuarios = "CREATE TABLE IF NOT EXISTS usuarios (id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(50),
                nombre VARCHAR(50),
                apellidos VARCHAR(100),
                contrasena VARCHAR(100))";
                
                if ($con->query($sqlUsuarios) === TRUE) {
                    echo '<div class="alert alert-success" role="alert"> Tabla usuarios creada </div>';
                } else {
                    echo '<div class="alert alert-success" role="alert"> Error al crear la tabla usuarios: " . $con->error . "-" </div>';
                }
                
                // Crear tabla tareas
                $sqlTareas = "CREATE TABLE IF NOT EXISTS tareas (id INT AUTO_INCREMENT PRIMARY KEY,
                titulo VARCHAR(50),
                descripcion VARCHAR(250),
                estado VARCHAR(50),
                id_usuario INT,
                FOREIGN KEY (id_usuario) REFERENCES usuarios(id))";
                
                if ($con->query($sqlTareas) === TRUE) {
                    echo '<div class="alert alert-success" role="alert"> Tabla tareas creada </div>';
                } else {
                    echo '<div class="alert alert-success" role="alert"> Error al crear la tabla tareas: " . $con->error . "-" </div>';
                }
                
                $con->close();
                ?>
            </div>
            </main>
        </div>
        <?php include ('componentes/footer.php'); ?>
    </div>
</body>
</html>