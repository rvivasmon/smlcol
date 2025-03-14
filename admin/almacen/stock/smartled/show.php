<?php 

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');

include('../../../../layout/admin/parte1.php');

$id_get = $_GET['id'];

$query = $pdo->prepare("SELECT
                                mvd.*,
                                productomovido.tipo_producto AS nombre_producto,
                                almacen_origen.nombre_almacen AS almacen_origen,
                                almacen_destino.nombre_almacen AS almacen_destino,
                                sub_almacen.sub_almacen AS nombre_sub_almacen,
                                CASE
                                WHEN mvd.tipo_producto = 1 THEN pitch_table.pitch -- Aquí se une la tabla tabla_pitch
                                WHEN mvd.tipo_producto = 2 THEN caraccon.marca_control
                                WHEN mvd.tipo_producto = 3 THEN caracfue.marca_fuente
                                ELSE NULL
                                END AS nombre_referencia_1,
                                CASE
                                WHEN mvd.tipo_producto = 1 THEN tmc.serie
                                WHEN mvd.tipo_producto = 2 THEN refecon.referencia
                                WHEN mvd.tipo_producto = 3 THEN refefue.modelo_fuente
                                ELSE NULL
                                END AS nombre_referencia_2
                                FROM
                                movimiento_diario AS mvd
                                INNER JOIN
                                t_productos AS productomovido ON mvd.tipo_producto = productomovido.id_producto
                                LEFT JOIN
                                t_asignar_todos_almacenes AS almacen_origen ON mvd.almacen_origen1 = almacen_origen.id_asignacion
                                LEFT JOIN
                                t_asignar_todos_almacenes AS almacen_destino ON mvd.almacen_destino1 = almacen_destino.id_asignacion


                                LEFT JOIN
                                tabla_pitch AS tp ON mvd.referencia_2 = tp.id AND mvd.tipo_producto = 1
                                LEFT JOIN
                                referencias_control AS refecon ON mvd.referencia_2 = refecon.id_referencia AND mvd.tipo_producto = 2
                                LEFT JOIN
                                referencias_fuente AS refefue ON mvd.referencia_2 = refefue.id_referencias_fuentes AND mvd.tipo_producto = 3

                                LEFT JOIN
                                producto_modulo_creado AS tmc ON mvd.referencia_2 = tmc.id AND mvd.tipo_producto = 1
                                LEFT JOIN
                                caracteristicas_control AS caraccon ON refecon.marca = caraccon.id_car_ctrl AND mvd.tipo_producto = 2
                                LEFT JOIN
                                caracteristicas_fuentes AS caracfue ON refefue.marca_fuente = caracfue.id_car_fuen AND mvd.tipo_producto = 3
                                LEFT JOIN
                                tabla_pitch AS pitch_table ON tmc.pitch = pitch_table.id
                                LEFT JOIN
                                t_sub_almacen AS sub_almacen ON mvd.sub_almacen = sub_almacen.id
                                WHERE
                                    id_movimiento_diario = :id_movimiento_diario
                                ");
$query->execute(['id_movimiento_diario' => $id_get]);
$usuarios = $query->fetchAll(PDO::FETCH_ASSOC);
foreach ($usuarios as $usuario){
    $id = $usuario['id_movimiento_diario'];
    $fecha = $usuario['fecha'];
    $producto = $usuario['nombre_producto'];
    $referencia = $usuario['nombre_referencia_2'];
    $origen = $usuario['almacen_origen'];
    $cantidad = $usuario['cantidad_entrada'];
    $observaciones = $usuario['observaciones'];
    $op = $usuario['op'];
    $sub_almacen = $usuario['nombre_sub_almacen'];
    $usuario = $usuario['id_usuario'];
}

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Mostrar Movimiento Diario</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card card-info">
                <div class="card-header">
                    Introduzca la información correspondiente
                </div>
                <div class="card-body">
                    <form action="controller_edit.php" method="post">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="fecha">Fecha</label>
                                    <input type="date" name="fecha" id="fecha" value="<?php echo $fecha;?>" class="form-control" placeholder="Nombre Completo" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="producto">Producto</label>
                                    <input type="text" name="producto" id="producto" value="<?php echo $producto;?>" class="form-control" placeholder="Usuario" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="referencia">Referencia</label>
                                    <input type="text" name="referencia" id="referencia" value="<?php echo $referencia;?>" class="form-control" placeholder="Email" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="cantidad">Cantidad</label>
                                    <input type="text" name="cantidad" id="cantidad" value="<?php echo $cantidad;?>" class="form-control" placeholder="Email" readonly>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="origen">Origen</label>
                                    <input type="text" name="origen" id="origen" value="<?php echo $origen;?>" class="form-control" placeholder="Email" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="op">OC / STOCK</label>
                                    <input type="text" name="op" id="op" value="<?php echo $op;?>" class="form-control" placeholder="Email" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="sub_almacen">Sub Almacén</label>
                                    <input type="text" name="sub_almacen" id="sub_almacen" value="<?php echo $sub_almacen;?>" class="form-control" placeholder="Email" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="observacion">Observaciones</label>
                                    <textarea name="observacion" id="observacion" class="form-control" rows="4" cols="50" readonly><?php echo $observaciones; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-2">
                                <a href="<?php echo $URL."admin/almacen/stock/smartled"; ?>" class="btn btn-default btn-block">Volver</a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div>
</div>

<?php include('../../../../layout/admin/parte2.php');?>