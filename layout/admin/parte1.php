<?php 

$email_sesion = $_SESSION['sesion_email'];


  $query_sesion = $pdo->prepare("SELECT * FROM usuarios as usu INNER JOIN cargo as rol ON rol.id_cargo = usu.id_cargo WHERE usu.email = '$email_sesion' AND usu.estado = '1'");

  $query_sesion->execute();

  $datos_sesion_usuarios = $query_sesion->fetchAll(PDO::FETCH_ASSOC);
  foreach ($datos_sesion_usuarios as $dato_sesion_usuario);
    $nombre_sesion_usuario = $dato_sesion_usuario['email'];
    $id_rol_sesion_usuario = $dato_sesion_usuario['id_cargo'];
    $rol_sesion_usuario = $dato_sesion_usuario['descripcion'];
    $nombres_sesion_usuario = $dato_sesion_usuario['nombre'];


$url = $_SERVER["PHP_SELF"];
$conta = strlen($url);
$rest = substr($url, 15, $conta);


$sql_roles_permisos = "SELECT * FROM roles_permisos AS rolper INNER JOIN t_permisos AS per ON per.id_permisos = rolper.permiso_id INNER JOIN cargo AS rol ON rol.id_cargo = rolper.rol_id WHERE rolper.estado = '1' ";

$query_roles_permisos = $pdo->prepare($sql_roles_permisos);
$query_roles_permisos-> execute();
$roles_permisos = $query_roles_permisos->fetchAll(PDO::FETCH_ASSOC);
$contadorpermiso = 0;

foreach ($roles_permisos as $rol_permiso) {
  if($id_rol_sesion_usuario == $rol_permiso['rol_id']) {
    //echo $rol_permiso['url'];

      if($rest == $rol_permiso['url']) {
        //echo "Permiso autorizado - ";
        $contadorpermiso = $contadorpermiso + 1;
      }else{
        //echo "Permiso no autorizado - ";
    }
  }
}

  if($contadorpermiso>0){
    //echo "Ruta autorizada";
  }else{
    //echo "Usuario no autorizado";
    //header('Location:'.$URL."admin/no-autorizado.php");
  }

?>


<!DOCTYPE html>
  <html lang="es">

    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>SMARTLED</title>
      
      <!-- Google Fonts -->
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
      
      <!-- Font Awesome -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
      
      <!-- AdminLTE -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
      
      <!-- DataTables -->
      <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap4.min.css">
      <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
      <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css">

      <!-- jsPDF -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>

      
      <!-- Icon Logo -->
      <link rel="icon" type="image/png" href="/favicon.png">
      
      <!-- Main CSS -->
      <link rel="stylesheet" href="css/main.css">
      <!-- Style QR-->
      <link rel="stylesheet" href="css/styles.css">

      
    </head>

    <body class="hold-transition sidebar-mini layout-fixed" style="height: auto;">
      <div class="wrapper">
        <div class="preloader flex-column justify-content-center align-items-center" style="height: 0px">

        </div>
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
          <!-- Left navbar links -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
              <a class="nav-link">SMARTLED COLOMBIA</a>
            </li>
          </ul>
          <!-- Right navbar links -->
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
          <!-- Brand Logo -->
          <a href="<?php echo $URL?>/admin" class="brand-link">
            <img src="<?php echo $URL?>/public/dist/img/smlblancoovalado.png" alt="SML Logo" class="brand-image img-circle elevation-3" style="opacity: 1.9">
            <span class="brand-text font-weight-light">SML Col</span> 
          </a>

          <!-- Sidebar -->
          <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                <img src="<?php echo $URL?>/public/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
              </div>
              <div class="info">
                <a href="#" class="d-block"><?php echo $sesion_usuario['nombre']?></a>
              </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->

                    <?php 
                      if( ($id_rol_sesion_usuario=="7") || ($id_rol_sesion_usuario=="14") ){ ?>

                        <li class="nav-item">
                          <a href="#" class="nav-link active">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                              ADMINISTRACIÓN
                              <i class="right fas fa-angle-left"></i>
                            </p>
                          </a>
                          <ul class="nav nav-treeview">
                            <li class="nav-item">
                              <a href="<?php echo $URL;?>admin/administracion/oc/" class="nav-link">
                                <i class="fas fa-cog nav-icon"></i>
                                <p>ORDEN DE COMPRA INTERNA</p>
                              </a>
                            </li>
                            <li class="nav-item">
                              <a href="<?php echo $URL;?>admin/administracion/tracking/tracking_col/index_tracking.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>COMPRA TECHLED</p>
                              </a>
                            </li>
                            <li class="nav-item">
                              <a href="<?php echo $URL;?>admin/administracion/tecnicos/index_tecnicos.php" class="nav-link">
                                <i class="fas fa-cog nav-icon"></i>
                                <p>TÉCNICOS</p>
                              </a>
                            </li>
                            <li class="nav-item">
                              <a href="<?php echo $URL;?>admin/administracion/clientes/index_clientes.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>LISTA CLIENTES</p>
                              </a>
                            </li>
                            <li class="nav-item">
                              <a href="<?php echo $URL;?>admin/administracion/vehiculos" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>VEHÍCULOS</p>
                              </a>
                            </li>
                          </ul>
                        </li>

                    <?php
                      }
                    ?>

                    <?php
                      if( ($id_rol_sesion_usuario=="7") || ($id_rol_sesion_usuario=="14") || ($id_rol_sesion_usuario=="15") ){ ?>

                    <?php
                        // Ejemplo de generación dinámica de submenús para Consulta Stock

                        // Ejemplo de datos simulados (reemplaza con tu lógica de datos real)
                        $almacenes = array(
                          array('id' => 3, 'nombre' => 'Almacén Principal'),
                          array('id' => 4, 'nombre' => 'Almacén Techled'),
                          array('id' => 5, 'nombre' => 'Almacén Importación'),
                          array('id' => 6, 'nombre' => 'Almacén Técnica'),
                          array('id' => 7, 'nombre' => 'Almacén Planta'),
                          array('id' => 8, 'nombre' => 'Almacén Pruebas'),
                          array('id' => 9, 'nombre' => 'Almacén Desechados'),
                          array('id' => 10, 'nombre' => 'Almacén Soporte Técnico'),
                          array('id' => 11, 'nombre' => 'Almacén Aliados'),
                          array('id' => 12, 'nombre' => 'Almacén General'),
                          // Agregar más almacenes según necesites
                        );

                        $productos = array(
                          array('id' => 6, 'nombre' => 'General'),
                          // Agregar más productos según necesites
                        );
                      ?>

                        <li class="nav-item">
                          <a href="#" class="nav-link active">
                            <i class="fa-solid fa-warehouse"></i>
                            <p>
                              ALMACÉN
                              <i class="right fas fa-angle-left"></i>
                            </p>
                          </a>
                          <ul class="nav nav-treeview">
                            <li class="nav-item">
                              <a href="#" class="nav-link">
                                <i class="fas fa-box-open nav-icon"></i>
                                  <p>Consulta Stock</p>
                              </a>
                              <ul class="nav nav-treeview">
                                  <?php foreach ($almacenes as $almacen): ?>
                                      <li class="nav-item">
                                          <a href="#" class="nav-link">
                                              <i class="nav-icon fas fa-circle"></i>
                                              <p><?php echo $almacen['nombre']; ?></p>
                                          </a>
                                          <ul class="nav nav-treeview">
                                              <?php foreach ($productos as $producto): ?>
                                                  <?php
                                                  // Definir variables para las URL por defecto
                                                  $url_producto = "#"; // URL por defecto si no se cumple ninguna condición
                                                  // Condiciones para las direcciones específicas
                                                  if ($almacen['id'] == 3) {
                                                      if ($producto['id'] == 1) {
                                                          $url_producto = $URL . "admin/almacen/inventario/principal/index_modulos.php";
                                                      } elseif ($producto['id'] == 2) {
                                                          $url_producto = $URL . "admin/almacen/inventario/principal/index_control.php";
                                                      } elseif ($producto['id'] == 3) {
                                                          $url_producto = $URL . "admin/almacen/inventario/principal/index_fuentes.php";
                                                      } elseif ($producto['id'] == 6) {
                                                        $url_producto = $URL . "admin/almacen/inventario/principal/index.php";
                                                    }
                                                      // Agregar más condiciones según sea necesario
                                                  } elseif ($almacen['id'] == 4) {
                                                    if ($producto['id'] == 1) {
                                                      $url_producto = $URL . "admin/almacen/inventario/index_modulos.php";
                                                  } elseif ($producto['id'] == 2) {
                                                      $url_producto = $URL . "admin/almacen/inventario/index_control.php";
                                                  } elseif ($producto['id'] == 3) {
                                                      $url_producto = $URL . "admin/almacen/inventario/index_fuentes.php";
                                                  } elseif ($producto['id'] == 6) {
                                                    $url_producto = $URL . "admin/almacen/inventario/techled/index.php";
                                                }
                                                  } elseif ($almacen['id'] == 5) {
                                                    if ($producto['id'] == 1) {
                                                      $url_producto = $URL . "admin/almacen/inventario/index_modulos.php";
                                                  } elseif ($producto['id'] == 2) {
                                                      $url_producto = $URL . "admin/almacen/inventario/index_control.php";
                                                  } elseif ($producto['id'] == 3) {
                                                      $url_producto = $URL . "admin/almacen/inventario/index_fuentes.php";
                                                  } elseif ($producto['id'] == 6) {
                                                    $url_producto = $URL . "admin/almacen/inventario/importacion/index.php";
                                                }
                                                  } elseif ($almacen['id'] == 6) {
                                                    if ($producto['id'] == 1) {
                                                      $url_producto = $URL . "admin/almacen/inventario/index_modulos.php";
                                                  } elseif ($producto['id'] == 2) {
                                                      $url_producto = $URL . "admin/almacen/inventario/index_control.php";
                                                  } elseif ($producto['id'] == 3) {
                                                      $url_producto = $URL . "admin/almacen/inventario/index_fuentes.php";
                                                  } elseif ($producto['id'] == 6) {
                                                    $url_producto = $URL . "admin/almacen/inventario/tecnica/index.php";
                                                }
                                                  } elseif ($almacen['id'] == 7) {
                                                    if ($producto['id'] == 1) {
                                                      $url_producto = $URL . "admin/almacen/inventario/index_modulos.php";
                                                  } elseif ($producto['id'] == 2) {
                                                      $url_producto = $URL . "admin/almacen/inventario/index_control.php";
                                                  } elseif ($producto['id'] == 3) {
                                                      $url_producto = $URL . "admin/almacen/inventario/index_fuentes.php";
                                                  } elseif ($producto['id'] == 6) {
                                                    $url_producto = $URL . "admin/almacen/inventario/planta/index.php";
                                                }
                                                  } elseif ($almacen['id'] == 8) {
                                                    if ($producto['id'] == 1) {
                                                      $url_producto = $URL . "admin/almacen/inventario/index_modulos.php";
                                                  } elseif ($producto['id'] == 2) {
                                                      $url_producto = $URL . "admin/almacen/inventario/index_control.php";
                                                  } elseif ($producto['id'] == 3) {
                                                      $url_producto = $URL . "admin/almacen/inventario/index_fuentes.php";
                                                  } elseif ($producto['id'] == 6) {
                                                    $url_producto = $URL . "admin/almacen/inventario/pruebas/index.php";
                                                }
                                                  } elseif ($almacen['id'] == 9) {
                                                    if ($producto['id'] == 1) {
                                                      $url_producto = $URL . "admin/almacen/inventario/index_modulos.php";
                                                  } elseif ($producto['id'] == 2) {
                                                      $url_producto = $URL . "admin/almacen/inventario/index_control.php";
                                                  } elseif ($producto['id'] == 3) {
                                                      $url_producto = $URL . "admin/almacen/inventario/index_fuentes.php";
                                                  } elseif ($producto['id'] == 6) {
                                                    $url_producto = $URL . "admin/almacen/inventario/desechados/index.php";
                                                }
                                                  } elseif ($almacen['id'] == 10) {
                                                    if ($producto['id'] == 1) {
                                                      $url_producto = $URL . "admin/almacen/inventario/index_modulos.php";
                                                  } elseif ($producto['id'] == 2) {
                                                      $url_producto = $URL . "admin/almacen/inventario/index_control.php";
                                                  } elseif ($producto['id'] == 3) {
                                                      $url_producto = $URL . "admin/almacen/inventario/index_fuentes.php";
                                                  } elseif ($producto['id'] == 6) {
                                                    $url_producto = $URL . "admin/almacen/inventario/soporte_tecnico/index.php";
                                                }
                                                  } elseif ($almacen['id'] == 11) {
                                                    if ($producto['id'] == 1) {
                                                      $url_producto = $URL . "admin/almacen/inventario/index_modulos.php";
                                                  } elseif ($producto['id'] == 2) {
                                                      $url_producto = $URL . "admin/almacen/inventario/index_control.php";
                                                  } elseif ($producto['id'] == 3) {
                                                      $url_producto = $URL . "admin/almacen/inventario/index_fuentes.php";
                                                  } elseif ($producto['id'] == 6) {
                                                    $url_producto = $URL . "admin/almacen/inventario/aliados/index.php";
                                                }
                                                  } elseif ($almacen['id'] == 12) {
                                                    if ($producto['id'] == 1) {
                                                      $url_producto = $URL . "admin/almacen/inventario/index_modulos.php";
                                                  } elseif ($producto['id'] == 2) {
                                                      $url_producto = $URL . "admin/almacen/inventario/index_control.php";
                                                  } elseif ($producto['id'] == 3) {
                                                      $url_producto = $URL . "admin/almacen/inventario/index_fuentes.php";
                                                  } elseif ($producto['id'] == 6) {
                                                    $url_producto = $URL . "admin/almacen/inventario/almacenes/index.php";
                                                }
                                                  }
                                                  ?>
                                                  <li class="nav-item">
                                                      <a href="<?php echo $url_producto; ?>" class="nav-link">
                                                          <i class="far fa-dot-circle nav-icon"></i>
                                                          <p><?php echo $producto['nombre']; ?></p>
                                                      </a>
                                                  </li>
                                              <?php endforeach; ?>
                                          </ul>
                                      </li>
                                  <?php endforeach; ?>
                              </ul>
                            </li>
                            <li class="nav-item">
                              <a href="<?php echo $URL;?>admin/almacen/mv_diario" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Movimiento Diario</p>
                              </a>
                            </li>
                          </ul>
                        </li>

                    <?php
                      }
                    ?>

                    <?php
                      if( ($id_rol_sesion_usuario=="7") || ($id_rol_sesion_usuario=="14") ){ ?>

                        <li class="nav-item">
                          <a href="#" class="nav-link active">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>
                              OPERACIÓN
                              <i class="right fas fa-angle-left"></i>
                            </p>
                          </a>
                          <ul class="nav nav-treeview">
                            <li class="nav-item">
                              <a href="<?php echo $URL;?>admin/operacion/pop/" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Status POP </p>
                              </a>
                            </li>
                            <li class="nav-item">
                              <a href="<?php echo $URL;?>admin/usuarios/create.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Status OP</p>
                              </a>
                            </li>
                          </ul>
                        </li>

                    <?php
                      }
                    ?>

                    <?php
                      if( ($id_rol_sesion_usuario=="7") || ($id_rol_sesion_usuario=="15") ){ ?>

                        <li class="nav-item">
                          <a href="#" class="nav-link active">
                            <i class="nav-icon fas fa-universal-access"></i>
                            <p>
                              ATENCIÓN CLIENTE
                              <i class="right fas fa-angle-left"></i>
                            </p>
                          </a>
                          <ul class="nav nav-treeview">
                            <li class="nav-item">
                              <a href="<?php echo $URL;?>admin/atencion_cliente/stc/create.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Creación Nueva STC</p>
                              </a>
                            </li>
                            <li class="nav-item">
                              <a href="<?php echo $URL;?>admin/atencion_cliente/stc" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tratamiento Soporte Técnico (TSTC)</p>
                              </a>
                            </li>
                          </ul>
                        </li>

                    <?php
                      }
                    ?>

                    <?php
                      if( ($id_rol_sesion_usuario=="7") || ($id_rol_sesion_usuario=="15") ){ ?>

                        <li class="nav-item">
                          <a href="#" class="nav-link active">
                            <i class="nav-icon fas fa-hard-hat"></i>
                            <p>
                              VISITA TÉCNICA
                              <i class="right fas fa-angle-left"></i>
                            </p>
                          </a>
                          <ul class="nav nav-treeview">
                            <li class="nav-item">
                              <a href="<?php echo $URL;?>admin/atencion_cliente/ost" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Orden de Servicio Técnico NUEVAS (OST)</p>
                              </a>
                            </li>
                            <li class="nav-item">
                              <a href="<?php echo $URL;?>admin/atencion_cliente/ost/index_create.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tratamiento de Orden de Servicio Técnico(TOST)</p>
                              </a>
                            </li>
                          </ul>
                        </li>

                    <?php
                      }
                    ?>

                    <?php
                      if( ($id_rol_sesion_usuario=="7") || ($id_rol_sesion_usuario=="Administración") ){ ?>

                        <li class="nav-item">
                          <a href="#" class="nav-link active">
                            <i class="nav-icon fas fa-sort-amount-asc"></i>
                            <p>
                              CRM
                              <i class="right fas fa-angle-left"></i>
                            </p>
                          </a>
                          <ul class="nav nav-treeview">
                            <li class="nav-item">
                              <a href="<?php echo $URL;?>admin/crm/contacto/index.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>LIstado de Contactos</p>
                              </a>
                            </li>
                            <li class="nav-item">
                              <a href="<?php echo $URL;?>admin/almacen/crear_modulos/" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Modulos para Ventas</p>
                              </a>
                            </li>
                            <li class="nav-item">
                              <a href="<?php echo $URL;?>admin/crm/preproyectos/" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pre Proyectos</p>
                              </a>
                            </li>
                            <li class="nav-item">
                              <a href="<?php echo $URL;?>admin/crm/proyectos/create.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Proyectos</p>
                              </a>
                            </li>
                          </ul>
                        </li>

                    <?php
                      }
                    ?>

                    <?php
                      if( ($id_rol_sesion_usuario=="7") || ($id_rol_sesion_usuario=="Administración") ){ ?>

                        <li class="nav-item">
                          <a href="#" class="nav-link active">
                            <i class="nav-icon fas fa-object-ungroup"></i>
                            <p>
                              DISEÑO INDUSTRIAL
                              <i class="right fas fa-angle-left"></i>
                            </p>
                          </a>
                          <ul class="nav nav-treeview">
                            <li class="nav-item">
                              <a href="<?php echo $URL;?>admin/usuarios" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Status DDI </p>
                              </a>
                            </li>
                          </ul>
                        </li>

                    <?php
                      }
                    ?>

                    <?php
                      if( ($id_rol_sesion_usuario=="7") || ($id_rol_sesion_usuario=="Administración") || ($id_rol_sesion_usuario=="15") ){ ?>

                        <li class="nav-item">
                          <a href="#" class="nav-link active">
                            <i class="nav-icon fas fa-television"></i>
                            <p>
                              PRODUCTO
                              <i class="right fas fa-angle-left"></i>
                            </p>
                          </a>
                          <ul class="nav nav-treeview">
                            <li class="nav-item">
                              <a href="<?php echo $URL;?>admin/almacen/inventario/" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Productos Creados</p>
                              </a>
                            </li>
                            <li class="nav-item">
                              <a href="<?php echo $URL;?>admin/ti/partes_modulos/index.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Caracteristicas Módulos</p>
                              </a>
                            </li>
                          </ul>
                        </li>

                    <?php
                      }
                    ?>

                    <?php
                      if( ($id_rol_sesion_usuario=="7") || ($id_rol_sesion_usuario=="Administración") ){ ?>

                        <li class="nav-item">
                          <a href="#" class="nav-link active">
                            <i class="nav-icon fas fa-puzzle-piece "></i>
                            <p>
                              PROYECTO
                              <i class="right fas fa-angle-left"></i>
                            </p>
                          </a>
                          <ul class="nav nav-treeview">
                          
                          </ul>
                        </li>

                    <?php
                      }
                    ?>

                    <?php
                      if( ($id_rol_sesion_usuario=="7") || ($id_rol_sesion_usuario=="Administración") ){ ?>

                        <li class="nav-item">
                          <a href="#" class="nav-link active">
                            <i class="nav-icon fas fa-database"></i>
                            <p>
                              TI
                              <i class="right fas fa-angle-left"></i>
                            </p>
                          </a>
                          <ul class="nav nav-treeview">
                            <li class="nav-item">
                              <a href="<?php echo $URL;?>admin/ti/ciudades" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Listado Ciudades</p>
                              </a>
                            </li>
                            <li class="nav-item">
                              <a href="<?php echo $URL;?>admin/ti/usuarios" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Listado Usuarios</p>
                              </a>
                            </li>
                            <li class="nav-item">
                              <a href="<?php echo $URL;?>admin/ti/permisos" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Listado de Permisos</p>
                              </a>
                            </li>
                            <li class="nav-item">
                              <a href="<?php echo $URL;?>admin/ti/cargos" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Listado de Roles</p>
                              </a>
                            </li>
                            <li class="nav-item">
                              <a href="<?php echo $URL;?>admin/ti/menu_principal" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Lista Menú</p>
                              </a>
                            </li>
                          </ul>
                        </li>

                    <?php
                      }
                    ?>

                    <?php
                      if( ($id_rol_sesion_usuario=="7") || ($id_rol_sesion_usuario=="16") ){ ?>

                        <li class="nav-item">
                          <a href="#" class="nav-link active">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                              TECHLED
                              <i class="right fas fa-angle-left"></i>
                            </p>
                          </a>
                          <ul class="nav nav-treeview">
                            <li class="nav-item" hidden>
                              <a href="<?php echo $URL;?>admin/techled/tracking_chi/index_tracking.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Requests Tracking</p>
                              </a>
                            </li>
                            <li class="nav-item" hidden>
                              <a href="<?php echo $URL;?>admin/techled/tracking_techled/index_trackin_techled.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Price Modules</p>
                              </a>
                            </li>
                            <li class="nav-item" hidden>
                              <a href="<?php echo $URL;?>admin/list_price_techled/index_cabinet.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Price Cabinet</p>
                              </a>
                            </li>
                            <li class="nav-item" hidden>
                              <a href="<?php echo $URL;?>admin/list_price_techled/index_equipment.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Price Equipment & Accessories</p>
                              </a>
                            </li>
                            <li class="nav-item" hidden>
                              <a href="<?php echo $URL;?>admin/list_price_techled/index_hologram.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Price Hologram</p>
                              </a>
                            </li>
                            <li class="nav-item" hidden>
                              <a href="<?php echo $URL;?>admin/list_price_techled/index_lcd.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Price LCD</p>
                              </a>
                            </li>
                            <li class="nav-item" hidden>
                              <a href="<?php echo $URL;?>admin/list_price_techled/index_rental.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Price Rental & Display</p>
                              </a>
                            </li>
                            <li class="nav-item" hidden>
                              <a href="<?php echo $URL;?>admin/list_price_techled/index_system.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Price System & Control</p>
                              </a>
                            </li>
                            <li class="nav-item">
                              <a href="<?php echo $URL;?>admin/techled/" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Producto</p>
                              </a>
                            </li>
                          </ul>
                        </li>

                    <?php
                      }
                    ?>

                    <?php
                      if( ($id_rol_sesion_usuario=="7") || ($id_rol_sesion_usuario=="Administración") ){ ?>

                        <li class="nav-item">
                          <a href="#" class="nav-link active">
                            <i class="nav-icon fas fa-university"></i>
                            <p>
                              PLANTA
                              <i class="right fas fa-angle-left"></i>
                            </p>
                          </a>
                          <ul class="nav nav-treeview">
                            <li class="nav-item">
                              <a href="<?php echo $URL;?>admin/planta" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Listado ID Pantallas</p>
                              </a>
                            </li>
                          </ul>
                        </li>

                    <?php
                      }
                    ?>

                    <?php
                      if( ($id_rol_sesion_usuario=="7") || ($id_rol_sesion_usuario=="9") ){ ?>

                        <li class="nav-item">
                          <a href="#" class="nav-link active">
                            <i class="nav-icon fas fa-wrench"></i>
                            <p>
                              TÉCNICO
                              <i class="right fas fa-angle-left"></i>
                            </p>
                          </a>
                          <ul class="nav nav-treeview">
                            <li class="nav-item">
                              <a href="<?php echo $URL;?>admin/ti_usuarios" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Listado OST Asignadas</p>
                              </a>
                            </li>
                          </ul>
                        </li>

                    <?php
                      }
                    ?>

                        <?php
                      if( ($id_rol_sesion_usuario=="7") || ($id_rol_sesion_usuario=="8") ){ ?>

                        <li class="nav-item">
                          <a href="#" class="nav-link active">
                            <i class="nav-icon fas fa-user-plus"></i>
                            <p>
                              CLIENTE
                              <i class="right fas fa-angle-left"></i>
                            </p>
                          </a>
                          <ul class="nav nav-treeview">
                            <li class="nav-item">
                              <a href="<?php echo $URL;?>admin/cliente" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Listado Pantallas</p>
                              </a>
                            </li>
                          </ul>
                        </li>

                    <?php
                      }
                    ?>

                    <?php
                      if( ($id_rol_sesion_usuario=="7") || ($id_rol_sesion_usuario=="14") ){ ?>

                        <li class="nav-item">
                          <a href="#" class="nav-link active">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>
                              INGRESO PRODUCTO
                              <i class="right fas fa-angle-left"></i>
                            </p>
                          </a>
                          <ul class="nav nav-treeview">
                            <li class="nav-item">
                              <a href="<?php echo $URL;?>admin/producto/producto_ingreso/create_producto.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ingresar Producto</p>
                              </a>
                            </li>
                          </ul>
                        </li>

                    <?php
                      }
                    ?>

                        <li class="nav-item">
                          <a href="<?php echo $URL;?>/login/controller_cerrar_sesion.php" class="nav-link" style="background-color: #ca0a0b">
                            <i class="nav-icon fas fa-door-closed"></i>
                            <p>Cerrar Sesión</p>
                          </a>            
                        </li>
              </ul>
            </nav>
            <!-- /.sidebar-menu -->
          </div>
          <!-- /.sidebar -->
        </aside>