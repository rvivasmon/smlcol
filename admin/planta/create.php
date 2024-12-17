<?php

include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/sesion.php');
include('../../layout/admin/datos_sesion_user.php');

include('../../layout/admin/parte1.php');

// Obtener la fecha de creación del formulario
$fecha_creacion = isset($_POST['fechaingreso']) ? $_POST['fechaingreso'] : date('Y-m-d');

// Obtener el año y mes de la fecha actual en formato YYYYMM
$anio_mes = date('Ym', strtotime($fecha_creacion));

// Obtener el último registro de la base de datos ordenado por año_mes de forma descendente
$query_ultimo_registro = $pdo->prepare('SELECT * FROM id_producto WHERE anio_mes_prod = :anio_mes ORDER BY contador_prod DESC LIMIT 1');
$query_ultimo_registro->bindParam(':anio_mes', $anio_mes);
$query_ultimo_registro->execute();
$ultimo_registro_prod = $query_ultimo_registro->fetch(PDO::FETCH_ASSOC);

// Determinar el contador
if ($ultimo_registro_prod) {
    // Si hay un último registro, continuar con el contador
    $contador_prod = $ultimo_registro_prod['contador_prod'] + 1;
} else {
    // Si no hay ningún registro para este año y mes, inicializar el contador en 1
    $contador_prod = 1;
}

// Crear el ID del producto
$id_prod = $anio_mes . '-' . sprintf('%03d', $contador_prod);
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">CREAR ID PANTALLA</h1>
                </div>
            </div>

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
                                                <input type="hidden" name="anio_mes1" id="anio_mes1" value="<?php echo $anio_mes; ?>">
                                                <input type="hidden" name="contador1" value="<?php echo $contador_prod; ?>">
                                                <input type="text" name="idprod" class="form-control" value="<?php echo $id_prod; ?>" hidden>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Fecha Creación</label>
                                                <input type="date" name="fechaingreso" id="fechaingreso" class="form-control" value="<?php echo $fecha_creacion; ?>" onchange="actualizarContador()">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Agente</label>
                                                <input type="text" name="agente1" class="form-control" value="<?php echo htmlspecialchars($sesion_nombre = $sesion_usuario['nombre']); ?>" disabled>
                                                <input type="text" name="agente" class="form-control" value="<?php echo htmlspecialchars($sesion_nombre = $sesion_usuario['nombre']); ?>" hidden>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Orden OP</label>
                                                <select name="OP" id="OP" class="form-control" required>
                                                    <option value="">Seleccionar OP</option>
                                                    <?php
                                                    $query_op = $pdo->prepare('SELECT * FROM op WHERE id_producto = 1');
                                                    $query_op->execute();
                                                    $ops = $query_op->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($ops as $op) {
                                                        $id_op = $op['id'];
                                                        $op_val = $op['op'];
                                                    ?>
                                                        <option value="<?php echo htmlspecialchars($id_op); ?>"><?php echo htmlspecialchars($op_val); ?></option>
                                                    <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="">ID Producto</label>
                                                <input type="text" name="idproducto" id="idproducto" class="form-control" value="<?php echo $id_prod; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="">URL</label>
                                                <input type="text" name="url" id="url" class="form-control" placeholder="Check List">
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
                                    <!-- Contenedor general para el QR y el botón -->
                                    <div style="text-align: center; display: flex; flex-direction: column; align-items: center; gap: 5px;">
                                        <!-- Texto superior -->
                                        <div id="qrTextTop" style="font-weight: bold; font-size: 20px;"></div>
                                        <!-- Contenedor QR -->
                                        <div id="qrContainer" style="width: 250px; height: 260px; border: 1px solid #ddd;"></div>

                                    </div>
                                    <!-- Campo oculto para enviar el QR generado -->
                                    <input type="hidden" name="qr_code" id="qr_code">
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <a href="<?php echo $URL."admin/planta";?>" class="btn btn-default btn-block">Cancelar</a>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" onclick="return confirm('Seguro de haber diligenciado correctamente los datos?')" class="btn btn-primary btn-block">Crear ID</button>
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

<script
    src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"
    integrity="sha512-CNgIRecGo7nphbeZ04Sc13ka07paqdeTu0WR1IM4kNcpmBAUSHSQX0FslNhTDadL4O5SAGapGt4FodqL8My0mA=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer">
</script>

<script>
    function actualizarContador() {
    var fecha = document.getElementById('fechaingreso').value;
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "actualizar_contador.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var nuevoContador = xhr.responseText;
            var anio_mes = fecha.substring(0, 7).replace('-', '');
            var id_prod = anio_mes + '-' + ('000' + nuevoContador).slice(-3);
            document.getElementById('idproducto').value = id_prod;
            document.querySelector('input[name="anio_mes1"]').value = anio_mes;
            document.querySelector('input[name="contador1"]').value = nuevoContador;
        }
    };
    xhr.send("fecha=" + encodeURIComponent(fecha));
}
</script>

<script>
    // Contenedores y elementos del formulario
    const qrContainer = document.getElementById('qrContainer');
    const qrInput = document.getElementById('url');
    const hiddenQrInput = document.getElementById('qr_code');
    const qrTextTop = document.getElementById('qrTextTop');
    const idProductoInput = document.getElementById('idproducto');
    const fechaIngresoInput = document.getElementById('fechaingreso');

    // Función para actualizar el QR
    function actualizarQR() {
    const idProducto = idProductoInput.value.trim();  // Obtener el ID del producto
    const url = qrInput.value.trim();  // Obtener la URL ingresada

    if (!url) return; // No generar QR si no hay URL

    // Crear un nuevo canvas para personalizar el QR
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');

    // Dimensiones del canvas (ajustadas para QR y textos)
    const qrSize = 200; // Tamaño del QR
    const padding = 25; // Espaciado para los textos
    const fontSize = 18; // Tamaño de fuente para los textos
    canvas.width = qrSize;
    canvas.height = qrSize + padding * 2; // Espacio para texto superior e inferior

    // Generar el QR en un canvas temporal
    const qrCanvas = document.createElement('canvas');
    const qrCode = new QRCode(qrCanvas, {
        text: url,
        width: qrSize,
        height: qrSize,
    });

    // Esperar a que el QR se genere y renderizarlo en el nuevo canvas
    setTimeout(() => {
        ctx.fillStyle = '#ffffff'; // Fondo blanco
        ctx.fillRect(0, 0, canvas.width, canvas.height); // Llenar todo el canvas

        // Dibujar el texto superior (ID)
        ctx.fillStyle = '#000000'; // Color negro
        ctx.font = `${fontSize}px Arial`;
        ctx.textAlign = 'center';
        ctx.fillText('ID ' + idProducto, canvas.width / 2, fontSize);

        // Dibujar el QR
        ctx.drawImage(qrCanvas.querySelector('canvas'), 0, padding);

        // Dibujar el texto inferior
        ctx.fillText('SMARTLED', canvas.width / 2, canvas.height - fontSize / 2);

        // Convertir el canvas a Base64 y guardar en el input oculto
        hiddenQrInput.value = canvas.toDataURL('image/png', 1.0);

        // Mostrar el QR actualizado en la interfaz
        qrContainer.innerHTML = ''; // Limpiar contenedor
        const img = document.createElement('img');
        img.src = hiddenQrInput.value;
        qrContainer.appendChild(img);
    }, 500); // Espera para asegurarse de que el QR se haya generado
}


    // Evento de cambio en el campo fechaingreso (para actualizar el ID y limpiar el campo URL)
    fechaIngresoInput.addEventListener('change', function () {
        // Llamar a la función para actualizar el ID (idproducto)
        actualizarContador();

        // Limpiar el campo URL después de actualizar el idproducto
        qrInput.value = '';

        // Llamar a la función para actualizar el QR con los nuevos valores
        actualizarQR();
    });

    // Función para actualizar el contador e idproducto basado en la fecha
    function actualizarContador() {
        const fecha = fechaIngresoInput.value;
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "actualizar_contador.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const nuevoContador = xhr.responseText;
                const anio_mes = fecha.substring(0, 7).replace('-', '');
                const id_prod = anio_mes + '-' + ('000' + nuevoContador).slice(-3);
                idProductoInput.value = id_prod;
                document.querySelector('input[name="anio_mes1"]').value = anio_mes;
                document.querySelector('input[name="contador1"]').value = nuevoContador;
            }
        };
        xhr.send("fecha=" + encodeURIComponent(fecha));
    }

    // Evento de cambio en el campo url (para actualizar el QR)
    qrInput.addEventListener('input', actualizarQR);

    // Llamada inicial para generar el QR con los valores predeterminados
    document.addEventListener('DOMContentLoaded', actualizarQR);
</script>
