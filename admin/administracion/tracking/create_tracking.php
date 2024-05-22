<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

include('../../../layout/admin/parte1.php');

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Crear Nueva Solicitud</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card card-blue">
                <div class="card-header">
                    Introduzca la información correspondiente
                </div>
                <div class="card-body">
                    <form id="formulario" action="controller_create_tracking.php" method="POST" enctype="multipart/form-data">

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Date</label>
                                                <input type="date" name="fechaingreso" id="fechaingreso" class="form-control" value= "<?php echo date('Y-m-d'); ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Origin</label>
                                                <input type="text" name="destinomercancia" class="form-control" placeholder="" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Category</label>
                                                <select class="form-control"  id="tipoproducto" name="tipoproducto" required>
                                                    <option value="">Seleccionar Tipo Producto</option>
                                                    <option value="Fuentes">Fuentes</option>
                                                    <option value="Modulos">Modulos</option>
                                                    <option value="Tarjetas">Tarjetas</option>
                                                    <option value="Sistema de Control">Sistema de Control</option>
                                                    <option value="Video Procesador">Video Procesador</option>
                                                    <option value="LCD">LCD</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-0"> <!-- Se coloca aquí el usuario que está trabajando el archivo --> 
                                            <div class="form-group">
                                                <label for=""></label>
                                                <input type="text" name="usuarioperador" class="form-control" value="<?php echo $sesion_nombre; ?>" hidden>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="">Type</label>
                                                <input type="text" name="descripcion" class="form-control" placeholder="Nombre Comercial">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Cantidad</label>
                                                <input type="text" name="cantidad" class="form-control" placeholder="ID Producto">
                                            </div>
                                        </div>
                                    </div>                                
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Observaciones Colombia</label>
                                    <textarea type="text" name="obscolombia" class="form-control" rows="8" placeholder="" required></textarea>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <a href="<?php echo $URL."admin/administracion/tracking/index_tracking.php";?>" class="btn btn-default btn-block ml-3">Cancelar</a>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" onclick="return confirm('Seguro de haber diligenciado correctamente los datos?')" class="btn btn-primary btn-block ml-3">Crear Solicitud</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
</div>

<script>
    document.getElementById("formulario").addEventListener("submit", function(event) {
        var medioIngreso = document.getElementById("medio_ingreso").value;
        var tipoServicio = document.getElementById("tiposervicio").value;

        if (medioIngreso === "") {
            alert("Por favor seleccionar un medio de ingreso.");
            event.preventDefault();
        }

        if (tipoServicio === "") {
            alert("Por favor seleccione un tipo de servicio.");
            event.preventDefault();
        }
    });
    
</script>

<?php include('../../../layout/admin/parte2.php');?>
