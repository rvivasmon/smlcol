<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');


$fecha_ingreso = $_POST['fechaingreso'];
$nombre_comercial = $_POST['nombrecomercial'];
$razon_social = $_POST['razonsocial'];
$clase_cliente = $_POST['clasecliente'];
$siglas_cliente = $_POST['siglascliente'];
$celular = $_POST['celular'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];
$celular = $_POST['celular'];
$persona_contacto = $_POST['personacontacto'];
$nit = $_POST['nit'];
$web = $_POST['web'];
$direccion = $_POST['direccion'];
$ciudad = $_POST['ciudad'];
$departamento = $_POST['departamento'];
$pais = $_POST['pais'];
$usuariocliente = $_POST['usuariocliente'];


$sql = "INSERT INTO clientes (fecha, nombre_comercial, razon_social, clase_cliente, siglas_cliente, celular, email, telefono, contacto, nit, web, direccion, ciudad, departamento, pais, id_usuario) VALUES (:fecha_ingreso, :nombre_comercial, :razon_social, :clase_cliente, :siglas_cliente, :celular, :email, :telefono, :contacto, :nit, :web, :direccion, :ciudad, :departamento, :pais, :usuariocliente)";


$sentencia = $pdo->prepare($sql);

$sentencia->bindParam(':fecha_ingreso', $fecha_ingreso);
$sentencia->bindParam(':nombre_comercial', $nombre_comercial);
$sentencia->bindParam(':razon_social', $razon_social);
$sentencia->bindParam(':clase_cliente', $clase_cliente);
$sentencia->bindParam(':siglas_cliente', $siglas_cliente);
$sentencia->bindParam(':celular', $celular);
$sentencia->bindParam(':telefono', $telefono);
$sentencia->bindParam(':email', $email);
$sentencia->bindParam(':contacto', $contacto);
$sentencia->bindParam(':nit', $nit);
$sentencia->bindParam(':web', $web);
$sentencia->bindParam(':direccion', $direccion);
$sentencia->bindParam(':ciudad', $ciudad);
$sentencia->bindParam(':departamento', $departamento);
$sentencia->bindParam(':pais', $pais);
$sentencia->bindParam(':usuariocliente', $usuariocliente);


if($sentencia->execute()){
//echo "¡Usuario creado exitosamente!"; // O maneja el mensaje/logica de éxito
header('Location:' .$URL. 'admin/administracion/clientes/index_clientes.php');
session_start();
$_SESSION['msj'] = "Se ha registrado el usuario de manera correcta";
}else{
    session_start();
$_SESSION['msj'] = "Error al introducir la información";
    //echo 'Error en las contraseñas, no son iguales';
}

