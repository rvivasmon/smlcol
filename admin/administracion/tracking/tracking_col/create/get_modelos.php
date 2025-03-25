<?php
include('../../../../../app/config/config.php');
include('../../../../../app/config/conexion.php');

if (isset($_POST['uso'])) {
    try {
        $uso = $_POST['uso'];

        $query = "SELECT DISTINCT t.id, t.modelo_modulo 
                  FROM producto_modulo_creado p
                  JOIN t_tipo_producto t ON p.modelo = t.id
                  WHERE p.uso = :uso";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":uso", $uso);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo '<option value=""></option>';
        foreach ($result as $row) {
            echo '<option value="' . $row['id'] . '">' . $row['modelo_modulo'] . '</option>';
        }
    } catch (PDOException $e) {
        echo '<option value="">Error en la consulta: ' . $e->getMessage() . '</option>';
    }
}
?>
