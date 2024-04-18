<?php 

function setFlashData($indice, $valor)
{
    $_SESSION[$indice] = $valor;
}

function getFlashData($indice){
    if(isset($_SESSION[$indice])){
        $valor = $_SESSION[$indice];
        unset($_SESSION[$indice]);
        return $valor;
    }
    return null;
}

function redirect($url){
    
    header("Location: $url");
    exit;

}