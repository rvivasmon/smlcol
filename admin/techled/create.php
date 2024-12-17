<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/sesion.php');
include('../../layout/admin/datos_sesion_user.php');

include('../../layout/admin/parte1.php');
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><b>TECHLED</b></h1>
                </div>
            </div>
            
            <div class="card card-blue">
                <div class="card-header">
                    <a href="#" class="d-block"><?php echo $sesion_usuario['nombre']; ?></a>
                </div>

                <div class="card-body">
                    <!-- Formulario principal -->
                    <form action="controller.php" method="post" enctype="multipart/form-data" id="formProducto">

                        <!-- Campos del formulario -->
                        <div class="row">        

                            <!-- El resto del formulario (derecha) -->
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="producto">Producto</label>
                                            <input type="text" name="producto" id="producto" class="form-control" placeholder="Ingresa el producto" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="modelo">Modelo</label>
                                            <input type="text" name="modelo" id="modelo" class="form-control" placeholder="Ingresa el modelo" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="serial">Serial</label>
                                            <input type="text" name="serial" id="serial" class="form-control" placeholder="Ingresa el serial" pattern="[A-Za-z0-9]+" title="Solo se permiten letras y números" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cantidad">Cantidad</label>
                                            <input type="text" name="cantidad" id="cantidad" class="form-control" placeholder="Ingresa la cantidad" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="descripcion">Descripciones generales</label>
                                            <textarea name="descripcion" id="descripcion" cols="30" rows="4" placeholder="Descripciones generales" class="form-control" required></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="valor">Valor</label>
                                            <input type="text" name="valor" id="valor" class="form-control" placeholder="Valor" required>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- /.col-md-5 -->

                            <!-- Columna para cargar archivo (izquierda) -->
                            <div class="col-md-7">
                                <div class="form-group">
                                    <p><b>Adjuntar archivo</b></p><br>

                                    <!-- Vista previa de la imagen cargada -->
                                    <div id="vista-previa" class="mt-2" style="display:none;">
                                        <img id="imagen-previa" src="" alt="Vista previa de la imagen" class="img-fluid mb-3" style="max-width: 200px;">
                                    </div>

                                    <!-- Botón para adjuntar archivo -->
                                    <label for="archivo">
                                        <span class="btn btn-primary btn-icon">
                                            <i class="fas fa-upload"></i> Adjuntar archivo
                                        </span>
                                    </label>
                                    <input type="file" class="d-none" id="archivo" name="archivo" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.csv,.zip,.rar">

                                    <!-- Mostrar el nombre del archivo cargado -->
                                    <div id="archivo-nombre" class="mt-2" style="display:none;">
                                        <p>Archivo cargado: <span id="nombre-archivo"></span></p>
                                    </div>
                                </div>
                            </div> <!-- /.col-md-7 -->

                        </div> <!-- /.row -->                        
                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <a href="<?php echo $URL . "admin/techled/index.php"; ?>" class="btn btn-default btn-block">Volver</a>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="submit" class="btn btn-primary">Registrar producto</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>                
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
    document.getElementById('serial').addEventListener('input', function (e) {
        const input = e.target;
        input.value = input.value.replace(/[^A-Za-z0-9]/g, '');
    });

    document.getElementById('valor').addEventListener('input', function (e) {
        let value = e.target.value.replace(/[^0-9]/g, '');
        if (value) {
            value = parseInt(value).toLocaleString('es-CO');
            e.target.value = `${value}`;
        } else {
            e.target.value = '';
        }
    });

    document.getElementById('archivo').addEventListener('change', function (e) {
        const file = e.target.files[0];
        const vistaPrevia = document.getElementById('vista-previa');
        const imagenPrevia = document.getElementById('imagen-previa');
        const archivoNombre = document.getElementById('archivo-nombre');
        const nombreArchivo = document.getElementById('nombre-archivo');
        
        if (file) {
            archivoNombre.style.display = 'block';
            nombreArchivo.textContent = file.name;

            if (file.type.startsWith('../../img_uploads/img_techled/')) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    imagenPrevia.src = event.target.result;
                    vistaPrevia.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                vistaPrevia.style.display = 'none';
            }
        }
    });

    // Verificar si se adjuntó un archivo antes de enviar el formulario
    document.getElementById('formProducto').addEventListener('submit', function(e) {
        const archivoInput = document.getElementById('archivo');
        
        if (!archivoInput.files.length) {
            if (!confirm("¿Está seguro que desea registrar el producto sin adjuntar un archivo?")) {
                e.preventDefault(); // Evita el envío si el usuario cancela
            }
        }
    });
</script>
<?php include('../../layout/admin/parte2.php'); ?>
