<?php


include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');

include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');

include('../../../../layout/admin/parte1.php');


// Obtener el ID del contacto y el tipo de contacto
$contacto_id = $_POST['contacto_id'];
$tipo_contacto = $_POST['tipo_contacto'];
$nombre = $_POST['nombre'];

// Consulta para obtener el nombre del tipo de contacto basado en el ID
$stmt = $pdo->prepare("SELECT tipo FROM contactos_tipos WHERE id = ?");
$stmt->execute([$tipo_contacto]);
$tipo_contacto_nombre = $stmt->fetchColumn();

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Crear Nuevo Contacto</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card card-blue">
                        <div class="card-header">
                            Posible Cliente para: <?php echo $nombre; ?>
                        </div>
                        <div class="card-body">

                        <form id="formulario" action="controller_posible_cliente.php" method="POST">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <!-- Campo oculto para vincular al contacto -->
                                        <input type="hidden" name="contacto_id" value="<?php echo $contacto_id; ?>">
                                        <input type="hidden" name="user" value="<?php echo $sesion_usuario['id']; ?>">

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="fecha">Fecha:</label>
                                                    <input type="text" id="fecha" name="fecha" class="form-control" value="<?php echo date('Y-m-d'); ?>" readonly>
                                                </div>
                                            </div>
                                            <!-- Mostrar el tipo de contacto (puedes mostrar campos adicionales dependiendo del tipo) -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="tipo_contacto">Tipo de Contacto:</label>
                                                    <input type="text" id="tipo_contacto" name="tipo_contacto" class="form-control" value="<?php echo htmlspecialchars($tipo_contacto_nombre); ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="tipo_cliente">Tipo de Cliente:</label>
                                                    <input type="text" id="tipo_cliente" name="tipo_cliente" class="form-control">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <!-- Campos adicionales para crear el posible cliente -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="empresa">Empresa:</label>
                                                    <input type="text" id="empresa" name="empresa"class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="telefono">Teléfono Empresa:</label>
                                                    <input type="text" id="telefono" name="telefono"class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="tipoE">Tipo Empresa:</label>
                                                    <input type="text" id="tipoE" name="tipoE"class="form-control" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="direccion">Direccion:</label>
                                                    <input type="text" id="direccion" name="direccion" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="ciudad">Ciudad:</label>
                                                    <input type="text" id="ciudad" name="ciudad" class="form-control" required>
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
                                            <div class="col-md-5">
                                                <button type="submit" class="btn btn-primary">Guardar</button>
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

        </div><!-- /.container-fluid -->
    </div>
</div>

    <?php include('../../../../layout/admin/parte2.php'); ?>
