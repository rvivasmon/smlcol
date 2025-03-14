<?php 

include('../../../../../app/config/config.php');
include('../../../../../app/config/conexion.php');

if (isset($_POST['solicitante'])) {
    $solicitante_id = $_POST['solicitante'];

    // Obtener las siglas del solicitante usando su ID
    $query_siglas = $pdo->prepare('SELECT siglas FROM almacenes_grupo WHERE id = :solicitante_id');
    $query_siglas->execute(['solicitante_id' => $solicitante_id]);
    $result_siglas = $query_siglas->fetch(PDO::FETCH_ASSOC);

    if (!$result_siglas) {
        echo "Error: Solicitante no encontrado.";
        exit;
    }

    $solicitante_siglas = $result_siglas['siglas']; // Obtener las siglas

    // Obtener el año y mes actual en formato YYYYMM
    $ano_mes = date('Ym');

    // Buscar en la base de datos si ya existe un registro con este solicitante (origin) y este año-mes
    $query = $pdo->prepare('SELECT contador_colombia FROM tracking 
                            WHERE origin = :solicitante_id AND ano_mes = :ano_mes 
                            ORDER BY contador_colombia DESC LIMIT 1');

    $query->execute([
        'solicitante_id' => $solicitante_id,
        'ano_mes' => $ano_mes
    ]);
    
    $resultado = $query->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        // Si existe un registro para este mes y solicitante, incrementar el contador
        $nuevoContador = $resultado['contador_colombia'] + 1;
    } else {
        // Si no hay registros para este mes y solicitante, iniciar en 1
        $nuevoContador = 1;
    }

    // Formatear el contador con ceros a la izquierda (3 dígitos)
    $contadorFormateado = str_pad($nuevoContador, 3, '0', STR_PAD_LEFT);

    // Generar el código final en formato SIGLAS-YYYYMM-0001
    $codigoFinal = $solicitante_siglas . '-' . $ano_mes . '-' . $contadorFormateado;

    echo $codigoFinal;
} else {
    echo "Error: No se recibió el solicitante.";
}
?>
