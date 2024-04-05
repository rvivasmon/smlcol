<?php 

include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/sesion.php');
include('../../layout/admin/datos_sesion_user.php');

include('../../layout/admin/parte1.php');

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Crear Nuevo Usuario</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card card-blue">
                <div class="card-header">
                    Introduzca la información correspondiente
                </div>
                <div class="card-body">
                    <form action="controller_create.php" method="post">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Nombre</label>
                                    <input type="text" name="nombre" class="form-control" placeholder="Nombre Completo" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Correo Electrónico</label>
                                    <input type="text" name="email" class="form-control" placeholder="Email" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Usuario</label>
                                    <input type="text" name="usuario" class="form-control" placeholder="Usuario" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Contraseña</label>
                                    <input type="text" name="password" class="form-control" placeholder="Password" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Verificar contraseña</label>
                                    <input type="text" name="verificar_password" class="form-control" placeholder="Verifique su contraseña" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Cargo</label>
                                    <select name="id_cargo" id="id_cargo" class="form-control" required>
                                        <?php 
                                        $query_cargo = $pdo->prepare('SELECT * FROM cargo ORDER BY descripcion ASC');
                                        $query_cargo->execute();
                                        $cargos = $query_cargo->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($cargos as $cargo) {
                                            $id_cargo = $cargo['id_cargo'];
                                            $cargo = $cargo['descripcion'];
                                            ?>
                                            <option value="<?php echo $id_cargo; ?>"><?php echo $cargo; ?></option>
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
                                <a href="<?php echo $URL."admin/ti_usuarios";?>" class="btn btn-default btn-block">Cancelar</a>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" onclick="return confirm('Seguro de haber diligenciado correctamente los datos?')" class="btn btn-primary btn-block">Registrar Usuario</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div>
</div>
<?php include('../../layout/admin/parte2.php');?>
