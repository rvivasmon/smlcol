<?php
include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

// Obtener valores de los campos del formulario
$oci_oc = $_POST['oci_oc'] ?? '';
$sml_psi_tl = $_POST['sml_psi_tl'] ?? '';

// Verificar si la combinación existe
$query = $pdo->prepare('SELECT contador FROM oc WHERE oc = :oci_oc AND tipo_oc = :sml_psi_tl ORDER BY contador DESC LIMIT 1');
$query->bindParam(':oci_oc', $oci_oc, PDO::PARAM_STR);
$query->bindParam(':sml_psi_tl', $sml_psi_tl, PDO::PARAM_STR);
$query->execute();

$result = $query->fetch(PDO::FETCH_ASSOC);

if ($result) {
    // Si existe, incrementa el contador
    $new_counter = $result['contador'] + 1;
} else {
    // Si no existe, comienza el contador en 1
    $new_counter = 1;
}

// Devuelve el nuevo contador
echo $new_counter;
