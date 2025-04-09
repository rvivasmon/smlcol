<?php 

include('../../../app/config/config.php');
include('../../../app/config/conexion.php');

include('../../../layout/admin/sesion.php');
include('../../../layout/admin/datos_sesion_user.php');

include('../../../layout/admin/parte1.php');

$usuario = $sesion_usuario['nombre'];

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Crear Nuevo Producto</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card card-blue">
                <div class="card-header">
                    Introduzca la información correspondiente
                </div>
                <div class="card-body">
                    <form id="" action="controller_create.php" method="POST" enctype="multipart/form-data">

                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="producto">Categoría</label>
                                                <select name="producto" id="producto" class="form-control">
                                                    <option value="">Seleccione un Producto</option>
                                                    <?php
                                                    $query_producto = $pdo->prepare('SELECT id_producto, tipo_producto FROM t_productos WHERE tipo_producto IS NOT NULL AND tipo_producto != "" AND habilitar = "1" ORDER BY tipo_producto ASC');
                                                    $query_producto->execute();
                                                    $productos = $query_producto->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($productos as $producto) {
                                                        echo '<option value="' . $producto['id_producto'] . '">' . $producto['tipo_producto'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-0">
                                            <div class="form-group"> <!-- Se coloca aquí el usuario que está trabajando el  -->
                                                <input  class="form-control"  id="idusuario" name="idusuario" value="<?php echo $sesion_usuario['nombre']?>" hidden>
                                                <input  class="form-control"  id="nombreidusuario" name="nombreidusuario" value="<?php echo $sesion_usuario['id']?>" hidden>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-sm-6">
                                            <h1 class="m-0">Validar Producto</h1>
                                        </div><!-- /.col -->
                                    </div><!-- /.row -->

                                    <!-- MODULO -->

                                    <div class="row">
                                        <div class="col-md-3 campo Modulo">
                                            <div class="form-group">
                                                <label for="uso">Uso</label>
                                                <select id="uso" name="uso" class="form-control">
                                                    <option value="">Seleccione un Uso</option>
                                                    <?php
                                                    // Obtener el valor del producto seleccionado
                                                    $categoria_id = 1; // Por defecto, seleccionamos el primero
                                                    $query_uso = $pdo->prepare('SELECT id_uso, producto_uso FROM t_uso_productos WHERE t_productos = :categoria_id AND producto_uso IS NOT NULL AND producto_uso != "" ORDER BY producto_uso ASC');
                                                    $query_uso->execute(['categoria_id' => $categoria_id]);
                                                    $usos = $query_uso->fetchAll(PDO::FETCH_ASSOC);

                                                    foreach ($usos as $uso): ?>
                                                        <option value="<?php echo htmlspecialchars($uso['id_uso']); ?>">
                                                            <?php echo htmlspecialchars($uso['producto_uso']); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-5 campo Modulo">
                                            <div class="form-group">
                                                <label for="modelo_modulo1">Modelo</label>
                                                <select id="modelo_modulo1" name="modelo_modulo1" class="form-control">

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 campo Modulo">
                                            <div class="form-group">
                                                <label for="pitch">Pitch</label>
                                                <select id="pitch" name="pitch" class="form-control">
                                                    <option value="">Seleccione un pitch</option>
                                                    <?php
                                                    $query_pitch = $pdo->prepare('SELECT id, pitch FROM tabla_pitch WHERE habilitar_almacen = "1" ORDER BY pitch ASC');
                                                    $query_pitch->execute();
                                                    $pitches = $query_pitch->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($pitches as $pitch): ?>
                                                        <option value="<?php echo $pitch['id']; ?>">
                                                            <?php echo $pitch['pitch']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2 campo Modulo">
                                            <div class="form-group">
                                                <label for="medida_modulo">Tamaño Modulo</label>
                                                <select id="medida_modulo" name="medida_modulo" class="form-control">
                                                    <option value="">Seleccione una Medida</option>
                                                    <?php
                                                    $query_tamano = $pdo->prepare('SELECT * FROM tabla_tamanos_modulos WHERE habilitar_almacen = "1" ORDER BY tamanos_modulos ASC');
                                                    $query_tamano->execute();
                                                    $tamanos = $query_tamano->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($tamanos as $tamano): ?>
                                                        <option value="<?php echo $tamano['id']; ?>"
                                                        data-tamano-x="<?php echo $tamano['tamano_x']; ?>"
                                                        data-tamano-y="<?php echo $tamano['tamano_y']; ?>">
                                                            <?php echo $tamano['tamanos_modulos']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 campo Modulo" hidden>
                                            <div class="form-group">
                                                <label for="medida_x">Tamaño X</label>
                                                <input type="text" id="medida_x" name="medida_x" class="form-control" placeholder="Tamaño X" >
                                            </div>
                                        </div>
                                        <div class="col-md-2 campo Modulo" hidden>
                                            <div class="form-group">
                                                <label for="medida_y">Tamaño Y</label>
                                                <input type="text" id="medida_y" name="medida_y" class="form-control" placeholder="Tamaño Y" >
                                            </div>
                                        </div>
                                        <div class="col-md-2 campo Modulo" hidden>
                                            <div class="form-group">
                                                <label for="pixel_x">Pixel X</label>
                                                <input type="text" id="pixel_x" name="pixel_x" class="form-control" placeholder="Pixel X" >
                                            </div>
                                        </div>
                                        <div class="col-md-2 campo Modulo" hidden>
                                            <div class="form-group">
                                                <label for="pixel_y">Pixel Y</label>
                                                <input type="text" id="pixel_y" name="pixel_y" class="form-control" placeholder="Pixel Y" >
                                            </div>
                                        </div>
                                        <div class="col-md-4 campo Modulo">
                                            <div class="form-group">
                                                <label for="serie_modulo">Serie Modulo</label>
                                                <input type="text" id="serie_modulo" name="serie_modulo" class="form-control" placeholder="Serie Módulo" >
                                            </div>
                                        </div>
                                        <div class="col-md-4 campo Modulo" hidden>
                                            <div class="form-group">
                                                <label for="referencia_modulo">Referencia Módulo</label>
                                                <input type="text" id="referencia_modulo" name="referencia_modulo" class="form-control" placeholder="Referencia Módulo" >
                                            </div>
                                        </div>
                                    </div>

                                    <!-- CONTROLADORA -->

                                    <div class="row">
                                        <div class="col-md-3 campo Control">
                                            <div class="form-group">
                                                <label for="marca_control">Marca</label>
                                                <select id="marca_control" name="marca_control" class="form-control">
                                                    <option value="">Seleccione una Marca</option>
                                                    <?php
                                                    $query_marca_fuente = $pdo->prepare("SELECT * FROM caracteristicas_control WHERE marca_control IS NOT NULL AND marca_control != '' ORDER BY marca_control ASC");
                                                    $query_marca_fuente->execute();
                                                    $marcas_fuentes = $query_marca_fuente->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($marcas_fuentes as $marca_fuente): ?>
                                                        <option value="<?php echo $marca_fuente['id_car_ctrl']; ?>">
                                                            <?php echo $marca_fuente['marca_control']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 campo Control">
                                            <div class="form-group">
                                                <label for="funcion_control">Función</label>
                                                <select id="funcion_control" name="funcion_control" class="form-control">
                                                    <option value="">Seleccione una Función</option>
                                                    <?php
                                                    $query_marca_fuente = $pdo->prepare("SELECT * FROM caracteristicas_control WHERE funcion_control IS NOT NULL AND funcion_control != '' ORDER BY funcion_control ASC");
                                                    $query_marca_fuente->execute();
                                                    $marcas_fuentes = $query_marca_fuente->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($marcas_fuentes as $marca_fuente): ?>
                                                        <option value="<?php echo $marca_fuente['id_car_ctrl']; ?>">
                                                            <?php echo $marca_fuente['funcion_control']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 campo Control">
                                            <div class="form-group">
                                                <label for="sim">SIM</label>
                                                <select name="sim" id="sim" class="form-control">
                                                    <option value="" selected disabled>Seleccione una opción</option>
                                                    <option value="1">SÍ</option>
                                                    <option value="0">NO</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 campo Control">
                                            <div class="form-group">
                                                <label for="puertos">Cantidad Puertos</label>
                                                <input type="text" id="puertos" name="puertos" class="form-control" placeholder="Puertos" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 campo Control">
                                            <div class="form-group">
                                                <label for="referencia_control">Referencia</label>
                                                <input type="text" id="referencia_control" name="referencia_control" class="form-control" placeholder="Pixel Máximo" >
                                            </div>
                                        </div>
                                        <div class="col-md-3 campo Control">
                                            <div class="form-group">
                                                <label for="pixel_maximo">Pixel Máximo</label>
                                                <input type="text" id="pixel_maximo" name="pixel_maximo" class="form-control" placeholder="Pixel Máximo" >
                                            </div>
                                        </div>
                                        <div class="col-md-3 campo Control">
                                            <div class="form-group">
                                                <label for="pixel_x_puerto">Pixel x Puerto</label>
                                                <input type="text" id="pixel_x_puerto" name="pixel_x_puerto" class="form-control" placeholder="Pixel x Puerto" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2 campo Control">
                                            <div class="form-group">
                                                <label for="pixel_x_maximo">Pixel X Máximo</label>
                                                <input type="text" id="pixel_x_maximo" name="pixel_x_maximo" class="form-control" placeholder="Pixel X Máximo" >
                                            </div>
                                        </div>
                                        <div class="col-md-2 campo Control">
                                            <div class="form-group">
                                                <label for="pixel_y_maximo">Pixel Y Máximo</label>
                                                <input type="text" id="pixel_y_maximo" name="pixel_y_maximo" class="form-control" placeholder="Pixel Y Máximo" >
                                            </div>
                                        </div>
                                        <div class="col-md-6 campo Control">
                                            <div class="form-group">
                                                <label for="descripcion">Descripción</label>
                                                <textarea id="descripcion" name="descripcion" class="form-control" placeholder="Descripción" rows="4"></textarea>
                                                </div>
                                        </div>
                                    </div>

                                    <!-- FUENTE -->

                                    <div class="row">
                                        <div class="col-md-4 campo Fuente">
                                            <div class="form-group">
                                                <label for="marca_fuente">Marca</label>
                                                <select id="marca_fuente" name="marca_fuente" class="form-control">
                                                    <option value="">Seleccione una Marca</option>
                                                    <?php
                                                    $query_marca_fuente = $pdo->prepare("SELECT * FROM caracteristicas_fuentes WHERE marca_fuente IS NOT NULL AND marca_fuente != '' ORDER BY marca_fuente ASC");
                                                    $query_marca_fuente->execute();
                                                    $marcas_fuentes = $query_marca_fuente->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($marcas_fuentes as $marca_fuente): ?>
                                                        <option value="<?php echo $marca_fuente['id_car_fuen']; ?>">
                                                            <?php echo $marca_fuente['marca_fuente']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 campo Fuente">
                                            <div class="form-group">
                                                <label for="tipo_fuente">Tipo</label>
                                                <select id="tipo_fuente" name="tipo_fuente" class="form-control">
                                                    <option value="">Seleccione una Tipo</option>
                                                    <?php
                                                    $query_tipo_fuente = $pdo->prepare("SELECT * FROM caracteristicas_fuentes WHERE tipo_fuente IS NOT NULL AND tipo_fuente != '' ORDER BY tipo_fuente ASC");
                                                    $query_tipo_fuente->execute();
                                                    $tipos_fuentes = $query_tipo_fuente->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($tipos_fuentes as $tipo_fuente): ?>
                                                        <option value="<?php echo $tipo_fuente['id_car_fuen']; ?>">
                                                            <?php echo $tipo_fuente['tipo_fuente']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 campo Fuente">
                                            <div class="form-group">
                                                <label for="voltaje_fuente">Voltaje</label>
                                                <select id="voltaje_fuente" name="voltaje_fuente" class="form-control">
                                                    <option value="">Seleccione un Voltaje</option>
                                                    <?php
                                                    $query_voltaje = $pdo->prepare("SELECT * FROM caracteristicas_fuentes WHERE voltaje IS NOT NULL AND voltaje != '' ORDER BY voltaje ASC");
                                                    $query_voltaje->execute();
                                                    $voltajes = $query_voltaje->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($voltajes as $voltaje): ?>
                                                        <option value="<?php echo $voltaje['id_car_fuen']; ?>">
                                                            <?php echo $voltaje['voltaje']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-5 campo Fuente">
                                            <div class="form-group">
                                                <label for="modelo_fuente">Modelo</label>
                                                <input type="text" id="modelo_fuente" name="modelo_fuente" class="form-control" placeholder="Modelo">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- LCD -->

                                    <div class="row">
                                        <div class="col-md-3 campo LCD">
                                            <div class="form-group">
                                                <label for="marca_lcd">Marca</label>
                                                <input type="text" id="marca_lcd" name="marca_lcd" class="form-control" placeholder="Marca">
                                            </div>
                                        </div>
                                        <div class="col-md-3 campo LCD">
                                            <div class="form-group">
                                                <label for="modelo_lcd">Modelo</label>
                                                <input type="text" id="modelo_lcd" name="modelo_lcd" class="form-control" placeholder="Modelo">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <a href="<?php echo $URL."admin/almacen/inventario/";?>" class="btn btn-default btn-block">Cancelar</a>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <button type="submit" onclick="return confirm('Seguro de haber diligenciado correctamente los datos?')" class="btn btn-primary btn-block">Guardar Producto</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="archivo_adjunto">Archivo Adjunto</label>
                                                <br>
                                                <output id="list" style="position: relative; width: 300px; height: 300px; overflow: hidden;"></output>
                                                <input type="file" name="archivo_adjunto" id="file" class="form-control-file" multiple >
                                            </div>
                                        </div>
                                        <div class="col-md-4" hidden>
                                            <div class="form-group">
                                                <label for="almacen_grupo">ALMACEN</label>
                                                <select id="almacen_grupo" name="almacen_grupo" class="form-control">
                                                    <option value="" disabled selected>Seleccione un Almacen</option>
                                                    <?php
                                                    $query_almagrupo = $pdo->prepare('SELECT id, almacenes FROM almacenes_grupo WHERE almacenes IS NOT NULL AND almacenes != "" ORDER BY almacenes ASC');
                                                    $query_almagrupo->execute();
                                                    $almagrupos = $query_almagrupo->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($almagrupos as $almagrupo): ?>
                                                        <option value="<?php echo $almagrupo['id']; ?>">
                                                            <?php echo $almagrupo['almacenes']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
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
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
</div>

<?php include('../../../layout/admin/parte2.php'); ?>


<script>

    // Código para ingresar productos con pistola

    let seriales = [];
    
    // Función que se activa cuando se escanea un código de barras
    function agregarSerial(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            const codigo = document.getElementById("codigo_barras").value;

            if (codigo) {
                // Agregar el código a la lista de seriales
                seriales.push(codigo);

                // Mostrar los seriales en la tabla
                let listaSeriales = document.getElementById("lista_seriales");
                let row = document.createElement("tr");
                row.innerHTML = `<td>${seriales.length}</td><td>${codigo}</td>`;
                listaSeriales.appendChild(row);

                // Actualizar el campo oculto con los seriales
                document.getElementById("seriales").value = JSON.stringify(seriales);

                // Limpiar el campo de entrada
                document.getElementById("codigo_barras").value = "";
            }
        }
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ocultar todos los campos al cargar la página
        var campos = document.querySelectorAll('.campo');
        campos.forEach(function(campo) {
            campo.style.display = 'none';
        });

        // Llamar a la función cuando el campo de producto cambia
        document.getElementById('producto').addEventListener('change', function() {
            actualizarCampos();
        });

        // Función para mostrar/ocultar campos según el producto seleccionado
        function actualizarCampos() {
            var producto = document.getElementById('producto').value.toLowerCase().trim();
            var campos = document.querySelectorAll('.campo');
            
            // Ocultar todos los campos
            campos.forEach(function(campo) {
                campo.style.display = 'none';
            });

            // Mostrar campos según el producto seleccionado
            if (producto === "1") {
                mostrarCampos('Modulo');
            } else if (producto === "2") {
                mostrarCampos('Control');
            } else if (producto === "3") {
                mostrarCampos('Fuente');
            } else if (producto === "4") {
                mostrarCampos('LCD');
            } else if (producto === "5") {
                mostrarCampos('Accesorios');
            }
        }

        function mostrarCampos(clase) {
            var campos = document.querySelectorAll('.' + clase);
            campos.forEach(function(campo) {
                campo.style.display = 'block';
            });
        }
    });
</script>
<script>
    $(document).ready(function() {
        // Capturar el evento cuando se cambia el valor del select 'medida_modulo'
        $('#medida_modulo').change(function() {
            // Obtener el valor seleccionado y los datos personalizados
            var selectedOption = $(this).find('option:selected');
            var tamanoX = selectedOption.data('tamano-x');
            var tamanoY = selectedOption.data('tamano-y');

            // Actualizar los campos ocultos con los valores de tamano_x y tamano_y
            $('#medida_x').val(tamanoX).closest('.Modulo').show();  // Muestra el campo
            $('#medida_y').val(tamanoY).closest('.Modulo').show();  // Muestra el campo

            // Una vez que se actualizan los valores de medida_x y medida_y, calcular los píxeles
            calcularPixeles();  // Llama a la función para recalcular los píxeles
        });

        // También detecta cambios en el campo 'pitch'
        $('#pitch').change(function() {
            calcularPixeles();  // Recalcular los píxeles cuando el pitch cambia
        });
    });

    // Función para calcular los píxeles
    function calcularPixeles() {
        // Obtener los valores de los campos
        var medidaX = parseFloat($('#medida_x').val());
        var medidaY = parseFloat($('#medida_y').val());
        var pitch = parseFloat($('#pitch').val());

        // Verificar que todos los valores sean números válidos antes de continuar
        if (!isNaN(medidaX) && !isNaN(medidaY) && !isNaN(pitch) && pitch > 0) {
            // Calcular pixel_x y pixel_y redondeados hacia arriba
            var pixelX = Math.round(medidaX / pitch);
            var pixelY = Math.round(medidaY / pitch);

            // Asignar los resultados a los campos correspondientes
            $('#pixel_x').val(pixelX);
            $('#pixel_y').val(pixelY);
        }
    }
</script>
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

<script>
$(document).ready(function() {
    // Escuchar cambios en el campo 'uso'
    $('#uso').change(function() {
        var id_uso = $(this).val(); // Obtener el valor seleccionado (id_uso)

        // Verificar que haya un valor seleccionado
        if (id_uso !== "") {
            // Realizar petición AJAX
            $.ajax({
                url: 'get_modelos.php', // Archivo PHP que hará la consulta
                type: 'POST',
                data: { id_uso: id_uso }, // Enviar el id_uso
                success: function(response) {
                    // Rellenar el select 'modelo_modulo1' con los datos recibidos
                    $('#modelo_modulo1').html(response);
                },
                error: function() {
                    alert('Hubo un error al cargar los modelos.');
                }
            });
        } else {
            // Limpiar el campo 'modelo_modulo1' si no se selecciona un 'uso'
            $('#modelo_modulo1').html('<option value="">Seleccione un Modelo</option>');
        }
    });
});
</script>

<script>
    $(document).ready(function() {
        // Detectar cuando cambie el valor del campo 'producto'
        $('#producto').change(function() {
            limpiarCampos(); // Llama a la función que limpia los campos
        });

        // Función para limpiar todos los campos del formulario, excluyendo el campo 'producto'
        function limpiarCampos() {
            // Limpiar todos los inputs de texto, select y textarea, excepto el campo 'producto'
            $('input[type="text"]').not('#producto').val('');  // Limpiar campos de texto excepto 'producto'
            $('input[type="number"]').val(''); // Limpiar campos numéricos
            $('input[type="file"]').val('');   // Limpiar campo de archivo
            $('select').not('#producto').val(''); // Limpiar selects excepto 'producto'
            $('textarea').val('');             // Limpiar textareas

            // También puedes vaciar los campos ocultos, si es necesario
            $('input[type="hidden"]').val('');

            // Si tienes algún campo específico que necesitas manejar aparte, puedes hacerlo aquí.
            $('#list').empty(); // Vaciar la lista de imágenes si es necesario
            $('#lista_seriales').empty(); // Vaciar la tabla de seriales
            seriales = []; // Reiniciar la lista de seriales (si usas esa variable)
        }
    });
</script>


