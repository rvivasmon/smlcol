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
                    <h1 class="m-0">Crear Nuevo Usuario</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card card-blue">
                <div class="card-header">
                    Introduzca la información correspondiente
                </div>
                <div class="card-body">
                    <form action="controller_create.php" method="post">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Nombre</label>
                                    <input type="text" name="nombre" class="form-control" placeholder="Nombre Completo" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Correo Electrónico</label>
                                    <input type="text" name="email" class="form-control" placeholder="Email" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Usuario</label>
                                    <input type="text" name="usuario" class="form-control" placeholder="Usuario" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Contraseña</label>
                                    <input type="text" name="password" class="form-control" placeholder="Password" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Verificar contraseña</label>
                                    <input type="text" name="verificar_password" class="form-control" placeholder="Verifique su contraseña" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Cargo</label>
                                    <select name="id_cargo" id="id_cargo" class="form-control" required>
                                        <?php 
                                        $query_cargo = $pdo->prepare('SELECT * FROM cargo ORDER BY descripcion ASC');
                                        $query_cargo->execute();
                                        $cargos = $query_cargo->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($cargos as $cargo) {
                                            $id_cargo = $cargo['id_cargo'];
                                            $cargo_descripcion = $cargo['descripcion'];
                                            if ($cargo_descripcion === "Cliente") {
                                                // Si el cargo es "cliente", mostramos la opción y asociamos el evento de apertura del modal
                                                echo '<option value="' . $id_cargo . '" data-toggle="modal" data-target="#cargoModal">' . $cargo_descripcion . '</option>';
                                            } else {

                                            echo '<option value="' . $id_cargo . '">' . $cargo_descripcion . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>                            
                        </div>
                        <!-- Este es el campo oculto del ID del cliente seleccionado aquí -->
                        <input type="hidden" id="id_cliente" name="id_cliente">
                        <hr>

                        <div class="row">
                            <div class="col-md-2">
                                <a href="<?php echo $URL."admin/ti/usuarios";?>" class="btn btn-default btn-block">Cancelar</a>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" onclick="return confirm('Seguro de haber diligenciado correctamente los datos?')" class="btn btn-primary btn-block">Registrar Usuario</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="cargoModal" tabindex="-1" role="dialog" aria-labelledby="cargoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cargoModalLabel">Listado De Clientes Sin Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Aquí puedes agregar contenido adicional relacionado con el cliente -->
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Clientes:</label>
                        <select name="idcliente" id="idcliente" class="form-control" required>
                            <option value="">Seleccione Un Cliente</option>
                            <?php 
                            $query_cliente = $pdo->prepare('SELECT * FROM clientes WHERE id NOT IN (SELECT id_cliente FROM usuarios)');
                            $query_cliente->execute();
                            $clientes = $query_cliente->fetchAll(PDO::FETCH_ASSOC);                            
                            foreach($clientes as $cliente) {
                                $id = $cliente['id'];
                                $cliente_comercial = $cliente['nombre_comercial'];
                            ?>
                            <option value="<?php echo $id; ?>"> <?php echo $cliente_comercial; ?></option>
                            <?php
                            }
                            ?>
                        </select>                  
                    </div> 
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnAceptar">Aceptar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>    
    </div>
</div>

<?php include('../../../layout/admin/parte2.php');?>

<script>
    // Función para actualizar el campo id_cliente cuando se selecciona un cliente
    function registrarCliente() {
        var clienteSeleccionado = document.getElementById('idcliente').value;
        document.getElementById('id_cliente').value = clienteSeleccionado;
    }
    // apertura del modal si id_cargo pertenece a cliente
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('id_cargo').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var cargo = selectedOption.textContent.trim().toLowerCase();
            if (cargo === "cliente") {
                $('#cargoModal').modal('show');
            }
        });

        // Llamar a la función registrarCliente cuando se selecciona un cliente en el modal
        document.getElementById('btnAceptar').addEventListener('click', function() {
            registrarCliente();
        });
    });
</script>
