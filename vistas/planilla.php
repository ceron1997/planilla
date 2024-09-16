<?php
session_start();
include 'llayouts/plantilla_header.php';

require_once "../clases/Empleados.php";
$empleadoObj = new Empleado();

require_once "../clases/Tramos_renta.php";
$rentaObj = new Tramos_renta();

require_once "../clases/DescuentosFijos.php";
$descuentosFijosObj = new DescuentosFijos();


// Obtener tasas de ISSS y AFP
$isssPorcentaje = $descuentosFijosObj->obtenerPorcentaje('ISSS')['porcentaje'];
$afpPorcentaje = $descuentosFijosObj->obtenerPorcentaje('AFP')['porcentaje'];

// Obtener tramos de renta (puedes ajustarlo según tu implementación)
$tramosRenta = $rentaObj->obtenerTramosRenta();

?>

<script>
// Pasar las tasas de ISSS y AFP, y los tramos de renta al frontend
let isssPorcentaje = <?= $isssPorcentaje; ?>;
let afpPorcentaje = <?= $afpPorcentaje; ?>;
let tramosRenta = <?= json_encode($tramosRenta); ?>;
</script>

<div class="container">
    <h3>Generación de Planilla Quincenal</h3>

    <?php


    function calcularSalarioRecibir($isss, $afp, $renta, $salario)
    {

        $descuentos = $isss + $afp + $renta;  // Suma de los descuentos
        return $salario - $descuentos;  // Retorna el salario neto
    }




    $empleados = $empleadoObj->obtenerTodosLosEmpleados("estado = 1");


    // Generar tabla de planilla
    echo "<div class='table-wrapper' style='max-height: 500px; overflow-y: auto; overflow-x: auto;'>";

    echo "<table class='table' style='min-width: 1250px;'>";

    echo "<thead class='table-header' style='position: sticky; top: 0; background-color: white; z-index: 1;'>
            <tr>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Dias trabajados</th>
                <th>Salario Bruto</th>
                <th>ISSS</th>
                <th>AFP</th>
                <th>Renta</th>
                <th>Descuento</th>
                <th>Comentario</th>
                <th>Salario a Recibir</th>
            </tr>
          </thead>";
    echo "<tbody>";
    $diasTrabajados = 15;
    foreach ($empleados as $empleado) {
        $salario = ($empleado['salario'] / 30) * $diasTrabajados;
        $isss = $descuentosFijosObj->calcularISSS($salario);
        $afp = $descuentosFijosObj->calcularAFP($salario);
        $renta = $rentaObj->calcularRenta($salario);
        $salarioRecibir = calcularSalarioRecibir($isss, $afp, $renta, $salario);

        echo "<tr data-salario-base='{$empleado['salario']}'>
            <td>{$empleado['nombres']}</td>
            <td>{$empleado['apellidos']}</td>
            <td><input type='number' class='form-control diaTrabajados' value='15'></td>
            <td><input type='text' class='form-control salario' value=\$" . number_format($salario, 2) . " disabled></td>
            <td><input type='text' class='form-control isss' value=\$" . number_format($isss, 2) . " disabled></td>
            <td><input type='text' class='form-control afp' value=\$" . number_format($afp, 2) . " disabled></td>
            <td><input type='text' class='form-control renta' value=\$" . number_format($renta, 2) . " disabled></td>
            <td><input type='number' class='form-control descuento'  ></td>
            <td><input type='text' class='form-control comentario' ></td>
            <td><input type='text' class='form-control salarioRecibir' value=\$" . number_format($salarioRecibir, 2) . " disabled></td>
          </tr>";
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";

    ?>

</div>

<?php include 'llayouts/plantilla_footer.php'; ?>


<script>
    // Función que calcula la suma cuando se cambia el valor de Num 1
    $(document).ready(function() {
        // Manejador para 'input' en el campo de descuento y diasTrabajados
        $('.diaTrabajados, .descuento').on('input', function() {
            // Para cada fila de la tabla
            $(this).closest('tr').each(function() {
                let diasTrabajados = parseFloat($(this).find('.diaTrabajados').val()) || 0;
                let descuento = parseFloat($(this).find('.descuento').val()) || 0;

                // Validación max 15 dias
                if (diasTrabajados > 15) {          
                    $(this).find('.diaTrabajados').val(15);
                    diasTrabajados = 15;
                }

                let salarioBase = parseFloat($(this).data('salario-base')) || 0;
                let salario = (salarioBase / 30) * diasTrabajados;

                // Calcular deducciones usando los porcentajes dinámicos
                let isss = salario * isssPorcentaje;
                let afp = salario * afpPorcentaje;

                // Calcular Renta basado en los tramos dinámicos
                let renta = 0;
                for (let i = 0; i < tramosRenta.length; i++) {
                    let tramo = tramosRenta[i];
                    if (salario > tramo.tramo_desde && salario <= tramo.tramo_hasta) {
                        renta = ((salario - tramo.tramo_desde) * (tramo.porcentaje_exceso / 100)) + tramo.cuota_fija;
                        break;
                    }
                }

                // Calcular salario a recibir, incluyendo el descuento
                let salarioRecibir = salario - (isss + afp + renta + descuento);

                // Actualizar los valores en las columnas respectivas
                $(this).find('.salario').val('$' + salario.toFixed(2));
                $(this).find('.isss').val('$' + isss.toFixed(2));
                $(this).find('.afp').val('$' + afp.toFixed(2));
                $(this).find('.renta').val('$' + renta.toFixed(2));
                $(this).find('.salarioRecibir').val('$' + salarioRecibir.toFixed(2));
            });
        });

    });
</script>