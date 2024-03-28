<?php 
// Incluir archivo de conexión
include 'db.php';

// Verificar si se envió el formulario con el metodo POST
if ($_SERVER['REQUEST_METHOD'] == "POST") { 
    $nombre = $_POST["nombre_comercial"]; // Asumiendo que el input tiene el name="nombres"
    $razon = $_POST["razon_social"];
    $email = $_POST["email"];
    $telefono = $_POST["telefono"];
    $contacto = $_POST["contacto"];
    $nit = $_POST["nit"];
    $direccion = $_POST["direccion"];
    $ciudad = $_POST["ciudad"]; 
    $departamento = $_POST["departamento"];
    $pais = $_POST["pais"];

    // Obtener la fecha y la hora actual
    $fechaHoraActual = date("Y-m-d H:i:s");

    // Preparar la consulta SQL para insertar los datos en la tabla CREACIÓN CLIENTE
    // Aquí se insertaerá los datos en las columna nombre, razón ...
    $sql = "INSERT INTO clientes (nombre_comercial, razon_social, email, telefono, contacto, nit, direccion, ciudad, departamento, pais, CREATED_AT, UPDATED_AT) values ('$nombre', '$razon', '$email', '$telefono', '$contacto', '$nit', '$direccion', '$ciudad', '$departamento', '$pais', '$fechaHoraActual', '$fechaHoraActual')";

    // Ejecutar la consulta
    if (mysqli_query($conn, $sql)) {
        echo "Datos ingresados exitosamente.";
    } else { 
        echo "Error al ingresar datos: " . mysqli_error($conn);
    }

    // Cerrar conexión
    mysqli_close($conn);
} else {
    echo "Acceso denegado.";
}
