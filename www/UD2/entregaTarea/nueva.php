<!-- nueva.php -->
<?php
include 'utils.php';

$descripcion = $_POST['descripcion'] ?? '';
$estado = $_POST['estado'] ?? '';

if (guardarTarea($descripcion, $estado)) {
    echo "<p>Tarea guardada con éxito.</p>";
    echo '<p><a href="listaTareas.php"> Lista de tareas Actualizada </a> </p>';
} else {
    echo "<p>Error: Verifica los datos e intenta nuevamente.</p>";
}
?>
