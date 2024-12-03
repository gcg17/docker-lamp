<?php
function getPDOConnection() {
    $dsn = 'mysql:host=db;dbname=tareas';
    $username = 'root';
    $password = 'test';

    try {
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}
?>
