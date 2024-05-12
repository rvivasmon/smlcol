<?php 

include('../app/config/config.php');
include('../app/config/conexion.php');

include('../layout/admin/sesion.php');
include('../layout/admin/datos_sesion_user.php');

include('controller_index.php');

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
          <div class="col-md-3">
          <table class="table table-hover table-bordered table-striped" style="background-color: #fff">
              <thead>
                <tr>
                  <th scope="col">Nombre</th>
                  <td scope="col" class="align-middle"><?php echo $sesion_nombre?></td>
                </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">Email</th>
                    <td class="align-middle"><?php echo $sesion_email?></td>
                  </tr>
                  <tr>
                    <th scope="row">ID Cargo</th>
                    <td class="align-middle"><?php echo $sesion_cargo?></td>
                  </tr>
                  <tr>
                    <th scope="row">Estado</th>
                    <td class="align-middle"><?php echo $sesion_estado?></td>
                  </tr>
                </tbody>
            </table>
          </div>
          <div class="col-md-4"></div>
        </div>
      </div><!-- /.container-fluid -->
      
      
      
        <div class="row">



          <div class="col-lg-2 col-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <?php 
                $contador_de_usuarios = 0; 
                foreach ($usuarios_datos as $usuario_dato){
                    $contador_de_usuarios = $contador_de_usuarios + 1;
                }
                ?>
                <h3><?php echo $contador_de_usuarios; ?></h3>
                <p>Usuarios Registrados</p>
              </div>
              <a href="<?php echo $URL; ?>admin/ti_usuarios/create.php">
                <div class="icon">
                  <i class="fas fa-user-plus"></i>
                </div>
              </a>
                <a href="<?php echo $URL; ?>admin/ti_usuarios" class="small-box-footer">
                Más Información <i class="fas fa-arrow-circle-right"></i>
                </a>  
            </div>
          </div>

          <div class="col-lg-2 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <?php 
                $contador_de_usuarios = 0; 
                foreach ($usuarios_datos as $usuario_dato){
                    $contador_de_usuarios = $contador_de_usuarios + 1;
                }
                ?>
                <h3><?php echo $contador_de_usuarios; ?></h3>
                <p>Usuarios Registrados</p>
              </div>
              <a href="<?php echo $URL; ?>admin/ti_usuarios/create.php">
                <div class="icon">
                  <i class="fas fa-user-plus"></i>
                </div>
              </a>
                <a href="<?php echo $URL; ?>admin/ti_usuarios" class="small-box-footer">
                Más Información <i class="fas fa-arrow-circle-right"></i>
                </a>  
            </div>
          </div>

          <div class="col-lg-2 col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <?php 
                $contador_de_usuarios = 0; 
                foreach ($usuarios_datos as $usuario_dato){
                    $contador_de_usuarios = $contador_de_usuarios + 1;
                }
                ?>
                <h3><?php echo $contador_de_usuarios; ?></h3>
                <p>Usuarios Registrados</p>
              </div>
              <a href="<?php echo $URL; ?>admin/ti_usuarios/create.php">
                <div class="icon">
                  <i class="fas fa-user-plus"></i>
                </div>
              </a>
                <a href="<?php echo $URL; ?>admin/ti_usuarios" class="small-box-footer">
                Más Información <i class="fas fa-arrow-circle-right"></i>
                </a>  
            </div>
          </div>



        </div>

    </div>
  </div>

<?php include('../layout/admin/parte2.php');?>