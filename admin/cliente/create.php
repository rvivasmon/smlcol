<?php 

include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/sesion.php');
include('../../layout/admin/datos_sesion_user.php');


?>

<?php include('../../layout/admin/parte1.php'); ?>

<?php 
    $id_producto = $_GET['id_producto'];
    $proyecto = $_GET['proyecto'];
?>

<div class="content-wrapper">
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Crear Falla de Pantalla</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->

        <div class="card card-blue">
            <div class="card-header">
                <a href="#" class="d-block"><?php echo $sesion_usuario['nombre']?></a>                    
            </div>
            <div class="card-body"> 
                <form id="formulario" action="controller_create.php" method="post" enctype= "multipart/form-data"> 

                    <div class="row"> 
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-0">
                                        <div class="form-group">
                                            <label for=""></label>

                                            <?php

                                            // Obtener el año y el mes actuales en formato YYYYMM
                                            $anio_mes = date('Ym');

                                            // Obtener el último registro de la base de datos ordenado por año_mes de forma descendente
                                            $query_ultimo_registro = $pdo->prepare('SELECT * FROM stc ORDER BY contador DESC LIMIT 1');
                                            $query_ultimo_registro->execute();
                                            $ultimo_registro = $query_ultimo_registro->fetch(PDO::FETCH_ASSOC);

                                            // Inicializar el contador en 1 por defecto
                                            $contador = 1;

                                            // Verificar si hay un último registro
                                            if($ultimo_registro) {
                                                // Si hay un último registro, verificar si el año_mes es igual al del último registro
                                                if($ultimo_registro['anio_mes'] == $anio_mes) {
                                                    // Si el año_mes es igual, continuar con el contador
                                                    $contador = $ultimo_registro['contador'] + 1;
                                                } else {
                                                    // Si el año_mes es diferente, reiniciar el contador
                                                    $contador = 1;
                                                }
                                            }

                                            // Crea el ID STC utilizando el año_mes y el contador
                                            $id_stc = 'STC - ' . $anio_mes . '-' . sprintf('%03d', $contador);

                                            ?>

                                            <input type="hidden" name="anio_mes" value="<?php echo $anio_mes; ?>">
                                            <input type="hidden" name="contador" value="<?php echo $contador; ?>">
                                            <input type="text" name="idstc" class="form-control" value="<?php echo $id_stc; ?>" hidden>
                                        </div>
                                        </div>                                                                   
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">Fecha de Ingreso</label>
                                            <input type="date" name="fechaingreso" id="fechaingreso" class="form-control" value= "<?php echo date('Y-m-d'); ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-0" style="display: none;">
                                    <div class="form-group">
                                        <label for=""></label>
                                        <select class="form-control" id="medio_ingreso" name="medio_ingreso" value="<?php echo $medio_ingreso;?>" readonly>
                                            <option value="">Seleccionar Medio</option>
                                            <option value="Email">EMAIL</option>
                                            <option value="Llamada">LLAMADA</option>
                                            <option value="Whatsapp">WHATSAPP</option>
                                            <option value="Otro" selected>OTRO</option>
                                            
                                        </select>
                                    </div>
                                </div>

                                    <div class="col-md-0">
                                        <div class="form-group">
                                            <label for=""></label>
                                            <input type="text" name="ticketexterno" class="form-control" placeholder="Ticket Externo" hidden>
                                        </div>
                                    </div>  
                                    
                                    <div class="col-md-0">
                                        <div class="form-group">
                                            <label for=""></label>
                                            <select name="tiposervicio" id="tiposervicio" class="form-control" hidden>
                                                <?php 
                                                $valor_actual_en_edicion = $stc['tipo_servicio'];
                                                $query_servicio = $pdo->prepare('SELECT * FROM tipo_servicio');
                                                $query_servicio->execute();
                                                $servicios = $query_servicio->fetchAll(PDO::FETCH_ASSOC);
                                                foreach($servicios as $servicio) {
                                                    $id_servicio = $servicio['id'];
                                                    $servicio = $servicio['servicio_stc'];
                                                    $selected = ($id_servicio == 5) ? 'selected' : '';
                                                    ?>
                                                    <option value="<?php echo $id_servicio; ?>" <?php echo $selected; ?>><?php echo $servicio; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">Id Producto</label>
                                            <input type="text" name="id_producto" class="form-control" value="<?php echo $id_producto;?>"  readonly>
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">Proyecto</label>
                                            <input type="text" name="proyecto" class="form-control" value="<?php echo $proyecto; ?>"  readonly>
                                        </div>
                                    </div>                                      
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">Estado</label>
                                            <input name="idestado" id="idestado" class="form-control" value="CON FALLAS" readonly>
                                            <select name="idestado" id="idestado" class="form-control"  hidden>                                                   
                                                
                                                <?php
                                                $valor_actual_en_edicion = $stc['estado'];
                                                $query_estado = $pdo->prepare('SELECT * FROM estado');
                                                $query_estado->execute();
                                                $estados = $query_estado->fetchAll(PDO::FETCH_ASSOC);
                                                foreach($estados as $estado) {
                                                    $id_estado = $estado['id'];
                                                    $estado = $estado['estadostc'];
                                                    $selected = ($id_estado == $valor_actual_en_edicion) ? 'selected' : '';
                                                    ?>
                                                    
                                                    <option value="<?php echo $id_estado; ?>" hidden <?php echo $selected; ?> hidden <?php echo $estado; ?> hidden> </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>                                                                               
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">Ciudad</label>
                                            <select name="idciudad" id="idciudad" class="form-control" readonly>
                                                <?php
                                                $valor_actual_en_edicion = $stc['ciudad'];
                                                $query_ciudad = $pdo->prepare('SELECT * FROM ciudad');
                                                $query_ciudad->execute();
                                                $ciudades = $query_ciudad->fetchAll(PDO::FETCH_ASSOC);
                                                foreach($ciudades as $ciudad) {
                                                    $id_ciudad = $ciudad['id'];
                                                    $ciudad = $ciudad['ciudad'];
                                                    $selected = ($id_ciudad == $valor_actual_en_edicion) ? 'selected' : '';
                                                    ?>
                                                    <option value="<?php echo $id_ciudad; ?>" <?php echo $selected; ?>><?php echo $ciudad; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>                             
                                </div> 

                                <div class = "row">
                                    <div class="col-md-0">
                                        <div class="form-group"> <!-- Se coloca aquí el usuario que está trabajando el archivo -->
                                            <label for=""></label>
                                            <input  class="form-control"  id="idusuario" name="idusuario" value="<?php echo $sesion_usuario['nombre']?>" hidden>                                            
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">Cliente</label>
                                            <select name="idcliente" id="idcliente" class="form-control" readonly>
                                                <?php
                                                $valor_actual_en_edicion = $stc['cliente'];
                                                $query_cliente = $pdo->prepare('SELECT * FROM clientes');
                                                $query_cliente->execute();
                                                $clientes = $query_cliente->fetchAll(PDO::FETCH_ASSOC);
                                                foreach($clientes as $cliente) {
                                                    $id_cliente = $cliente['id'];
                                                    $cliente = $cliente['nombre_comercial'];
                                                    $selected = ($id_cliente == $valor_actual_en_edicion) ? 'selected' : '';
                                                    ?>
                                                    <option value="<?php echo $id_cliente; ?>" <?php echo $selected; ?>><?php echo $cliente; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Persona Contacto</label>
                                            <input type="text" name="personacontacto" class="form-control" placeholder="Persona Contacto" required>
                                        </div>
                                    </div>  
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Medio de Contacto</label>
                                            <input type="text" name="medio_contacto" class="form-control" placeholder="# Celular - WhatsApp - # Fijo - Correo Electronico" required>
                                        </div>
                                    </div>
                                </div>
                                    
                                <div class = "row">                                        
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="">Falla</label>
                                            <textarea name="falla" id="" cols="30" rows="4"  class="form-control" placeholder="Describa la Falla..." required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="">Observación</label>
                                            <textarea  name="observacion" id="" cols="30" rows="4" class="form-control" placeholder="Observación..." required></textarea>
                                        </div>
                                    </div>
                                </div>                            
                            </div>
                        </div>
                        <div class="col-md-3">
                                <div class="form-group">
                                    <label for="archivo_adjunto">Archivo Adjunto</label>
                                    <br>
                                    <output id="list" style="position: relative; width: 300px; height: 300px; overflow: hidden;"></output>
                                    <input type="file" name="archivo_adjunto" id="file" class="form-control-file" multiple>

                                        <script>
                                            var currentImageIndex = 0; // Índice de la imagen actual

                                            function archivo(evt) {
                                            var files = evt.target.files; // FileList object

                                                for (var i = 0, f; f = files[i]; i++) {
                                                    var reader = new FileReader();
                                                    // Si el archivo es una imagen
                                                    if (f.type.match('image.*')) {
                                                        reader.onload = (function(theFile) {
                                                            return function(e) {
                                                                // Insertamos la imagen
                                                                var img = document.createElement('img');
                                                                img.src = e.target.result;
                                                                img.width = 200; // Tamaño de la imagen
                                                                img.style.display = "none"; // Ocultamos la imagen
                                                                document.getElementById("list").appendChild(img);
                                                        };
                                                            })(f);
                                                        }
                                                        // Lectura del archivo
                                                        reader.readAsDataURL(f);
                                                    }
                                                    showImage(currentImageIndex); // Mostramos la primera imagen
                                                }

                                                document.getElementById('file').addEventListener('change', archivo, false);

                                                function showImage(index) {
                                                var images = document.getElementById("list").getElementsByTagName("img");
                                                for (var i = 0; i < images.length; i++) {
                                                    images[i].style.display = "none"; // Ocultamos todas las imágenes
                                                }
                                                images[index].style.display = "block"; // Mostramos la imagen actual
                                            }

                                            function nextImage() {
                                            var images = document.getElementById("list").getElementsByTagName("img");
                                            currentImageIndex = (currentImageIndex + 1) % images.length; // Avanzamos al siguiente índice circularmente
                                                    showImage(currentImageIndex);
                                            }

                                            function prevImage() {
                                                var images = document.getElementById("list").getElementsByTagName("img");
                                                currentImageIndex = (currentImageIndex - 1 + images.length) % images.length; // Retrocedemos al índice anterior circularmente
                                                showImage(currentImageIndex);
                                            }
                                        </script>
                                </div>
                            </div>
                            
                            
                        </div>
                                
                        <hr>

                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <a href="<?php echo $URL."admin/clientes/index.php";?>" class="btn btn-default btn-block">Cancelar</a>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="submit" onclick="return confirm('Seguro de haber diligenciado correctamente los datos?')" class="btn btn-primary btn-block">Crear Falla de Pantalla</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-md-5">
                                            <button type="button" class="btn btn-default" onclick="prevImage()">Anterior</button>
                                        </div>
                                        <div class="col-md-5">
                                            <button type="button" class="btn btn-default" onclick="nextImage()">Siguiente</button>
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
<?php include('../../layout/admin/parte2.php');?>