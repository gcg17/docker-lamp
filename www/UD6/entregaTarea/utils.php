<?php

require_once 'flight/Flight.php';
function validarUsuario($nombre, $email, $password) {
    $validacion= [true];
    $errores= [];
    if(!isset($nombre) || is_null($nombre) || !is_string($nombre) || empty($nombre) ) {
        $validacion[0]= false;
        array_push($errores, 'El nombre no es valido');
    }
    if(!isset($email) || is_null($email) || !is_string($email) || empty($email)) {
        $validacion[0]= false;
        array_push($errores, 'El email no es valido');
    }
    if(!isset($password) || is_null($password) || !is_string($password) || empty($password)) {
        $validacion[0]= false;
        array_push($errores, 'La contraseña no es valida');
    }
    array_push($validacion, $errores);
    return $validacion;
}