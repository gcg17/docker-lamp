<?php

require_once(__DIR__ . '/../flight/Flight.php');
require_once(__DIR__ . '/../utils.php');
require_once (__DIR__ . '/../conexion/db.php');

Flight::route('POST /register', function () {
    $db = Flight::get('pdo');
    $nombre = Flight::request()->data -> nombre;
    $email = Flight::request()->data -> email;
    $password = Flight::request()->data -> password;
    
    if (validarUsuario($nombre, $email, $password) [0] == true) {

    $stmt = $db->prepare("INSERT INTO usuarios (nombre, email, password, token, created_at) VALUES (?, ?, ?, ?, NOW())");

    try {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $token = bin2hex(random_bytes(32));
        $stmt -> bindParam(1, $nombre);
        $stmt -> bindParam(2, $email);
        $stmt -> bindParam(3, $hashed);
        $stmt -> bindParam(4, $token);
        $stmt->execute();
        Flight::json(['message' => 'Usuario registrado con éxito. Token: ' . $token], 201);
    } catch (PDOException $e) {
        error_log("Error PDO: " . $e->getMessage());
        Flight::json(['error' => 'Error al registrar: '. $e->getMessage()], 400);
    }

   } else {
    
    Flight::json(["errores" => validarUsuario ($nombre, $email, $password)], 400);

   }

});

Flight::route('POST /login', function () {
    $db = Flight::get('pdo');
    $email = Flight::request()->data -> email;
    $password = Flight::request()->data -> password;

    $stmt = $db->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        Flight::json(['error' => 'Email incorrecto'], 404);
        return;
    } else if (!password_verify($password, $user['password'])) {
        Flight::json(['error' => 'Contraseña incorrecta'], 401);
        return;
    }
    
    $token = bin2hex(random_bytes(32));
    $update = $db->prepare("UPDATE usuarios SET token = ? WHERE id = ?");
    $update->execute([$token, $user['id']]);
    Flight::json('Sesion iniciada. Token: ' . $token);
  
});