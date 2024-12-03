<?php
require 'pdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $nombre = htmlspecialchars($_POST['nombre']);
    $apellidos = htmlspecialchars($_POST['apellidos']);
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

    $pdo = getPDOConnection();
    $sql = "INSERT INTO usuarios (username, nombre, apellidos, contrasena) VALUES (?, ?, ?, ?)";
    
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$username, $nombre, $apellidos, $contrasena])) {
        echo "Usuario añadido correctamente.";
    } else {
        echo "Error al añadir el usuario.";
    }
}
?>
