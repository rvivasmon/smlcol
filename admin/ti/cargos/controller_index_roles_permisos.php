<?php

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');


$id_rol = $_GET['rol_id'];
$permiso_id = $_GET['permiso_id'];


$sql = "INSERT INTO roles_permisos (rol_id, permiso_id) VALUES (:rol_id, :permiso_id)";

$sentencia = $pdo->prepare($sql);

$sentencia->bindParam(':rol_id', $id_rol);
$sentencia->bindParam(':permiso_id', $permiso_id);


$sentencia->execute();


?>

<div class="row">

<table class="table table-bordered table-sm table-striped table-hover" id="tabla_res<?=$id_rol;?>">
<tr>
    <th style="text-align: center; background-color: goldenrod">Nro</th>
    <th style="text-align: center; background-color: goldenrod">Rol</th>
    <th style="text-align: center; background-color: goldenrod">Permiso</th>
    <th style="text-align: center; background-color: goldenrod">Acción</th>
</tr>
<?php
$contador2 = 0;
$sql_roles_permisos = "SELECT * FROM roles_permisos AS rolper INNER JOIN permisos AS per ON per.id_permisos = rolper.permiso_id INNER JOIN cargo AS rol ON rol.id_cargo = rolper.rol_id WHERE rolper.estado = '1' ORDER BY per.nombre_url ASC";
$query_roles_permisos = $pdo->prepare($sql_roles_permisos);
$query_roles_permisos-> execute();
$roles_permisos = $query_roles_permisos->fetchAll(PDO::FETCH_ASSOC);

foreach ($roles_permisos as $rol_permiso) {
if($id_rol == $rol_permiso['rol_id']) {
    $id_rol_permiso = $rol_permiso['id_rol_permiso'];
    $contador2 = $contador2 + 1;
?>
    <tr>
        <td><center><?=$contador2;?></center></td>
        <td><center><?=$rol_permiso['descripcion'];?></center></td>
        <td><?=$rol_permiso['nombre_url'];?></td>
        <a href="delete.php?id=<?php echo $id_rol; ?>" class="btn btn-danger btn-sm">Borrar <i class="fas fa-trash"></i></a>
    </tr>
<?php
    }
    }
    ?>
</table>

</div>
