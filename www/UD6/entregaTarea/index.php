<?php

require_once ('flight/Flight.php');
require_once ('utils.php');
require_once ('conexion/db.php');
require_once ('routes/auth.php');
require_once ('routes/contactos.php');

Flight::route('/', function () {
    Flight::json('Bienvenido al Servicio (API) de Agenda de Contactos');
});

Flight::start();