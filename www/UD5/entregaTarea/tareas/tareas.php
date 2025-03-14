<?php

require_once ('../conexiones/mysqli.php');
require_once ('../usuarios/usuario.php');

class Tarea {
    private int $id;
    private string $titulo;
    private string $descripcion;
    private string $estado;
    private Usuario $usuario;

    public function __construct($id, $titulo, $descripcion, $estado, Usuario $usuario) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
        $this->estado = $estado;
        $this->usuario = $usuario;
    }
    #Metodos

    #Metodo para listar tareas
    public static function listarTareas(): array {
        $mysqli = getMysqliConnection();
        $sql = "SELECT t.id AS tareas_id, t.titulo, t.descripcion, t.estado,
               u.id AS user_id, u.username, u.nombre, u.apellidos, u.contrasena, u.rol
               FROM tareas t JOIN usuarios u ON t.id_usuario = u.id";
        $stmt = $mysqli->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $tareas = [];
        while ($row = $result->fetch_assoc()) {
            $usuario = new Usuario(
                $row['user_id'],
                $row['username'],
                $row['nombre'],
                $row['apellidos'],
                $row['contrasena'],
                $row['rol']
            );
            
            $tareas[] = new Tarea(
                $row['tareas_id'],
                $row['titulo'],
                $row['descripcion'],
                $row['estado'],
                $usuario
            );
        }
        return $tareas;
    }

    #Metodo para listar tareas por usuario
    public static function listarTareasUsuario($id_usuario): array {
        $mysqli = getMysqliConnection();
        $sql = "SELECT t.id AS tareas_id, t.titulo, t.descripcion, t.estado,
               u.id AS user_id, u.username, u.nombre, u.apellidos, u.contrasena, u.rol 
               FROM tareas t JOIN usuarios u ON t.id_usuario = u.id
               where id_usuario = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $tareas = [];
        while ($row = $result->fetch_assoc()) {
            $usuario = new Usuario(
                $row['user_id'],
                $row['username'],
                $row['nombre'],
                $row['apellidos'],
                $row['contrasena'],
                $row['rol']
            );
            
            $tareas[] = new Tarea(
                $row['tareas_id'],
                $row['titulo'],
                $row['descripcion'],
                $row['estado'],
                $usuario
            );
        }
        return $tareas;
    
    }

     #Metodo para seleccionar una tarea por id_usuario y estado
     public static function seleccionarPorIdTarea(int $id_tarea): ?Tarea {
        $mysqli = getMysqliConnection();
        $sql = "SELECT t.id AS tareas_id, t.titulo, t.descripcion, t.estado,
                u.id AS user_id, u.username, u.nombre, u.apellidos, u.contrasena, u.rol FROM tareas t  
                INNER JOIN usuarios u ON t.id_usuario = u.id
                WHERE t.id = ?";
                
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $id_tarea);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($row = $result->fetch_assoc()) {
            $usuario = new Usuario(
                $row['user_id'],
                $row['username'],
                $row['nombre'],
                $row['apellidos'],
                $row['contrasena'],
                $row['rol']
            );
            
            return new Tarea(
                $row['tareas_id'],
                $row['titulo'],
                $row['descripcion'],
                $row['estado'],
                $usuario
            );
        } else {
             return null;
        }
    }
    
    #Metodo para seleccionar una tarea por id_usuario y estado
    public static function seleccionarPorIdEstado(int $id_usuario, string $estado): array {
        $mysqli = getMysqliConnection();
        $sql = "SELECT t.id AS tareas_id, t.titulo, t.descripcion, t.estado,
                u.id AS user_id, u.username, u.nombre, u.apellidos, u.contrasena, u.rol FROM tareas t 
                INNER JOIN usuarios u ON t.id_usuario = u.id 
                WHERE t.id_usuario = ? AND t.estado = ?";
                
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("is", $id_usuario, $estado);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $tareas = [];
        while ($row = $result->fetch_assoc()) {
            $usuario = new Usuario(
                $row['user_id'],
                $row['username'],
                $row['nombre'],
                $row['apellidos'],
                $row['contrasena'],
                $row['rol']
            );
            
            $tareas[] = new Tarea(
                $row['tareas_id'],
                $row['titulo'],
                $row['descripcion'],
                $row['estado'],
                $usuario
            );
        }
        return $tareas;
    }

    #Metodo para seleccionar tareas por titulo
    public static function seleccionarPorTitulo(string $titulo): array {
        $mysqli = getMysqliConnection();
        $sql = "SELECT t.id AS tareas_id, t.titulo, t.descripcion, t.estado,
               u.id AS user_id, u.username, u.nombre, u.apellidos, u.contrasena, u.rol 
               FROM tareas t JOIN usuarios u ON t.id_usuario = u.id WHERE t.titulo LIKE ?";
        $stmt = $mysqli->prepare($sql);
        $tituloParam = "%$titulo%";
        $stmt->bind_param("s", $tituloParam);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $tareas = [];
        while ($row = $result->fetch_assoc()) {
            $usuario = new Usuario(
                $row['user_id'],
                $row['username'],
                $row['nombre'],
                $row['apellidos'],
                $row['contrasena'],
                $row['rol']
            );
            
            $tareas[] = new Tarea(
                $row['tareas_id'],
                $row['titulo'],
                $row['descripcion'],
                $row['estado'],
                $usuario
            );
        }
        return $tareas;
    }

    #Metodo para actualizar tarea
    public function actualizarTarea(): bool {
        $mysqli = getMysqliConnection();
        $sql = "UPDATE tareas SET titulo = ?, descripcion = ?, estado = ?, id_usuario = ? WHERE id = ?";
        
        #si da error al hacer get un atributo de un objeto debemos inicializarlo y darle valor
        $stmt = $mysqli->prepare($sql);
        $userId = $this->usuario->getId();
        $stmt->bind_param("sssii", 
            $this->titulo,
            $this->descripcion,
            $this->estado,
            $userId,
            $this->id
        );
        return $stmt->execute();
    }

    #Metodo para borrar tarea
    public function borrarTarea(): bool {
        $mysqli = getMysqliConnection();
        $sql = "DELETE FROM tareas WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }    
    #Getters y Setters
    public function getId(): int { return $this->id; }
    public function getTitulo(): string { return $this->titulo; }
    public function getDescripcion(): string { return $this->descripcion; }
    public function getEstado(): string { return $this->estado; }
    public function getUsuario(): Usuario { return $this->usuario; }


    public function setTitulo(string $titulo) { $this->titulo = $titulo; }
    public function setDescripcion(string $descripcion) { $this->descripcion = $descripcion; }
    public function setEstado(string $estado) { $this->estado = $estado; }
    public function setUsuario(Usuario $usuario) { $this->usuario = $usuario; }
}
?>
