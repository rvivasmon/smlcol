<?php
session_start();
if (isset($_SESSION['sesion_email'])) {
    //echo "Existe sesión, y ha pasado por el Login";
    $email_sesion = $_SESSION['sesion_email'];
}else{
    //echo "No existe sesión porque no ha pasado por el Login";
    header('Location: '.$URL.'login/'); 
}

