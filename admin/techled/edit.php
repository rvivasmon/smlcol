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

// Consulta principal en la tabla 'techled'
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
                    <h1 class="m-0"><b>Visor de productos</b></h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            
            <div class="card card-green">
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
                                        <input type="text" name="valor" id="valor" value="<?php echo $valor; ?>" class="form-control form-control-sm" readonly>
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
                            <label for="archivo" class="text-sm">Archivos</label>
                            <?php 
                            // Consulta para obtener la columna 'archivo' de la base de datos
                            $query = $pdo->prepare("SELECT archivo FROM techled WHERE id = :id");
                            $query->bindParam(':id', $id);
                            $query->execute();
                            $row = $query->fetch(PDO::FETCH_ASSOC);
                            $archivo = $row['archivo'] ?? ''; // Archivos obtenidos de la columna

                            // Validar si hay archivos
                            if (!empty($archivo)) {
                                $archivos = []; // Array para almacenar rutas de archivos

                                // Determinar si es un único archivo o múltiples archivos separados por comas
                                if (strpos($archivo, ',') !== false) {
                                    // Múltiples archivos (caso del controlador 1)
                                    $archivos = explode(',', $archivo);
                                } else {
                                    // Un único archivo (caso del controlador 2)
                                    $archivos[] = $archivo;
                                }

                                // Extensiones válidas de imágenes y videos
                                $image_extensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
                                $video_extensions = ['mp4', 'avi', 'mov', 'wmv', 'webm'];
                                $document_extensions = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx'];

                                ?>
                                <!-- Carrusel de archivos -->
                                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner">
                                        <?php 
                                        foreach ($archivos as $index => $nombre_archivo):
                                            $nombre_archivo = trim($nombre_archivo, " []");
                                            $file_extension = pathinfo($nombre_archivo, PATHINFO_EXTENSION);
                                            $file_url = '../../img_uploads/img_techled/' . $nombre_archivo; // Asume que todos los archivos están en 'img/'

                                            if (in_array(strtolower($file_extension), $image_extensions)): 
                                                // Si es una imagen
                                        ?>
                                        <div class="carousel-item <?php echo $index == 0 ? 'active' : ''; ?>" 
                                            onclick="maximizeFile('<?php echo $file_url; ?>', 'image')" 
                                            style=" justify-content: center; align-items: center; text-align: center; height: 100%;">
                                            <img src="<?php echo $file_url; ?>" alt="Archivo" style="max-height: 300px; max-width: 100%; margin: 0 auto;">
                                        </div>

                                        <?php 
                                            elseif (in_array(strtolower($file_extension), $video_extensions)): 
                                                // Si es un video
                                        ?>
                                            <div class="carousel-item <?php echo $index == 0 ? 'active' : ''; ?>" onclick="maximizeFile('<?php echo $file_url; ?>', 'video')">
                                                <video class="d-block w-200" controls style="max-height:300px;">
                                                    <source src="<?php echo $file_url; ?>" type="video/<?php echo $file_extension; ?>">
                                                    Tu navegador no soporta la etiqueta de video.
                                                </video>
                                            </div>
                                        <?php 
                                            elseif (in_array(strtolower($file_extension), $document_extensions)): 
                                                // Si es un documento
                                        ?>
                                        <div class="carousel-item <?php echo $index == 0 ? 'active' : ''; ?>" 
                                                onclick="maximizeFile('<?php echo $file_url; ?>', 'document')" 
                                                style=" flex-direction: column; justify-content: center; align-items: center; text-align: center; height: 100%;">
                                                <img src="img/icono_doc.png" alt="Documento" style="max-height: 300px; max-width: 100%; margin: 0 auto;">
                                                <p style="margin-top: 10px;">Documento: <?php echo $nombre_archivo; ?></p>
                                            </div>

                                        <?php 
                                            endif;
                                        endforeach;
                                        ?>
                                    </div>
                                        <button class="carousel-control-prev" type="button" data-target="#carouselExampleControls" data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Anterior</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-target="#carouselExampleControls" data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Siguiente</span>
                                        </button>
                                </div>
                                    <?php } else { ?>
                                        <p class="text-sm">No hay archivo disponible.</p>
                                    <?php } ?>
                        </div>
                    </div>

                    <!-- Modal para maximizar archivos -->
                    <div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                            <div class="container-fluid">
                            <div class="card card-green">
                            <div class="card-header">
                            <div class="modal-header">
                                <h5 class="modal-title" id="fileModalLabel">Archivo Maximizado</h5>
                                <button type="button" 
                                style="color: white; color: card-green; border: none; padding: 10px; border-radius: 4px; cursor: pointer; 
                                    transition: color 0.3s ease, background-color 0.3s ease;" 
                                onmouseover="this.style.color='black'; this.style.backgroundColor='lightgreen';" 
                                onmouseout="this.style.color='white'; this.style.backgroundColor='green';" 
                                class="btn btn-default" 
                                data-dismiss="modal" aria-label="Close">
                                <b>X</b>
                            </button>

                            </div>
                            </div>
                            
                                

                            </div>
                            <div class="modal-body">
                                <div id="fileContent"></div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                    <!-- Modal de Edición -->
                    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <!-- Tarjeta dentro del modal -->
                                <div class="container-fluid">
                                <div class="card card-green">
                                    <div class="card-header">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel">Editar Información del Producto</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    </div>
                                    <form action="controller_edit.php" method="POST" enctype="multipart/form-data">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="producto">Producto</label>
                                                <input type="text" name="producto" id="producto" value="<?php echo $producto; ?>" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="modelo">Modelo</label>
                                                <input type="text" name="modelo" id="modelo" value="<?php echo $modelo; ?>" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="serial">Serial</label>
                                                <input type="text" name="serial" id="serial" value="<?php echo $serial; ?>" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="cantidad">Cantidad</label>
                                                <input type="text" name="cantidad" id="cantidad" value="<?php echo $cantidad; ?>" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="valor">Valor</label>
                                                <input type="text" name="valor" id="valor" value="<?php echo $valor; ?>" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="descripcion">Descripción</label>
                                                <textarea name="descripcion" id="descripcion" rows="3" class="form-control"><?php echo $descripcion; ?></textarea>
                                            </div>
                                        <!-- Campo para cargar archivo nuevo -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="archivos" class="text-sm">Cargar Archivos</label>
                                                    <!-- Botón personalizado para cargar archivos -->
                                                    <div class="custom-file">
                                                        <!-- Se oculta el campo input de archivo -->
                                                        <input type="file" name="archivos[]" id="archivos" class="custom-file-input" multiple style="display:none;">
                                                        <label class="custom-file-label" for="archivos">
                                                            <i class="fas fa-upload text-success"></i> Cargar Archivos
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                        <div class="card-footer text-right">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-success ">Guardar Cambios</button>
                                        </div>
                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    </form>
                                </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Botones Editar y Volver alineados horizontalmente -->
                    <div class="row justify-content-center">
                        <div class="col-md-6 d-flex justify-content-between">
                            <!-- Botón Editar -->
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#editModal">Editar</button>
                            <!-- Botón Volver -->
                            <a href="<?php echo $URL . "admin/techled/index.php"; ?>" class="btn btn-default">Volver</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Script para maximizar imagen al hacer doble clic -->
<script>
    function maximizeImage(img) {
        // Crear una ventana emergente o modal para maximizar la imagen
        const imageUrl = img.src;
        const newWindow = window.open(imageUrl, '_blank', 'width=800,height=600');
        newWindow.focus();
    }
</script>
<!-- Script para maximizar imagen al hacer doble clic -->
<script>
    function maximizeImage(img) {
        // Crear una ventana emergente o modal para maximizar la imagen
        const imageUrl = img.src;
        const newWindow = window.open(imageUrl, '_blank', 'width=800,height=600');
        newWindow.focus();
    }

    function maximizeVideo(video) {
        // Crear una ventana emergente o modal para maximizar el video
        const videoUrl = video.querySelector('source').src;
        const newWindow = window.open(videoUrl, '_blank', 'width=800,height=600');
        newWindow.focus();
    }
</script>
<script>
    // Función para maximizar el archivo
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