<?php 
$db_server = "localhost";
$db_user = "TIadmin";
$db_pass = "";
$db_name = "bd_sigcp_2024";
$db_port = 3306;


// Crear conexión
$conn=mysqli_connect($db_server,$db_user,$db_pass,$db_name,$db_port);

// Verificar conexión
if ($conn) {
    echo "Conexión Exitosa";
} else {
    echo "Conexión Fallida: " . mysqli_connect_error();
}
?>