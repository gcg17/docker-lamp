<?php
#conexion mediante variables de entorno
function getMysqliConnection() {
    $mysqli = new mysqli(
        getenv('DATABASE_HOST'),
        getenv('DATABASE_USER'),
        getenv('DATABASE_PASSWORD'),
        getenv('DATABASE_NAME'));

    #manera alternativa
    #$mysqli = new mysqli(
        #$_ENV['DATABASE_HOST'],
        #$_ENV['DATABASE_USER'],
        #$_ENV['DATABASE_PASSWORD'],
        #$_ENV['DATABASE_NAME']);

    if ($mysqli->connect_error) {
        die("Error de conexión: " . $mysqli->connect_error);
    }
    return $mysqli;
  }
?>
