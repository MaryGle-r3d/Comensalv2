<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comensal</title>
    <?php include 'assets/components/head.php'; ?>
    <link rel="stylesheet" href="assets/css/style.css">  
    <!-- Asegúrate que head.php carga CSS de DataTables y Bootstrap -->

</head>
<body>

    <h1>Gestión de Comensales</h1>
    <button id="btnToggleSidebar">☰</button>
    <?php include 'assets/components/sidebar.php'; ?>

<section>
    <div id="content">
        <center><h1>Listado de Comensales</h1></center>
        <div class="d-flex justify-content-end mb-3"> 
            <button class="btn btn-primary" onclick="abrirModal()">Agregar Comensal</button>
        </div>
        <table id="tablaComensales" class="display table table-bordered" style="width:100%">
            <thead>
              <tr>
                <th>Cédula</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Tipo</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Departamento</th>
                <th>Acciones</th>
              </tr>
            </thead>
        </table>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="modalComensal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Agregar / Editar Comensal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form id="formComensal">
          <div class="row mb-3">
            <div class="col">
              <label for="cedula" class="form-label">Cédula</label>
              <input type="text" class="form-control" id="cedula" name="cedula" required>
            </div>
            <div class="col">
              <label for="nombre" class="form-label">Nombre</label>
              <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col">
              <label for="apellido" class="form-label">Apellido</label>
              <input type="text" class="form-control" id="apellido" name="apellido" required>
            </div>
            <div class="col">
              <label for="tipo" class="form-label">Tipo</label>
              <select class="form-select" id="tipo" name="tipo" required>
                <option value="">Seleccione</option>
                <option value="Estudiante">Estudiante</option>
                <option value="Docente">Docente</option>
                <option value="Administrativo">Administrativo</option>
                <option value="Obrero">Obrero</option>
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col">
              <label for="direccion" class="form-label">Dirección</label>
              <input type="text" class="form-control" id="direccion" name="direccion" required>
            </div>
            <div class="col">
              <label for="telefono" class="form-label">Teléfono</label>
              <input type="text" class="form-control" id="telefono" name="telefono" required>
            </div>
          </div>
          <div class="row mb-6">
            <div class="col">
              <label for="departamento" class="form-label">Departamento</label>
              <input type="text" class="form-control" id="departamento" name="departamento" required>
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
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
            pageLength: 5,
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

    function abrirModal() {
        $('#formComensal')[0].reset();
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

    $('#btnToggleSidebar').on('click', function () {
        $('#sidebar').toggleClass('collapsed');
        $('#content').toggleClass('expanded');
    });
</script>
</body>
</html>

