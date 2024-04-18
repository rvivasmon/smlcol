<?php 

include('../app/config/config.php');
include('../app/config/conexion.php');

session_start();

$codigoVerificacion = isset($_SESSION['codigo_verificacion']) ? $_SESSION['codigo_verificacion'] : '';

$correo =  isset($_POST['correo']) ? $_POST['correo'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$captcha1 = isset($_POST['captcha']) ? $_POST['captcha'] : '';

if($correo == '' || $password == ''){
    echo "Debe llenar todos los datos";
    exit;
}

$captcha = sha1($captcha1);

if($codigoVerificacion != $captcha){
    $_SESSION['codigo_verificacion'] = '';
    echo "Codigo de verificación es incorrecto";
    exit;
}

//echo "El correo del usuario es: ".$correo;
//echo "La contraseña del usuario es: ".$password;

$query_login = $pdo->prepare("SELECT * FROM usuarios WHERE email='$correo' AND estado = '1' ");
$query_login->execute();

$usuarios = $query_login->fetchAll(PDO::FETCH_ASSOC);
$contador = 0;
foreach ($usuarios as $usuario) {
    $contador = $contador + 1;
    $nombre = $usuario['nombre'];
    $password_tb = $usuario['contraseña'];
}
//echo $contador;

if($contador == "0") {
    //echo "Error al ingresar los datos";
    header('Location: '.$URL.'login/error.php');
}else{    
    //echo "Usuario correcto";

    if(password_verify($password, $password_tb)){
        //echo "Usuario correcto";
        session_start();
        $_SESSION['sesion_email'] = $correo;
        header('Location: '.$URL.'admin/');
    }else{
        //echo "Error al ingresar los datos";
        header('Location: '.$URL.'login/error.php');

    }
}

