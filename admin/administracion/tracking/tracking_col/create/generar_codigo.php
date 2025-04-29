<?php 

include('../../../../../app/config/config.php');
include('../../../../../app/config/conexion.php');

try {
    if (!isset($_POST['solicitante']) || empty($_POST['solicitante'])) {
        throw new Exception("Error: No se recibió el solicitante.");
    }

    $solicitante_id = $_POST['solicitante'];

    // Obtener las siglas del solicitante
    $query_siglas = $pdo->prepare('SELECT siglas FROM almacenes_grupo WHERE id = :solicitante_id');
    $query_siglas->execute(['solicitante_id' => $solicitante_id]);
    $solicitante_siglas = $query_siglas->fetchColumn();

    if (!$solicitante_siglas) {
        throw new Exception("Error: Solicitante no encontrado.");
    }

    // Obtener año y mes actual (YYYYMM)
    $ano_mes = date('Ym');

    // Obtener el último contador para este solicitante y mes
    $query = $pdo->prepare('SELECT contador_colombia FROM tracking 
                            WHERE solicitante = :solicitante_id AND ano_mes = :ano_mes 
                            ORDER BY contador_colombia DESC LIMIT 1');

    $query->execute([
        'solicitante_id' => $solicitante_id,
        'ano_mes' => $ano_mes
    ]);

    $ultimoContador = $query->fetchColumn();
    $nuevoContador = ($ultimoContador !== false) ? $ultimoContador + 1 : 1;

    // Formatear el contador con ceros a la izquierda
    $contadorFormateado = str_pad($nuevoContador, 3, '0', STR_PAD_LEFT);

    // Generar código final
    $codigoFinal = "{$solicitante_siglas}-SMC-{$ano_mes}-{$contadorFormateado}";

    // Enviar respuesta en formato JSON
    echo json_encode([
        'codigo' => $codigoFinal,
        'contador' => $nuevoContador,
        'ano_mes' => $ano_mes
    ]);

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

?>
