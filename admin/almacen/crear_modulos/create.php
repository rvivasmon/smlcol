<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

include('../../../layout/admin/parte1.php');

$usuario = $sesion_usuario['nombre'];

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Crear Nuevo Modulo</h1>
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
                                    <label for="categoria">CATEGORÍA</label>
                                    <select name="categoria" id="categoria" class="form-control">
                                        <option value="" disabled selected>Seleccione una Catergoría</option>
                                        <?php
                                        $query_categoria = $pdo->prepare('SELECT * FROM t_uso_productos WHERE categoria_productos = "1" ORDER BY producto_uso ASC');
                                        $query_categoria->execute();
                                        $categorias = $query_categoria->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($categorias as $categoria) {
                                            $id = $categoria['id_uso'];
                                            $nombre_categoria = $categoria['producto_uso'];
                                        ?>
                                        <option value="<?php echo $id; ?>"><?php echo $nombre_categoria; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="pitch">PITCH</label>
                                    <select name="pitch" id="pitch" class="form-control">
                                    <option value="" disabled selected>Seleccione un Pitch</option>
                                        <?php
                                        $query_pitch = $pdo->prepare('SELECT * FROM tabla_pitch ORDER BY pitch ASC');
                                        $query_pitch->execute();
                                        $pitches = $query_pitch->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($pitches as $pitch) {
                                            $id = $pitch['id'];
                                            $nombre_pitch = $pitch['pitch'];
                                        ?>
                                        <option value="<?php echo $id; ?>"><?php echo $nombre_pitch; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="sub">SUB. CATEGORÍA</label>
                                    <select name="sub" id="sub" class="form-control">
                                        <option value="" disabled selected>Seleccione una Sub</option>
                                        <?php
                                        $query_sub = $pdo->prepare('SELECT * FROM t_tipo_producto ORDER BY tipo_producto21 ASC');
                                        $query_sub->execute();
                                        $subs  = $query_sub->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($subs as $sub) {
                                            $id = $sub['id'];
                                            $nombre_sub = $sub['tipo_producto21'];
                                        ?>
                                        <option value="<?php echo $id; ?>"><?php echo $nombre_sub; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tipo">TIPO</label>
                                    <select name="tipo" id="tipo" class="form-control">
                                        <option value="" disabled selected>Seleccione un Tipo</option>
                                        <?php
                                        $query_tipo = $pdo->prepare('SELECT * FROM tabla_tipo_modulo ORDER BY tipo ASC');
                                        $query_tipo->execute();
                                        $tipos = $query_tipo->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($tipos as $tipo) {
                                            $id = $tipo['id'];
                                            $nombre_tipo = $tipo['tipo'];
                                        ?>
                                        <option value="<?php echo $id; ?>"><?php echo $nombre_tipo; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="medidas">MEDIDAS</label>
                                    <select name="medidas" id="medidas" class="form-control">
                                        <option value="" disabled selected>Seleccione una Medida</option>
                                        <?php
                                        $query_tamano = $pdo->prepare('SELECT * FROM tabla_tamanos_modulos ORDER BY tamanos_modulos ASC');
                                        $query_tamano->execute();
                                        $tamanos = $query_tamano->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($tamanos as $tamano) {
                                            $id = $tamano['id'];
                                            $nombre_tamano = $tamano['tamanos_modulos'];
                                        ?>
                                        <option value="<?php echo $id; ?>"><?php echo $nombre_tamano; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="nits">NITS</label>
                                    <select name="nits" id="nits" class="form-control" required>
                                        <option value="" disabled selected>Seleccione un Nits</option>
                                        <?php
                                        $query_nit = $pdo->prepare('SELECT * FROM tabla_nits_refresh ORDER BY nits ASC');
                                        $query_nit->execute();
                                        $nits = $query_nit->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($nits as $nit) {
                                            $id = $nit['id'];
                                            $nombre_nit = $nit['nits'];
                                        ?>
                                        <option value="<?php echo $id; ?>"><?php echo $nombre_nit; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="refresh">REFRESH</label>
                                    <select name="refresh" id="refresh" class="form-control">
                                        <option value="" disabled selected>Seleccione una Tasa de Refresh</option>
                                        <?php
                                        $query_refresh = $pdo->prepare('SELECT * FROM tabla_nits_refresh WHERE refresh IS NOT NULL AND refresh != "" ORDER BY refresh ASC');
                                        $query_refresh->execute();
                                        $refreshes = $query_refresh->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($refreshes as $refresh) {
                                            $id = $refresh['id'];
                                            $nombre_refresh = $refresh['refresh'];
                                        ?>
                                        <option value="<?php echo $id; ?>"><?php echo $nombre_refresh; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="standard">Es Standard?</label>
                                    <select name="standard" id="standard" class="form-control">
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
                                <a href="<?php echo $URL."admin/almacen/crear_modulos/";?>" class="btn btn-default btn-block">Cancelar</a>
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

<?php include('../../../layout/admin/parte2.php');?>