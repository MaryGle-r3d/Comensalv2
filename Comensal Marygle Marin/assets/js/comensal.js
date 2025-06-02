let tabla;
let modalComensal;

$(document).ready(function () {
    tabla = $('#tablaComensales').DataTable({
        ajax: {
            url: 'controlador/comensal.php?action=listar',
            dataSrc: ''
        },
        columns: [
            { data: 'cedula' },
            { data: 'nombre' },
            { data: 'apellido' },
            { data: 'tipo' },
            { data: 'direccion' },
            { data: 'telefono' },
            { data: 'departamento' },
            {
                data: null,
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-sm btn-primary far fa-edit w-100 small-width mt-2" onclick="editar('${row.cedula}')">Editar</button>
                        <button class="btn btn-sm btn-danger fas fa-trash w-100 small-width mt-2" onclick="eliminar('${row.cedula}')">Eliminar</button>
                    `;
                }
            } 
        ],
        lengthMenu: [5, 10, 15, 20],
        language: {
            lengthMenu: "Mostrar _MENU_ registros por página",
            zeroRecords: "No se encontraron resultados",
            info: "Mostrando página _PAGE_ de _PAGES_",
            infoEmpty: "No hay registros disponibles",
            infoFiltered: "(filtrado de _MAX_ registros totales)",
            search: "Buscar:",
            paginate: {
                first: "Primero",
                last: "Último",
                next: "Siguiente",
                previous: "Anterior"
            }
        }
    });

    modalComensal = new bootstrap.Modal(document.getElementById('modalComensal'));

    $('#formComensal').submit(function(e) {
        e.preventDefault();

        // Limpiar errores previos
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();

        // Obtener datos
        const cedula = $('#cedula').val().trim();
        const nombre = $('#nombre').val().trim();
        const apellido = $('#apellido').val().trim();
        const tipo = $('#tipo').val().trim();
        const direccion = $('#direccion').val().trim();
        const telefono = $('#telefono').val().trim();
        const departamento = $('#departamento').val().trim();

        let valido = true;

        // Validaciones campo por campo
        if (!cedula || !/^\d+$/.test(cedula)) {
            mostrarError('#cedula', 'La cédula es obligatoria y debe ser numérica.');
            valido = false;
        }
        if (!nombre) {
            mostrarError('#nombre', 'El nombre es obligatorio.');
            valido = false;
        }
        if (!apellido) {
            mostrarError('#apellido', 'El apellido es obligatorio.');
            valido = false;
        }
        if (!tipo) {
            mostrarError('#tipo', 'El tipo es obligatorio.');
            valido = false;
        }
        if (!direccion) {
            mostrarError('#direccion', 'La dirección es obligatoria.');
            valido = false;
        }
        if (!telefono || !/^\d{6,15}$/.test(telefono)) {
            mostrarError('#telefono', 'El teléfono debe ser numérico y tener entre 6 y 15 dígitos.');
            valido = false;
        }
        if (!departamento) {
            mostrarError('#departamento', 'El departamento es obligatorio.');
            valido = false;
        }

        if (!valido) return;

        // Enviar al servidor
        let formData = $(this).serialize();

        $.post('controlador/comensal.php?action=guardar', formData, function(response) {
            if (response.success) {
                modalComensal.hide();
                tabla.ajax.reload(null, false);
            } else {
                alert('Error al guardar: ' + (response.error || ''));
            }
        }, 'json');
    });
});

function mostrarError(selector, mensaje) {
    const input = $(selector);
    input.addClass('is-invalid');
    input.after(`<div class="invalid-feedback">${mensaje}</div>`);
}

function abrirModal() {
    $('#formComensal')[0].reset();
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove();
    $('#cedula').prop('readonly', false);
    modalComensal.show();
}

function editar(cedula) {
    $.getJSON('controlador/comensal.php?action=obtener&cedula=' + cedula, function(data) {
        if ($.isEmptyObject(data)) {
            alert('Comensal no encontrado');
        } else {
            $('#cedula').val(data.cedula).prop('readonly', true);
            $('#nombre').val(data.nombre);
            $('#apellido').val(data.apellido);
            $('#tipo').val(data.tipo);
            $('#direccion').val(data.direccion);
            $('#telefono').val(data.telefono);
            $('#departamento').val(data.departamento);
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();
            modalComensal.show();
        }
    });
}

function eliminar(cedula) {
    if (confirm('¿Seguro que deseas eliminar este comensal?')) {
        $.post('controlador/comensal.php?action=eliminar', {cedula: cedula}, function(response) {
            if (response.success) {
                tabla.ajax.reload(null, false);
            } else {
                alert('Error al eliminar: ' + (response.error || ''));
            }
        }, 'json');
    }
}

