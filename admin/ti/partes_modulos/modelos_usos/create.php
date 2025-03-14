<?php 

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');

include('../../../../layout/admin/parte1.php');

$usuario = $sesion_usuario['nombre'];

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Crear Nuevo Modelo</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card card-blue">
                <div class="card-header">
                    Introduzca la información correspondiente
                </div>
                <div class="card-body">
                    <form action="controller_create.php" method="post">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="uso">Uso Modulo</label>
                                    <select name="uso" id="uso" class="form-control" required>
                                        <option value="">Seleccione un Uso</option>
                                            <?php
                                            $query_solicitante = $pdo->prepare('SELECT id, producto_uso FROM t_tipo_producto WHERE producto_uso IS NOT NULL AND producto_uso != "" AND id_cat_productos = "1" ORDER BY producto_uso ASC');
                                            $query_solicitante->execute();
                                        $solicitantes = $query_solicitante->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($solicitantes as $solicitud) {
                                            echo '<option value="' . $solicitud['id'] . '">' . $solicitud['producto_uso'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="modelo">Modelo</label>
                                    <input type="text" name="modelo" id="modelo" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="habilitado">Habilitar?</label>
                                    <select name="habilitado" id="habilitado" class="form-control">
                                        <option value="" disabled selected>Seleccione una opción</option>
                                        <option value="1">SI</option>
                                        <option value="0">NO</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Este es el campo oculto del ID del usuario seleccionado aquí -->
                        <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $usuario; ?>">
                        <hr>

                        <div class="row">
                            <div class="col-md-2">
                                <a href="<?php echo $URL."admin/ti/partes_modulos/modelos_usos/";?>" class="btn btn-default btn-block">Cancelar</a>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" onclick="return confirm('Seguro de haber diligenciado correctamente los datos?')" class="btn btn-primary btn-block">Registrar Modulo</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div>
</div>

<?php include('../../../../layout/admin/parte2.php');?>