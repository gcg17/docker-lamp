<?php

require_once 'flight/Flight.php';

$host = $_ENV['DATABASE_HOST'];
$name = $_ENV['DATABASE_NAME'];
$user = $_ENV['DATABASE_USER'];
$pass = $_ENV['DATABASE_PASSWORD'];

Flight::register('db', 'PDO', array("mysql:host=$host;dbname=$name", $user, $pass));
if (Flight::db() != null)  {
    die("Conexion a la base de datos establecida");
}