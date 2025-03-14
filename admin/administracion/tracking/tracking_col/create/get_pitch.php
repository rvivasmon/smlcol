<?php
include('../../../../../app/config/config.php');
include('../../../../../app/config/conexion.php');

if (isset($_POST['modelo'])) {
    try {
        $modelo = $_POST['modelo'];

        $query = "SELECT DISTINCT tp.id, tp.pitch 
                  FROM producto_modulo_creado p
                  JOIN tabla_pitch tp ON p.pitch = tp.id
                  WHERE p.modelo = :modelo";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":modelo", $modelo, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo '<option value="">Seleccione un pitch</option>';
        foreach ($result as $row) {
            echo '<option value="' . $row['id'] . '">' . $row['pitch'] . '</option>';
        }
    } catch (PDOException $e) {
        echo '<option value="">Error en la consulta: ' . $e->getMessage() . '</option>';
    }
}
?>
