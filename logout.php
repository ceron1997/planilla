<?php
session_start();
session_destroy(); // Destruir la sesión actual
header("Location: login_form.php"); // Redirigir a la página de inicio de sesión
?>
