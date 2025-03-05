<?php
#Obtener archivos adjuntos
require_once("../conexiones/mysqli.php");

#Procesar subida de archivo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['subir_archivo'])) {
    $idTarea = $_POST['id_tarea'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    
    if (isset($_FILES['archivo'])) {
        $archivo = $_FILES['archivo'];
        $nombreArchivo = $archivo['name'];
        $rutaTemporal = $archivo['tmp_name'];
        $rutaDestino = "../uploads/" . time() . "_" . $nombreArchivo;
        
        if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
            $conexion = getMysqliConnection();
            $sql = "INSERT INTO ficheros (nombre, file, descripcion, id_tarea) VALUES (?, ?, ?, ?)";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("sssi", $nombre, $rutaDestino, $descripcion, $idTarea);
            
            if ($stmt->execute()) {
                header("Location: ../tareas/tarea.php?id=" . $idTarea);
                exit();
            }
            $conexion->close();
        }
    }
}

#Obtener lista de archivos adjuntos a una tarea
function getArchivos($idTarea) {
    $conexion = getMysqliConnection();
    $sql = "SELECT * FROM ficheros WHERE id_tarea = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $idTarea);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
    $conexion->close();
    header("Location: ../tareas/tarea.php?id=" . $idTarea);
}

?>