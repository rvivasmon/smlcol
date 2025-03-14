<?php 

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

// Obtener el último contador desde la base de datos
if (isset($_POST['almacen_entra'])) {
    $almacenEntra = $_POST['almacen_entra']; // ID seleccionado en el formulario
    $anioMes = date('Ym'); // Obtener año y mes en formato YYYYMM

    // Consulta para obtener la descripción del almacén
    $queryDesc = $pdo->prepare('SELECT siglas FROM almacenes_grupo WHERE id = :almacenEntra');
    $queryDesc->execute(['almacenEntra' => $almacenEntra]);
    $almacenData = $queryDesc->fetch(PDO::FETCH_ASSOC);

    if (!$almacenData) {
        echo json_encode(['error' => 'Almacén no encontrado']);
        exit;
    }

    $nombreAlmacen = $almacenData['siglas']; // Nombre del almacén en lugar del ID

    // Consulta para obtener el último contador
    $query = $pdo->prepare('
        SELECT consecu_entra 
        FROM movimiento_admon 
        WHERE almacen_destino1 = :almacenEntra 
        ORDER BY consecu_entra DESC 
        LIMIT 1
    ');
    $query->execute(['almacenEntra' => $almacenEntra]);
    $resultado = $query->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        $ultimoContador = (int)$resultado['consecu_entra']; 
        $nuevoContador = $ultimoContador + 1;
    } else {
        $nuevoContador = 1;
    }

    // Formatear el contador a 3 dígitos (Ejemplo: 001, 002, 010, 100)
    $contadorFormateado = str_pad($nuevoContador, 3, '0', STR_PAD_LEFT);

    // Generar el nuevo ID usando el nombre del almacén en lugar del ID
    $nuevoID = $nombreAlmacen . "-" . $anioMes . $contadorFormateado;

    // Devolver la respuesta en formato JSON
    echo json_encode([
        'id_generado12' => $nuevoID,
        'contador_entra' => $contadorFormateado
    ]);
}


    ?>