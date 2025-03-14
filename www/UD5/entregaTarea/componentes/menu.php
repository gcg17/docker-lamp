<?php
#verificar si se ha iniciado sesión
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usuario'])) {
    header("Location: ../sesiones/login.php");
    exit();
}

#verificar si hay un tema guardado en las cookies sino se establece el tema por defecto
$tema = $_COOKIE['tema'] ?? 'light';
?>

<!-- menu.php -->
<?php
#setear el tema en el nav
if ($tema == 'dark') {
    echo '<nav class="col-md-3 col-lg-2 d-md-block sidebar">';
}else{
    echo '<nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">';
}?>
    <div class="position-sticky">        
            <?php
            #Comprobar si el usuario es admin
            if ($_SESSION['usuario']['rol'] == '1') {
            ?>
        <ul class="nav flex-column">
            <li class="nav-item">
            <a class="nav-link" href="/UD5/entregaTarea/init.php">
                <button type="submit" class="btn btn-primary">Inicializar (mysqli)</button>
            </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/UD5/entregaTarea/index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/UD5/entregaTarea/usuarios/usuarios.php">Usuarios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/UD5/entregaTarea/usuarios/nuevoUsuarioForm.php">Nuevo Usuario</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/UD5/entregaTarea/tareas/listaTareas.php">Mis Tareas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/UD5/entregaTarea/tareas/nuevaForm.php">Nueva tarea</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/UD5/entregaTarea/tareas/buscaTareas.php">Buscador de tareas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/UD5/entregaTarea/sesiones/logout.php">Salir</a>
            </li>
        </ul>
        <div>
            <form action="/UD5/entregaTarea/cookies/tema.php" method="POST" class="m-3 w-50">
            <select id="tema" name="tema" class="form-select mb-2" aria-label="Selector de tema">
                <option value="light">Claro</option>
                <option value="dark">Oscuro</option>
                <option value="auto" selected>Automático</option>
            </select>
            <button type="submit" class="btn btn-primary w-100">Aplicar</button>
            </form>
        </div>   
            <?php 
            #Si no es admin se muestra lo siguiente
            } else { ?>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="/UD5/entregaTarea/index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/UD5/entregaTarea/tareas/listaTareas.php">Mis Tareas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/UD5/entregaTarea/tareas/nuevaForm.php">Nueva tarea</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/UD5/entregaTarea/sesiones/logout.php">Salir</a>
            </li>
        </ul>
        <div>
        <form action="cookies/tema.php" method="POST" class="m-3 w-50">
            <select id="tema" name="tema" class="form-select mb-2" aria-label="Selector de tema">
                <option value="light">Claro</option>
                <option value="dark">Oscuro</option>
                <option value="auto" selected>Automático</option>
            </select>
            <button type="submit" class="btn btn-primary w-100">Aplicar</button>
        </form>
        </div>
        <?php } ?>
    </div>
</nav>