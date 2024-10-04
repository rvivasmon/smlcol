<?php 
include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');

include('../../../../layout/admin/parte1.php');

$id_get = $_GET['id'];

// Consulta para obtener los datos del pre-proyecto
$query = $pdo->prepare("SELECT * FROM pre_proyecto WHERE id_preproyec = :id_get");
$query->bindParam(':id_get', $id_get, PDO::PARAM_INT);
$query->execute();
$proyecto = $query->fetch(PDO::FETCH_ASSOC);

if ($proyecto) {
    $id = $proyecto['id_preproyec'];
    $fecha = $proyecto['fecha'];
    $tipo = $proyecto['tipo_proyecto'];
    $idprepro = $proyecto['idprepro'];
    $preproyecto = $proyecto['nombre_preproyecto'];
    $cliente = $proyecto['cliente'];
    $contacto = $proyecto['contacto'];
    $telefono = $proyecto['telefono'];
    $ciudad = $proyecto['ciudad'];
} else {
    echo "No se encontró el pre-proyecto.";
    exit;
}

// Consulta para obtener los datos del item - preproyecto
$query_pre = $pdo->prepare("SELECT * FROM item_preproyecto WHERE id_preproyec = :id_get");
$query_pre->bindParam(':id_get', $id_get, PDO::PARAM_INT);
$query_pre->execute();
$pre_proyecto = $query_pre->fetch(PDO::FETCH_ASSOC);

if ($pre_proyecto) {
    $id_pre = $pre_proyecto['id_item_preproy'];

} else {
    echo "No se encontró el pre-proyecto.";
    exit;
}

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                    <h1 class="m-0">Tratamiento de PRE PROYECTOS</h1>
                    <div class="card card-blue">
                        <div class="card-header">
                            Identificador
                        </div>

                        <div class="card-body">
                            <div class="container-fluid">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fecha" class="d-block mb-0">Fecha</label>
                                            <input type="date" id="fecha" name="fecha" class="form-control" value="<?php echo $fecha; ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="hora" class="d-block mb-0">Hora</label>
                                            <input type="time" id="hora" name="hora" class="form-control" value="<?php echo date('H:i', strtotime($fecha)); ?>" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="tipo_proyecto" class="d-block mb-0">Tipo Proyecto</label>
                                                <select name="tipo_proyecto" id="tipo_proyecto" class="form-control" readonly>
                                                    <option value="<?php echo htmlspecialchars($tipo); ?>"><?php echo htmlspecialchars($tipo); ?></option>
                                                </select>
                                            </div>
                                    </div>
                                    <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="id_proyecto" class="d-block mb-0">Id Proyecto</label>
                                                <input type="text" name="id_proyecto" id="id_proyecto" class="form-control" value="<?php echo htmlspecialchars($idprepro); ?>" readonly>
                                            </div>
                                    </div>
                                    <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ciudad" class="d-block mb-0">Ciudad</label>
                                                <input type="text" name="ciudad" id="ciudad" class="form-control" value="<?php echo htmlspecialchars($ciudad); ?>">
                                            </div>
                                    </div>
                                    <div class="col-md-0">
                                            <input type="hidden" name="idusuario2" value="<?php echo $sesion_usuario['id']; ?>">
                                    </div>
                                </div>

                                <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nombre_proyecto" class="d-block mb-0">Proyecto</label>
                                                <input type="text" name="nombre_proyecto" class="form-control" value="<?php echo htmlspecialchars($preproyecto); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="cliente" class="d-block mb-0">Cliente</label>
                                                <input type="text" name="cliente" class="form-control" value="<?php echo htmlspecialchars($cliente); ?>">
                                            </div>
                                        </div>
                                </div>

                                <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="contacto_cliente" class="d-block mb-0">Contacto</label>
                                                <input type="text" name="contacto_cliente" class="form-control" value="<?php echo htmlspecialchars($contacto); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="telefono_contacto" class="d-block mb-0">Teléfono Contacto</label>
                                                <input type="text" name="telefono_contacto" class="form-control" value="<?php echo htmlspecialchars($telefono); ?>">
                                            </div>
                                        </div>
                                </div>

                            </div>

                            <div class="table-responsive">
                                <table id="table_usuarios" class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th># Pantallas</th>
                                            <th>Estado</th>
                                            <th>Categoría</th>
                                            <th>Uso</th>
                                            <th>T. Producto</th>
                                            <th hidden>T. Modelo Módulo</th>
                                            <th hidden>Pitch</th>
                                            <th>X Disponible</th>
                                            <th>Y Disponible</th>
                                            <th>Justificación</th>
                                            <th><center>Acciones</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 0;
                                        $query_items = $pdo->prepare('SELECT
                                                    item_preproyecto.*,
                                                    t_estado.estado_ppc AS nom_estado,
                                                    t_categoria_productos.categoria AS nom_categoria,
                                                    tipo_prod.tipo_producto21 AS nom_producto,
                                                    modelo_prod.modelo_modulo AS nom_modelo,
                                                    t_uso_productos.producto_uso AS nom_uso,
                                                    caracteristicas_modulos.pitch AS nom_pitch
                                                FROM
                                                    item_preproyecto
                                                LEFT JOIN t_estado ON item_preproyecto.estado = t_estado.id
                                                LEFT JOIN t_categoria_productos ON item_preproyecto.categoria = t_categoria_productos.id_prod_terminado
                                                LEFT JOIN t_tipo_producto as tipo_prod ON item_preproyecto.tipo_producto = tipo_prod.id
                                                LEFT JOIN t_tipo_producto as modelo_prod ON item_preproyecto.modelo_uso = modelo_prod.id
                                                LEFT JOIN t_uso_productos ON item_preproyecto.uso = t_uso_productos.id_uso
                                                LEFT JOIN caracteristicas_modulos ON item_preproyecto.pitch = caracteristicas_modulos.id_car_mod
                                                WHERE
                                                    item_preproyecto.id_preproyec = :id_proyecto
                                                ORDER BY nom_pitch ASC
                                        ');

                                        $query_items->bindParam(':id_proyecto', $id, PDO::PARAM_INT); // Utiliza el valor de $id_proyecto del formulario
                                        $query_items->execute();
                                        $productos = $query_items->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($productos as $producto) {
                                                $contador++;
                                                ?>
                                                <tr>
                                                    <td><?php echo $contador; ?></td>
                                                    <td><?php echo htmlspecialchars($producto['cantidad_pantallas'] ?? ''); ?></td>
                                                    <td><?php echo htmlspecialchars($producto['nom_estado'] ?? ''); ?></td>
                                                    <td><?php echo htmlspecialchars($producto['nom_categoria'] ?? ''); ?></td>
                                                    <td><?php echo htmlspecialchars($producto['nom_uso'] ?? ''); ?></td>
                                                    <td><?php echo htmlspecialchars($producto['nom_producto'] ?? ''); ?></td>
                                                    <td hidden><?php echo htmlspecialchars($producto['nom_modelo'] ?? ''); ?></td>
                                                    <td hidden><?php echo htmlspecialchars($producto['nom_pitch'] ?? ''); ?></td>
                                                    <td><?php echo htmlspecialchars($producto['x_disponible'] ?? ''); ?></td>
                                                    <td><?php echo htmlspecialchars($producto['y_disponible'] ?? ''); ?></td>
                                                    <td><?php echo htmlspecialchars($producto['justificacion'] ?? ''); ?></td>
                                                    <td>
                                                    <center>
                                                    <a href="edit_create.php?item_id=<?php echo $producto['id_item_preproy']; ?>&preproyec_id=<?php echo $id; ?>" class="btn btn-success btn-sm">Tratar <i class="fas fa-pen"></i></a>
                                                    <a href="delete.php?id=<?php echo $id_pre; ?>" class="btn btn-danger btn-sm">Borrar <i class="fas fa-trash"></i></a>
                                                    </center>
                                                </tr>
                                            <?php
                                            }                            
                                            ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <a href="<?php echo $URL . "admin/crm/preproyectos";?>" class="btn btn-default btn-block">Cancelar</a>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <button type="submit" onclick="return confirm('¿Seguro de haber diligenciado correctamente los datos?')" class="btn btn-primary btn-block">Crear Proyecto</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <!-- Botón para abrir el modal -->
                                                <div class="form-group">
                                                    <a href="#" class="btn btn-warning btn-block" data-toggle="modal" data-target="#addItemModal">Añadir Item</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal -->
                                <div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="addItemModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addItemModalLabel">Añadir Item</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="addItemForm">
                                                    <div class="form-group cloned-section">
                                                        <div class="row">
                                                            <div class="col-md-4 items_pre">
                                                                <div class="form-group">
                                                                    <label for="items" class="d-block mb-0">Items</label>
                                                                    <input type="text" name="items[]" class="form-control" value="1" readonly>
                                                                    <input type="hidden" id="item_data" name="item_data">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 items_pre">
                                                                <div class="form-group">
                                                                    <label for="pantallas" class="d-block mb-0">Cantidad de Pantallas</label>
                                                                    <input type="text" name="pantallas[]" id="pantallas[]" class="form-control" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 items_pre">
                                                                <label for="estado" class="d-block mb-0">Estado</label>
                                                                <select name="estado[]" class="form-control" required>
                                                                    <option value="1">Nuevo</option>
                                                                    <?php foreach ($estados as $estado) : ?>
                                                                        <option value="<?php echo htmlspecialchars($estado['id']); ?>">
                                                                            <?php echo htmlspecialchars($estado['estado_ppc']); ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4 items_pre">
                                                                <div class="form-group">
                                                                    <label for="categoria_producto" class="d-block mb-0">Categoría Producto</label>
                                                                    <select name="categoria_producto[]" class="form-control" onchange="cargarDatosRelacionados(this.value)">
                                                                        <option value="">Seleccione Categoría</option>
                                                                        <?php foreach ($productos as $producto) : ?>
                                                                            <?php if ($producto['id_prod_terminado'] != 5) : ?>
                                                                                <option value="<?php echo htmlspecialchars($producto['id_prod_terminado']); ?>">
                                                                                    <?php echo htmlspecialchars($producto['categoria']); ?>
                                                                                </option>
                                                                            <?php endif; ?>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 items_pre">
                                                                <div class="form-group">
                                                                    <label for="uso" class="d-block mb-0">Uso</label>
                                                                    <select name="uso[]" class="form-control">
                                                                        <option value="">Seleccione Uso</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 items_pre">
                                                                <div class="form-group">
                                                                    <label for="tipo_producto" class="d-block mb-0">Tipo Producto</label>
                                                                    <select name="tipo_producto[]" class="form-control">
                                                                        <option value="">Seleccione Tipo</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-2 items_pre">
                                                                <div class="form-group">
                                                                    <label for="x_dispo_mts" class="d-block mb-0">X Dispo en mts</label>
                                                                    <input type="text" name="x_dispo_mts[]" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 items_pre">
                                                                <div class="form-group">
                                                                    <label for="y_dispo_mts" class="d-block mb-0">Y Dispo en mts</label>
                                                                    <input type="text" name="y_dispo_mts[]" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 items_pre">
                                                                <div class="form-group">
                                                                    <label for="x_disponible" class="d-block mb-0">X Dispo en mm</label>
                                                                    <input type="text" name="x_disponible[]" class="form-control" readonly />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 items_pre">
                                                                <div class="form-group">
                                                                    <label for="y_disponible" class="d-block mb-0">Y Dispo en mm</label>
                                                                    <input type="text" name="y_disponible[]" class="form-control" readonly />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 items_pre">
                                                                <div class="form-group">
                                                                    <label for="justificacion" class="d-block mb-0">Observaciones</label>
                                                                    <textarea name="justificacion[]" class="form-control" rows="2"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Guardar Item</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.content-header -->

<?php include('../../../../layout/admin/parte2.php'); ?>

<script>
    $(document).ready(function () {
    $('#addItemForm').on('submit', function (e) {
        e.preventDefault(); // Evitar el envío normal del formulario

        // Obtener los datos del formulario
        var formData = $(this).serialize();

        // Realizar la solicitud AJAX para guardar los datos
        $.ajax({
            url: 'guardar_item.php', // URL del archivo PHP que procesará la solicitud
            type: 'POST',
            data: formData,
            success: function (response) {
                // Manejar la respuesta del servidor
                alert(response); // Muestra un mensaje con la respuesta
                $('#addItemModal').modal('hide'); // Cierra el modal
                location.reload(); // Recargar la página para actualizar la tabla
            },
            error: function () {
                alert('Error al guardar el item.'); // Manejar errores
            }
        });
    });
});

</script>
