<?php
require_once '../clases/Empleados.php';

$empleado = new Empleado();

$id_empleado = $_POST['id_empleado'];
echo $empleado->eliminarEmpleado($id_empleado );

?>