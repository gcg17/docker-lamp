<?php
require ('../conexiones/pdo.php');

if (isset($_GET['username'])) {
    $username = (string)$_GET['username'];
    $pdo = getPDOConnection();
    
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE username = ?");
    $stmt->execute([$username]);
    $id = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($id) {
        $stmt2 = $pdo->prepare("SELECT t.*, u.username FROM tareas t JOIN usuarios u ON t.id_usuario = u.id WHERE t.id_usuario = ?");
        $stmt2->execute([$id['id']]);
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
            echo "No existen tareas para este usuario";
        }
    } else {
        echo "El usuario selecciona no existe";
    }
}
?>
