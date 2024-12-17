<?php

include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/sesion.php');
include('../../layout/admin/datos_sesion_user.php');

include('../../layout/admin/parte1.php');

$id = $_GET['id'];

$query_pantallas = $pdo->prepare("SELECT idp.*,
                                            idp.id_producto AS id_producto,
                                            op.op AS nombre_op,
                                            pop_admin.pop AS pop,
                                            clientes.nombre_comercial AS cliente,
                                            t_ciudad.ciudad AS ciudad,
                                            oc_admin.nombre_proyecto AS proyecto,
                                            oc_admin.lugar_instalacion AS lugar
                                        FROM
                                            id_producto as idp
                                        LEFT JOIN
                                            op ON idp.op = op.id
                                        LEFT JOIN
                                            pop_admin ON op.pop = pop_admin.id
                                        LEFT JOIN
                                            oc_admin ON pop_admin.oc = oc_admin.id
                                        LEFT JOIN
                                            clientes ON oc_admin.cliente = clientes.id
                                        LEFT JOIN
                                            t_ciudad ON oc_admin.ciudad = t_ciudad.id
                                        WHERE
                                            idp.id = $id
                                        ");

$query_pantallas->execute();
$pantallas_id = $query_pantallas->fetchAll(PDO::FETCH_ASSOC);

foreach($pantallas_id as $pantalla_id){
    $id = $pantalla_id['id'];
    $fecha = $pantalla_id['fecha'];
    $op = $pantalla_id['nombre_op'];
    $id_producto = $pantalla_id['id_producto'];
    $imagen_qr = $pantalla_id['qr_image_path'];
    $url = $pantalla_id['url'];
    $pop = $pantalla_id['pop'];
    $cliente = $pantalla_id['cliente'];
    $proyecto = $pantalla_id['proyecto'];
    $ciudad = $pantalla_id['ciudad'];
    $lugar_instalacion = $pantalla_id['lugar'];

}

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">EDITAR ID PANTALLA</h1>
                </div>
            </div>

            <div class="card card-green">
                <div class="card-header">
                    Introduzca la información correspondiente
                </div>
                <div class="card-body">
                    <form action="controller_edit.php" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Fecha Creación</label>
                                                <input type="date" name="fechaingreso" id="fechaingreso" class="form-control" value="<?php echo $fecha; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">OP</label>
                                                <input type="text" name="op" id="op" class="form-control" value="<?php echo $op; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">POP</label>
                                                <input type="text" name="pop" id="pop" class="form-control" value="<?php echo $pop; ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Cliente</label>
                                                <input type="text" name="cliente" id="cliente" class="form-control" value="<?php echo $cliente; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">ID Producto</label>
                                                <input type="text" name="idproducto" id="idproducto" class="form-control" value="<?php echo $id_producto; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">URL</label>
                                                <input type="text" name="url" id="url" class="form-control" value="<?php echo $url; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                            <div class="col-md-0"> <!-- Se coloca aquí el usuario que está trabajando el archivo -->
                                                <div class="form-group">
                                                    <label for=""></label>
                                                    <input type="text" name="usuario" class="form-control" value="<?php echo $sesion_nombre; ?>" hidden>
                                                    <input type="text" name="producto_id" class="form-control" value="<?php echo $id; ?>" hidden>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Proyecto</label>
                                                    <input type="text" name="proyecto" id="proyecto" class="form-control" value="<?php echo $proyecto; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Ciudad</label>
                                                    <input type="text" name="ciudad" id="ciudad" class="form-control" value="<?php echo $ciudad; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Lugar Instalación</label>
                                                    <input type="text" name="lugar_instalacion" id="lugar_instalacion" class="form-control" value="<?php echo $lugar_instalacion; ?>" readonly>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="archivo_adjunto">Archivo Adjunto</label>
                                    <br>
                                    <!-- Contenedor para mostrar la imagen del QR -->
                                    <div id="qrContainer">
                                        <?php if (!empty($imagen_qr)): ?>
                                            <img src="<?php echo htmlspecialchars($imagen_qr); ?>" alt="QR Code" style="width: 230px; height: 250px; border: 1px solid #ddd;">
                                        <?php else: ?>
                                            <p>No hay imagen del QR disponible.</p>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Botón para eliminar QR -->
                                    <button type="button" id="eliminarQR" class="btn btn-danger btn-sm mt-2">Eliminar QR</button>

                                    <!-- Inputs necesarios para la generación del QR -->
                                    <input type="hidden" id="url" placeholder="URL para generar QR" class="form-control">
                                    <input type="hidden" id="qr_code" name="qr_code">
                                    <input type="hidden" id="fechaingreso" name="fechaingreso" class="form-control">

                                    <!-- Inputs ocultos para almacenar valores adicionales -->
                                    <input type="hidden" name="anio_mes1">
                                    <input type="hidden" name="contador_prod" id="contador_prod">
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <a href="<?php echo $URL."admin/planta";?>" class="btn btn-default btn-block">Volver</a>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <button type="submit" onclick="return confirm('Seguro de haber diligenciado correctamente los datos?')" class="btn btn-success btn-block">Guardar ID</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">

                                        </div>
                                        <div class="col-md-4">

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

<!-- Incluir la librería de QRCode.js -->
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"
    integrity="sha512-CNgIRecGo7nphbeZ04Sc13ka07paqdeTu0WR1IM4kNcpmBAUSHSQX0FslNhTDadL4O5SAGapGt4FodqL8My0mA=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer">
</script>

<script>
    // Contenedores y elementos del formulario
    const qrContainer = document.getElementById('qrContainer');
    const qrInput = document.getElementById('url');
    const hiddenQrInput = document.getElementById('qr_code');
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

        const qrSize = 200; // Tamaño del QR
        const padding = 25; // Espaciado para los textos
        const fontSize = 18; // Tamaño de fuente para los textos
        canvas.width = qrSize;
        canvas.height = qrSize + padding * 2;

        const qrCanvas = document.createElement('canvas');
        const qrCode = new QRCode(qrCanvas, {
            text: url,
            width: qrSize,
            height: qrSize,
        });

        setTimeout(() => {
            ctx.fillStyle = '#ffffff'; // Fondo blanco
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            // Texto superior (ID del producto)
            ctx.fillStyle = '#000000';
            ctx.font = `${fontSize}px Arial`;
            ctx.textAlign = 'center';
            ctx.fillText(idProducto, canvas.width / 2, fontSize);

            // Dibujar el QR
            ctx.drawImage(qrCanvas.querySelector('canvas'), 0, padding);

            // Texto inferior
            ctx.fillText('SMARTLED', canvas.width / 2, canvas.height - fontSize / 2);

            hiddenQrInput.value = canvas.toDataURL('image/png', 1.0);

            // Actualizar contenedor del QR
            qrContainer.innerHTML = '';
            const img = document.createElement('img');
            img.src = hiddenQrInput.value;
            qrContainer.appendChild(img);
        }, 500);
    }

    // Función para actualizar el contador basado en la fecha
    function actualizarContador() {
        const fecha = fechaIngresoInput.value;
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "actualizar_contador.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const nuevoContador = xhr.responseText;
                const anio_mes = fecha.substring(0, 7).replace('-', '');
                const id_prod = 'ID ' + anio_mes + '-' + ('000' + nuevoContador).slice(-3);
                idProductoInput.value = id_prod;
                document.querySelector('input[name="anio_mes1"]').value = anio_mes;
                document.querySelector('input[name="contador1"]').value = nuevoContador;
            }
        };
        xhr.send("fecha=" + encodeURIComponent(fecha));
    }

    // Eventos
    fechaIngresoInput.addEventListener('change', function () {
        actualizarContador();
        qrInput.value = '';
        actualizarQR();
    });

    qrInput.addEventListener('input', actualizarQR);

    document.addEventListener('DOMContentLoaded', actualizarQR);
</script>

<script>
    // Botón para eliminar QR
const eliminarQRButton = document.getElementById('eliminarQR');

// Evento para limpiar los campos y eliminar el QR
eliminarQRButton.addEventListener('click', function () {
    // Limpiar los campos
    idProductoInput.value = ''; // Limpia el campo del ID Producto
    qrInput.value = '';        // Limpia el campo de la URL
    hiddenQrInput.value = '';  // Limpia el campo oculto del QR

    // Remover el QR del contenedor
    qrContainer.innerHTML = '<p>No hay imagen del QR disponible.</p>';
});

</script>

<script>
    // Selecciona los campos del formulario
    const idProductoInput1 = document.getElementById('idproducto'); // Campo "idproducto"
    const contadorProdInput = document.querySelector('input[name="contador_prod"]'); // Campo "contador_prod"

    // Función para actualizar el contador basado en los últimos tres dígitos de "idproducto"
    function actualizarContadorProd() {
        const idProducto = idProductoInput1.value.trim(); // Obtiene el valor del campo "idproducto"

        // Extrae los últimos 3 dígitos del valor de "idproducto"
        const ultimosTresDigitos = idProducto.slice(-3);

        // Asigna los últimos 3 dígitos al campo "contador_prod"
        contadorProdInput.value = ultimosTresDigitos;
    }

    // Agrega un evento "input" al campo "idproducto" para detectar cambios
    idProductoInput1.addEventListener('input', actualizarContadorProd);

    // Inicializa el campo "contador_prod" al cargar la página (por si ya tiene valor inicial)
    document.addEventListener('DOMContentLoaded', actualizarContadorProd);
</script>
