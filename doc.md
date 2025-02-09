# Documentación

## Unidad X

1) consulta sql de union entre dos tablas sin llamar a la function en mysqli
    $sql = "SELECT a.id, a.titulo, a.descripcion, a.estado, u.username 
        FROM tareas a INNER JOIN usuarios u ON a.id_usuario = u.id";
        $resultado = $conexion -> query($sql);
        while ($row = $resultado -> fetch_assoc()) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['titulo']}</td>
                    <td>{$row['descripcion']}</td>
                    <td>{$row['estado']}</td>
                    <td>{$row['username']}</td>
                    <td>
                        <a class='btn btn-sm btn-outline-success' href='editaUsuarioForm.php?id={$row['id']}' role ='buttom'> Editar </a>
                        <a class='btn btn-sm btn-outline-danger ms-2' href='borraUsuario.php?id={$row['id']}' role ='buttom'> Borrar </a>
                    </td>
                    </tr>";
            }
