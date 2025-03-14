<?php 

include('../../../../../app/config/config.php');
include('../../../../../app/config/conexion.php');

include('../../../../../layout/admin/sesion.php');
include('../../../../../layout/admin/datos_sesion_user.php');

include('../../../../../layout/admin/parte1.php');

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Crear Sub Almacen</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card card-blue">
                <div class="card-header">
                    Introduzca la información correspondiente
                </div>
                <div class="card-body">
                    <form action="controller_create.php" method="post">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="bodega">Nombre Sub Almacén</label>
                                    <input type="text" name="bodega" id="bodega" class="form-control" placeholder="Nombre Bodega" required>
                                </div>
                            </div>
                        </div>

                        <!-- Este es el campo oculto del ID del cliente seleccionado aquí -->
                        <input type="hidden" id="id_cliente" name="id_cliente">
                        <hr>

                        <div class="row">
                            <div class="col-md-2">
                                <a href="<?php echo $URL."admin/administracion/admon/almacenes/sub_almacenes";?>" class="btn btn-default btn-block">Cancelar</a>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" onclick="return confirm('Seguro de haber diligenciado correctamente los datos?')" class="btn btn-primary btn-block">Registrar Sub Almacén</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div>
</div>

<?php include('../../../../../layout/admin/parte2.php');?>

<script>
    // Función para actualizar el campo id_cliente cuando se selecciona un cliente
    function registrarCliente() {
        var clienteSeleccionado = document.getElementById('idcliente').value;
        document.getElementById('id_cliente').value = clienteSeleccionado;
    }
    // apertura del modal si id_cargo pertenece a cliente
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('id_cargo').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var cargo = selectedOption.textContent.trim().toLowerCase();
            if (cargo === "cliente") {
                $('#cargoModal').modal('show');
            }
        });

        // Llamar a la función registrarCliente cuando se selecciona un cliente en el modal
        document.getElementById('btnAceptar').addEventListener('click', function() {
            registrarCliente();
        });
    });
</script>
