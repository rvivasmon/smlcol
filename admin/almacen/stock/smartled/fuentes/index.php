<?php 

include('../../../../../app/config/config.php');
include('../../../../../app/config/conexion.php');

include('../../../../../layout/admin/sesion.php');
include('../../../../../layout/admin/datos_sesion_user.php');

include('../../../../../layout/admin/parte1.php');

?>


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                <h1 class="m-0">Stock Principal de Fuentes</h1>                
                    <div class="card card-blue">
                        <div class="card-header">
                            FUENTES ACTIVAS
                        </div>

                        <hr>

                        <div class="card-tools ml-4">
                            <a href="../index.php" class="btn btn-warning"><i class="bi bi-plus-square"></i>Regresar</a>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table_stcs" class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Marca Fuente</th>
                                            <th>Tipo Fuente</th>
                                            <th>Voltaje Salida</th>
                                            <th>Modelo Fuente</th>
                                            <th>Posición</th>
                                            <th>Observación</th>
                                            <th>Existencia</th>
                                            <th>Sub Almacén</th>
                                            <th><center>Acciones</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 0;
                                        $query = $pdo->prepare('SELECT 
                                            ap.*,
                                            cf.marca_fuente as nombre_marca,
                                            cf1.tipo_fuente as nombre_tipo,
                                            rf.voltaje_salida as nombre_voltaje,
                                            rf.modelo_fuente as nombre_modelo,
                                            sa.sub_almacen as nombre_sub_almacen,
                                            da.posiciones as nombre_posicion
                                        FROM
                                            alma_smartled AS ap
                                        INNER JOIN 
                                            referencias_fuente AS rf ON ap.producto = rf.id_referencias_fuentes
                                        LEFT JOIN
                                            caracteristicas_fuentes AS cf ON rf.marca_fuente = cf.id_car_fuen
                                        LEFT JOIN
                                            caracteristicas_fuentes AS cf1 ON rf.tipo_fuente = cf1.id_car_fuen
                                        LEFT JOIN
                                            distribucion_almacen AS da ON ap.posicion = da.id
                                        LEFT JOIN
                                            t_sub_almacen AS sa ON ap.sub_almacen = sa.id
                                        WHERE
                                            ap.tipo_producto = 3
                                        ');

                                        $query->execute();
                                        $almacenes_pricipales = $query->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($almacenes_pricipales as $almacen_pricipal){
                                            $id = $almacen_pricipal['id_almacen_principal'];
                                            $marca_fuente = $almacen_pricipal['nombre_marca'];
                                            $tipo_fuente = $almacen_pricipal['nombre_tipo'];
                                            $voltaje_salida = $almacen_pricipal['nombre_voltaje'];
                                            $modelo_fuente = $almacen_pricipal['nombre_modelo'];
                                            $posicion = $almacen_pricipal['nombre_posicion'];
                                            $observacion = $almacen_pricipal['observacion'];
                                            $existencia = $almacen_pricipal['cantidad_plena'];
                                            $sub_almacen = $almacen_pricipal['nombre_sub_almacen'];
                                            $contador = $contador + 1;

                                        ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($contador); ?></td>
                                                <td><?php echo htmlspecialchars($marca_fuente); ?></td>
                                                <td><?php echo htmlspecialchars($tipo_fuente); ?></td>
                                                <td><?php echo htmlspecialchars($voltaje_salida); ?></td>
                                                <td><?php echo htmlspecialchars($modelo_fuente); ?></td>
                                                <td><?php echo htmlspecialchars($posicion); ?></td>
                                                <td><?php echo htmlspecialchars($observacion); ?></td>
                                                <td><?php echo htmlspecialchars($existencia); ?></td>
                                                <td><?php echo htmlspecialchars($sub_almacen); ?></td>
                                                <td>
                                                    <center>
                                                        <a href="show.php?id=<?php echo $id; ?>" class="btn btn-info btn-sm">Mostrar <i class="fas fa-eye"></i></a>
                                                        <a href="edit.php?id=<?php echo $id; ?>" class="btn btn-success btn-sm">Editar <i class="fas fa-pen"></i></a>
                                                        <a href="delete.php?id=<?php echo $id; ?>" class="btn btn-danger btn-sm">Borrar <i class="fas fa-trash"></i></a>
                                                    </center>
                                                </td>
                                            </tr>
                                        <?php
                                        }                            
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                            <!-- Menú contextual -->
                            <div id="contextMenu" class="dropdown-menu" style="display: none; position: absolute;">
                            <button class="dropdown-item" onclick="filtrarColumna()">Filtrar</button>
                            <button class="dropdown-item" onclick="copiarColumna()" hidden>Copiar</button>
                            <button class="dropdown-item" onclick="ordenarColumna()" hidden>Ordenar</button>
                            <button class="dropdown-item" onclick="resetearFiltro()">Mostrar todo</button> <!-- Nuevo botón -->
                        </div>

                    </div>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
</div>


<?php include('../../../../../layout/admin/parte2.php'); ?>

<style>
    #contextMenu {
        position: absolute;
        z-index: 1050;
        display: none;
        background-color: white;
        border: 1px solid #ddd;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
        border-radius: 5px;
        padding: 5px 0;
    }
</style>

<script>
    $(function () {
        $("#table_stcs").DataTable({
            "pageLength": 10,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Fuentes",
                "infoEmpty": "Mostrando 0 a 0 de 0 Fuentes",
                "infoFiltered": "(Filtrado de _MAX_ total Fuentes)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Fuentes",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscador:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            "responsive": true, "lengthChange": true, "autoWidth": false,
            buttons: [{
                extend: 'collection',
                text: 'Reportes',
                orientation: 'landscape',
                buttons: [{
                    text: 'Copiar',
                    extend: 'copy',
                }, {
                    extend: 'pdf'
                }, {
                    extend: 'csv'
                }, {
                    extend: 'excel'
                }, {
                    text: 'Imprimir',
                    extend: 'print'
                }
                ]
            },
                {
                    extend: 'colvis',
                    text: 'Visor de columnas',
                    collectionLayout: 'fixed three-column'
                }
            ],
        }).buttons().container().appendTo('#table_stcs_wrapper .col-md-6:eq(0)');
    });
</script>

<script>
  $(document).ready(function() {
    $('.servicio-link').click(function() {
      // Abre el modal correspondiente cuando se hace clic en el enlace del servicio
      $('#servicioModal').modal('show');
    });
  });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tableHeaders = document.querySelectorAll('#table_stcs thead th'); // Seleccionar cabeceras
        const contextMenu = document.getElementById('contextMenu');

        tableHeaders.forEach((header, index) => {
            header.addEventListener('contextmenu', function (event) {
                event.preventDefault(); 

                // Obtener el contenedor más cercano con desplazamiento
                const container = document.querySelector('.content-wrapper'); 
                const containerRect = container.getBoundingClientRect();

                // Ajustar la posición del menú contextual
                const posX = event.pageX - containerRect.left; 
                const posY = event.pageY - containerRect.top;

                contextMenu.style.left = `${posX}px`;
                contextMenu.style.top = `${posY}px`;
                contextMenu.style.display = 'block';

                contextMenu.setAttribute('data-column-index', index);
            });

        });

        // Ocultar el menú contextual al hacer clic en cualquier parte
        document.addEventListener('click', function () {
            contextMenu.style.display = 'none';
        });
    });
</script>

<script>async function filtrarColumna() {
    const contextMenu = document.getElementById('contextMenu');
    const columnIndex = contextMenu.getAttribute('data-column-index'); // Obtener índice de la columna seleccionada
    const table = $('#table_stcs').DataTable(); // Instancia de DataTables

    if (columnIndex === "7") { // Suponiendo que la columna "Cantidad" está en la posición 8 (índice basado en 0)
        // Mostrar alerta SweetAlert2 para solicitar el valor con operador
        const { value: filterValue } = await Swal.fire({
            title: "Filtrar por cantidad",
            text: "Introduce el operador (< o >) seguido del valor, por ejemplo: >10 o <20",
            input: "text",
            inputAttributes: {
                autocapitalize: "off"
            },
            showCancelButton: true,
            confirmButtonText: "Filtrar",
            cancelButtonText: "Cancelar",
            preConfirm: (value) => {
                if (!/^[<>]\d+$/.test(value)) {
                    Swal.showValidationMessage("Por favor, introduce un filtro válido, como >10 o <20.");
                }
                return value;
            },
            allowOutsideClick: () => !Swal.isLoading()
        });

        if (filterValue) {
            // Extraer el operador y el valor del filtro
            const operator = filterValue.charAt(0); // < o >
            const number = parseInt(filterValue.slice(1), 10);

            // Usar la función de filtro personalizada para aplicar el filtro
            $.fn.dataTable.ext.search.push((settings, data) => {
                const cantidad = parseFloat(data[columnIndex]) || 0; // Convertir valor de la columna a número
                if (operator === "<") {
                    return cantidad < number;
                } else if (operator === ">") {
                    return cantidad > number;
                }
                return true; // Mostrar todos los demás
            });

            table.draw(); // Aplicar el filtro

            // Notificar al usuario sobre el filtro aplicado
            Swal.fire({
                title: "Filtro aplicado",
                text: `Se ha filtrado por valores ${filterValue}.`,
                icon: "success",
                confirmButtonText: "Aceptar"
            });
        }
    } else {
        // Lógica general para otras columnas
        const { value: filterValue } = await Swal.fire({
            title: "Introduce el valor exacto para filtrar",
            input: "text",
            inputAttributes: {
                autocapitalize: "off"
            },
            showCancelButton: true,
            confirmButtonText: "Filtrar",
            cancelButtonText: "Cancelar",
            preConfirm: (value) => {
                if (!value || value.trim() === "") {
                    Swal.showValidationMessage("Por favor, introduce un valor válido.");
                }
                return value;
            },
            allowOutsideClick: () => !Swal.isLoading()
        });

        if (filterValue) {
            table.column(columnIndex).search(filterValue, false, false).draw();

            const filteredRows = table.rows({ filter: 'applied' }).data().length;
            if (filteredRows === 0) {
                Swal.fire({
                    title: "Sin coincidencias",
                    text: "No se encontraron coincidencias exactas. Mostrando todos los registros.",
                    icon: "warning",
                    confirmButtonText: "Aceptar"
                }).then(() => {
                    resetearFiltro(); // Mostrar todos los registros
                });
            } else {
                Swal.fire({
                    title: "Filtrado aplicado",
                    text: `Se encontraron ${filteredRows} registros que coinciden.`,
                    icon: "success",
                    confirmButtonText: "Aceptar"
                });
            }
        }
    }
}

// Función para restablecer filtros personalizados
function resetearFiltro() {
    $.fn.dataTable.ext.search = []; // Restablecer filtros personalizados
    const table = $('#table_stcs').DataTable(); // Instancia de DataTables
    table.search('').columns().search('').draw(); // Limpiar todos los filtros

    Swal.fire({
        title: "Filtros restablecidos",
        text: "Se han mostrado todos los registros.",
        icon: "info",
        confirmButtonText: "Aceptar"
    });
}

</script>
