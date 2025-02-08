<?php
require ('../conexiones/pdo.php');

#verificar que se han enviado los datos del formulario
if (isset($_GET['id_usuario']) && isset($_GET['estado'])) {
    $id = htmlspecialchars($_GET['id_usuario']);
    $estado = htmlspecialchars($_GET['estado']);    
    
    #conexion con PDO
    $pdo = getPDOConnection();

    #ejecución de la consulta SQL
    if ($id) {
        $stmt2 = $pdo->prepare("SELECT * FROM tareas WHERE id_usuario = ?");
        $stmt2->execute([$id]);
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
