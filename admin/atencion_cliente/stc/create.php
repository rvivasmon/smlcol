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
                    <h1 class="m-0">Crear Nuevo STC</h1>
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
                                                $query_ultimo_registro = $pdo->prepare('SELECT * FROM stc ORDER BY anio_mes DESC, contador DESC LIMIT 1');
                                                $query_ultimo_registro->execute();
                                                $ultimo_registro_stc = $query_ultimo_registro->fetch(PDO::FETCH_ASSOC);

                                                // Verificar si hay un último registro
                                                if($ultimo_registro_stc) {
                                                    // Obtener el año y mes del último registro en formato YYYYMM
                                                    $ultimo_anio_mes = date('Ym', strtotime($ultimo_registro_stc['fecha_ingreso']));

                                                    // Si el mes y año del último registro son iguales al mes y año actuales, continuar con el contador
                                                    if ($ultimo_anio_mes == $anio_mes) {
                                                        $contador_stc = $ultimo_registro_stc['contador'] + 1;
                                                    } else{

                                                        // Inicializar el contador
                                                        $contador_stc = 1;
                                                    }

                                                }

                                                // Crea el ID STC utilizando el año_mes y el contador
                                                $id_stc = 'STC - ' . $anio_mes . '-' . sprintf('%03d', $contador_stc);

                                                ?>

                                                <input type="hidden" name="anio_mes" value="<?php echo $anio_mes; ?>">
                                                <input type="hidden" name="contador" value="<?php echo $contador_stc; ?>">
                                                <input type="text" name="idstc" class="form-control" value="<?php echo $id_stc; ?>" hidden>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="fechaingreso">Fecha de Ingreso</label>
                                                <input type="date" name="fechaingreso" id="fechaingreso" class="form-control" value="<?php echo date('Y-m-d'); ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Ingreso</label>
                                                <select id="medio_ingreso" name="medio_ingreso" class="form-control" value="<?php echo $medio_ingreso; ?>" required>
                                                    <option value="">Seleccionar Medio</option>
                                                    <option value="email">EMAIL</option>
                                                    <option value="llamada">LLAMADA</option>
                                                    <option value="whatsapp">WHATSAPP</option>
                                                    <option value="otro">OTRO</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="ticketexterno">Ticket Externo</label>
                                                <input type="text" name="ticketexterno" class="form-control" placeholder="Ticket Externo">
                                            </div>
                                        </div>
                                        <div class="col-md-3" hidden>
                                            <div class="form-group">
                                                <label for="">Tipo de Servicio</label>
                                                <select name="tiposervicio" id="tiposervicio" class="form-control" required>
                                                    <option value="">Seleccionat Tipo de Servicio</option>
                                                    <?php
                                                    $query_servicio = $pdo->prepare('SELECT * FROM t_tipo_servicio WHERE id = 5'); // Modificación en la consulta SQL para obtener solo el servicio con ID 5
                                                    $query_servicio->execute();
                                                    $servicio = $query_servicio->fetch(PDO::FETCH_ASSOC); // Utilizamos fetch en lugar de fetchAll, ya que esperamos solo una fila
                                                    $id_servicio = $servicio['id']; // Obtenemos el ID del servicio
                                                    $servicio_nombre = $servicio['servicio_stc']; // Obtenemos el nombre del servicio

                                                    $selected = 'selected'; // Marcamos esta opción como seleccionada, ya que solo hay una opción

                                                    ?>
                                                        <option value="<?php echo $id_servicio; ?>" <?php echo $selected; ?>><?php echo $servicio_nombre; ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">ID Producto</label>
                                                <input type="text" name="idproducto" id="idproducto" class="form-control" placeholder="ID Producto" required readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Cliente</label>
                                                <select name="idcliente" id="idcliente" class="form-control" required>
                                                    <option value="">Seleccionar Cliente</option>
                                                    <?php
                                                    $query_cliente = $pdo->prepare('SELECT * FROM clientes ORDER BY nombre_comercial ASC');
                                                    $query_cliente->execute();
                                                    $clientes = $query_cliente->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($clientes as $cliente) {
                                                        $id_cliente = $cliente['id'];
                                                        $cliente_nombre = $cliente['nombre_comercial'];
                                                        ?>
                                                        <option value="<?php echo $id_cliente; ?>"><?php echo $cliente_nombre; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Ciudad</label>
                                                <select name="idciudad" id="idciudad" class="form-control" required>
                                                    <option value="">Seleccionar Ciudad</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Lugar de instalación</label>
                                                <select name="proyecto" id="proyecto" class="form-control" required>
                                                    <option value="">Seleccione un Lugar</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Persona Contacto</label>
                                                <input type="text" name="personacontacto" class="form-control" placeholder="Persona Contacto" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Estado</label>
                                                <select name="idestado" id="idestado" class="form-control" required>
                                                    <?php
                                                    $query_estado = $pdo->prepare('SELECT * FROM t_estado WHERE id = "1"');
                                                    $query_estado->execute();
                                                    $estados = $query_estado->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($estados as $estado) {
                                                        $id_estado = $estado['id'];
                                                        $estado = $estado['estadostc'];
                                                        ?>
                                                        <option value="<?php echo $id_estado; ?>"><?php echo $estado; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
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
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Medio de Contacto</label>
                                                <input type="text" name="medio_contacto" class="form-control" placeholder="Medio de Contacto" required>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="">Falla</label>
                                                <textarea name="falla" id="" cols="30" rows="4" class="form-control" placeholder="Fallas" required></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="">Observación</label>
                                                <textarea name="observacion" id="" cols="30" rows="4" class="form-control" placeholder="Observaciones" required></textarea>
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

<?php include('../../../layout/admin/parte2.php');?>

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
document.getElementById('idcliente').addEventListener('change', function() {
    var clienteId = this.value;
    var ciudadSelect = document.getElementById('idciudad');
    ciudadSelect.innerHTML = '<option value="">Seleccionar Ciudad</option>'; // Opción predeterminada
    var proyectoSelect = document.getElementById('proyecto');
    proyectoSelect.innerHTML = '<option value="">Seleccionar Ciudad</option>'; // Opción predeterminada

    var idproductoInput = document.getElementById('idproducto');
    idproductoInput.value = ''; //Limpia el valor
    

    if (clienteId) {
        // Realizar la solicitud AJAX para obtener las ciudades
        fetch(`obtener_ciudades.php?cliente_id=${clienteId}`)
            .then(response => response.json())
            .then(ciudades => {
                ciudades.forEach(function(ciudad) {
                    var option = document.createElement('option');
                    option.value = ciudad.ciudad_id; // Asignar el ID de la ciudad como valor
                    option.textContent = ciudad.nombre_ciudad; // Mostrar el nombre de la ciudad
                    ciudadSelect.appendChild(option);
                });
            });
    }
});

document.getElementById('idciudad').addEventListener('change', function() {
    var clienteId = document.getElementById('idcliente').value;
    var ciudadId = this.value;

    // Limpiar el select de proyectos
    var proyectoSelect = document.getElementById('proyecto');
    proyectoSelect.innerHTML = '<option value="">Seleccione un proyecto</option>';

    if (clienteId && ciudadId) {
        // Cargar los proyectos asociados al cliente y la ciudad seleccionada
        fetch(`obtener_lugar_instalacion.php?cliente_id=${clienteId}&ciudad_id=${ciudadId}`)
            .then(response => response.json())
            .then(proyectos => {
                proyectos.forEach(function(proyecto) {
                    var option = document.createElement('option');
                    option.value = proyecto.id;
                    option.textContent = proyecto.lugar_instalacion;
                    proyectoSelect.appendChild(option);
                });
            });
    }
});

document.getElementById('proyecto').addEventListener('change', function() {
    var proyectoId = this.value;

    if (proyectoId) {
        // Llamada AJAX para obtener el id_producto basado en el proyecto seleccionado
        fetch(`obtener_id_producto.php?proyecto_id=${proyectoId}`)
            .then(response => response.json())
            .then(data => {
                // Verifica que el producto exista antes de colocarlo en el campo
                if (data.id_producto) {
                    document.querySelector('input[name="idproducto"]').value = data.id_producto;
                } else {
                    document.querySelector('input[name="idproducto"]').value = ''; // Limpia el campo si no se encuentra el producto
                    alert("No se encontró un producto correspondiente para este proyecto.");
                }
            })
            .catch(error => console.error('Error al obtener el ID del producto:', error));
    } else {
        document.querySelector('input[name="idproducto"]').value = ''; // Limpia el campo si no se selecciona un proyecto
    }
});

</script>
