<?php
#Obtener archivos adjuntos
require_once("../conexiones/mysqli.php");

function getArchivos($idTarea) {
    $conexion = getMysqliConnection();
    $sql = "SELECT * FROM archivos WHERE id_tarea = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $idTarea);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

#Procesar subida de archivo
function subirArchivo($idTarea) {
    if (isset($_POST['subir_archivo'])) {
        $archivo = $_FILES['archivo'];
        $nombreArchivo = $archivo['name'];
        $rutaTemporal = $archivo['tmp_name'];
        $rutaDestino = "../uploads/" . time() . "_" . $nombreArchivo;
        
        if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
            $conexion = getMysqliConnection();
            $sqlInsert = "INSERT INTO archivos (id_tarea, nombre, ruta) VALUES (?, ?, ?)";
            $stmtInsert = $conexion->prepare($sqlInsert);
            $stmtInsert->bind_param("iss", $idTarea, $nombreArchivo, $rutaDestino);
            $stmtInsert->execute();
        }
        
        header("Location: tarea.php?id=" . $idTarea);
        exit();
    }
    return false;
}

#Procesar eliminación de archivo
function eliminarArchivo($idTarea) {
    if (isset($_POST['eliminar_archivo'])) {
        $idArchivo = $_POST['id_archivo'];
        $sqlDelete = "DELETE FROM archivos WHERE id = ?";
        $stmtDelete = $conexion->prepare($sqlDelete);
        $stmtDelete->bind_param("i", $idArchivo);
        $stmtDelete->execute();
        header("Location: tarea.php?id=" . $idTarea);
        exit();
    }
    return false;
}

?>