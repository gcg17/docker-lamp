<?php
session_start();

#funcion para comprobar usuario y contraseña y asignar rol
function comprobar_usuario($nombre, $pass) {
    try {

        require_once('../conexiones/pdo.php');
        $conexion = getPDOConnection();
        
        $sql = "SELECT * FROM usuarios WHERE username = :username AND contrasena = :password";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':username', $nombre);
        $stmt->bindParam(':password', $pass);
        $stmt->execute();
        
        if($usuario = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return [
                'nombre' => $usuario['username'],
                'rol' => $usuario['rol'] // Assuming you have a rol column
            ];
        }
        return false;
    }
    catch(PDOException $e) {
        return false;
    }
    finally {
        $conexion = null;
    }
}

#Comprobar si se reciben los datos    
    $nombre = htmlspecialchars($_POST["usuario"], ENT_QUOTES, 'UTF-8');
    $pass = htmlspecialchars($_POST["clave"], ENT_QUOTES, 'UTF-8');    
    $user = comporbar_usuario($nombre, $pass);
    if(!$user){
        header('Location: login.php?error=true');
    }
    else
    {
        $_SESSION['usuario'] = $user;
        #Redirigimos a index.php
        header('Location: index.php');
    }