<?php

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

include('../../../layout/admin/parte1.php');

$id_oc = $_GET['id'];  // ID del OC que viene en la URL, por ejemplo, cuando se navega desde una lista de OCs.

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Nuevo Item</h1>
                </div>
            </div>
            <div class="card card-success">
                <div class="card-header">
                    Introduzca la información correspondiente
                </div>
                <div class="card-body">

                    <form action="controller_create_items.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id_oc" value="<?php echo htmlspecialchars($id_oc); ?>">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="descripcion">Descripción</label>
                                    <input type="text" name="descripcion" id="descripcion" placeholder="Descripción" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cantidad">Cantidad</label>
                                    <input type="number" name="cantidad" id="cantidad" placeholder="Cantidad" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="instalacion">Instalación</label>
                                    <select name="instalacion" id="instalacion" class="form-control" required>
                                        <option value="">Instalación?</option>
                                        <?php 
                                            $query_tabla_union = $pdo->prepare('SELECT id, consecutivo_instalacion_oc FROM oc_prefijos LIMIT 2');
                                            $query_tabla_union->execute();
                                            $uniones = $query_tabla_union->fetchAll(PDO::FETCH_ASSOC);
                                            foreach($uniones as $prefijos) {
                                                $consecutivo_instalacion_oc = $prefijos['consecutivo_instalacion_oc'];
                                                echo "<option value='$consecutivo_instalacion_oc'>$consecutivo_instalacion_oc</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <a href="<?php echo $URL."admin/administracion/oc/edit.php?id=".$id_oc; ?>" class="btn btn-default btn-block">Cancelar</a>
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

<?php include('../../../layout/admin/parte2.php');?>