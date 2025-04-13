<?php

require_once ('flight/Flight.php');
require_once ('utils.php');
require_once ('conexion/db.php');
require_once ('routes/auth.php');
require_once ('routes/contactos.php');

Flight::route('/', function(){
    echo 'Servicio de Agenda de contactos';
});

Flight::route('GET /register', function() {
    echo 'Registro de usuario';
});

Flight::route('GET /login', function() {
    echo 'Login de usuario';
});

Flight::start();