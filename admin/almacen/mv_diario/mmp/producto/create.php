<?php

include('../../../../../app/config/config.php');
include('../../../../../app/config/conexion.php');

include('../../../../../layout/admin/sesion.php');
include('../../../../../layout/admin/datos_sesion_user.php');

include('../../../../../layout/admin/parte1.php');

// Obtener la fecha de creación del formulario
$fecha_creacion = isset($_POST['fechaingreso']) ? $_POST['fechaingreso'] : date('Y-m-d');

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Cear Producto MMP</h1>
                </div>
            </div>

            <div class="card card-blue">
                <div class="card-header">
                    Introduzca la información correspondiente
                </div>
                <div class="card-body">
                    <form id="formulario" action="controller_create.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Fecha Creación</label>
                                                <input type="date" name="fechaingreso" id="fechaingreso" class="form-control" value="<?php echo $fecha_creacion; ?>" onchange="actualizarContador()" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Agente</label>
                                                <input type="text" name="agente1" class="form-control" value="<?php echo htmlspecialchars($sesion_nombre = $sesion_usuario['nombre']); ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Tipo Producto</label>
                                                <select name="tipo_producto" id="tipo_producto" class="form-control" required>
                                                    <option value="">Seleccionar Tipo Producto</option>
                                                    <?php
                                                    $query_tipo = $pdo->prepare('SELECT id, tipo_prod_mmp, nomenclatura FROM t_tipo_producto WHERE habilitar_mmp = 1');
                                                    $query_tipo->execute();
                                                    $tipos = $query_tipo->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($tipos as $tipo) {
                                                        $id_tipo = $tipo['id'];
                                                        $tipo = $tipo['tipo_prod_mmp'];
                                                    ?>
                                                        <option value="<?php echo htmlspecialchars($id_tipo); ?>"><?php echo htmlspecialchars($tipo); ?></option>
                                                    <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="">Producto</label>
                                                <input type="text" name="producto" id="producto" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-0"> <!-- Se coloca aquí el usuario que está trabajando el archivo -->
                                            <div class="form-group">
                                                <label for=""></label>
                                                <input type="text" name="usuario" class="form-control" value="<?php echo $sesion_nombre; ?>" hidden>
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
                                        <div class="col-md-2">
                                            <a href="<?php echo $URL."admin/almacen/mv_diario/mmp/producto";?>" class="btn btn-default btn-block">Cancelar</a>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" onclick="return confirm('Seguro de haber diligenciado correctamente los datos?')" class="btn btn-primary btn-block">Crear Producto</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
</div>

<?php include('../../../../../layout/admin/parte2.php');?>