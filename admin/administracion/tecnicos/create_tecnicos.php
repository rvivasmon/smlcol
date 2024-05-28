<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

include('../../../layout/admin/parte1.php');

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Crear Nuevo Técnico</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card card-blue">
                <div class="card-header">
                    Introduzca la información correspondiente
                </div>
                <div class="card-body">
                    <form action="controller_create_tecnicos.php" method="post">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Nombre</label>
                                    <input type="text" name="nombre" class="form-control" placeholder="Nombre Completo" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Dcumento de identidad</label>
                                    <input type="text" name="doc_ident" class="form-control" placeholder="Doc. Ident." required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Usuario</label>
                                    <input type="text" name="usuario" class="form-control" placeholder="Usuario">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Ciudad</label>
                                    <select name="ciudad" id="ciudad" class="form-control" required>
                                        <?php 
                                        $query_ciudad = $pdo->prepare('SELECT * FROM ciudad ORDER BY ciudad ASC');
                                        $query_ciudad->execute();
                                        $ciudades = $query_ciudad->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($ciudades as $ciudad) {
                                            $id_ciudad = $ciudad['id'];
                                            $nom_ciudad = $ciudad['ciudad'];
                                            ?>
                                            <option value="<?php echo $id_ciudad; ?>"><?php echo $nom_ciudad; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Estado General</label>
                                    <select name="estado_general" id="estado_general" class="form-control" required>
                                        <?php 
                                        $query_estado = $pdo->prepare('SELECT * FROM estado WHERE estado_general IS NOT NULL AND estado_general != "" ORDER BY estado_general ASC');
                                        $query_estado->execute();
                                        $estados = $query_estado->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($estados as $estado) {
                                            $id_estado = $estado['id'];
                                            $estado_general = $estado['estado_general'];
                                            ?>
                                            <option value="<?php echo $id_estado; ?>"><?php echo $estado_general; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>                            
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-2">
                                <a href="<?php echo $URL."admin/Administracion/tecnicos/index_tecnicos.php";?>" class="btn btn-default btn-block">Cancelar</a>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" onclick="return confirm('Seguro de haber diligenciado correctamente los datos?')" class="btn btn-primary btn-block">Registrar Técnico</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div>
</div>
<?php include('../../../layout/admin/parte2.php');?>
