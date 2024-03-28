<?php 
ini_set('display_errores', 1);
error_reporting(E_ALL);

include('db.php');

$nombre=$_POST['txtNombre'];
$usuario=$_POST['txtUsuario'];
$contraseña=$_POST['txtContraseña'];
$tipousuario=$_POST['txtTipoUsuario'];

$consulta="INSERT INTO `usuarios` (`nombre`, `usuario`, `contraseña`, `id_cargo`)
VALUES ('$nombre', '$usuario', '$contraseña', '$tipousuario')";

$resultado=mysqli_query($conn,$consulta) or die("error de registro");

echo "registro exitoso";

mysqli_close($conn);

?>