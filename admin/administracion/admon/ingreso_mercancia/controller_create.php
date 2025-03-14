<?php
include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');
include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');


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
        $fecha = $_POST['fecha'];
        $contador_entra = $_POST['contador_entra'] ?? null;
        $almacen_salida_md = $_POST['almacen_salida_md'];
        $almacen_entrada_md = $_POST['almacen_entra'];
        $usuario = $_POST['idusuario'];
        $bodega = $_POST['bodega'];
        $sub_almacen = $_POST['sub_almacen'];
        $id_generado = $_POST['id_generado12'] ?? null;

        // 2️⃣ CAPTURAR EL ARRAY DE ITEMS
        if (!empty($_POST['item_data'])) {
            $items = json_decode($_POST['item_data'], true); // Convertir JSON a array

            // Preparar la consulta de inserción
            $sql = "INSERT INTO movimiento_admon 
                    (fecha, consecu_entra, almacen_origen1, almacen_destino1, id_usuario, 
                    bodega, sub_almacen, tipo_producto, referencia_2, 
                    cantidad_entrada, observaciones, id_entrada) 
                    VALUES (:fecha, :contador_entra, :almacen_salida_md, :almacen_entrada_md, 
                            :usuario, :bodega, :sub_almacen, :producto, :referencia_21, 
                            :cantidad_entrada_md, :justificacion, :id_generado)";
            $stmt = $pdo->prepare($sql);

            // 3️⃣ Insertar cada producto con los datos fijos
            foreach ($items as $item) {
                // Determinar referencia_21
                $referencia_21 = !empty($item['id_serie_modulo']) ? $item['id_serie_modulo'] : 
                                (!empty($item['referencia_control35']) ? $item['referencia_control35'] : 
                                $item['modelo_fuente35']);

                $stmt->execute([
                    ':fecha' => $fecha,
                    ':contador_entra' => $contador_entra,
                    ':almacen_salida_md' => $almacen_salida_md,
                    ':almacen_entrada_md' => $almacen_entrada_md,
                    ':usuario' => $usuario,
                    ':bodega' => $bodega,
                    ':sub_almacen' => $sub_almacen,
                    ':producto' => $item['producto'],
                    ':referencia_21' => $referencia_21, // Aquí se asigna la referencia correcta
                    ':cantidad_entrada_md' => $item['cantidad_entrada_md'],
                    ':justificacion' => $item['justificacion'],
                    ':id_generado' => $id_generado
                ]);
            }
        }

        $pdo->commit(); // Confirmar la transacción

        header('Location: ' . $URL . 'admin/administracion/admon/ingreso_mercancia'); // Redireccionar con éxito
        exit();
    } catch (Exception $e) {
        $pdo->rollBack(); // Revertir cambios en caso de error
        die("Error al guardar los datos: " . $e->getMessage());
    }
}
?>
