<?php
function getPDOConnection() {
    $dsn = 'mysql:host=db;dbname=tareas';
    $username = 'root';
    $password = 'test';

    try {
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}

function listaUsuarios() {
    
    try{
        $con = getPDOConnection();
        $sql = 'SELECT * FROM usuarios';
        $stmt = $con->query($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $tareas = $stm;
        $tareas = array();
        return  $tareas;
        
    } catch (PDOException $e){
        return [false, $e -> getMessage()];
    }finally {
        $con = null;
    }
}

function buscarUsuario($id_usuario){

    try{
        $con = getPDOConnection();
        $sql = 'SELECT * FROM usuarios WHERE id_usuario = '.$id_usuario;
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if ($stmt->rowCount() == 1)
        {
            return $stmt->fetch();
        }
        else
        {
            return null;
        }
    }catch (PDOExcepcion $e){
        return [false, $e -> getMessage()];
    }finally{
        $con = null;
    }

}

?>
