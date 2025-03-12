<?php
#verificar si se ha iniciado sesión
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: sesiones/login.php");
    exit();
}

#Redirigir a index si el usuario no es administrador
if ($_SESSION['usuario']['rol'] != 1) {
    header("Location: index.php");
    exit();
}

#verificar si hay un tema guardado en las cookies sino se establece el tema por defecto
$tema = $_COOKIE['tema'] ?? 'light';
?>

<!--init.php -->
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
    <title>UD4. Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
                
                #conexion mediante variables de entorno
                $con = new mysqli(
                    getenv('DATABASE_HOST'),
                    getenv('DATABASE_USER'),
                    getenv('DATABASE_PASSWORD'),
                    getenv('DATABASE_NAME'));
                
                #manera alternativa
                #$mysqli = new mysqli(
                #$_ENV['DATABASE_HOST'],
                #$_ENV['DATABASE_USER'],
                #$_ENV['DATABASE_PASSWORD'],
                #$_ENV['DATABASE_NAME']);
                
                #Comprobar la conexión
                if ($con->connect_error) {
                    die("Error de conexión: " . $con->connect_error);
                }
               
                #Crear base de datos si no existe
                $sqlDB = "CREATE DATABASE IF NOT EXISTS tareas";
                
                if ($con->query($sqlDB) === TRUE) { 
                    echo '<div class="alert alert-success" role="alert"> BBDD creada </div>';
                } else {
                    echo '<div class="alert alert-success" role="alert"> Error al crear la base de datos: " . $con->error . "-" <div/>';
                }
                
                $con->select_db("tareas");
                
                #Crear tabla usuarios
                $sqlUsuarios = "CREATE TABLE IF NOT EXISTS usuarios (id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(50),
                rol INT(1) NOT NULL DEFAULT 0,
                nombre VARCHAR(50),
                apellidos VARCHAR(100),
                contrasena VARCHAR(100))";
                
                if ($con->query($sqlUsuarios) === TRUE) {
                    echo '<div class="alert alert-success" role="alert"> Tabla usuarios creada</div>';
                } else {
                    echo '<div class="alert alert-success" role="alert"> Error al crear la tabla usuarios: " . $con->error . "-" </div>';
                }
                
                #Crear tabla tareas
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

                #Crear tabla ficheros
                $sqlFicheros = "CREATE TABLE IF NOT EXISTS ficheros (id INT AUTO_INCREMENT PRIMARY KEY,
                nombre VARCHAR(100),
                file VARCHAR(250),
                descripcion VARCHAR(250),
                id_tarea INT,
                FOREIGN KEY (id_tarea) REFERENCES tareas(id))";
                if ($con->query($sqlFicheros) === TRUE) {
                    echo '<div class="alert alert-success" role="alert"> Tabla ficheros creada </div>';
                } else {
                    echo '<div class="alert alert-success" role="alert"> Error al crear la tabla ficheros: " . $con->error . "-" </div>';
                }
                
                #cerrar conexión
                $con->close();
                ?>
            </div>
            </main>
        </div>
        <?php include ('componentes/footer.php'); ?>
    </div>
</body>
</html>