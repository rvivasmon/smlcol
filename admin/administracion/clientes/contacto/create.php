<?php

include('../../../../app/config/config.php');
include('../../../../app/config/conexion.php');
include('../../../../layout/admin/sesion.php');
include('../../../../layout/admin/datos_sesion_user.php');
include('../../../../layout/admin/parte1.php');

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
                            Introduzca la información correspondiente
                        </div>
                        <div class="card-body">
                            <form action="controller_create.php" method="POST" id="formContacto">
                                <div class="form-group">
                                    <label for="nombre">Nombre del Contacto</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required>
                                </div>

                                <div class="form-group">
                                    <label for="celular">Celular</label>
                                    <input type="text" class="form-control" id="celular" name="celular" placeholder="Celular" required>
                                </div>

                                <div class="form-group">
                                    <label for="telefono">Teléfono</label>
                                    <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Teléfono" required>
                                </div>

                                <div class="form-group">
                                    <label for="posible_cliente">Posible Cliente</label>
                                    <select class="form-control" id="posible_cliente" name="posible_cliente" required>
                                        <option value="">Seleccionar</option>
                                        <option value="Sí">Sí</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="tipo_contacto">Tipo de Contacto</label>
                                    <select id="tipo_contacto" name="tipo_contacto" class="form-control" required>
                                        <option value="">Seleccione Tipo de Contacto</option>
                                        <?php
                                        $query_contacto = $pdo->prepare('SELECT id, tipo FROM contactos_tipos WHERE tipo IS NOT NULL AND tipo != "" ORDER BY tipo ASC');
                                        $query_contacto->execute();
                                        $contactos = $query_contacto->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($contactos as $contacto): ?>
                                            <option value="<?php echo $contacto['id']; ?>">
                                                <?php echo $contacto['tipo']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Campo oculto para el usuario que crea el contacto -->
                                <input type="hidden" name="usuario_crea" id="usuario_crea" value="<?php echo $sesion_usuario['id']; ?>">

                                <hr>

                                <div class="col-md-5">
                                    <button type="submit" class="btn btn-primary">Guardar Contacto</button>
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
