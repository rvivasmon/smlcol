<?php 

$passwordform ="204163ZJ";

echo password_hash($passwordform, PASSWORD_DEFAULT).'<br>';

$passwordbd = password_hash($passwordform, PASSWORD_DEFAULT);


if (password_verify($passwordform, $passwordbd)) {
    echo "Password correcto";
}else{
    echo "Password incorrecto";
}

?>