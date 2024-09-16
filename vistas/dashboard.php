<?php
session_start();
// echo $_SESSION['usuario'];
// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}


?>
    <?php include 'llayouts/plantilla_header.php'; ?>
    <div class="container">
        Hola Bienvenido
    </div>
    <?php include 'llayouts/plantilla_footer.php'; ?>
