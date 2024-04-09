<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

include('../../../layout/admin/parte1.php');

$id_get = $_GET['id'];

$query = $pdo->prepare("SELECT usuarios.*, cargo.descripcion AS nombre_cargo, estado.estado_general AS nombre_estado FROM usuarios JOIN cargo ON usuarios.id_cargo = cargo.id_cargo JOIN estado ON usuarios.estado = estado.id WHERE usuarios.id = '$id_get'");

$query->execute();
$usuarios = $query->fetchAll(PDO::FETCH_ASSOC);
foreach ($usuarios as $usuario){
    $id = $usuario['id'];
    $nombres = $usuario['nombre'];
    $correos = $usuario['email'];
    $usuario_uso = $usuario['usuario'];
    $cargo = $usuario['nombre_cargo'];
    $estado = $usuario['nombre_estado'];
    $valor_actual_en_edicion = $usuario['estado'];

}

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edición Usuario</h1>

                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card">
                <div class="card-header" style="background-color: #00A000; color: #ffffff">
                    Introduzca la información correspondiente
                </div>
                <div class="card-body">
                    <form action="controller_edit.php" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Nombre</label>
                                    <input type="text" name="nombre" value="<?php echo $nombres;?>" class="form-control" placeholder="Nombre Completo" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Correo Electrónico</label>
                                    <input type="text" name="email" value="<?php echo $correos;?>" class="form-control" placeholder="Email" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Usuario</label>
                                    <input type="text" name="usuario" value="<?php echo $usuario_uso;?>" class="form-control" placeholder="Usuario">
                                    <input type="text" name="id_usuario" value="<?php echo $id_get;?>" hidden>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Cargo</label>
                                    <select name="id_cargo" id="id_cargo" class="form-control" required>
                                        
                                        <?php
                                        $query_cargo = $pdo->prepare('SELECT * FROM cargo');
                                        $query_cargo->execute();
                                        $cargos = $query_cargo->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($cargos as $cargo) {

                                            $id_cargo = $cargo['id_cargo'];
                                            $cargo_descripcion = $cargo['descripcion'];
                                            $selected = ($id_cargo == $valor_actual_en_edicion) ? 'selected' : '';
                                            ?>
                                            <option value="<?php echo $id_cargo; ?>" <?php echo $selected; ?>><?php echo $cargo_descripcion; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Estado</label>
                                    <select name="id_estado" id="id_estado" class="form-control" required>
                                        
                                    <?php
                                        $query_estado = $pdo->prepare('SELECT * FROM estado');
                                        $query_estado->execute();
                                        $estados = $query_estado->fetchAll(PDO::FETCH_ASSOC);
                                        
                                        foreach($estados as $estado) {
                                            $id_estado = $estado['id'];
                                            $estado_descripcion = $estado['estado_general'];
                                            if(!empty($estado_descripcion)) { // Verifica si el estado tiene datos antes de mostrarlo
                                            $selected = ($id_estado == $valor_actual_en_edicion) ? 'selected' : '';
                                            ?>
                                            <option value="<?php echo $id_estado; ?>" <?php echo $selected; ?>><?php echo $estado_descripcion; ?></option>
                                        <?php
                                        }
                                    }
                                    ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-2">
                                <a href="<?php echo $URL."admin/ti/cargos/index.php";?>" class="btn btn-default btn-block">Cancelar</a>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" onclick="return confirm('Asegurese de diligenciar correctamente los datos')" class="btn btn-success btn-block">Actualizar Usuario</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div>
</div>
<?php include('../../../layout/admin/parte2.php');?>
