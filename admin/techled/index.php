<?php
// Incluir archivos necesarios
include('../../app/config/config.php');
include('../../app/config/conexion.php');  // Se asume que $pdo ya está configurado en este archivo

include('../../layout/admin/sesion.php');
include('../../layout/admin/datos_sesion_user.php');

include('../../layout/admin/parte1.php');

// Fecha de creación actual
$fecha_creacion = date('Y-m-d');

// Consultar los datos desde la base de datos usando PDO
try {
    // Asegurarnos de que la conexión PDO esté funcionando
    if (isset($pdo)) {
        $query = "SELECT * FROM techled"; // Asegúrate de que 'techled' es el nombre correcto de tu tabla
        $stmt = $pdo->query($query);

        if ($stmt === false) {
            // En caso de que la consulta falle
            throw new Exception("Error en la consulta: " . implode(", ", $pdo->errorInfo()));
        }

        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtener todos los resultados
    } else {
        throw new Exception("La conexión PDO no está disponible.");
    }
} catch (Exception $e) {
    // Si ocurre algún error, lo mostramos
    die("Error: " . $e->getMessage());
}

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                    <h1 class="m-0"><b>TECHLED</b></h1>
                    
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo htmlspecialchars($sesion_usuario['nombre']); ?></h3>
                        </div>
                        
                        <div class="col-md-4 mt-3 mb-3">
                            <a href="<?php echo $URL; ?>admin/techled/create.php" class="btn btn-primary">Solicitar producto</a>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="techled" class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Producto</th>
                                            <th>Modelo</th>
                                            <th>Serial</th>
                                            <th>Cantidad</th>
                                            <th>Descripciones</th>
                                            <th>Valor</th>
                                            <th>Archivo adjunto</th>
                                            <th><center>Acciones</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($resultado)) {
                                            foreach ($resultado as $fila) { ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($fila['id']); ?></td>
                                                    <td><?php echo htmlspecialchars($fila['producto']); ?></td>
                                                    <td><?php echo htmlspecialchars($fila['modelo']); ?></td>
                                                    <td><?php echo htmlspecialchars($fila['serial']); ?></td>
                                                    <td><?php echo htmlspecialchars($fila['cantidad']); ?></td>
                                                    <td><?php echo htmlspecialchars($fila['descripcion']); ?></td>
                                                    <td><?php echo htmlspecialchars($fila['valor']); ?></td>
                                                    <td>
                                                        <!-- Mostrar archivo con la ruta almacenada -->
                                                        <a href="img/<?php echo basename($fila['archivo']); ?>" target="_blank">Ver archivo</a>
                                                    </td>
                                                    <td>
                                                        <center>
                                                            <a href="show.php?id=<?php echo $fila['id']; ?>" class="btn btn-info btn-sm">Mostrar <i class="fas fa-eye"></i></a>
                                                            <a href="edit.php?id=<?php echo $fila['id']; ?>" class="btn btn-success btn-sm">Editar <i class="fas fa-pen"></i></a>
                                                            <!-- Botón de eliminar con modal de confirmación -->
                                                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirmDeleteModal" data-id="<?php echo $fila['id']; ?>">Borar <i class="fas fa-trash"></i></button>
                                                        </center>
                                                    </td>
                                                </tr>
                                        <?php }} else {
                                            echo "<tr><td colspan='9'>No se encontraron registros.</td></tr>";
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmación -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="container-fluid">
                <div class="card card-red">
                    <div class="card-header"> 
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmDeleteModalLabel">Confirma si deseas borar</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                    <div class="modal-body">
                        ¿Esta seguro de que desea borrar esta información?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <a href="delete.php?id=<?php echo $fila['id']; ?>"class="btn btn-danger">Borrar <i class="fas fa-trash"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script para manejar el modal -->
<script>
    // Capturar el ID del elemento a eliminar
    $('#confirmDeleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Botón que abrió el modal
        var id = button.data('id'); // Extraer ID del atributo data-id
        var modal = $(this);
        modal.find('#confirmDeleteButton').attr('href', 'controller.php?id=' + id); // Establecer la URL de eliminación
    });
</script>

<?php include('../../layout/admin/parte2.php'); ?>
