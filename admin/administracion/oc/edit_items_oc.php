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
$items = $query_items->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">  
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edición de Items</h1>
                </div>
            </div>

            <div class="card">
                <div class="card-header" style="background-color: #00A000; color: #ffffff">
                    Modifique la información correspondiente
                </div>
                <div class="card-body">
                    <form action="controller_edit_items_oc.php" method="post">
                        <?php foreach ($items as $oc_item): ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="descripcion_<?php echo $oc_item['id_item']; ?>">Descripcion</label>
                                        <input type="text" name="descripcion[]" id="descripcion_<?php echo $oc_item['id_item']; ?>" value="<?php echo $oc_item['descripcion']; ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="cantidad_<?php echo $oc_item['id_item']; ?>">Cantidad</label>
                                        <input type="number" name="cantidad[]" id="cantidad_<?php echo $oc_item['id_item']; ?>" value="<?php echo $oc_item['cantidad']; ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="instalacion_<?php echo $oc_item['id_item']; ?>">Instalación</label>
                                        <select name="instalacion[]" id="instalacion_<?php echo $oc_item['id_item']; ?>" class="form-control" required>
                                            <option value="">Seleccione</option>
                                            <?php 
                                            $query_tabla_union = $pdo->prepare('SELECT id, consecutivo_instalacion_oc FROM oc_prefijos');
                                            $query_tabla_union->execute();
                                            $uniones = $query_tabla_union->fetchAll(PDO::FETCH_ASSOC);

                                            foreach($uniones as $prefijos) {
                                                $consecutivo_instalacion_oc = $prefijos['consecutivo_instalacion_oc'];
                                                $selected = ($consecutivo_instalacion_oc == $oc_item['instalacion']) ? 'selected' : '';
                                                echo "<option value='$consecutivo_instalacion_oc' $selected>$consecutivo_instalacion_oc</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- Campo oculto para el ID del ítem -->
                                <input type="hidden" name="id_item[]" value="<?php echo $oc_item['id_item']; ?>">
                            </div>
                        <?php endforeach; ?>

                        <hr>

                        <div class="row">
                            <div class="col-md-4">
                                <a href="<?php echo $URL."admin/nueva_tarea_8-7-24/index_oc.php";?>" class="btn btn-default btn-block">Cancelar</a>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" onclick="return confirm('¿Seguro de haber diligenciado correctamente los datos?')" class="btn btn-success btn-block">Guardar Cambios</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../../../layout/admin/parte2.php'); ?>
