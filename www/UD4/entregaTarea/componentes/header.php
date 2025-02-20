<?php
#verificar si se ha iniciado sesión
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usuario'])) {
    header("Location: ../sesiones/login.php");
    exit();
}
?>

<!-- header.php -->
<header class="bg-primary text-white text-center py-3">
    <h1> UD4 - Gonzalo Cohen García </h1>
    <p> Aplicación web de gestión de tareas </p>
</header>
