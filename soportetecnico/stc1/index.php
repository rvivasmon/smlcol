<?php 

include('../app/config/config.php');
include('../app/config/conexion.php');

include('../layout/admin/sesion.php');
include('../layout/admin/datos_sesion_user.php');

?>

<?php include('../layout/admin/parte1.php');?>

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Bienvenido</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="row">
          <div class="col-md-4"></div>
          <div class="col-md-4">
          <table class="table table-hover table-bordered table-striped" style="background-color: #fff">
              <thead>
                <tr>
                  <th scope="col">Nombre</th>
                  <td scope="col"><?php echo $sesion_nombre?></td>
                </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">Email</th>
                    <td><?php echo $sesion_email?></td>
                  </tr>
                  <tr>
                    <th scope="row">ID Cargo</th>
                    <td><?php echo $sesion_cargo?></td>
                  </tr>
                  <tr>
                    <th scope="row">Estado</th>
                    <td><?php echo $sesion_estado?></td>
                  </tr>
                </tbody>
            </table>
          </div>
          <div class="col-md-4"></div>
        </div>
      </div><!-- /.container-fluid -->
    </div>
  </div>

<?php include('../layout/admin/parte2.php');?>