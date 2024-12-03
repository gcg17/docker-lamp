<?php
require 'pdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)$_POST['id'];
    $username = htmlspecialchars($_POST['username']);
    $nombre = htmlspecialchars($_POST['nombre']);
    $apellidos = htmlspecialchars($_POST['apellidos']);

    $pdo = getPDOConnection();
    $sql = "UPDATE usuarios SET username = ?, nombre = ?, apellidos = ? WHERE id = ?";
    
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$username, $nombre, $apellidos, $id])) {
        echo "Usuario actualizado correctamente.";
    } else {
        echo "Error al actualizar el usuario.";
    }
}
?>
