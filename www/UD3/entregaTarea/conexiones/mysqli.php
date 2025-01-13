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
            $sql = 'SELECT * FROM tareas';
            $resultados = $conexion -> query($sql);
            $tareas = array();
            while ($row = $resultados->fetch_assoc()) {
                $usuario = buscaUsuariomyslqi($row['id_usuario']);
                $row['id_usuario'] = $usuario['username'];
                array_push($tareas, $row);
            }
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
