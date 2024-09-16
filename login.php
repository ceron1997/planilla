<?php
session_start(); // Iniciar la sesión

// Incluir la clase Database
require_once 'clases/Database.php';
require_once 'clases/Usuario.php';

// $password = "123";
// $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
// echo $hashedPassword;


$usuario = new Usuario();

if (!$_SERVER["REQUEST_METHOD"] == "POST") {

    echo 'REQUEST_METHOD no es valdio';
    exit();
}
$nombre_usuario = $_POST['nombre_usuario'];
$password = $_POST['password'];


// Verificar credenciales
$user = $usuario->getUsuarioPorNombre($nombre_usuario);
// var_dump($user);
if ($user && password_verify($password, $user['password'])) {
    // Contraseña correcta
    $_SESSION['usuario'] = $user['nombre'];
    $_SESSION['rol'] = $user['rol'];

    echo "Bienvenido, " . $_SESSION['usuario'];
    // Redirigir al dashboard 
    header("Location: vistas/dashboard.php");
} else {
    // Contraseña incorrecta o usuario no encontrado

    echo "Usuario o contraseña incorrectos.";
    // sleep(2);
    // header("Location: index.php");
}
