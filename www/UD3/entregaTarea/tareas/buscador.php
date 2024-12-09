<?php
require 'pdo.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $pdo = getPDOConnection();
    
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
    $stmt->execute([$id]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($usuario) {
        echo "<form action='editaUsuario.php' method='post'>
                <input type='hidden' name='id' value='{$usuario['id']}'>

                <label for='username'>Username:</label>
                <input type='text' name='username' value='{$usuario['username']}' required><br>

                <label for='nombre'>Nombre:</label>
                <input type='text' name='nombre' value='{$usuario['nombre']}' required><br>

                <label for='apellidos'>Apellidos:</label>
                <input type='text' name='apellidos' value='{$usuario['apellidos']}' required><br>

                <input type='submit' value='Guardar Cambios'>
              </form>";
    } else {
        echo "Usuario no encontrado";
    }
}
?>
