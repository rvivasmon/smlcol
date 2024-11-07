<?php 
include('../app/config/config.php');
include('../app/config/conexion.php');

session_start();

include_once('funcs/funcs.php');

// Obtener los datos enviados desde el formulario
$correo = $_POST['correo'] ?? '';
$password = $_POST['password'] ?? '';

// Validar que los campos de correo y contraseña no estén vacíos
if (empty($correo) || empty($password)) {
    setFlashData('error', 'Debe llenar todos los datos');
    redirect('index.php');
}

// Buscar al usuario en la base de datos
$query_login = $pdo->prepare("SELECT * FROM usuarios WHERE email = :correo AND estado = '1'");
$query_login->bindParam(':correo', $correo);
$query_login->execute();

$usuario = $query_login->fetch(PDO::FETCH_ASSOC);

// Verificar si el usuario existe
if ($usuario === false) {
    header('Location: ' . $URL . 'login/error.php');
} else {
    // Verificar si la contraseña es correcta
    if (password_verify($password, $usuario['contraseña'])) {
        $_SESSION['sesion_email'] = $correo;

        // Redirigir si es la primera vez que inicia sesión
        if ($usuario['primera_vez'] == 1) {
            header('Location: ' . $URL . 'login/change_password.php');
        } else {

            header('Location: ' . $URL . 'admin/');

        }
    } else {
        header('Location: ' . $URL . 'login/error.php');
    }
}
?>
