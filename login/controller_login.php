<?php 
include('../app/config/config.php');
include('../app/config/conexion.php');

session_start();

include_once('funcs/funcs.php');

$codigoVerificacion = $_SESSION['codigo_verificacion'] ?? '';

$correo = $_POST['correo'] ?? '';
$password = $_POST['password'] ?? '';
$captcha1 = $_POST['captcha'] ?? '';
$imagen_presionada = $_POST['imagen_presionada'] ?? ''; // Obtenemos la imagen presionada

if (empty($correo) || empty($password) || empty($captcha1)) {
    setFlashData('error', 'Debe llenar todos los datos');
    redirect('index.php');
}

$captcha = sha1($captcha1);

if ($codigoVerificacion !== $captcha) {
    $_SESSION['codigo_verificacion'] = '';
    setFlashData('error', 'El código de verificación es incorrecto');
    redirect('index.php');
}

$query_login = $pdo->prepare("SELECT * FROM usuarios WHERE email = :correo AND estado = '1'");
$query_login->bindParam(':correo', $correo);
$query_login->execute();

$usuario = $query_login->fetch(PDO::FETCH_ASSOC);

if ($usuario === false) {
    header('Location: ' . $URL . 'login/error.php');
} else {
    if (password_verify($password, $usuario['contraseña'])) {
        $_SESSION['sesion_email'] = $correo;
        
        if ($usuario['primera_vez'] == 1) {
            // Redirigir a la página de cambio de contraseña
            header('Location: ' . $URL . 'login/change_password.php');
        } else {
            // Redireccionar según la imagen presionada
            if ($imagen_presionada === 'smlnegro') {
                header('Location: ' . $URL . 'admin/');
            } elseif ($imagen_presionada === 'techled') {
                header('Location: ' . $URL . 'admin_techled/index_techled.php');
            }
        }
    } else {
        header('Location: ' . $URL . 'login/error.php');
    }
}
?>
