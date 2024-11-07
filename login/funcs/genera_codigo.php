<?php 

session_start();

$codigo = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 0, 6);
$ancho = 150;
$alto = 50;
$fuente = realpath('../font/Consolas.ttf');
$tamanioFuente = 30;    

$_SESSION['codigo_verificacion'] = sha1($codigo);

$imagen = imagecreatetruecolor($ancho, $alto);
$colorFondo = imagecolorallocate($imagen, 255, 255, 255);
imagefill($imagen, 0, 0, $colorFondo);

$colorText = imagecolorallocate($imagen, 50, 50, 50);
$colorSecundario = imagecolorallocate($imagen,  0, 0, 128);

for ($i = 0; $i < 1; $i++) {
    imageline($imagen, 0, rand(0, $alto), $ancho, rand(0, $alto), $colorSecundario);
}

for ($i = 0; $i < 100; $i++) {
    imagesetpixel($imagen, rand(0, $ancho), rand(0, $alto), $colorSecundario);
}


imagettftext($imagen, $tamanioFuente, -5, 10, 35, $colorText, $fuente, $codigo);

header('Content-Type: image/png');

imagepng($imagen);

imagedestroy($imagen);