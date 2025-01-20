<?php

include_once "../../app/config/config.php";
include_once "../../app/config/conexion.php";
include('../../layout/admin/sesion.php');
include('../../layout/admin/datos_sesion_user.php');
include('../../layout/admin/parte1.php');
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                    <h1 class="m-0"><b>CHAT</b></h1>
                    <div class="card card-blue" style="height: 800px; ">
                        <div class="card-header">
                            <a href="#" class="d-block invisible"><?php echo $sesion_usuario['nombre']; ?></a>
                        </div>

                        <hr>

                        <div class="card-body" > <!-- Aumentamos la altura -->
                            <div class="table-responsive" style="width: 100%; height: 100%; ">
                                <!-- Contenido del chat aislado dentro de un iframe -->
                                <iframe 
                                    src="./chat/users.php" 
                                    style="width: 100%; height: 100%; border: none;">
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php include('../../layout/admin/parte2.php'); ?>
