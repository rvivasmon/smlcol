<?php 

include('../app/config/config.php');
include('../app/config/conexion.php');

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistema SMARTLED COLOMBIA</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo $URL?>/public/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo $URL?>/public/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $URL?>/public/dist/css/adminlte.min.css">
  <!-- Icon Logo -->
  <link rel="icon" type="image/ico" href="../public/images/Logo.png">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="../../index2.html" class="h1"><b>Sis </b>SMLCOL</a>
    </div>
    <div class="card-body">
        <center>
          <img src="<?php echo $URL?>/public/images/smlnegro.png" style= "width: 200px" alt="">
        </center>
        
        <br>

        <div class="alert alert-danger">
            Error al introducir sus datos
        </div>

      <form action="controller_login.php" method="post">
      <label for="email">Correo Electrónico</label>
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="correo" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <label for="password">Contraseña</label>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div>
        
        <div class="form-group">
          <a href="#" class="btn btn-default btn-block">Cancelar</a>
          <button type="submit" class= "btn btn-primary btn-block">Ingresar</button>
        </div>
        
        </div>

      </form>

  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?php echo $URL?>/public/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo $URL?>/public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $URL?>/public/dist/js/adminlte.min.js"></script>
</body>
</html>
