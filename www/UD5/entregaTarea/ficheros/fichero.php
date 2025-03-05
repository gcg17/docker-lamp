<?php
class Fichero {
    private int $id;
    private string $nombre;
    private string $file;
    private string $descripcion;
    private Tarea $tarea;

    public const FORMATOS = ['pdf', 'docx', 'txt', 'jpg', 'png'];
    public const MAX_SIZE = 5 * 1024 * 1024; // 5MB

    public function __construct($id, $nombre, $file, $descripcion, Tarea $tarea) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->file = $file;
        $this->descripcion = $descripcion;
        $this->tarea = $tarea;
    }

    // Método estático para validar archivos
    public static function validarArchivo($archivo): array {
        $errores = [];

        if (!in_array(pathinfo($archivo['name'], PATHINFO_EXTENSION), self::FORMATOS)) {
            $errores['formato'] = "Formato no permitido.";
        }

        if ($archivo['size'] > self::MAX_SIZE) {
            $errores['tamaño'] = "El archivo supera el tamaño máximo permitido.";
        }

        return $errores;
    }
}
?>
