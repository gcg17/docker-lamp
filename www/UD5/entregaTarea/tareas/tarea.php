<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../sesiones/login.php");
    exit();
}

#Obtener ID de la tarea
require_once("../conexiones/mysqli.php");
$idTarea = isset($_GET['id']) ? $_GET['id'] : null;

if (!$idTarea) {
    header("Location: listaTareas.php");
    exit();
}

#Obtener detalles de la tarea
$conexion = getMysqliConnection();
$sql = "SELECT t.*, u.nombre as nombre_usuario 
        FROM tareas t 
        JOIN usuarios u ON t.id_usuario = u.id 
        WHERE t.id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $idTarea);
$stmt->execute();
$resultado = $stmt->get_result();
$tarea = $resultado->fetch_assoc();

#verificar si hay un tema guardado en las cookies sino se establece el tema por defecto
$tema = $_COOKIE['tema'] ?? 'light';
?>

<!--tarea.php -->
<!DOCTYPE html>
<?php
#setear el tema en el head
if ($tema == 'dark') {
    echo '<html lang="es" data-bs-theme="dark">';
}else{
    echo '<html lang="es">';
}?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <?php include ('../componentes/header.php'); ?>
        <div class="row">
            <?php include ('../componentes/menu.php'); ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2>Detalles de la Tarea</h2>
            </div>
            <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
            <div class="table">
            <table class="table table-striped table-hover">
                    <thead class="thead">
                        <tr>
                            <th>Título</th>
                            <td><?php echo htmlspecialchars($tarea['titulo']); ?></td>
                        </tr>
                    </thead>
                    <thead class="thead">
                        <tr>
                            <th>Descripción</th>
                            <td><?php echo htmlspecialchars($tarea['descripcion']); ?></td>
                        </tr>
                    </thead>
                    <thead class="thead">
                        <tr>
                            <th>Estado</th>
                            <td><?php echo htmlspecialchars($tarea['estado']); ?></td>
                        </tr>
                    </thead>
                    <thead class="thead">
                        <tr>
                            <th>Usuario</th>
                            <td><?php echo htmlspecialchars($tarea['nombre_usuario']); ?></td>
                        </tr>
                    </thead>
            </table>
        </div>

        <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottomon">
            <h3>Archivos Adjuntos</h3>
            
        <?php include('../ficheros/subidaFichForm.php'); ?>

            <!-- Lista de archivos -->
            <div class="archivos-lista">
                <?php require_once('../ficheros/subidaFichProc.php');
                $archivos = getArchivos($idTarea);
                while ($archivo = $archivos->fetch_assoc()):?>
                    <div class="d-flex align-items-center gap-3">
                    <?php if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $archivo['file'])): ?>
                        <img src="<?php echo htmlspecialchars($archivo['file']); ?>" class="rounded border" style="width: 20%; height: 150px; object-fit: cover;">
                    </div>
                    <div class="archivo-acciones d-flex gap-2">
                    <?php elseif (preg_match('/\.pdf$/i', $archivo['file'])): ?>
                        <iframe src="<?php echo htmlspecialchars($archivo['file']); ?>" width="20%" height="150" class="border rounded"></iframe>
                    </div>
                        <?php else: ?>
                    <span class="fw-bold text-muted">📄 <?php echo htmlspecialchars($archivo['nombre']); ?></span>
                    <?php endif; ?>
                    <div class="archivo-acciones d-flex gap-2">  
                        <a href="<?php echo htmlspecialchars($archivo['file']); ?>" download class="btn btn-primary btn-sm">Descargar</a>
                        <form action="../ficheros/borrarArchivo.php" method="POST" style="display: inline;">
                            <input type="hidden" name="id_archivo" value="<?php echo $archivo['id']; ?>">
                            <input type="hidden" name="id_tarea" value="<?php echo $idTarea; ?>">
                            <button type="submit" name="eliminar_archivo" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
        <a href="listaTareas.php" class="btn btn-primary">Volver a la lista</a>
      </main>
    </div>
    <?php include_once ('../componentes/footer.php'); ?>
</body>
</html>
