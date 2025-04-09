<?php
include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');

/*
print_r($_POST);
exit();
*/

try {
  // Validar que ID sea numérico y no esté vacío
  $id = filter_input(INPUT_POST, 'id_tracking', FILTER_VALIDATE_INT);
  if (!$id) {
      throw new Exception("ID no válido o ausente.");
  }

    // Obtener los valores actuales del registro
  $sql_select = "SELECT * FROM tracking WHERE id = :id";
  $sentencia_select = $pdo->prepare($sql_select);
  $sentencia_select->execute(['id' => $id]);
  $datos_actuales = $sentencia_select->fetch(PDO::FETCH_ASSOC);

  // Sanitización de datos
  $date = isset($_POST['date']) ? htmlspecialchars($_POST['date'], ENT_QUOTES, 'UTF-8') : $datos_actuales['date'];
  $solicitante = isset($_POST['solicitante']) ? htmlspecialchars($_POST['solicitante'], ENT_QUOTES, 'UTF-8') : $datos_actuales['solicitante'];
  $codigo_generado = isset($_POST['codigo_generado']) ? htmlspecialchars($_POST['codigo_generado'], ENT_QUOTES, 'UTF-8') : $datos_actuales['codigo_generado'];
  $fecha_oc = isset($_POST['fecha_oc']) ? htmlspecialchars($_POST['fecha_oc'], ENT_QUOTES, 'UTF-8') : $datos_actuales['fecha_oc'];
  $origen = isset($_POST['origen']) ? htmlspecialchars($_POST['origen'], ENT_QUOTES, 'UTF-8') : $datos_actuales['origen'];
  $producto = isset($_POST['producto']) ? htmlspecialchars($_POST['producto'], ENT_QUOTES, 'UTF-8') : $datos_actuales['producto'];
  $origen_cliente = isset($_POST['origen_cliente']) ? htmlspecialchars($_POST['origen_cliente'], ENT_QUOTES, 'UTF-8') : $datos_actuales['origen_cliente'];
  $uso = isset($_POST['uso']) ? htmlspecialchars($_POST['uso'], ENT_QUOTES, 'UTF-8') : $datos_actuales['uso'];
  $pitch = isset($_POST['pitch']) ? htmlspecialchars($_POST['pitch'], ENT_QUOTES, 'UTF-8') : $datos_actuales['pitch'];
  $modelo_nombre = isset($_POST['modelo_nombre']) ? htmlspecialchars($_POST['modelo_nombre'], ENT_QUOTES, 'UTF-8') : $datos_actuales['modelo_nombre'];
  $category = isset($_POST['modelo']) ? htmlspecialchars($_POST['modelo'], ENT_QUOTES, 'UTF-8') : $datos_actuales['modelo'];
  $x_mm = isset($_POST['x_mm']) ? htmlspecialchars($_POST['x_mm'], ENT_QUOTES, 'UTF-8') : $datos_actuales['x_mm'];
  $y_mm = isset($_POST['y_mm']) ? htmlspecialchars($_POST['y_mm'], ENT_QUOTES, 'UTF-8') : $datos_actuales['y_mm'];
  $resol_x = isset($_POST['resol_x']) ? htmlspecialchars($_POST['resol_x'], ENT_QUOTES, 'UTF-8') : $datos_actuales['resol_x'];
  $resol_y = isset($_POST['resol_y']) ? htmlspecialchars($_POST['resol_y'], ENT_QUOTES, 'UTF-8') : $datos_actuales['resol_y'];
  $pixel_modulo = isset($_POST['pixel_modulo']) ? htmlspecialchars($_POST['pixel_modulo'], ENT_QUOTES, 'UTF-8') : $datos_actuales['pixel_modulo'];
  $marca_control = isset($_POST['marca_control']) ? htmlspecialchars($_POST['marca_control'], ENT_QUOTES, 'UTF-8') : $datos_actuales['marca_control'];
  $ref_control = isset($_POST['referencia_control35']) ? htmlspecialchars($_POST['referencia_control35'], ENT_QUOTES, 'UTF-8') : $datos_actuales['referencia_control35'];
  $marca_fuente = isset($_POST['marca_fuente']) ? htmlspecialchars($_POST['marca_fuente'], ENT_QUOTES, 'UTF-8') : $datos_actuales['marca_fuente'];
  $modelo_fuente = isset($_POST['modelo_fuente35']) ? htmlspecialchars($_POST['modelo_fuente35'], ENT_QUOTES, 'UTF-8') : $datos_actuales['modelo_fuente35'];
  $observaciones_colombia = isset($_POST['observaciones_colombia']) ? htmlspecialchars($_POST['observaciones_colombia'], ENT_QUOTES, 'UTF-8') : $datos_actuales['observaciones_colombia'];
  $smd_encapsulado = isset($_POST['smd_encap']) ? htmlspecialchars($_POST['smd_encap'], ENT_QUOTES, 'UTF-8') : $datos_actuales['smd_encap'];
  $interface_hub = isset($_POST['interface_h']) ? htmlspecialchars($_POST['interface_h'], ENT_QUOTES, 'UTF-8') : $datos_actuales['interface_h'];
  $grupo_datos = isset($_POST['grupo_datos']) ? htmlspecialchars($_POST['grupo_datos'], ENT_QUOTES, 'UTF-8') : $datos_actuales['grupo_datos'];
  $nits_brillo = isset($_POST['nits']) ? htmlspecialchars($_POST['nits'], ENT_QUOTES, 'UTF-8') : $datos_actuales['nits'];
  $corriente_shinkong = isset($_POST['c_shinkong']) ? htmlspecialchars($_POST['c_shinkong'], ENT_QUOTES, 'UTF-8') : $datos_actuales['c_shinkong'];
  $corriente_kinglight = isset($_POST['c_king']) ? htmlspecialchars($_POST['c_king'], ENT_QUOTES, 'UTF-8') : $datos_actuales['c_king'];
  $corriente_nationstar = isset($_POST['c_nation']) ? htmlspecialchars($_POST['c_nation'], ENT_QUOTES, 'UTF-8') : $datos_actuales['c_nation'];
  $consumo_watts = isset($_POST['consumo_watts']) ? htmlspecialchars($_POST['consumo_watts'], ENT_QUOTES, 'UTF-8') : $datos_actuales['consumo_watts'];
  $mls = isset($_POST['mls']) ? htmlspecialchars($_POST['mls'], ENT_QUOTES, 'UTF-8') : $datos_actuales['mls'];
  $ref_alim_5v = isset($_POST['ref_5v']) ? htmlspecialchars($_POST['ref_5v'], ENT_QUOTES, 'UTF-8') : $datos_actuales['ref_5v'];
  $referencia_cable = isset($_POST['refe_cable']) ? htmlspecialchars($_POST['refe_cable'], ENT_QUOTES, 'UTF-8') : $datos_actuales['refe_cable'];
  $estan_magnet = isset($_POST['estan_magnet']) ? htmlspecialchars($_POST['estan_magnet'], ENT_QUOTES, 'UTF-8') : $datos_actuales['estan_magnet'];
  $cantidad = isset($_POST['cantidad']) ? htmlspecialchars($_POST['cantidad'], ENT_QUOTES, 'UTF-8') : $datos_actuales['cantidad'];
  $num_mod_5v40a = isset($_POST['num_mod_5v40a']) ? htmlspecialchars($_POST['num_mod_5v40a'], ENT_QUOTES, 'UTF-8') : $datos_actuales['num_mod_5v40a'];
  $num_mod_5v60a = isset($_POST['num_mod_5v60a']) ? htmlspecialchars($_POST['num_mod_5v60a'], ENT_QUOTES, 'UTF-8') : $datos_actuales['num_mod_5v60a'];
  $cantidad_ic_control = isset($_POST['num_ic_control']) ? htmlspecialchars($_POST['num_ic_control'], ENT_QUOTES, 'UTF-8') : $datos_actuales['num_ic_control'];
  

  // Preparar la consulta SQL
  $sql = "UPDATE tracking SET 
      date = :date, 
      solicitante = :solicitante,
      codigo_generado = :codigo_generado,
      fecha_oc = :fecha_oc,
      origen = :origen, 
      origen_cliente = :origen_cliente,
      producto = :producto,
      cantidad = :cantidad,
      uso = :uso,
      pitch = :pitch,
      modelo_nombre = :modelo_nombre,
      category = :category,
      x_mm = :x_mm,
      y_mm = :y_mm,
      resol_x = :resol_x,
      resol_y = :resol_y,
      pixel_modulo = :pixel_modulo,
      marca_control = :marca_control,
      ref_control = :ref_control,
      marca_fuente = :marca_fuente,
      modelo_fuente = :modelo_fuente,
      observaciones_colombia = :observaciones_colombia,
      smd_encapsulado = :smd_encapsulado,
      interface_hub = :interface_hub,
      grupo_datos = :grupo_datos,
      nits_brillo = :nits_brillo,
      corriente_shinkong = :corriente_shinkong,
      corriente_kinglight = :corriente_kinglight,
      corriente_nationstar = :corriente_nationstar,
      num_mod_5v40a = :num_mod_5v40a,
      num_mod_5v60a = :num_mod_5v60a,
      consumo_watts = :consumo_watts,
      cantidad_ic_control = :cantidad_ic_control,
      mls = :mls,
      ref_alim_5v = :ref_alim_5v,
      referencia_cable = :referencia_cable,
      estandar_magnet = :estan_magnet
      WHERE id = :id";

  $sentencia = $pdo->prepare($sql);

  // Definimos los parámetros manualmente para evitar errores
  $params = [
      ':id' => $id,
      ':date' => $date,
      ':solicitante' => $solicitante,
      ':codigo_generado' => $codigo_generado,
      ':fecha_oc' => $fecha_oc,
      ':origen' => $origen,
      ':origen_cliente' => $origen_cliente,
      ':producto' => $producto,
      ':cantidad' => $cantidad,
      ':uso' => $uso,
      ':pitch' => $pitch,
      ':modelo_nombre' => $modelo_nombre,
      ':category' => $category,
      ':x_mm' => $x_mm,
      ':y_mm' => $y_mm,
      ':resol_x' => $resol_x,
      ':resol_y' => $resol_y,
      ':pixel_modulo' => $pixel_modulo,
      ':marca_control' => $marca_control,
      ':ref_control' => $ref_control,
      ':marca_fuente' => $marca_fuente,
      ':modelo_fuente' => $modelo_fuente,
      ':observaciones_colombia' => $observaciones_colombia,
      ':smd_encapsulado' => $smd_encapsulado,
      ':interface_hub' => $interface_hub,
      ':grupo_datos' => $grupo_datos,
      ':nits_brillo' => $nits_brillo,
      ':corriente_shinkong' => $corriente_shinkong,
      ':corriente_kinglight' => $corriente_kinglight,
      ':corriente_nationstar' => $corriente_nationstar,
      ':num_mod_5v40a' => $num_mod_5v40a,
      ':num_mod_5v60a' => $num_mod_5v60a,
      ':consumo_watts' => $consumo_watts,
      ':cantidad_ic_control' => $cantidad_ic_control,
      ':mls' => $mls,
      ':ref_alim_5v' => $ref_alim_5v,
      ':referencia_cable' => $referencia_cable,
      ':estan_magnet' => $estan_magnet
  ];

  $sentencia->execute($params);
  header('Location: ' . $URL . 'admin/administracion/tracking/tracking_col/index.php');
  exit();
} catch (Exception $e) {
  echo "Error: " . $e->getMessage();
}

?>