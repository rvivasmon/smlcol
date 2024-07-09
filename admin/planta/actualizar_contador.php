<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["fecha"])) {
    $fecha = $_POST["fecha"];
    $anio_mes = date('Ym', strtotime($fecha));
    $query_ultimo_registro = $pdo->prepare('SELECT * FROM id_producto WHERE anio_mes_prod = :anio_mes ORDER BY contador_prod DESC LIMIT 1');
    $query_ultimo_registro->bindParam(':anio_mes', $anio_mes);
    $query_ultimo_registro->execute();
    $ultimo_registro_prod = $query_ultimo_registro->fetch(PDO::FETCH_ASSOC);
    $nuevoContador = $ultimo_registro_prod ? $ultimo_registro_prod['contador_prod'] + 1 : 1;
    echo $nuevoContador;
} else {
    echo "Error: Datos de solicitud incorrectos.";
}
?>