<?php
#Obtener archivos adjuntos
require_once("../conexiones/mysqli.php");

function getArchivos($idTarea) {
    $conexion = getMysqliConnection();
    $sql = "SELECT * FROM ficheros WHERE id_tarea = ?";
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
            $sqlInsert = "INSERT INTO ficheros (nombre, file, descripcion, id_tarea) VALUES (?, ?, ?, ?)";
            $stmtInsert = $conexion->prepare($sqlInsert);
            $stmtInsert->bind_param("sssi", $nombreArchivo, $rutaDestino, $descripcion, $idTarea);
            $stmtInsert->execute();
            $conexion->close();
        }
        
        header("Location: tarea.php?id=" . $idTarea);
        exit();
    }
    return false;
}

function eliminarArchivo($idTarea) {
    if (isset($_POST['eliminar_archivo'])) {
        $conexion = getMysqliConnection();
        $idArchivo = $_POST['id_archivo'];
        
        #Obtener el nombre del archivo
        $sqlSelect = "SELECT file FROM ficheros WHERE id = ?";
        $stmtSelect = $conexion->prepare($sqlSelect);
        $stmtSelect->bind_param("i", $idArchivo);
        $stmtSelect->execute();
        $result = $stmtSelect->get_result();
        $file = $result->fetch_assoc();
        
        #Eliminar el archivo del sistema
        if ($file && file_exists($file['file'])) {
            unlink($file['file']);
        }
        
        #Eliminar el registro de la base de datos
        $sqlDelete = "DELETE FROM ficheros WHERE id = ?";
        $stmtDelete = $conexion->prepare($sqlDelete);
        $stmtDelete->bind_param("i", $idArchivo);
        $stmtDelete->execute();
        $conexion->close();
        
        header("Location: tarea.php?id=" . $idTarea);
        exit();
    }
    return false;
}
?>