<?php 
include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/sesion.php');
include('../../layout/admin/datos_sesion_user.php');

include('../../layout/admin/parte1.php');

// Verificación de existencia de 'id'
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("El parámetro 'id' es obligatorio.");
}

$id_get = $_GET['id'];

// Consulta principal en la tabla 'rst'
$query_techled = $pdo->prepare("SELECT * FROM techled WHERE id = :id");
$query_techled->bindParam(':id', $id_get, PDO::PARAM_INT);
$query_techled->execute();
$techleds = $query_techled->fetchAll(PDO::FETCH_ASSOC);

foreach ($techleds as $techled_item) {
    $id = $techled_item['id'];
    $producto = $techled_item['producto'];
    $modelo = $techled_item['modelo'];
    $serial = $techled_item['serial'];
    $cantidad = $techled_item['cantidad'];
    $descripcion = $techled_item['descripcion'];
    $valor = $techled_item['valor'];
    $archivo = $techled_item['archivo'];
    $fecha_creacion = $techled_item['fecha_creacion'];
}
?>

<!-- Resto de tu HTML y PHP -->

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-4">
                    <h1 class="m-0 "><b>TECHLED</b></h1>
                </div>
            </div>

            <div class="card card-info">
                <div class="card-header">
                    Detalle del producto
                </div>

                <div class="card-body table-compact">
                    <div class="row g-1">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="producto" class="text-sm">Producto</label>
                                        <input type="text" name="producto" id="producto" value="<?php echo $producto; ?>" class="form-control form-control-sm" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="modelo" class="text-sm">Modelo</label>
                                        <input type="text" name="modelo" id="modelo" value="<?php echo $modelo; ?>" class="form-control form-control-sm" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="serial" class="text-sm">Serial</label>
                                        <input type="text" name="serial" id="serial" value="<?php echo $serial; ?>" class="form-control form-control-sm" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cantidad" class="text-sm">Cantidad</label>
                                        <input type="text" name="cantidad" id="cantidad" value="<?php echo $cantidad; ?>" class="form-control form-control-sm" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                 <!-- Campo Valor con tamaño reducido -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="valor" class="text-sm">Valor</label>
                                        <input type="text" name="valor" id="valor" value="<?php echo $valor; ?>" class="form-control form-control-sm" readonly ">
                                    </div>
                                </div>
                                <!-- Campo Descripción como Textarea -->
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="descripcion" class="text-sm">Descripciones Generales</label>
                                        <textarea name="descripcion" id="descripcion" rows="3" class="form-control form-control-sm" readonly><?php echo $descripcion; ?></textarea>
                                    </div>
                                </div>

   
                                </div>

                        </div>

                        <!-- Archivo -->
<div class="col-md-6 text-center">
    <div class="form-group">
        <label for="archivo" class="text-sm">Archivo</label>
        <?php if (!empty($archivo)): ?>
            <?php
            $file_extension = pathinfo($archivo, PATHINFO_EXTENSION);
            $image_extensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
            $video_extensions = ['mp4', 'avi', 'mov', 'wmv', 'flv'];
            $file_url = "img/" . $archivo;
            ?>
            <?php if (in_array(strtolower($file_extension), $image_extensions)): ?>
                <div ondblclick="maximizeFile('<?php echo $file_url; ?>', 'image')" class="img-thumbnail" style="cursor: pointer;">
                    <img src="<?php echo $file_url; ?>" alt="Archivo" class="img-fluid" style="max-width: 100%; max-height: 200px;">
                </div>
            <?php elseif (in_array(strtolower($file_extension), $video_extensions)): ?>
                <div ondblclick="maximizeFile('<?php echo $file_url; ?>', 'video')" class="img-thumbnail" style="cursor: pointer;">
                    <video class="img-fluid" style="max-width: 100%; max-height: 200px;" controls>
                        <source src="<?php echo $file_url; ?>" type="video/<?php echo $file_extension; ?>">
                        Tu navegador no soporta la etiqueta de video.
                    </video>
                    <p class="text-sm mt-2">Video: <?php echo $archivo; ?></p>
                </div>
            <?php else: ?>
                <div ondblclick="maximizeFile('<?php echo $file_url; ?>', 'document')" class="img-thumbnail" style="cursor: pointer;">
                    <img src="img/icono_doc.png" alt="Documento" class="img-fluid" style="max-width: 100px; max-height: 100px;">
                    <p class="text-sm mt-2">Documento: <?php echo $archivo; ?></p>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <p class="text-sm">No hay archivo disponible.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Modal para maximizar archivos -->
<div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="container-fluid">
                <div class="card card-info">
                    <div class="card-header">
                        <div class="modal-header">
                            <h5 class="modal-title" id="fileModalLabel">Archivo Maximizado</h5>
                            <button type="button" 
                                style="color: white; background-color: info; border: none; padding: 10px; border-radius: 4px; cursor: pointer; 
                                    transition: color 0.3s ease, background-color 0.3s ease;" 
                                onmouseover="this.style.color='black'; this.style.backgroundColor='lightinfo';" 
                                onmouseout="this.style.color='white'; this.style.backgroundColor='info';" 
                                class="btn btn-default" 
                                data-dismiss="modal" aria-label="Close">
                                <b>X</b>
                            </button>
                        </div>
                    </div>

                    <div class="modal-body">
                        <div id="fileContent"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




                    </div>


                    <hr>

                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <a href="<?php echo $URL . "admin/nueva_tarea_8-7-24/techled/index.php"; ?>" class="btn btn-default btn-block btn-sm">Volver</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- #region -->
 <!-- Script para maximizar archivos -->
<script>
    function maximizeFile(fileUrl, type) {
        var fileContent = document.getElementById('fileContent');
        
        if (type === 'image') {
            fileContent.innerHTML = '<img src="' + fileUrl + '" class="img-fluid" alt="Imagen Maximizada">';
        } else if (type === 'video') {
            fileContent.innerHTML = '<video class="d-block w-100" controls><source src="' + fileUrl + '" type="video/mp4">Tu navegador no soporta la etiqueta de video.</video>';
        } else if (type === 'document') {
            fileContent.innerHTML = '<iframe src="' + fileUrl + '" class="w-100" style="height: 500px;"></iframe>';
        }

        // Mostrar el modal
        var myModal = new bootstrap.Modal(document.getElementById('fileModal'));
        myModal.show();
    }
</script>




<?php include('../../layout/admin/parte2.php'); ?>
                                