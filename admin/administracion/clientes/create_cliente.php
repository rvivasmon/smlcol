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
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label for="">Fecha Ingreso</label>
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
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label for="">Siglas Cliente</label>
                                                <input type="text" name="siglascliente" class="form-control" placeholder="ID Producto">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">NIT</label>
                                                <input type="text" name="nit" class="form-control" placeholder="Medio de Contacto" >
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-2 campo Contacto">
                                            <div class="form-group">
                                                <label for="contacto_admon">Contacto Administrativo</label>
                                                <input type="text" name="contacto_admon" id="contacto_admon" class="form-control" placeholder="Persona Contacto">
                                                <input type="hidden" name="id_administrativo" id="id_administrativo" class="form-control">

                                            </div>
                                        </div>
                                        <div class="col-md-2 campo Contacto">
                                            <div class="form-group">
                                                <label for="">Celular</label>
                                                <input type="text" name="celular" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-2 campo Contacto">
                                            <div class="form-group">
                                                <label for="">Teléfono</label>
                                                <input type="text" name="telefono" class="form-control" placeholder="Teléfono">
                                            </div>
                                        </div>
                                        <div class="col-md-2 campo Contacto">
                                            <div class="form-group">
                                                <label for="contacto_comercial">Contacto Comercial</label>
                                                <input type="text" name="contacto_comercial" id="contacto_comercial" class="form-control" placeholder="Persona Contacto">
                                                <input type="hidden" name="id_comercial" id="id_comercial" class="form-control">

                                            </div>
                                        </div>
                                        <div class="col-md-2 campo Contacto">
                                            <div class="form-group">
                                                <label for="">Celular</label>
                                                <input type="text" name="celular" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-2 campo Contacto">
                                            <div class="form-group">
                                                <label for="">Teléfono</label>
                                                <input type="text" name="telefono" class="form-control" placeholder="Teléfono">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2 campo Contacto">
                                            <div class="form-group">
                                                <label for="contacto_proyecto">Contacto Proyecto</label>
                                                <input type="text" name="contacto_proyecto" id="contacto_proyecto" class="form-control" placeholder="Persona Contacto">
                                                <input type="hidden" name="id_proyecto" id="id_proyecto" class="form-control">

                                            </div>
                                        </div>
                                        <div class="col-md-2 campo Contacto">
                                            <div class="form-group">
                                                <label for="">Celular</label>
                                                <input type="text" name="celular" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-2 campo Contacto">
                                            <div class="form-group">
                                                <label for="">Teléfono</label>
                                                <input type="text" name="telefono" class="form-control" placeholder="Teléfono">
                                            </div>
                                        </div>
                                        <div class="col-md-2 campo Contacto">
                                            <div class="form-group">
                                                <label for="contacto_otro">Otro Contacto</label>
                                                <input type="text" name="contacto_otro" id="contacto_otro" class="form-control" placeholder="Persona Contacto">
                                                <input type="hidden" name="id_otro" id="id_otro" class="form-control">

                                            </div>
                                        </div>
                                        <div class="col-md-2 campo Contacto">
                                            <div class="form-group">
                                                <label for="">Celular</label>
                                                <input type="text" name="celular" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-2 campo Contacto">
                                            <div class="form-group">
                                                <label for="">Teléfono</label>
                                                <input type="text" name="telefono" class="form-control" placeholder="Teléfono">
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
                                                <label for="">Email</label>
                                                <input type="text" name="email" class="form-control" placeholder="" >
                                            </div>
                                        </div>
                                        <div class="col-md-2">
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

                        <!-- Modal para registrar contactos -->
                        <div class="modal fade" id="contactoModal" tabindex="-1" aria-labelledby="contactoModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="contactoModalLabel">Registrar Contacto</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="formContacto">
                                        <div class="form-group">
                                            <label for="nombreContacto">Nombre del Contacto</label>
                                            <input type="text" class="form-control" id="nombreContacto" placeholder="Nombre">
                                        </div>
                                        <div class="form-group">
                                            <label for="celularContacto">Celular</label>
                                            <input type="text" class="form-control" id="celularContacto" placeholder="Celular">
                                        </div>
                                        <div class="form-group">
                                            <label for="telefonoContacto">Teléfono</label>
                                            <input type="text" class="form-control" id="telefonoContacto" placeholder="Teléfono">
                                        </div>
                                        <input type="text" id="tipoContacto" value="">
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <button type="button" class="btn btn-primary" id="guardarContacto">Guardar Contacto</button>
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

<?php include('../../../layout/admin/parte2.php');?>

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

<script>
    document.querySelectorAll('.campo.Contacto input[type="text"]').forEach(function(input) {
    input.addEventListener('click', function() {
        // Determinar el tipo de contacto (administrativo, comercial, etc.)
        const tipo = this.getAttribute('id').split('_')[1];  // 'admon', 'comercial', etc.
        
        // Establecer el tipo de contacto en un campo oculto en el modal
        document.getElementById('tipoContacto').value = tipo;

        // Abrir el modal
        $('#contactoModal').modal('show');
    });
});
</script>

<script>
    document.getElementById('guardarContacto').addEventListener('click', function() {
    // Obtener los valores del formulario
    const nombre = document.getElementById('nombreContacto').value;
    const celular = document.getElementById('celularContacto').value;
    const telefono = document.getElementById('telefonoContacto').value;
    const tipo = document.getElementById('tipoContacto').value;

    // Realizar la solicitud AJAX para guardar el contacto
    const formData = new FormData();
    formData.append('nombre', nombre);
    formData.append('celular', celular);
    formData.append('telefono', telefono);
    formData.append('tipo', tipo);

    fetch('guardar_contacto.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Actualizar los campos de contacto con los datos ingresados
            document.getElementById(`contacto_${tipo}`).value = nombre;
            document.querySelector(`input[name=celular][id*=${tipo}]`).value = celular;
            document.querySelector(`input[name=telefono][id*=${tipo}]`).value = telefono;

            // Actualizar el campo oculto con el ID del contacto
            document.getElementById(`id_${tipo}`).value = data.id_contacto;

            // Cerrar el modal
            $('#contactoModal').modal('hide');
        } else {
            alert('Error al guardar el contacto');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

</script>
