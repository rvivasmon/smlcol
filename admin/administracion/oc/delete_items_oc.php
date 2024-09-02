<?php 
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');
include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');
include('../../../layout/admin/parte1.php');

$id_get = $_GET['id'];

// Consultar ítems asociados
$query_items = $pdo->prepare("SELECT * FROM tabla_items_oc WHERE id_oc = :id_oc");
$query_items->bindParam(':id_oc', $id_get, PDO::PARAM_INT);
$query_items->execute();
$oc_item = $query_items->fetch(PDO::FETCH_ASSOC); // Cambiado a fetch para un solo ítem

if ($oc_item) {
    $id_item = $oc_item['id_item'];
    $id_oc = $oc_item['id_oc'];
    $descripcion = $oc_item['descripcion'];
    $cantidad = $oc_item['cantidad'];
    $instalacion = $oc_item['instalacion'];
} else {
    echo "No se encontró el ítem.";
    exit();
}

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">  
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Eliminar Items</h1>
                </div>
            </div>

            <div class="card">
                <div class="card-header" style="background-color: #d92005; color: #ffffff">
                    <a href="#" class="d-block"></a>
                    Confirme la eliminación del ítem
                </div>
                <div class="card-body">
                    <form action="controller_delete_items_oc.php" method="post">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="descripcion">Descripción</label>
                                                <input type="text" name="descripcion" id="descripcion" value="<?php echo htmlspecialchars($descripcion); ?>" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="cantidad">Cantidad</label>
                                                <input type="text" name="cantidad" id="cantidad" value="<?php echo htmlspecialchars($cantidad); ?>" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="instalacion">Instalación</label>
                                                <input type="text" name="instalacion" id="instalacion" value="<?php echo htmlspecialchars($instalacion); ?>" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="usuario_elimina_oc">Usuario que elimina el ítem</label>
                                                <input type="text" name="usuario_elimina_oc" id="usuario_elimina_oc" value="<?php echo htmlspecialchars($sesion_usuario['nombre']); ?>" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>  
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <a href="<?php echo $URL . 'admin/nueva_tarea_8-7-24/index_oc.php'; ?>" class="btn btn-default btn-block">Cancelar</a>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="submit" onclick="return confirm('¿Seguro de querer eliminar el ítem?')" class="btn btn-danger btn-block">Eliminar Ítem</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Campo oculto para pasar el ID del ítem -->
                        <input type="hidden" name="id_item" value="<?php echo htmlspecialchars($id_get); ?>">

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<?php include('../../../layout/admin/parte2.php'); ?>
