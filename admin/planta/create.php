<?php 

include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/sesion.php');
include('../../layout/admin/datos_sesion_user.php');

?>

<?php include('../../layout/admin/parte1.php');?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">CREAR ID PRODUCTO</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card card-blue">
                <div class="card-header">
                    Introduzca la información correspondiente
                </div>
                <div class="card-body">
                    <form id="formulario" action="controller_create.php" method="POST" enctype="multipart/form-data">

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
                                                <label for="">Fecha de Creación</label>
                                                <input type="date" name="fechaingreso" id="fechaingreso" class="form-control" value= "<?php echo date('Y-m-d'); ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Agente</label>
                                                <input type="text" name="Agente" class="form-control" placeholder="Agente">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Orden de Producción OP</label>
                                                <select name="tiposervicio" id="tiposervicio" class="form-control" required>
                                                    <option value="">Seleccionat Tipo de Servicio</option>
                                                    <?php 
                                                    $query_servicio = $pdo->prepare('SELECT * FROM tipo_servicio');
                                                    $query_servicio->execute();
                                                    $servicios = $query_servicio->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($servicios as $servicio) {
                                                        $id_servicio = $servicio['id'];
                                                        $servicio = $servicio['servicio_stc'];
                                                        $selected = ($id_servicio == 5) ? 'selected' : '';
                                                        if($id_servicio !=4) {
                                                    ?>
                                                        <option value="<?php echo $id_servicio; ?>" <?php echo $selected; ?>><?php echo $servicio; ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">ID Producto</label>
                                                <input type="text" name="idproducto" class="form-control" placeholder="ID Producto" required>
                                            </div>
                                        </div>                                    
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">

                                                <label for="">Cliente</label>
                                                <select name="idcliente" id="idcliente" class="form-control" required>
                                                    <option value="">Seleccionar Cliente</option>

                                                    <?php 
                                                    $query_cliente = $pdo->prepare('SELECT * FROM clientes');
                                                    $query_cliente->execute();
                                                    $clientes = $query_cliente->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($clientes as $cliente) {
                                                        $id_cliente = $cliente['id'];
                                                        $cliente = $cliente['nombre_comercial'];
                                                        ?>
                                                        <option value="<?php echo $id_cliente; ?>"><?php echo $cliente; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">POP</label>
                                                <select name="idciudad" id="idciudad" class="form-control" required>
                                                    <option value="">Seleccionar POP</option>

                                                    <?php 
                                                    $query_ciudad = $pdo->prepare('SELECT * FROM ciudad');
                                                    $query_ciudad->execute();
                                                    $ciudades = $query_ciudad->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($ciudades as $ciudad) {
                                                        $id_ciudad = $ciudad['id'];
                                                        $ciudad = $ciudad['ciudad'];
                                                        ?>
                                                        <option value="<?php echo $id_ciudad; ?>"><?php echo $ciudad; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Check List</label>
                                                <input type="text" name="proyecto" class="form-control" placeholder="Check List" required>
                                            </div>
                                        </div>
                                    </div>                                
                                    <div class="row">
                                        <div class="col-md-0"> <!-- Se coloca aquí el usuario que está trabajando el archivo --> 
                                            <div class="form-group">
                                                <label for=""></label>
                                                <input type="text" name="usuario" class="form-control" value="<?php echo $sesion_nombre; ?>" hidden>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="archivo_adjunto">Archivo Adjunto</label>
                                    <br>
                                    <output id="list" style="position: relative; width: 200px; height: 200px; overflow: hidden;"></output>
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
                                        <div class="col-md-2">
                                            <a href="<?php echo $URL."admin/atencion_cliente/stc";?>" class="btn btn-default btn-block">Cancelar</a>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" onclick="return confirm('Seguro de haber diligenciado correctamente los datos?')" class="btn btn-primary btn-block">Crear STC</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-default" onclick="prevImage()">Anterior</button>
                                        </div>
                                        <div class="col-md-6">
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

<?php include('../../layout/admin/parte2.php');?>
