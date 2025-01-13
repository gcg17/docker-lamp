<?php
function getMysqliConnection() {
    $mysqli = new mysqli("db", "root", "test", "tareas");

    if ($mysqli->connect_error) {
        die("Error de conexión: " . $mysqli->connect_error);
    }
    return $mysqli;
}

function listaTareas() {

    try{
        $conexion = getMysqliConnection();
        if ($conexion->connect_error) {
            [false, $conexion->connect_error];
        } else {
            $sql = 'SSELECT a.id, a.titulo, a.descripcion, a.estado, u.username 
                    FROM tareas a INNER JOIN usuarios u ON a.id_usuario = u.id';
            $resultados = $conexion -> query($sql);
            $tareas = array();
            return [true, $tareas];
        }
    } catch(mysqli_sql_exception $e) {
        return [false, $e -> getMessage()];
        
    } finally {
        if (isset($conexion) && $conexion->connect_errno === 0) {
            $conexion->close();
        }
    }

}

function nuevaTarea(){

}

function actualizaTarea(){

}

function borraTarea(){

}

function buscaTarea(){

}

function buscaUsuariomyslqi($id){
    $conexion = getMysqliConnection();
    if ($conexion->connect_error)
    {
        return [false, $conexion->error];
    }
    else
    {
        $sql = "SELECT * FROM usuarios WHERE id = " . $id;
        $resultados = $conexion->query($sql);
        if ($resultados->num_rows == 1){
            return $resultados->fetch_assoc();
        }
        else{
            return null;
        }
    }
}

?>
