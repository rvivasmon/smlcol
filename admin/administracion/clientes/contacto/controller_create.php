<?php
include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

$nombre = $_POST['nombre'];
$celular = $_POST['celular'];
$telefono = $_POST['telefono'];
$posible_cliente = $_POST['posible_cliente'];
$tipo_contacto = $_POST['tipo_contacto'];
$usuario_crea = $_POST['usuario_crea'];

try {
    // Iniciar transacción
    $pdo->beginTransaction();

    // Insertar el contacto
    $stmt = $pdo->prepare('INSERT INTO contactos (nombre, celular, telefono, tipo_contacto, usuario) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$nombre, $celular, $telefono, $tipo_contacto, $usuario_crea]);

    // Obtener el ID del contacto recién creado
    $contacto_id = $pdo->lastInsertId();

    // Confirmar la transacción
    $pdo->commit();

    // Si el contacto es un posible cliente
    if ($posible_cliente == "Sí") {
        // Crear un formulario para enviar los datos por POST
        echo '
        <form id="form_redirect" action="create_posible_cliente.php" method="POST">
            <input type="hidden" name="contacto_id" value="' . $contacto_id . '">
            <input type="hidden" name="tipo_contacto" value="' . $tipo_contacto . '">
            <input type="hidden" name="nombre" value="' . htmlspecialchars($nombre, ENT_QUOTES) . '">
        </form>
        <script type="text/javascript">
            document.getElementById("form_redirect").submit();
        </script>';
        exit;
    } else {
        // Si no es un posible cliente, redirigir de vuelta a la lista de contactos o a otra página
        header('Location: index.php');
        exit;
    }

} catch (Exception $e) {
    // Si ocurre un error, revertir la transacción
    $pdo->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
