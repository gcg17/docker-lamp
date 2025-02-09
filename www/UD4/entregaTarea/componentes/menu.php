<?php
#verificar si se ha iniciado sesión
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../sesiones/login.php");
    exit();
}
?>

<!-- menu.php -->
<nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
    <div class="position-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
            
            <?php
            #Comprobar si el usuario es admin
            if ($_SESSION['usuario']['rol'] == 'admin') {
            ?>
            <a class="nav-link" href="/UD4/entregaTarea/init.php">
                <button type="submit" class="btn btn-primary">Inicializar (mysqli)</button>
            </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/UD4/entregaTarea/index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/UD4/entregaTarea/usuarios/usuarios.php">Usuarios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/UD4/entregaTarea/usuarios/nuevoUsuarioForm.php">Nuevo Usuario</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/UD4/entregaTarea/tareas/listaTareas.php">Mis Tareas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/UD4/entregaTarea/tareas/nuevaForm.php">Nueva tarea</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/UD4/entregaTarea/tareas/buscaTareas.php">Buscador de tareas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/UD4/entregaTarea/sesiones/logout.php">Salir</a>
            </li>
            
            <?php 
            #Si no es admin se muestra lo siguiente
            } else { ?>
            
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/UD4/entregaTarea/index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/UD4/entregaTarea/tareas/listaTareas.php">Mis Tareas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/UD4/entregaTarea/tareas/nuevaForm.php">Nueva tarea</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/UD4/entregaTarea/sesiones/logout.php">Salir</a>
            </li>
            <?php } ?>
        </ul>
    </div>
</nav>