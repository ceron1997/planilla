
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla con Suma Automática</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h3 class="text-center">Tabla con Suma Automática</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Num 1</th>
                    <th>Num 2</th>
                    <th>Resultado</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Aquí puedes generar las filas dinámicamente con PHP
                for ($i = 1; $i <= 3; $i++) {
                    $num2 = rand(1, 10); // Asignamos un valor aleatorio para Num 2
                    echo "
                    <tr>
                        <td><input type='number' class='form-control num1' value='0'></td>
                        <td><input type='number' class='form-control num2' value='$num2' readonly></td>
                        <td><input type='text' class='form-control resultado' value='0' readonly></td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        // Función que calcula la suma cuando se cambia el valor de Num 1
        $(document).ready(function() {
            $('.num1').on('input', function() {
                // Para cada fila de la tabla
                $(this).closest('tr').each(function() {
                    var num1 = parseFloat($(this).find('.num1').val()) || 0; // Valor de Num 1
                    var num2 = parseFloat($(this).find('.num2').val()) || 0; // Valor de Num 2
                    var resultado = num1 + num2; // Suma de Num 1 y Num 2

                    // Actualizamos el valor de la columna Resultado
                    $(this).find('.resultado').val(resultado);
                });
            });
        });
    </script>
</body>
</html>
