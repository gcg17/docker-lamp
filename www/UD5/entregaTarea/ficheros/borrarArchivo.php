<?php

require_once ('../conexiones/mysqli.php');

#Borrar archivo adjunto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_archivo'])) {
    $idArchivo = $_POST['id_archivo'];
    $idTarea = $_POST['id_tarea'];
    
    $conexion = getMysqliConnection();
    
    #Obtener ruta del archivo
    $sqlSelect = "SELECT file FROM ficheros WHERE id = ?";
    $stmtSelect = $conexion->prepare($sqlSelect);
    $stmtSelect->bind_param("i", $idArchivo);
    $stmtSelect->execute();
    $result = $stmtSelect->get_result();
    $file = $result->fetch_assoc();
    
    #Eliminar archivo físico
    if ($file && file_exists($file['file'])) {
        unlink($file['file']);
    }
    
    #Eliminar registro de la base de datos
    $sqlDelete = "DELETE FROM ficheros WHERE id = ?";
    $stmtDelete = $conexion->prepare($sqlDelete);
    $stmtDelete->bind_param("i", $idArchivo);
    $stmtDelete->execute();
    
    $conexion->close();
    
    header("Location: ../tareas/tarea.php?id=" . $idTarea);
    exit();
}
?>