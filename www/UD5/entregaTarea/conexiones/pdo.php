<?php
function getPDOConnection() {
    $dsn = 'mysql:host=' . getenv('DATABASE_HOST') . ';dbname=' . getenv('DATABASE_NAME');
    $username = getenv('DATABASE_USER');
    $password = getenv('DATABASE_PASSWORD');

        #manera alternativa
        #$dsn = 'mysql:host=' . $_ENV['DATABASE_HOST'] . ';dbname=' . $_ENV['DATABASE_NAME'];
        #$username = $_ENV['DATABASE_USER'];
        #$password = $_ENV['DATABASE_PASSWORD'];

    try {
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}

?>
