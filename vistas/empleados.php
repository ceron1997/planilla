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
    <h3>Administración de Empleados</h3>
    <div class="d-flex justify-content-end">
        <a href="editar_crear_empleado.php?action=new" class="btn btn-success">Agregar Empleado</a>
    </div>
   
    <div class="table-wrapper" style="max-height: 400px; overflow-y: auto;">
        <table id="tabla-empleados" class="table table-striped">
            <thead class="table-header" style="position: sticky; top: 0; background-color: white; z-index: 1;">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th style="width: 20%" class="text-center">Acción</th>
                </tr>
            </thead>
            <tbody>
                <!-- generado por ajax -->
            </tbody>
        </table>
    </div>
</div>


<?php include 'llayouts/plantilla_footer.php'; ?>

<script src="../js/empleados.js?<?php echo time(); ?>"></script>
<script>
    $(document).ready(function() {

        cargarempleados();


    });
</script>