<?php 

include('../app/config/config.php');
include('../app/config/conexion.php');

session_start();

include('funcs/funcs.php');

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
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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
            <a class="h1"><b>SIGCP</b> - 2024 <small style="font-size: 35px;"><b>TECHLED</b> Group</small> <small style="font-size: 13px;">Versión 1.2</small> </a>
          </div>
          <div class="card-body">

            <form action="controller_login.php" method="post" id="loginForm">
              <input type="hidden" name="imagen_presionada" id="imagen_presionada" value="">
                  <center>
                    <div style="display: flex; align-items: center;">
                      <a id="" class="">
                        <img src="<?php echo $URL?>/public/images/smlnegro.png" style= "width: 150px; margin-right: 20px;" alt="">
                      </a>
                      <a id="img" class="img">
                        <img src="<?php echo $URL?>/public/images/techled.png" style="width: 150px" alt="">
                      </a>
                    </div>
                  </center>

              <br>

              <?php 
                if($mensaje = getFlashData('error')) {
              ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                  <?php echo $mensaje; ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              <?php } ?>

              <label for="correo">Correo Electrónico</label>
                <div class="input-group mb-3">
                  <input type="email" class="form-control" id="correo" name="correo" placeholder="Email" value="">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                      </div>
                    </div>
                </div>

              <label for="password">Contraseña</label>
                <div class="input-group mb-3">
                  <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                      </div>
                    </div>
                </div>

                <div>
                  <div class="form-group">
                    <a href="" class="btn btn-default btn-block">Cancelar</a>
                    <button type="submit" class= "btn btn-primary btn-block">Ingresar</button>
                  </div>        
                </div>

            </form>

          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.login-box -->

      <!-- jQuery -->
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <!-- Bootstrap 4 -->
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
      <!-- AdminLTE App -->
      <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

      <script>

        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("correo").value = "";
            document.getElementById("password").value = "";
        });

        const imgCodigo = document.getElementById('img-codigo');
        const btnGenera = document.getElementById('regenera');
        const imgLinks = document.querySelectorAll('.img-link');

        const correo = document.getElementById('correo');
        const password = document.getElementById('password');
        const captcha = document.getElementById('captcha');

        btnGenera.addEventListener('click', generaCodigo, false);

        function generaCodigo() {
          let url = 'funcs/genera_codigo.php';

          fetch(url)
          .then(response => response.blob())
          .then(data => {
            if (data) {
              imgCodigo.src = URL.createObjectURL(data);
            }
          });
        }

        function checkFields() {
          const correoValido = correo.value.trim() !== "";
          const passwordValido = password.value.trim() !== "";
          const captchaValido = captcha.value.trim() !== "";

          if (correoValido && passwordValido && captchaValido) {
            imgLinks.forEach(link => {
              link.classList.remove('disabled-link');
              link.href = "https://example.com"; // Aquí puedes definir las URLs de destino
            });
          } else {
            imgLinks.forEach(link => {
              link.classList.add('disabled-link');
              link.href = "#";
            });
          }
        }

        document.querySelectorAll('#correo, #password, #captcha').forEach(input => {
          input.addEventListener('input', checkFields);
        });

        // Inicia con los links deshabilitados
        checkFields();
      </script>

      <style>
        .disabled-link {
          pointer-events: none;
          opacity: 0.6;
        }
      </style>

    </body>
  </html>
