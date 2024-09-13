<?php include 'llayouts/plantilla_header.php';

require_once "../clases/Empleados.php";
$empleadoObj = new Empleado();



?>

<div class="container">
    <h3>Generación de Planilla Quincenal</h3>

    <?php
    // Funciones para los descuentos de ley
    function calcularISSS($salario)
    {
        return $salario * 0.03; // 3%
    }

    function calcularAFP($salario)
    {
        return $salario * 0.0725; // 7.25%
    }

    function calcularRenta($salario)
    {

        if ($salario >= 0.01 && $salario <= 236.00) {
            // 1 TRAMO: No hay retención
            return 0;
        } elseif ($salario > 236.00 && $salario <= 447.62) {
            // II TRAMO: 10% sobre el exceso de $236.00 + una cuota fija de $8.83
            return (($salario - 236.00) * 0.10) + 8.83;
        } elseif ($salario > 447.62 && $salario <= 1019.05) {
            // III TRAMO: 20% sobre el exceso de $447.62 + una cuota fija de $30.00
            return (($salario - 447.62) * 0.20) + 30.00;
        } elseif ($salario > 1019.05) {
            // IV TRAMO: 30% sobre el exceso de $1019.05 + una cuota fija de $144.28
            return (($salario - 1019.05) * 0.30) + 144.28;
        }
        return 0;
    }

    function calcularSalarioRecibir($salario)
    {
        $isss = calcularISSS($salario);
        $afp = calcularAFP($salario);
        $renta = calcularRenta($salario);
        $descuentos = $isss + $afp + $renta;
        return $salario - $descuentos;
    }


    $empleados = $empleadoObj->obtenerTodosLosEmpleados("estado = 1");


    // Generar tabla de planilla
    echo "  <div class='table-wrapper' style='max-height: 500px; overflow-y: auto;'>";
    echo "<table class='table'>";
    echo "<thead class='table-header' style='position: sticky; top: 0; background-color: white; z-index: 1;'>
            <tr>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Dias trabajados</th>
                <th>Salario Bruto</th>
                <th>ISSS</th>
                <th>AFP</th>
                <th>Renta</th>
                <th>Salario a Recibir</th>
            </tr>
          </thead>";
    echo "<tbody>";
    $diasTrabajados = 15;
    foreach ($empleados as $empleado) {
        $salario = ($empleado['salario'] / 30) * $diasTrabajados;
        $isss = calcularISSS($salario);
        $afp = calcularAFP($salario);
        $renta = calcularRenta($salario);
        $salarioRecibir = calcularSalarioRecibir($salario);

        echo "<tr data-salario-base='{$empleado['salario']}'>
            <td>{$empleado['nombres']}</td>
            <td>{$empleado['apellidos']}</td>
            <td><input type='number' class='form-control diaTrabajados' value='15'></td>
            <td><input type='text' class='form-control salario' value=\$" . number_format($salario, 2) . " disabled></td>
            <td><input type='text' class='form-control isss' value=\$" . number_format($isss, 2) . " disabled></td>
            <td><input type='text' class='form-control afp' value=\$" . number_format($afp, 2) . " disabled></td>
            <td><input type='text' class='form-control renta' value=\$" . number_format($renta, 2) . " disabled></td>
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
        $('.diaTrabajados').on('input', function() {
            // Para cada fila de la tabla
            $(this).closest('tr').each(function() {
                let diasTrabajados = parseFloat($(this).find('.diaTrabajados').val()) || 0;

                // Validación max 15 dias
                if (diasTrabajados > 15) {
                    $(this).find('.diaTrabajados').val(15);
                    diasTrabajados = 15;
                }
                let salarioBase = parseFloat($(this).data('salario-base')) || 0;
                let salario = (salarioBase / 30) * diasTrabajados;

                // Calcular deducciones
                let isss = salario * 0.03; // ISSS: 3%
                let afp = salario * 0.0725; // AFP: 7.25%

                // Calcular Renta
                let renta = 0;
                if (salario > 236.00 && salario <= 447.62) {
                    renta = ((salario - 236.00) * 0.10) + 8.83;
                } else if (salario > 447.62 && salario <= 1019.05) {
                    renta = ((salario - 447.62) * 0.20) + 30.00;
                } else if (salario > 1019.05) {
                    renta = ((salario - 1019.05) * 0.30) + 144.28;
                }
                let salarioRecibir = salario - (isss + afp + renta);

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