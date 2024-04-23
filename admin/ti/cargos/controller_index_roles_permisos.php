<?php

// Verifica si se han recibido los parámetros 'rol_id' y 'permiso_id' en la solicitud GET
if(isset($_GET['rol_id']) && isset($_GET['permiso_id'])) {
    // Asigna el valor de 'rol_id' y 'permiso_id' a las variables correspondientes
    $rol_id = $_GET['rol_id'];
    $permiso_id = $_GET['permiso_id'];
    // Imprime los valores de 'rol_id' y 'permiso_id'
    echo "Rol ID: " . $rol_id . "<br>";
    echo "Permiso ID: " . $permiso_id;
} else {
    // Si alguno de los parámetros no está definido, muestra un mensaje de error
    echo "Los parámetros 'rol_id' y 'permiso_id' no están definidos en la solicitud GET.";
}
?>
