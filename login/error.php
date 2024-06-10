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
      <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/css/bootstrap.min.css" rel="stylesheet">
      <!-- Theme style -->
      <link href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css" rel="stylesheet">
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

            <label for="captcha">Captcha</label>
              <div class="input-group mb-3">
                <input type="password" class="form-control" name="captcha" placeholder="Captcha">
                  <div class="input-group-append">
                    <div class="input-group-text">                
                      <img src="funcs/genera_codigo.php" alt="Código de Verificación" id="img-codigo">
                        &nbsp;
                          <button type="button" class="btn btn-secondary btn-sm" id="regenera">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                              <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41m-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9"/>
                              <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5 5 0 0 0 8 3M3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9z"/>
                            </svg>
                          </button>
                        &nbsp;
                        Generar nuevo                
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

      </div>
      <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="<?php echo $URL?>/public/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    </body>

  </html>
