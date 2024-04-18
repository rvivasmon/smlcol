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

  <style>



  </style>
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

      <form action="controller_login.php" method="post">
      
      <label for="">Correo Electrónico</label>
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="correo" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

      <label for="">Contraseña</label>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        
      <label for="">Captcha</label>
        <div class="input-group mb-3">
          <input type="captcha" class="form-control" name="captcha" placeholder="Captcha">
            <div class="input-group-append">
              <div class="input-group-text">
                <div class="mb-3">
                  <img src="funcs/genera_codigo.php" alt="Código de Verificación" id="img-codigo">
                  &nbsp;
                  <button type="button" class="btn btn-secondary btn-sm" id="regenera">+</button>
                  &nbsp;
                  Generar nuevo
                </div>
              </div>
            </div>
        </div>

        <div>        
          <div class="form-group">
            <a href="" class="btn btn-default btn-block">Cancelar</a>
            <button type="submit" class= "btn btn-primary btn-block">Ingresar</button>
          </div>        
        </div>

        <!--
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!- /.col 
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!- /.col 
        </div> -->
      </form>

      <!--
      <div class="social-auth-links text-center mt-2 mb-3">
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div>
      <!- /.social-auth-links 

      <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p> -->
    </div>
    <!-- /.card-body -->
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

<script>
  const imgCodigo = document.getElementById('img-codigo')
  const btnGenera = document.getElementById('regenera')
  btnGenera.addEventListener('click', generaCodigo, false)

  function generaCodigo(){
    let url = 'funcs/genera_codigo.php'

    fetch(url)
    .then(response => response.blob())
    .then(data => {
      if(data){
        imgCodigo.src = URL.createObjectURL(data)
      }
    })
  }
</script>
</body>
</html>
