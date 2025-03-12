<?php
class Fichero {
    private ?int $id;
    private string $nombre;
    private string $file;
    private string $descripcion;
    private ?Tarea $tarea;

    public const FORMATOS = ['pdf', 'docx', 'txt', 'jpg', 'png'];
    public const MAX_SIZE = 5 * 1024 * 1024; // 5MB

    public function __construct($id, $nombre, $file, $descripcion, Tarea $tarea) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->file = $file;
        $this->descripcion = $descripcion;
        $this->tarea = $tarea;
    }

    #Método estático para validar archivos
    public static function validarArchivo(array $data): array {
        $errores = [];

        if (empty($data['name'])) {
            $errores['nombre'] = "El nombre del archivo es obligatorio.";
        }

        if (empty($data['file'])) {
            $errores['file'] = "El archivo es obligatorio.";
        }

        if (empty($data['descripcion'])) {
            $errores['descripcion'] = "La descripción es obligatoria.";
        }
        
        if (!in_array(pathinfo($data['name'], PATHINFO_EXTENSION), self::FORMATOS)) {
            $errores['formato'] = "Formato no permitido.";
        }

        if ($data['size'] > self::MAX_SIZE) {
            $errores['tamaño'] = "El archivo supera el tamaño máximo permitido.";
        }

        return $errores;
    }
    
    #Getters y Setters
    public function getId(): int { return $this->id; }
    public function getNombre(): string { return $this->nombre; }
    public function getFile(): string { return $this->file; }
    public function getDescripcion(): string { return $this->descripcion; }
    public function getTarea(): Tarea { return $this->tarea; }

    public function setId(int $id): void { $this->id = $id; }
    public function setNombre(string $nombre): void { $this->nombre = $nombre; }
    public function setFile(string $file): void { $this->file = $file; }
    public function setDescripcion(string $descripcion): void { $this->descripcion = $descripcion; }
    public function setTarea(Tarea $tarea): void { $this->tarea = $tarea; }

}
?>
