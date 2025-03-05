<?php
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

    // Getters y Setters
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
