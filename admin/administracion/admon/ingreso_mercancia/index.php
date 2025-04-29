<?php

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');

include('../../../../layout/admin/parte1.php');

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                <h1 class="m-0">Ingreso de Inventario</h1>
                    <div class="card card-blue">
                        <div class="card-header">
                            Movimientos
                        </div>

                        <hr>

                        <div class="row">
                            <div class="card-tools ml-4">
                                <div class="form-group">
                                    <a href="create_entrada.php" class="btn" style="background-color: #FFCC00; color: black; border-color: #FFCC00;">
                                        <i class="bi bi-plus-square"></i> Nuevo Ingreso
                                    </a>
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
                                            <th># Movimiento</th>
                                            <th>Origen</th>
                                            <th>Almacén Destino</th>
                                            <th>Producto</th>
                                            <th>Modelo</th>
                                            <th>Cantidad</th>
                                            <th>Usuario</th>
                                            <th><center>Acciones</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
$contador = 1;

$query = $pdo->prepare('
SELECT 
    p.tipo_producto AS nombre_producto,
    mvd.almacen_destino1,
    mvd.consecu_entra,
    mvd.id_entrada AS id_entrada,
    COUNT(*) AS total_registros,
    GROUP_CONCAT(mvd.id_movimiento_admon ORDER BY mvd.id_movimiento_admon ASC) AS ids_movimientos,
    mvd.fecha AS fecha,
    mvd.id_usuario AS id_usuario,
    mvd.tipo_producto AS tipo_producto, -- <--- Agregado
    mvd.referencia_2 AS referencia_2,    -- <--- Agregado
    mvd.cantidad_entrada AS cantidad_entrada, -- <--- Agregado
    almacen_origen.nombre_almacen AS almacen_origen, 
    almacen_destino.siglas AS nombre_almacen_destino,
    CASE
        WHEN mvd.tipo_producto = 1 THEN tmc.serie
        WHEN mvd.tipo_producto = 2 THEN caraccontrol.referencia
        WHEN mvd.tipo_producto = 3 THEN caracfuentes.modelo_fuente
        ELSE NULL
    END AS nombre_referencia_2
FROM movimiento_admon AS mvd
INNER JOIN
    t_productos AS p ON mvd.tipo_producto = p.id_producto
LEFT JOIN
    t_asignar_todos_almacenes AS almacen_origen ON mvd.almacen_origen1 = almacen_origen.id_asignacion
LEFT JOIN
    almacenes_grupo AS almacen_destino ON mvd.almacen_destino1 = almacen_destino.id
LEFT JOIN
    t_bodegas AS bg ON mvd.bodega = bg.id
LEFT JOIN
    t_sub_almacen AS sua ON mvd.sub_almacen = sua.id
LEFT JOIN
    producto_modulo_creado AS tmc ON mvd.referencia_2 = tmc.id AND mvd.tipo_producto = 1
LEFT JOIN
    referencias_control AS caraccontrol ON mvd.referencia_2 = caraccontrol.id_referencia AND mvd.tipo_producto = 2
LEFT JOIN
    referencias_fuente AS caracfuentes ON mvd.referencia_2 = caracfuentes.id_referencias_fuentes AND mvd.tipo_producto = 3
GROUP BY
    mvd.almacen_destino1, mvd.consecu_entra
ORDER BY
    mvd.almacen_destino1, mvd.consecu_entra DESC;
');

$query->execute();
$movidiarios = $query->fetchAll(PDO::FETCH_ASSOC);

foreach ($movidiarios as $movidiario) {
    $ids = explode(',', $movidiario['ids_movimientos']); // Convertir los IDs en un array
    $fecha = $movidiario['fecha'];
    $movimiento = $movidiario['id_entrada'];
    $almacen_origen1 = $movidiario['almacen_origen'];
    $almacen_destino1 = $movidiario['nombre_almacen_destino'];
    $id_usuario = $movidiario['id_usuario'];
    $producto = $movidiario['nombre_producto'];
    $modelo = $movidiario['nombre_referencia_2'];
    $cantidad = $movidiario['cantidad_entrada'];
    // Si solo necesitas un ID para los enlaces (ejemplo: el primero)
    $id_unico = $ids[0];

    echo "<tr>";
    echo "<td>" . $contador . "</td>";
    echo "<td>" . htmlspecialchars($fecha) . "</td>";
    echo "<td>" . htmlspecialchars($movimiento) . "</td>";
    echo "<td>" . htmlspecialchars($almacen_origen1) . "</td>";
    echo "<td>" . htmlspecialchars($almacen_destino1) . "</td>";
    echo "<td>" . htmlspecialchars($producto) . "</td>";
    echo "<td>" . htmlspecialchars($modelo) . "</td>";
    echo "<td>" . htmlspecialchars($cantidad) . "</td>";
    //echo "<td>" . implode(', ', $ids) . "</td>"; // Muestra todos los IDs en una celda
    echo "<td>" . htmlspecialchars($id_usuario) . "</td>";
    echo "<td>
            <center>
                <a href='show.php?id=" . $id_unico . "' class='btn btn-info btn-sm'>Mostrar <i class='fas fa-eye'></i></a>
                <a href='edit.php?id=" . $id_unico . "' class='btn btn-success btn-sm'>Editar <i class='fas fa-pen'></i></a>
            </center>
          </td>";
    echo "</tr>";

    $contador++;
}
?>


                                        <!-- Modal
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
                                                        <button type="button" class="btn btn-primary btn-block" onclick="location.href='<?php echo $URL;?>admin/administracion/admon/ingreso_mercancia/create_entrada.php'">Movimiento de Entrada</button>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>-->

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
            "pageLength": 10,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Movimientos",
                "infoEmpty": "Mostrando 0 a 0 de 0 Movimientos",
                "infoFiltered": "(Filtrado de _MAX_ total Movimientos)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Movimientos",
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
        }).buttons().container().appendTo('#table_usuarios_wrapper .col-md-6:eq(0)');
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

<script>async function filtrarColumna() {
    const contextMenu = document.getElementById('contextMenu');
    const columnIndex = contextMenu.getAttribute('data-column-index'); // Obtener índice de la columna seleccionada
    const table = $('#table_usuarios').DataTable(); // Instancia de DataTables

    if (columnIndex === "8") { // Suponiendo que la columna "Cantidad" está en la posición 8 (índice basado en 0)
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