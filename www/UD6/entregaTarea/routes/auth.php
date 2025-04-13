<?php

require_once __DIR__.'/Flight.php';
require_once __DIR__.'utils.php';
require_once __DIR__.'conexion/db.php';

Flight::route('POST /register', function () {
    $db = Flight::get('pdo');
    $data = Flight::request()->data;

    $stmt = $db->prepare("INSERT INTO usuarios (nombre, email, password, token, created_at) VALUES (?, ?, ?, '', NOW())");

    try {
        $hashed = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt->execute([$data['nombre'], $data['email'], $hashed]);
        Flight::json(['message' => 'Usuario registrado con éxito']);
    } catch (PDOException $e) {
        Flight::json(['error' => 'Email ya registrado'], 400);
    }
});

Flight::route('POST /login', function () {
    $db = Flight::get('pdo');
    $data = Flight::request()->data;

    $stmt = $db->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$data['email']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($data['password'], $user['password'])) {
        Flight::json(['error' => 'Credenciales incorrectas'], 401);
        return;
    }

    $token = bin2hex(random_bytes(32));
    $update = $db->prepare("UPDATE usuarios SET token = ? WHERE id = ?");
    $update->execute([$token, $user['id']]);

    Flight::json(['token' => $token]);
});