<?php
include('../../app/config/config.php');  // Asegúrate de incluir el archivo de configuración para conectar a la base de datos
include('../../app/config/conexion.php');  // Asegúrate de incluir el archivo de conexión a la base de datos

// Procesar la solicitud AJAX
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["fecha"])) {
    // Obtener la fecha del POST
    $fecha = $_POST["fecha"];
    
    // Obtener el año y mes de la fecha en formato YYYYMM
    $anio_mes = date('Ym', strtotime($fecha));
    
    // Obtener el último registro de la base de datos ordenado por año_mes de forma descendente
    $query_ultimo_registro = $pdo->prepare('SELECT * FROM id_producto WHERE anio_mes_prod = :anio_mes ORDER BY contador_prod DESC LIMIT 1');
    $query_ultimo_registro->bindParam(':anio_mes', $anio_mes);
    $query_ultimo_registro->execute();
    $ultimo_registro_prod = $query_ultimo_registro->fetch(PDO::FETCH_ASSOC);
    
    // Determinar el contador
    if ($ultimo_registro_prod) {
        // Si hay un último registro, continuar con el contador
        $nuevoContador = $ultimo_registro_prod['contador_prod'] + 1;
    } else {
        // Si no hay ningún registro para este año y mes, inicializar el contador en 1
        $nuevoContador = 1;
    }

    // Devolver el nuevo contador como respuesta
    echo $nuevoContador;
} else {
    // Si la solicitud no es POST o falta la fecha, devolver un mensaje de error
    echo "Error: Datos de solicitud incorrectos.";
}
?>
