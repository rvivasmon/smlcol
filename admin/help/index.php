<?php

include "../../app/config/config.php";
include "../../app/config/conexion.php";

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
                    
                    <div class="card card-blue" style="height: 800px;">
                        <div class="card-header">
                            <h3 class="card-title">Usuario: <?php echo htmlspecialchars($sesion_usuario['nombre']); ?></h3>
                        </div>
                        <hr>
                        <div class="card-body">
                            <div class="table-responsive" style="width: 100%; height: 100%;">
                                <!-- Contenido del chat dentro de un iframe -->
                                <iframe 
                                    id="chatFrame"
                                    src="./chat/users.php" 
                                    style="width: 100%; height: 100%; border: none;">
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<?php include('../../layout/admin/parte2.php'); ?>
