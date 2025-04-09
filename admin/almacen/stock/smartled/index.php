<?php 

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');

include('../../../../layout/admin/parte1.php');


$queryMovimientos = $pdo->prepare('SELECT mva.*,
                                        tpt.tipo_producto AS producto_nombre,
                                        tata.nombre_almacen AS nombre_almacen,
                                        tb.nombre_bodega AS nombre_bodega,
                                        tsa.sub_almacen AS nombre_sub_almacen,
                                    CASE
                                        when mva.tipo_producto = 1 then pmc.serie
                                        when mva.tipo_producto = 2 then rfc.referencia
                                        when mva.tipo_producto = 3 then rff.modelo_fuente
                                    END AS nombre_referencia2
                                    FROM movimiento_admon AS mva
                                    LEFT JOIN producto_modulo_creado AS pmc ON mva.referencia_2 = pmc.id AND mva.tipo_producto = 1
                                    LEFT JOIN referencias_control AS rfc ON mva.referencia_2 = rfc.id_referencia AND mva.tipo_producto = 2
                                    LEFT JOIN referencias_fuente AS rff ON mva.referencia_2 = rff.id_referencias_fuentes AND mva.tipo_producto = 3
                                    INNER JOIN t_productos AS tpt ON mva.tipo_producto = tpt.id_producto
                                    INNER JOIN t_asignar_todos_almacenes AS tata ON mva.almacen_origen1 = tata.id_asignacion
                                    INNER JOIN t_bodegas AS tb ON mva.bodega = tb.id
                                    INNER JOIN t_sub_almacen AS tsa ON mva.sub_almacen = tsa.id
                                    WHERE habilitar_almacen_entra = 0 AND almacen_destino1 = 3
                                ');
$queryMovimientos->execute();
$movimientos = $queryMovimientos->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                    <h1 class="m-0">Movimientos y Stock Almacén Smartled</h1>                
                    <div class="card card-blue">
                        <div class="card-header">
                            PRODUCTOS ACTIVOS
                        </div>

                        <hr>

                        <div class="row justify-content-center">
                            <!-- Contenedor principal para los botones -->
                            <div class="card-tools d-flex justify-content-center w-100">

                                <!-- Botón para ver los movimientos -->
                                <div class="form-group mx-2">
                                    <a href="#" class="btn btn-info" data-toggle="modal" data-target="#modalMovimientos">
                                        <i class="bi bi-plus-square"></i> Ver Movimientos Pendientes
                                    </a>
                                </div>

                                <!-- Botón para ingresar a Módulos -->
                                <div class="form-group mx-2">
                                    <a href="modulos/" class="btn btn-success">
                                        <i class="bi bi-plus-square"></i> Módulos
                                    </a>
                                </div>
                                <!-- Botón para ingresar a Controladoras -->
                                <div class="form-group mx-2">
                                    <a href="control/" class="btn btn-danger">
                                        <i class="bi bi-plus-square"></i> Controladoras
                                    </a>
                                </div>
                                <!-- Botón para ingresar a Fuentes -->
                                <div class="form-group mx-2">
                                    <a href="fuentes/" class="btn btn-warning">
                                        <i class="bi bi-plus-square"></i> Fuentes
                                    </a>
                                </div>

                                <!-- Botón existente para crear un nuevo movimiento -->
                                <div class="form-group mx-2">
                                    <button type="button" class="btn" style="background-color:rgb(34, 139, 245); color: white; border-color:rgb(34, 139, 245);" data-toggle="modal" data-target="#movimientoModal">
                                        <i class="bi bi-plus-square"></i> Crear Movimiento Mercancía
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table_usuarios" class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Fecha</th>
                                            <th>Producto</th>
                                            <th>Referencia 1</th>
                                            <th>Referencia 2</th>
                                            <th>Almacén Origen</th>
                                            <th>Almacén Destino</th>
                                            <th>Asignada a:</th>
                                            <th>Cantidad</th>
                                            <th>Observación</th>
                                            <th>Sub Almacén</th>
                                            <th>Recibe</th>
                                            <th><center>Acciones</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 0;
                                        $query = $pdo->prepare('SELECT
                                                                    mvd.*,
                                                                    productomovido.tipo_producto AS nombre_producto,
                                                                    almacen_origen.nombre_almacen AS almacen_origen,
                                                                    almacen_destino.nombre_almacen AS almacen_destino,
                                                                    sub_almacen.sub_almacen AS nombre_sub_almacen,
                                                                    COALESCE(tc.nombre, mvd.tecnico_recibe) AS nombre_tecnico,
                                                                CASE
                                                                    WHEN mvd.tipo_producto = 1 THEN pitch_table.pitch -- Aquí se une la tabla tabla_pitch
                                                                    WHEN mvd.tipo_producto = 2 THEN caraccon.marca_control
                                                                    WHEN mvd.tipo_producto = 3 THEN caracfue.marca_fuente
                                                                    ELSE NULL
                                                                END AS nombre_referencia_1,
                                                                CASE
                                                                    WHEN mvd.tipo_producto = 1 THEN tmc.serie
                                                                    WHEN mvd.tipo_producto = 2 THEN refecon.referencia
                                                                    WHEN mvd.tipo_producto = 3 THEN refefue.modelo_fuente
                                                                    ELSE NULL
                                                                END AS nombre_referencia_2
                                                                FROM
                                                                    movimiento_diario AS mvd
                                                                INNER JOIN
                                                                    t_productos AS productomovido ON mvd.tipo_producto = productomovido.id_producto
                                                                LEFT JOIN
                                                                    t_asignar_todos_almacenes AS almacen_origen ON mvd.almacen_origen1 = almacen_origen.id_asignacion
                                                                LEFT JOIN
                                                                    t_asignar_todos_almacenes AS almacen_destino ON mvd.almacen_destino1 = almacen_destino.id_asignacion
                                                                LEFT JOIN
                                                                    tabla_pitch AS tp ON mvd.referencia_2 = tp.id AND mvd.tipo_producto = 1
                                                                LEFT JOIN
                                                                    referencias_control AS refecon ON mvd.referencia_2 = refecon.id_referencia AND mvd.tipo_producto = 2
                                                                LEFT JOIN
                                                                    referencias_fuente AS refefue ON mvd.referencia_2 = refefue.id_referencias_fuentes AND mvd.tipo_producto = 3
                                                                LEFT JOIN
                                                                    producto_modulo_creado AS tmc ON mvd.referencia_2 = tmc.id AND mvd.tipo_producto = 1
                                                                LEFT JOIN
                                                                    caracteristicas_control AS caraccon ON refecon.marca = caraccon.id_car_ctrl AND mvd.tipo_producto = 2
                                                                LEFT JOIN
                                                                    caracteristicas_fuentes AS caracfue ON refefue.marca_fuente = caracfue.id_car_fuen AND mvd.tipo_producto = 3
                                                                LEFT JOIN
                                                                    tabla_pitch AS pitch_table ON tmc.pitch = pitch_table.id
                                                                LEFT JOIN
                                                                    t_sub_almacen AS sub_almacen ON mvd.sub_almacen = sub_almacen.id
                                                                LEFT JOIN
                                                                    tecnicos AS tc ON mvd.tecnico_recibe = tc.id
                                                                ORDER BY 
                                                                    20 DESC
                                                            ');
                                        $query->execute();
                                        $movidiarios = $query->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($movidiarios as $movidiario){
                                            $id = $movidiario['id_movimiento_diario'];
                                            $fecha = $movidiario['fecha'];
                                            $producto = $movidiario['nombre_producto'];
                                            $referencia1 = $movidiario['nombre_referencia_1'];
                                            $referencia2 = $movidiario['nombre_referencia_2'];
                                            $almacen_origen1 = $movidiario['almacen_origen'];
                                            $almacen_destino1 = $movidiario['almacen_destino'];
                                            $destino = $movidiario['op'];
                                            $cantidades = $movidiario['cantidad_entrada'];
                                            $observaciones = $movidiario['observaciones'];
                                            $sub_almacen = $movidiario['nombre_sub_almacen'];
                                            $tecnico = $movidiario['nombre_tecnico'];
                                            $contador = $contador + 1;
                                        ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($contador); ?></td>
                                                <td><?php echo htmlspecialchars($fecha); ?></td>
                                                <td><?php echo htmlspecialchars($producto); ?></td>
                                                <td><?php echo htmlspecialchars($referencia1); ?></td>
                                                <td><?php echo htmlspecialchars($referencia2); ?></td>
                                                <td><?php echo htmlspecialchars($almacen_origen1); ?></td>
                                                <td><?php echo htmlspecialchars($almacen_destino1); ?></td>
                                                <td><?php echo htmlspecialchars($destino); ?></td>
                                                <td><?php echo htmlspecialchars($cantidades); ?></td>
                                                <td><?php echo htmlspecialchars($observaciones); ?></td>
                                                <td><?php echo htmlspecialchars($sub_almacen); ?></td>
                                                <td><?php echo htmlspecialchars($tecnico); ?></td>
                                                <td>
                                                    <center>
                                                        <a href="show.php?id=<?php echo $id; ?>" class="btn btn-info btn-sm">Mostrar <i class="fas fa-eye"></i></a>
                                                        <a href="edit.php?id=<?php echo $id; ?>" class="btn btn-success btn-sm">Editar <i class="fas fa-pen"></i></a>
                                                    </center>
                                                </td>
                                            </tr>
                                        <?php
                                            }
                                        ?>

                                        <!-- Modal -->
                                        <div class="modal fade" id="movimientoModal" tabindex="-1" aria-labelledby="movimientoModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="background-color: 3371ff;">
                                                        <h5 class="modal-title" id="movimientoModalLabel" style="color: white; font-weight: 600;">Seleccionar Tipo de Movimiento</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <button type="button" class="btn btn-primary btn-block" onclick="location.href='<?php echo $URL;?>admin/almacen/mv_diario/smartled/movimiento_entrada/create_movimiento_entrada_final.php'">Movimiento de Entrada</button>
                                                        <button type="button" class="btn btn-secondary btn-block" onclick="location.href='<?php echo $URL;?>admin/almacen/mv_diario/smartled/movimiento_salida/create_movimiento_salida_final.php'">Movimiento de Salida</button>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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

<!-- Modal datos pendientes por tratar-->
<div class="modal fade" id="movimientoModal" tabindex="-1" aria-labelledby="movimientoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="movimientoModalLabel">Seleccionar Tipo de Movimiento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <button type="button" class="btn btn-primary btn-block" onclick="location.href='<?php echo $URL;?>admin/almacen/mv_diario/smartled/movimiento_entrada/create_movimiento_entrada_final.php'">Movimiento de Entrada</button>
                <button type="button" class="btn btn-secondary btn-block" onclick="location.href='<?php echo $URL;?>admin/almacen/mv_diario/smartled/movimiento_salida/create_movimiento_salida_final.php'">Movimiento de Salida</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal datos pendientes para ingresar de Admon-->
<div class="modal fade" id="modalMovimientos" tabindex="-1" aria-labelledby="modalMovimientosLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalMovimientosLabel">Movimientos Pendientes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Seleccionar</th>
                                <th>Tipo</th>
                                <th>Referencia</th>
                                <th>Origen</th>
                                <th>Cantidad</th>
                                <th>Observaciones</th>
                                <th>Bodega</th>
                                <th>Sub-Almacén</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($movimientos as $mov) { ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="seleccionar-movimiento"
                                            data-id_movimiento_admon="<?= htmlspecialchars($mov['id_movimiento_admon']); ?>"
                                            data-producto_nombre="<?= htmlspecialchars($mov['producto_nombre']); ?>"
                                            data-nombre_referencia2="<?= htmlspecialchars($mov['nombre_referencia2']); ?>"
                                            data-nombre_almacen="<?= htmlspecialchars($mov['nombre_almacen']); ?>"
                                            data-cantidad_entrada="<?= htmlspecialchars($mov['cantidad_entrada']); ?>"
                                            data-observaciones="<?= htmlspecialchars($mov['observaciones']); ?>"
                                            data-nombre_bodega="<?= htmlspecialchars($mov['nombre_bodega']); ?>"
                                            data-nombre_sub_almacen="<?= htmlspecialchars($mov['nombre_sub_almacen']); ?>">
                                    </td>
                                    <td><?= htmlspecialchars($mov['producto_nombre']); ?></td>
                                    <td><?= htmlspecialchars($mov['nombre_referencia2']); ?></td>
                                    <td><?= htmlspecialchars($mov['nombre_almacen']); ?></td>
                                    <td><?= htmlspecialchars($mov['cantidad_entrada']); ?></td>
                                    <td><?= htmlspecialchars($mov['observaciones']); ?></td>
                                    <td><?= htmlspecialchars($mov['nombre_bodega']); ?></td>
                                    <td><?= htmlspecialchars($mov['nombre_sub_almacen']); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="enviarSeleccionados">Registrar Seleccionados</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>



<?php include('../../../../layout/admin/parte2.php'); ?>

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
        $("#table_usuarios").DataTable({
            "pageLength": 25,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Productos",
                "infoEmpty": "Mostrando 0 a 0 de 0 Productos",
                "infoFiltered": "(Filtrado de _MAX_ total Productos)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Productos",
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
        }).buttons().container().appendTo('#table_usuarios_wrapper .col-md-6:eq(0)')
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
        const tableHeaders = document.querySelectorAll('#table_usuarios thead th'); // Seleccionar cabeceras
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

<script>
    async function filtrarColumna() {
    const contextMenu = document.getElementById('contextMenu');
    const columnIndex = contextMenu.getAttribute('data-column-index'); // Obtener índice de la columna seleccionada
    const table = $('#table_usuarios').DataTable(); // Instancia de DataTables

    if (columnIndex === "4") { // Suponiendo que la columna "Cantidad" está en la posición 8 (índice basado en 0)
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
    const table = $('#table_usuarios').DataTable(); // Instancia de DataTables
    table.search('').columns().search('').draw(); // Limpiar todos los filtros

    Swal.fire({
        title: "Filtros restablecidos",
        text: "Se han mostrado todos los registros.",
        icon: "info",
        confirmButtonText: "Aceptar"
    });
}

</script>

<script>
$(document).ready(function () {
    $("#enviarSeleccionados").click(function () {
        let seleccionados = [];
        
        $(".seleccionar-movimiento:checked").each(function () {
            seleccionados.push($(this).data("id_movimiento_admon"));
        });

        console.log("IDs seleccionados:", seleccionados); // Verifica los valores en la consola


        if (seleccionados.length > 0) {
            $.ajax({
                url: "actualizar_movimientos.php",
                type: "POST",
                data: { ids: seleccionados },
                success: function (response) {
                    alert("Movimientos actualizados correctamente.");
                    window.location.href = "<?php echo $URL; ?>admin/almacen/mv_diario/smartled/movimiento_entrada/create_movimiento_entrada_final.php";
                },
                error: function () {
                    alert("Hubo un error al actualizar los movimientos.");
                }
            });
        } else {
            alert("Seleccione al menos un movimiento.");
        }
    });
});
</script>