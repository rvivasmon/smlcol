<?php
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

if (isset($_POST['oci_oc']) && isset($_POST['sml_psi_tl'])) {
    $oci_oc = $_POST['oci_oc'];
    $sml_psi_tl = $_POST['sml_psi_tl'];

    // Verificar si la combinación existe en la tabla "oc"
    $query = $pdo->prepare('SELECT contador FROM oc WHERE oc = :oci_oc AND tipo_oc = :sml_psi_tl ORDER BY contador DESC LIMIT 1');
    $query->bindParam(':oci_oc', $oci_oc, PDO::PARAM_STR);
    $query->bindParam(':sml_psi_tl', $sml_psi_tl, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // Si existe, incrementar el contador
        $new_counter = $result['contador'] + 1;
    } else {
        // Si no existe, comenzar el contador en 1
        $new_counter = 1;
    }

    // Actualizar el contador en la base de datos
    $updateQuery = $pdo->prepare('INSERT INTO oc (oc, tipo_oc, contador) VALUES (:oci_oc, :sml_psi_tl, :contador) ON DUPLICATE KEY UPDATE contador = :contador');
    $updateQuery->bindParam(':oci_oc', $oci_oc, PDO::PARAM_STR);
    $updateQuery->bindParam(':sml_psi_tl', $sml_psi_tl, PDO::PARAM_STR);
    $updateQuery->bindParam(':contador', $new_counter, PDO::PARAM_INT);
    $updateQuery->execute();

    // Devolver el nuevo número de factura al cliente
    echo str_pad($new_counter, 3, '0', STR_PAD_LEFT) . ' - ' . date('Ymd');
}
?>
