<?php
require_once __DIR__.'/FicherosDBInt.php';
require_once __DIR__. '/mysqli.php';
require_once __DIR__. '/pdo.php';
require_once __DIR__. '/tarea.php';
require_once __DIR__. '/usuario.php';
require_once __DIR__. '/fichero.php';

class FicherosDBImp implements FicherosDBInt {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function listaFicheros($id_tarea): array {
        $stmt = $this->db->prepare("SELECT * FROM ficheros WHERE tarea_id = ?");
        $stmt->execute([$id_tarea]);
        
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $ficheros = array();

        while ($row = $stmt->fetch()) {
            $fichero = new Fichero
            ($row['id'], $row['nombre'], $row['file'], $row['descripcion']);

            #Obtener tarea asociada
            $tarea = Tarea::seleccionarPorIdTarea($row['tarea_id']);
            $fichero->setTarea($tarea);

            array_push($ficheros, $fichero);

        }
        return $ficheros;
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
