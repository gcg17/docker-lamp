<?php
function getMysqliConnection() {
    $mysqli = new mysqli("db", "root", "test", "tareas");

    if ($mysqli->connect_error) {
        die("Error de conexión: " . $mysqli->connect_error);
    }
    return $mysqli;
}
?>
