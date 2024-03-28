<?php

// Conexión a la base de datos
include 'db.php';


// Función para obtener el año y el mes actual
function obtenerFechaActual() {
    $fechaActual = date('Y-m');
    return $fechaActual;
}

// Función para obtener el último consecutivo del mes actual
function obtenerUltimoConsecutivo($conn, $fechaActual) {
    $sql = "SERLECT MAX(consecutivo) AS ultimo_consecutivo
            FROM id_producto
            WHERE fecha_creacion LIKE '$fechaActual%'";
    $resultado = mysqli_query($conn, $sql);
    $fila = mysqli_fetch_assoc($resultado);
    $ultimoConsecutivo = $fila['ultimo_consecutivo'];
    return $ultimoConsecutivo;
}

// Función para generar el ID
function generarID($prefijo, $fechaActual, $ultimoConsecutivo) {
    $consecutivo = str_pad($ultimoConsecutivo + 1, 3, '0', STR_PAD_LEFT);
    $id = $prefijo . '-' . $fechaActual . $consecutivo;
    return $id;
}

// Obtener la fecha actual
$fechaActual = obtenerFechaActual();

// Obtener el último consecutivo del mes actual
$ultimoConsecutivo = obtenerUltimoConsecutivo($conn, $fechaActual);

// Generar ID
$id = generarID('STC', $fechaActual, $ultimoConsecutivo);

// Ejemplo de uso
echo "El ID generado es: $id";

// Cerrarla conexión a la base de datos
mysqli_close($conn);

?>