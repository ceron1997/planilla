<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}

require_once "../clases/Departamentos.php";
require_once "../clases/Municipios.php";
require_once "../clases/Empleados.php";


$departamentosObj = new Departamento();
$municipiosObj = new Municipio();
$empleadoObj = new Empleado();

$departamentos = $departamentosObj->obtenerTodosLosDepartamentos();
$municipios = $municipiosObj->getAll();

if ($_GET['action'] == 'new') {
    $titulo = "Nuevo Empleado";
    $action = "#"; // No se necesita acción de formulario por defecto
    $id_empleado = $nombres = $apellidos = $salario = $fecha_ingreso = "";
    $id_departamento = $id_municipio = "";
} elseif ($_GET['action'] == 'edit') {
    $titulo = "Editar Empleado";
    $action = "#"; // No se necesita acción de formulario por defecto

    // Obtén la información del empleado usando la ID pasada en la URL
    $empleadoId = $_GET['id_empleado'];

    $empleado = $empleadoObj->obtenerTodosLosEmpleados('id_empleado = ' . $empleadoId); // Añadir este método en la clase Empleado
    // var_dump($empleado);
    $id_empleado = $empleado[0]['id_empleado'];
    $nombres = $empleado[0]['nombres'];
    $apellidos = $empleado[0]['apellidos'];
    $salario = $empleado[0]['salario'];
    $fecha_ingreso = $empleado[0]['fecha_ingreso'];
    $id_departamento = $empleado[0]['id_departamento'];
    $id_municipio = $empleado[0]['id_municipio'];
} else {
    $titulo = "Nuevo Empleado";
}
?>
<?php include 'llayouts/plantilla_header.php'; ?>

<div class="container " style="margin-bottom: 80px;">
    <div class="d-flex justify-content-end">
        <a href="empleados.php" class="btn btn-secondary mt-2">Regresar</a>
    </div>
    <h3><?php echo $titulo; ?></h3>
    <!-- Crear un formulario que sirva para crear y editar empleados -->
    <form id="form-empleado">
        <div class="form-group">
            <label for="nombres">Nombres</label>
            <input type="text" class="form-control" id="nombres" name="nombres" value="<?php echo $nombres; ?>" required>
        </div>

        <div class="form-group">
            <label for="apellidos">Apellidos</label>
            <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo $apellidos; ?>" required>
        </div>

        <div class="form-group">
            <label for="salario">Salario</label>
            <input type="number" step="0.01" class="form-control" id="salario" name="salario" value="<?php echo $salario; ?>" required>
        </div>

        <div class="form-group">
            <label for="fecha_ingreso">Fecha de Ingreso</label>
            <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" value="<?php echo $fecha_ingreso; ?>" required>
        </div>

        <div class="form-group">
            <label for="departamento">Departamento:</label>
            <select class="form-control" id="departamento" name="id_departamento" required>
                <option value="">Seleccione un departamento</option>
                <?php foreach ($departamentos as $dep) : ?>
                    <option value="<?php echo $dep['id_departamento']; ?>" <?php echo ($dep['id_departamento'] == $id_departamento) ? 'selected' : ''; ?>>
                        <?php echo $dep['nombre_departamento']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="municipio">Municipio:</label>
            <select class="form-control" id="municipio" name="id_municipio" required>
                <option value="">Seleccione un municipio</option>
                <?php foreach ($municipios as $m) : ?>
                    <option value="<?php echo $m['id_municipio']; ?>" <?php echo ($m['id_municipio'] == $id_municipio) ? 'selected' : ''; ?>>
                        <?php echo $m['nombre_municipio']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <input type="hidden" id="id_empleado" name="id_empleado" value="<?php echo $id_empleado; ?>">

        <button type="submit" class="btn btn-primary mt-2">
            <?php echo ($_GET['action'] == 'edit') ? 'Actualizar' : 'Crear'; ?>
        </button>
    </form>
</div>

<?php include 'llayouts/plantilla_footer.php'; ?>
<script src="../js/empleados.js?<?php echo time(); ?>"></script>
<script>
    $(document).ready(function() {

        $('#departamento').select2();
        $('#municipio').select2();
    });
</script>