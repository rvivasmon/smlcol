<?php 

include('../app/config/config.php');
include('../app/config/conexion.php');

include('../layout/admin/sesion.php');
include('../layout/admin/datos_sesion_user.php');

session_start();
if (isset($_SESSION['sesion_email'])) {
    session_destroy();
    header('Location: '.$URL.'login/');
}else{

}

