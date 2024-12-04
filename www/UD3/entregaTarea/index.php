<!-- index.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UD3. Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <?php include 'header.php'; ?>
        <div class="row">
            <?php include 'menu.php'; ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h2>Bienvenidos</h2>
            </div>
            <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                <p>¡Hola! <br> Mi nombre es <em> Gonzalo Cohen García </em>
                 tengo 28 años y este es mi segundo año en el ciclo de <b> DAW </b> (Desarrollo de Aplicaciones Web), actualmente estoy trabajando
                 y es mi primer año aprendiendo PHP en la asignatura <b> DWCS.</b> Antes había tocado algo de HTML, CSS, SQL y Java en las asignaturas de primer año.</p>
            </div>
            </main>
        </div>
        <?php include 'footer.php'; ?>
    </div>
</body>
</html>