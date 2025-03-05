<!-- utils.php -->

<?php
#verificar si se ha iniciado sesión
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: sesiones/login.php");
    exit();
}

function filtrarCampo($campo) {
    return trim(htmlspecialchars($campo));
}

function esTextoValido($texto) {
    $texto = filtrarCampo($texto);
    return !empty($texto) && strlen($texto) > 2;
}

function guardarTarea($descripcion, $estado) {
    global $tareas;
    if (esTextoValido($descripcion) && esTextoValido($estado)) {
        $tareanueva [] = [
            'id' => count($tareas) + 1,
            'descripcion' => filtrarCampo($descripcion),
            'estado' => filtrarCampo($estado)
        ];

        array_push($tareas, $tareanueva);   
        return true;
    }
    return false;
}

?>
