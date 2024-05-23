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
                    <h1 class="m-0">Crear Nuevo Cliente</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card card-blue">
                <div class="card-header">
                    Introduzca la información correspondiente
                </div>
                <div class="card-body">
                    <form id="formulario" action="controller_create_cliente.php" method="POST" enctype="multipart/form-data">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Fecha de Ingreso</label>
                                                <input type="date" name="fechaingreso" id="fechaingreso" class="form-control" value= "<?php echo date('Y-m-d'); ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Nombre Comercial</label>
                                                <input type="text" name="nombrecomercial" class="form-control" placeholder="Nombre Comercial" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Razón Social</label>
                                                <input type="text" name="razonsocial" class="form-control" placeholder="Razón Social" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Clase Cliente</label>
                                                <input type="text" name="clasecliente" class="form-control" placeholder="Nombre Comercial">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Siglas Cliente</label>
                                                <input type="text" name="siglascliente" class="form-control" placeholder="ID Producto">
                                            </div>
                                        </div>                                    
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Celular</label>
                                                <input type="text" name="celular" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Email</label>
                                                <input type="text" name="email" class="form-control" placeholder="" >
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Teléfono</label>
                                                <input type="text" name="telefono" class="form-control" placeholder="Proyecto" >
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Contacto</label>
                                                <input type="text" name="personacontacto" class="form-control" placeholder="Persona Contacto" >
                                            </div>
                                        </div>
                                    </div>                                
                                    <div class="row">
                                        <div class="col-md-0"> <!-- Se coloca aquí el usuario que está trabajando el archivo --> 
                                            <div class="form-group">
                                                <label for=""></label>
                                                <input type="text" name="usuariocliente" class="form-control" value="<?php echo $sesion_nombre; ?>" hidden>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">NIT</label>
                                                <input type="text" name="nit" class="form-control" placeholder="Medio de Contacto" >
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Web</label>
                                                <input type="text" name="web" class="form-control" placeholder="Web" >
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label for="">Dirección</label>
                                                <input type="text" name="direccion" class="form-control" placeholder="Dirección" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">País</label>
                                                <input type="text" name="pais" class="form-control" placeholder="País" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Departamento</label>
                                                <input type="text" name="departamento" class="form-control" placeholder="Departamento" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Ciudad</label>
                                                <input type="text" name="ciudad" class="form-control" placeholder="Ciudad" required>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <a href="<?php echo $URL."admin/administracion/clientes/index_clientes.php";?>" class="btn btn-default btn-block ml-3">Cancelar</a>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" onclick="return confirm('Seguro de haber diligenciado correctamente los datos?')" class="btn btn-primary btn-block ml-3">Crear Cliente</button>
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
