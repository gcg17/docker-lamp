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

<!-- footer.php -->
<footer class="bg-dark text-white text-center py-3">
    <small>&copy; 2024 Gonzalo Cohen García</small>
</footer>
