<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SMARTLED</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo $URL?>/public/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $URL?>/public/dist/css/adminlte.min.css">
  <!-- Icon Logo -->
  <link rel="icon" type="image/ico" href="../public/images/Logo.png">
  <!-- Ventana de alerta  sweetalert2-->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo $URL?>public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo $URL?>public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo $URL?>public/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

</head>
<body class="hold-transition sidebar-mini">

<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">SMARTLED COLOMBIA</a>
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
          <!-- Add icons to the links using the .nav-icon class
              with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-users"></i>
              <p>
                MENÚ ADMINISTRACIÓN
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/administracion/create_oc.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>CREAR OC</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/administracion/index_oc.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>OC PENDIENTES</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/administracion/create_cliente.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>CREAR CLIENTES</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/administracion/index_clientes.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>LISTA CLIENTES</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-users"></i>
              <p>
                MENÚ OPERACIÓN
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/usuarios" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Status POP </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/usuarios/create.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tratamiento POP</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/usuarios/create.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Status OP</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/usuarios/create.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tratamiento OP</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/usuarios/create.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>CAMPO LIBRE</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>bd_smlcol/soportetecnico/stc/index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>STC CLIENTE</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/usuarios/create.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>OST CLIENTE</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-users"></i>
              <p>
                MENÚ ATENCIÓN AL CLIENTE
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
          <li class="nav-item">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-users"></i>
              <p>
                MENÚ CRM
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/usuarios" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Status POP </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/usuarios/create.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tratamiento POP</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/usuarios/create.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Status OP</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/usuarios/create.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tratamiento OP</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/usuarios/create.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>CAMPO LIBRE</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>bd_smlcol/soportetecnico/stc/index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>STC CLIENTE</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/usuarios/create.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>OST CLIENTE</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-users"></i>
              <p>
                MENÚ DISEÑO iNDUSTRIAL
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/usuarios" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Status POP </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/usuarios/create.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tratamiento POP</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/usuarios/create.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Status OP</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/usuarios/create.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tratamiento OP</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/usuarios/create.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>CAMPO LIBRE</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>bd_smlcol/soportetecnico/stc/index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>STC CLIENTE</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/usuarios/create.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>OST CLIENTE</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-users"></i>
              <p>
                MENÚ PRODUCTO
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/usuarios" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Status POP </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/usuarios/create.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tratamiento POP</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/usuarios/create.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Status OP</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/usuarios/create.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tratamiento OP</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/usuarios/create.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>CAMPO LIBRE</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>bd_smlcol/soportetecnico/stc/index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>STC CLIENTE</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/usuarios/create.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>OST CLIENTE</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-users"></i>
              <p>
                MENÚ PROYECTO
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/usuarios" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Status POP </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/usuarios/create.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tratamiento POP</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/usuarios/create.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Status OP</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/usuarios/create.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tratamiento OP</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/usuarios/create.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>CAMPO LIBRE</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>bd_smlcol/soportetecnico/stc/index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>STC CLIENTE</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/usuarios/create.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>OST CLIENTE</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-users"></i>
              <p>
                MENÚ TI
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/ti_usuarios" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Listado Usuarios</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/ti_usuarios/create.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Crear Usuario</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/ti_usuarios/index_cargos.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Listado de Cargos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/ti_usuarios/create_cargo.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Crear Cargo</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-users"></i>
              <p>
                MENU TECHLED
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/list_price_techled/index_modules.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>List Price Modules</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/list_price_techled/index_cabinet.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>List Price Cabinet</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/list_price_techled/index_equipment.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>List Price Equipment & Accessories</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/list_price_techled/index_hologram.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>List Price Hologram</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/list_price_techled/index_lcd.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>List Price LCD</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/list_price_techled/index_rental.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>List Price Rental & Display</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/list_price_techled/index_system.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>List Price System & Control</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-users"></i>
              <p>
                MENÚ PLANTA
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/planta" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Listado ID Producto</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/planta/create.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Crear ID Producto</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/ti_usuarios/index_cargos.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>QQQQQQQQQQQQQQQQQQQQ</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/ti_usuarios/create_cargo.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>QQQQQQQQQQQQQQQQQQQ</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-users"></i>
              <p>
                MENÚ TÉCNICO
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
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/ti_usuarios/create.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Crear Usuario</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/ti_usuarios/index_cargos.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Listado de Cargos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $URL;?>admin/ti_usuarios/create_cargo.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Crear Cargo</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="<?php echo $URL;?>/login/controller_cerrar_sesion.php" class="nav-link" style="background-color: #ca0a0b">
              <i class="nav-icon fas fa-door-closed"></i>
              <p>
                Cerrar Sesión
              </p>
            </a>
            
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
