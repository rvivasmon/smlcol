<?php
include('../../../../../app/config/config.php');
include('../../../../../app/config/conexion.php');
include('../../../../../layout/admin/sesion.php');
include('../../../../../layout/admin/datos_sesion_user.php');

/*/COODIGO PARA VISUALIZAR LO QUE LLEGA AL CONTROLLER POR METODO POST

echo "<pre>";
print_r($_POST);
echo "</pre>";
exit;
*/

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $pdo->beginTransaction(); // Iniciar la transacción

        // 1️⃣ CAPTURAR LOS DATOS FIJOS DEL FORMULARIO
        $fecha_ingreso = $_POST['fecha_ingreso'] ?? null;
        $solicitante = $_POST['solicitante'] ?? null;
        $ano_mes = $_POST['ano_mes'] ?? null;
        $codigo_generado = $_POST['codigo_generado'] ?? null;
        $contador_colombia = $_POST['contador'] ?? null;
        $usuario_operador = $_POST['idUsuario'] ?? null;
        $fecha_oc = $_POST['fecha_oc'] ?? null;
        $origen = $_POST['origen'] ?? null;
        $origen_cliente = $_POST['origen_cliente'] ?? null;

        // 2️⃣ CAPTURAR EL ARRAY DE ITEMS
        if (!empty($_POST['item_data'])) {
            $items = json_decode($_POST['item_data'], true); // Convertir JSON a array asociativo

            // Verificar si el JSON se decodificó correctamente
            if (!is_array($items)) {
                throw new Exception("Error al decodificar los datos de los productos.");
            }

            // Preparar la consulta de inserción
            $sql = "INSERT INTO tracking (date, solicitante, codigo_generado, contador_colombia, fecha_oc, origen, origen_cliente, ano_mes, usuario, producto, cantidad, uso, pitch, modelo_nombre, category, x_mm, y_mm, resol_x, resol_y, pixel_modulo, marca_control, ref_control, marca_fuente, modelo_fuente, observaciones_colombia)
                    VALUES (:fecha_ingreso, :solicitante, :codigo_generado, :contador_colombia, :fecha_oc, :origen, :origen_cliente, :ano_mes, :usuario_operador, :producto, :cantidad, :uso, :pitch, :modelo_nombre, :modelo, :x_mm, :y_mm, :resol_x, :resol_y, :pixel_modulo, :marca_control, :referencia_control35, :marca_fuente, :modelo_fuente35, :obscolombia)";
            
            $stmt = $pdo->prepare($sql);

            // 3️⃣ Insertar cada producto con los datos fijos
            foreach ($items as $item) {
                $stmt->execute([
                    ':fecha_ingreso' => $fecha_ingreso,
                    ':solicitante' => $solicitante,
                    ':codigo_generado' => $codigo_generado,
                    ':contador_colombia' => $contador_colombia,
                    ':fecha_oc' => $fecha_oc,
                    ':origen' => $origen,
                    ':origen_cliente' => $origen_cliente,
                    ':ano_mes' => $ano_mes,
                    ':usuario_operador' => $usuario_operador,
                    ':producto' => $item['producto'] ?? null,
                    ':cantidad' => $item['cantidad_entrada_md'] ?? null,
                    ':uso' => $item['uso'] ?? null,
                    ':pitch' => $item['pitch'] ?? null,
                    ':modelo_nombre' => $item['modeloNombre'] ?? null,
                    ':modelo' => $item['modelo'] ?? null,
                    ':x_mm' => $item['x_mm'] ?? null,
                    ':y_mm' => $item['y_mm'] ?? null,
                    ':resol_x' => $item['resol_x'] ?? null,
                    ':resol_y' => $item['resol_y'] ?? null,
                    ':pixel_modulo' => $item['pixel_modulo'] ?? null,
                    ':marca_control' => $item['marca_control'] ?? null,
                    ':referencia_control35' => $item['referencia_control35'] ?? null,
                    ':marca_fuente' => $item['marca_fuente'] ?? null,
                    ':modelo_fuente35' => $item['modelo_fuente35'] ?? null,
                    ':obscolombia' => $item['justificacion'] ?? null
                ]);
            }
        }

        $pdo->commit(); // Confirmar la transacción

        header('Location: ' . $URL . 'admin/administracion/tracking/tracking_col'); // Redireccionar con éxito
        exit();
    } catch (Exception $e) {
        $pdo->rollBack(); // Revertir cambios en caso de error
        die("Error al guardar los datos: " . $e->getMessage());
    }
}
?>
