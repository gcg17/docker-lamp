<?php

require_once 'flight/Flight.php';

Flight::map('auth', function () {
    $db = Flight::get('pdo');
    $token = Flight::request()->getHeader('X-Token');

    if (!$token) {
        Flight::json(['error' => 'Token requerido'], 401);
        exit;
    }

    $stmt = $db->prepare("SELECT * FROM usuarios WHERE token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        Flight::json(['error' => 'Token inválido'], 401);
        exit;
    }

    Flight::set('user', $user);
});