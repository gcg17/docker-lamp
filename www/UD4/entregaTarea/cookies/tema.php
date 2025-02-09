<?php
session_start();

if (isset($_POST['tema'])) {
    $tema = $_POST['tema'];

    #Obtener el path base de la aplicación
    $path = dirname($_SERVER['PHP_SELF']);

    #Configurar opciones de la cookie
    $opciones = [
        'expires' => time() + (86400 * 30), // 30 días
        'path' => $path,
        'domain' => $_SERVER['HTTP_HOST'],
        'secure' => isset($_SERVER['HTTPS']),
        'httponly' => true,
        'samesite' => 'Strict'
    ];

    #Intentar establecer la cookie
    if (setcookie('tema', $tema, $opciones)) {
        $_SESSION['message'] = "Tema guardado correctamente.";
    } else {
        $_SESSION['error'] = "No se pudo guardar el tema.";
    }
}

#Redirigir de vuelta a la página anterior
if (isset($_SERVER['HTTP_REFERER'])) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
} else {
    #O cualquier página por defecto si no hay una página anterior
    header("Location: ../index.php"); 
}
exit();