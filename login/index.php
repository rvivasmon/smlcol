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
            <a href="../../index2.html" class="h1"><b>SIGCP</b> - 2024 <small style="font-size: 35px;"><b>TECHLED</b> Group</small> <small style="font-size: 13px;">Versión 1.2</small> </a>
          </div>
          <div class="card-body">

            <form action="controller_login.php" method="post" id="loginForm">
              <input type="hidden" name="imagen_presionada" id="imagen_presionada" value="">
                  <center>
                    <div style="display: flex; align-items: center;">
                      <a href="#" id="img1-link" class="img-link disabled-link">
                        <img src="<?php echo $URL?>/public/images/smlnegro.png" style= "width: 150px; margin-right: 20px;" alt="">
                      </a>
                      <a href="#" id="img2-link" class="img-link disabled-link">
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
                  <input type="email" class="form-control" id="correo" name="correo" placeholder="Email">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                      </div>
                    </div>
                </div>

              <label for="password">Contraseña</label>
                <div class="input-group mb-3">
                  <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                      </div>
                    </div>
                </div>

              <label for="captcha">Captcha</label>
                <div class="input-group mb-3">
                  <input type="password" class="form-control" id="captcha" name="captcha" placeholder="Captcha">
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
                    <a href="" class="btn btn-default btn-block">Cancelar</a>
                    <!-- <button type="submit" class= "btn btn-primary btn-block">Ingresar</button> -->
                  </div>        
                </div>

            </form>

            <script>
              const img1Link = document.getElementById('img1-link');
              const img2Link = document.getElementById('img2-link');
              const imagenPresionadaInput = document.getElementById('imagen_presionada');
              const loginForm = document.getElementById('loginForm');

              img1Link.addEventListener('click', function(e) {
                e.preventDefault();
                imagenPresionadaInput.value = 'smlnegro';
                loginForm.submit();
              });

              img2Link.addEventListener('click', function(e) {
                e.preventDefault();
                imagenPresionadaInput.value = 'techled';
                loginForm.submit();
              });
            </script>

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
