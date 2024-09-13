<?php

include_once "../clases/Empleados.php";
$empleado = new Empleado();
$todosLosEmpleados = $empleado->obtenerTodosLosEmpleados();

$json = json_encode($todosLosEmpleados);
// Enviamos la cabecera para indicar que estamos enviando JSON
header('Content-Type: application/json');
// Imprimimos el JSON
echo $json;