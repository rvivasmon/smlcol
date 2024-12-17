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
                    <h1 class="m-0">Crear Permiso Menú</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card card-blue">
                        <div class="card-header">
                            Introduzca la información correspondiente
                        </div>
                        <div class="card-body">
    <form method="POST" action="asignar_permisos.php">
        <!-- Selección de rol -->
        <div class="form-group">
            <label for="rol">Selecciona un rol:</label>
            <select name="rol_id" id="rol" class="form-control">
                <?php
                // Consulta todos los roles
                $roles = $pdo->prepare("SELECT id, nombre FROM menu_roles");
                $roles->execute(); // Asegúrate de ejecutar la consulta antes de usar fetchAll
                foreach ($roles->fetchAll(PDO::FETCH_ASSOC) as $row) {
                    echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
                }
                ?>
            </select>
        </div>

        <!-- Selección de permisos -->
        <div class="form-group" id="permisos">
            <label for="permisos">Selecciona permisos:</label>
            <div>
                <?php
                // Consulta todos los permisos
                $permisos = $pdo->prepare("SELECT id, nombre FROM menu_permisos");
                $permisos->execute(); // Ejecuta la consulta antes de usar fetchAll
                foreach ($permisos->fetchAll(PDO::FETCH_ASSOC) as $row) {
                    echo "
                    <div class='form-check'>
                        <input type='checkbox' class='form-check-input' name='permisos[]' value='{$row['id']}' id='permiso_{$row['id']}'>
                        <label class='form-check-label' for='permiso_{$row['id']}'>{$row['nombre']}</label>
                    </div>";
                }
                ?>
            </div>
        </div>

        <!-- Botón de envío -->
        <button type="submit" class="btn btn-primary">Guardar Permisos</button>
    </form>
</div>

                    </div>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div>
</div>
<?php include('../../../layout/admin/parte2.php');?>
