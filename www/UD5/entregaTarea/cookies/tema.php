<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (isset($_POST['tema'])) {
    $tema = $_POST['tema'];
    #Intentar establecer la cookie
    try {
        setcookie('tema', $tema, time() + (86400 * 30), "/");
    } catch (Exception $e) {
        #Manejar el error de la cookie
        echo "Error al establecer la cookie: " . $e->getMessage();
    }
   }
 }
#Redirigir de vuelta a la página anterior
if (isset($_SERVER['HTTP_REFERER'])) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
 } else {
    #O cualquier página por defecto si no hay una página anterior
    header("Location: /UD4/entregaTarea/index.php");
 }
exit();