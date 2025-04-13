<?php

require_once(__DIR__ . '/../flight/Flight.php');
require_once(__DIR__ . '/../utils.php');
require_once (__DIR__ . '/../conexion/db.php');

Flight::route('GET /contactos', function () {
    Flight::auth();
    $db = Flight::get('pdo');
    $user = Flight::get('user');
    $id = Flight::request()->query['id'] ?? null;

    if ($id) {
        $stmt = $db->prepare("SELECT * FROM contactos WHERE id = ? AND usuario_id = ?");
        $stmt->execute([$id, $user['id']]);
        $contacto = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$contacto) {
            Flight::json(['error' => 'Contacto no encontrado'], 404);
            return;
        }
        Flight::json($contacto);
    } else {
        $stmt = $db->prepare("SELECT * FROM contactos WHERE usuario_id = ?");
        $stmt->execute([$user['id']]);
        Flight::json($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
});

Flight::route('POST /contactos', function () {
    Flight::auth();
    $db = Flight::get('pdo');
    $user = Flight::get('user');
    $data = Flight::request()->data;

    $stmt = $db->prepare("INSERT INTO contactos (nombre, telefono, email, usuario_id, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->execute([$data['nombre'], $data['telefono'], $data['email'], $user['id']]);

    Flight::json(['message' => 'Contacto añadido']);
});

Flight::route('PUT /contactos', function () {
    Flight::auth();
    $db = Flight::get('pdo');
    $user = Flight::get('user');
    $data = Flight::request()->data;

    $stmt = $db->prepare("SELECT * FROM contactos WHERE id = ? AND usuario_id = ?");
    $stmt->execute([$data['id'], $user['id']]);
    if (!$stmt->fetch()) {
        Flight::json(['error' => 'No autorizado'], 403);
        return;
    }

    $update = $db->prepare("UPDATE contactos SET nombre = ?, telefono = ?, email = ? WHERE id = ?");
    $update->execute([$data['nombre'], $data['telefono'], $data['email'], $data['id']]);

    Flight::json(['message' => 'Contacto actualizado']);
});

Flight::route('DELETE /contactos', function () {
    Flight::auth();
    $db = Flight::get('pdo');
    $user = Flight::get('user');
    $id = Flight::request()->query['id'];

    $stmt = $db->prepare("SELECT * FROM contactos WHERE id = ? AND usuario_id = ?");
    $stmt->execute([$id, $user['id']]);
    if (!$stmt->fetch()) {
        Flight::json(['error' => 'No autorizado'], 403);
        return;
    }

    $delete = $db->prepare("DELETE FROM contactos WHERE id = ?");
    $delete->execute([$id]);

    Flight::json(['message' => 'Contacto eliminado']);
});