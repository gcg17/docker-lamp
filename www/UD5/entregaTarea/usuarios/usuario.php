<?php

require_once ('../conexiones/pdo.php');

class Usuario {
    private ?int $id;
    private string $username;
    private string $nombre;
    private string $apellidos;
    private string $contrasena;
    private int $rol;

    public function __construct($id, $username, $nombre, $apellidos, $contrasena, $rol) {
        $this->id = $id;
        $this->username = $username;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->contrasena = $contrasena;
        $this->rol = $rol;
    }

    #Métodos
    #Metodo para seleccionar usuario por id
    public static function seleccionarPorId(int $id): ?Usuario {
        $pdo = getPDOConnection();
        $sql = "SELECT * FROM usuarios WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return new Usuario(
                $row['id'],
                $row['username'],
                $row['nombre'],
                $row['apellidos'],
                $row['contrasena'],
                $row['rol']
            );
        }
        return null;
    }
    #Metodo para seleccionar usuario por username
    public static function seleccionarPorUsername(string $username): ?Usuario {
        $pdo = getPDOConnection();
        $sql = "SELECT * FROM usuarios WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':username' => $username]);
        
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return new Usuario(
                $row['id'],
                $row['username'],
                $row['nombre'],
                $row['apellidos'],
                $row['contrasena'],
                $row['rol']
            );
        }
        return null;
    }
    
    #Metodo para listar usuarios de la base de datos
       public static function listarUsuarios(): array {
        $pdo = getPDOConnection();
        $sql = "SELECT * FROM usuarios";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        
        $usuarios = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $usuarios[] = new Usuario(
                $row['id'],
                $row['username'],
                $row['nombre'],
                $row['apellidos'],
                $row['contrasena'],
                $row['rol']
            );
        }
        return $usuarios;
    }


    #Metodo para crear usuario en la base de datos
    public function crearUsuario(Usuario $usuario): bool {
        $sql = "INSERT INTO usuarios (username, nombre, apellidos, contrasena, rol) 
                VALUES (:username, :nombre, :apellidos, :contrasena, :rol)";
        
        $pdo = getPDOConnection();
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':username' => $usuario->getUsername(),
            ':nombre' => $usuario->getNombre(),
            ':apellidos' => $usuario->getApellidos(),
            ':contrasena' => $usuario->getContrasena(),
            ':rol' => $usuario->getRol()
        ]);
    }
 
    #Metodo para actualizar usuario en la base de datos
    public function actualizarUsuario(): bool {
        $pdo = getPDOConnection();
        $sql = "UPDATE usuarios 
                SET username = :username, 
                    nombre = :nombre, 
                    apellidos = :apellidos, 
                    contrasena = :contrasena, 
                    rol = :rol 
                WHERE id = :id";
        
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $this->id,
            ':username' => $this->username,
            ':nombre' => $this->nombre,
            ':apellidos' => $this->apellidos,
            ':contrasena' => $this->contrasena,
            ':rol' => $this->rol
        ]);
    }
    
    #Método toString
    public function __toString() {
        return "Usuario[id={$this->id}, username='{$this->username}', nombre='{$this->nombre}', apellidos='{$this->apellidos}', rol='{$this->rol}']";
    }



    #Getters y Setters
    public function getId(): int { return $this->id; }
    public function getUsername(): string { return $this->username; }
    public function getNombre(): string { return $this->nombre; }
    public function getApellidos(): string { return $this->apellidos; }
    public function getContrasena(): string { return $this->contrasena; }
    public function getRol(): string { return $this->rol; }
    
    public function setUsername(string $username) { $this->username = $username; }
    public function setNombre(string $nombre) { $this->nombre = $nombre; }
    public function setApellidos(string $apellidos) { $this->apellidos = $apellidos; }
    public function setContrasena(string $contrasena) { $this->contrasena = $contrasena; }
    public function setRol(string $rol) { $this->rol = $rol; }
}
?>
