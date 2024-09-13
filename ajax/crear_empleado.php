<?php
require_once '../clases/Empleados.php';

$empleado = new Empleado();

$id_empleado = $_POST['id_empleado'] ?? null;
$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$salario = $_POST['salario'];
$fecha_ingreso = $_POST['fecha_ingreso'];
$id_departamento = $_POST['id_departamento'];
$id_municipio = $_POST['id_municipio'];

if ($id_empleado) {
    // Actualizar empleado
    $resultado = $empleado->actualizarEmpleado($id_empleado, $nombres, $apellidos, $salario, $fecha_ingreso, $id_departamento, $id_municipio);
} else {
    // Crear nuevo empleado
    $resultado = $empleado->guardarEmpleado($nombres, $apellidos, $salario, $fecha_ingreso, $id_departamento, $id_municipio);
}

if ($resultado) {
    echo json_encode(['success' => true, 'message' => 'Empleado guardado con éxito']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al guardar el empleado']);
}
?>
