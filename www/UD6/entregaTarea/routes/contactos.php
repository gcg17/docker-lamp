<?php

require_once(__DIR__ . '/../flight/Flight.php');
require_once(__DIR__ . '/../utils.php');
require_once (__DIR__ . '/../conexion/db.php');

Flight::route('GET /contactos', function () {
    $db = Flight::get('pdo');
    $token = Flight::request()->getHeader('X-Token');
    
    try{
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE token = ?");
        $stmt->execute([$token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        Flight::json('Error en el Token' . $e->getMessage());
        return;
    }

    try{
        $stmt = $db->prepare("SELECT * FROM contactos WHERE usuario_id = ?");
        $stmt->execute([$user['id']]);
        $contacto = $stmt->fetch(PDO::FETCH_ASSOC);
        Flight::json($contacto);
        return;

    } catch (Exception $e) {
        Flight::json('Error al listar contactos' . $e->getMessage());
        return;
    }
});

Flight::route('GET /contactos(/@id)', function ($id=null) {
    $db = Flight::get('pdo');
    $token = Flight::request()->getHeader('X-Token');
    
    try{
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE token = ?");
        $stmt->execute([$token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        Flight::json(['Error en el Token'],401 . $e->getMessage());
        return;
    }

    try{
        $stmt = $db->prepare("SELECT * FROM contactos WHERE id = :id AND usuario_id = :usuario_id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':usuario_id', $user['id']);
        $stmt->execute();
        $contacto = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if(!$contacto){
        Flight::json(['No se encontro el contacto'], 404);
        return;
    } else {
        Flight::json($contacto);
        return;
    }

    } catch (Exception $e) {
        Flight::json('Error al listar contactos' . $e->getMessage());
        return;
}

  
});

Flight::route('POST /contactos', function () {
    $db = Flight::get('pdo');
    $token = Flight::request()->getHeader('X-Token');
    $nombre = Flight::request()->data->nombre;
    $email = Flight::request()->data->email;
    $telefono = Flight::request()->data->telefono;

    try{
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE token = ?");
        $stmt->execute([$token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        Flight::json(['Error en el Token'],401 . $e->getMessage());
        return;
    }
    
    try {
        $stmt = $db->prepare("INSERT INTO contactos (nombre, telefono, email, usuario_id, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([$nombre, $telefono, $email, $user['id']]);
        Flight :: json ('Contacto añadido');
        return;
    
    } catch (Exception $e) {
        Flight::json('Error al añadir el contacto' . $e->getMessage());
        return;
    }
});
Flight::route('PUT /contactos(/@id)', function ($id=null) {
    Flight::auth();
    $db = Flight::get('pdo');
    $user = Flight::get('usuario');
    $token = Flight::request()->getHeader('X-Token');
    $nombre = Flight::request()->data->nombre;
    $email = Flight::request()->data->email;
    $telefono = Flight::request()->data->telefono;

    try{
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE token = ?");
        $stmt->execute([$token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        Flight::json(['Error en el Token'],401 . $e->getMessage());
        return;
    }

    try{
    $update = $db->prepare("UPDATE contactos SET nombre = ?, telefono = ?, email = ? WHERE id = ? AND usuario_id = ?");
    $update->execute([$nombre, $telefono, $email, $id ,$user['id']]);

    Flight::json('Contacto actualizado');

    } catch (Exception $e) {
        Flight::json('Error al actualizar el contacto ' . $e->getMessage());
        return;
    }
});

Flight::route('DELETE /contactos', function () {
    $db = Flight::get('pdo');
    $token = Flight::request()->getHeader('X-Token');
    $id = Flight::request()-> data->id;

    try{
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE token = ?");
        $stmt->execute([$token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        Flight::json(['Error en el Token'],401 . $e->getMessage());
        return;
    }

    try{
    $delete = $db->prepare("DELETE FROM contactos WHERE id = ? AND usuario_id = ?");
    $delete->execute([$id, $user['id']]);

    Flight::json('Contacto eliminado');

    }catch (Exception $e) {
        Flight::json('Error al eliminar el contacto ' . $e->getMessage());
        return;
    }
});