<?php 
include('../app/config/config.php');
include('../app/config/conexion.php');
session_start();
include_once('funcs/funcs.php');

if (!isset($_SESSION['sesion_email'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    if ($new_password == $confirm_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $correo = $_SESSION['sesion_email'];
        
        $query_update = $pdo->prepare("UPDATE usuarios SET contraseña = :new_password, primera_vez = 0 WHERE email = :correo");
        $query_update->bindParam(':new_password', $hashed_password);
        $query_update->bindParam(':correo', $correo);
        $query_update->execute();
        
        // Redirigir al panel de administración
        header('Location: ' . $URL . 'admin/');
    } else {
        $error = "Las contraseñas no coinciden.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cambiar Contraseña</title>
    <link rel="stylesheet" href="<?php echo $URL?>/public/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?php echo $URL?>/public/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $URL?>/public/dist/css/adminlte.min.css">
    <link rel="icon" type="image/ico" href="../public/images/Logo.png">
</head>

<body class="hold-transition login-page">
<div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="../../index2.html" class="h1"><b>Cambiar </b>Contraseña</a>
        </div>
        <div class="card-body">
            <?php if (isset($error)) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <?php echo $error; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } ?>
            <form action="change_password.php" method="post">
                <label for="new_password">Nueva Contraseña</label>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="new_password" placeholder="Nueva Contraseña" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <label for="confirm_password">Confirmar Nueva Contraseña</label>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="confirm_password" placeholder="Confirmar Nueva Contraseña" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Cambiar Contraseña</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?php echo $URL?>/public/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo $URL?>/public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo $URL?>/public/dist/js/adminlte.min.js"></script>
</body>
</html>
