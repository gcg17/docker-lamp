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

?>
