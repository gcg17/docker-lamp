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

function listaUsuarios($id_usuario,$estado) {
    
    try{
        $con = getPDOConnection();
        $sql = 'SELECT * FROM tareas WHERE id_usuario = '.$id_usuario;
        if (isset($estado)){
            $sql = $sql. " AND estado = '".$estado. "'";
        }
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $tareas = array();
        while ($row = $stmt->fetch()){
            $usuario = buscaUsuario($row['id_usuario']);
            $row['id_usuario'] = $usuario['username'];
            array_push($tareas, $row);
        }
        return [true, $tareas];
        
    } catch (PDOException $e){
        return [false, $e -> getMessage()];
    }finally {
        $con = null;
    }
}

function buscarUsuario(){

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
