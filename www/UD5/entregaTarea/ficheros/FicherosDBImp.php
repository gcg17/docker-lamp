<?php
require_once '../interfaces/FicherosDBInt.php';

class FicherosDBImp implements FicherosDBInt {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function listaFicheros($id_tarea): array {
        $stmt = $this->db->prepare("SELECT * FROM ficheros WHERE tarea_id = ?");
        $stmt->execute([$id_tarea]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Fichero');
    }

    public function buscaFichero($id): Fichero {
        $stmt = $this->db->prepare("SELECT * FROM ficheros WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchObject('Fichero');
    }

    public function borraFichero($id): bool {
        $stmt = $this->db->prepare("DELETE FROM ficheros WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function nuevoFichero(Fichero $fichero): bool {
        $stmt = $this->db->prepare("INSERT INTO ficheros (nombre, file, descripcion, tarea_id) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$fichero->getNombre(), $fichero->getFile(), $fichero->getDescripcion(), $fichero->getTarea()->getId()]);
    }
}
?>
