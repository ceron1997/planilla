


function cargarempleados() {
    $.ajax({
        url: '../ajax/obtener_empleados.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            // Limpiar la tabla (si existe)
            $('#tabla-empleados tbody').empty();

            // Construir la tabla con los datos
            $.each(data, function (index, empleado) {
                $('#tabla-empleados tbody').append(`
                        <tr>
                            <td>${empleado.id_empleado}</td>
                            <td>${empleado.nombres}</td>
                            <td>${empleado.apellidos}</td>
                            <td class='text-center'>
                                <button class="btn btn-primary btn-editar"  onclick ='editarEmpleado(${empleado.id_empleado});' 
                                data-id="${empleado.id_empleado}">Editar</button>
                                <button class="btn btn-danger btn-eliminar" onclick ='eliminarEmpleado(${empleado.id_empleado});' 
                                data-id="${empleado.id_empleado}">Eliminar</button>
                            </td>
                        </tr>
                    `);
            });
        }
    });
}

function editarEmpleado(id_empleado) {

    let params = {
        action: 'edit',
        id_empleado: id_empleado
    };

    let url = '../vistas/editar_crear_empleado.php?' + $.param(params);
    window.location.href = url;
}

function eliminarEmpleado(id_empleado) {
    // Mostrar el diálogo de confirmación de SweetAlert
    Swal.fire({
        title: '¿Estás seguro?',
        text: "No podrás revertir esta acción",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: '../ajax/eliminar_empleado.php',
                type: 'POST',
                data: { id_empleado },
                success: function (response) {
                    if (response == '1') {
                        Swal.fire(
                            'Eliminado!',
                            'El empleado ha sido eliminado.',
                            'success'
                        );
                    } else {
                        Swal.fire(
                            'Fallo!',
                            'Ups, algo salio mal',
                            'warning'
                        );
                    }

                    cargarempleados();
                },
                error: function () {

                }
            });
        }
    });
}

$('#form-empleado').submit(function (event) {

    event.preventDefault(); // Evitar el envío normal del formulario

    let id_empleado = $('#id_empleado').val();

    let formData = {
        nombres: $('#nombres').val(),
        apellidos: $('#apellidos').val(),
        salario: $('#salario').val(),
        fecha_ingreso: $('#fecha_ingreso').val(),
        id_departamento: $('#departamento').val(),
        id_municipio: $('#municipio').val(),
    };

    if (id_empleado != '') {

        formData = {
            nombres: $('#nombres').val(),
            apellidos: $('#apellidos').val(),
            salario: $('#salario').val(),
            fecha_ingreso: $('#fecha_ingreso').val(),
            id_departamento: $('#departamento').val(),
            id_municipio: $('#municipio').val(),
            id_empleado
        };
    }





    $.ajax({
        url: '../ajax/crear_empleado.php',
        type: 'POST',
        data: formData,
        success: function (response) {
            // Manejar la respuesta del servidor
            // alert('Empleado guardado con éxito');
            if (id_empleado != '') {
                Swal.fire({
                    title: '¡Éxito!',
                    text: 'Registro Actualizado con éxito',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                });
            } else {
                Swal.fire({
                    title: '¡Éxito!',
                    text: 'Empleado guardado con éxito',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                });
                $('#form-empleado')[0].reset(); // Limpiar el formulario

                $('#departamento').val(null).trigger('change');
                $('#municipio').val(null).trigger('change');
            }




        },
        error: function (xhr, status, error) {
            console.error('Error al guardar el empleado:', error);
        }
    });
});