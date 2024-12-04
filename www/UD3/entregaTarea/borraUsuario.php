<?php
require 'pdo.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $pdo = getPDOConnection();

    // Borrar tareas asociadas al usuario
    $pdo->prepare("DELETE FROM tareas WHERE id_usuario = ?")->execute([$id]);

    // Borrar usuario
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
    if ($stmt->execute([$id])) {
        echo "Usuario y sus tareas asociadas borrados correctamente.";
    } else {
        echo "Error al borrar el usuario.";
    }
}
?>
