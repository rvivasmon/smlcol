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
                    <h1 class="m-0">Ingreso de Productos</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card card-blue">
                <div class="card-header">
                    Introduzca la información correspondiente
                </div>
                <div class="card-body">
                    <form action="controller_create.php" method="post">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="producto">PRODUCTO</label>
                                    <select name="producto" id="producto" class="form-control" required>
                                        <option value="" selected>Seleccione un Producto</option>
                                        <?php
                                        $query_categoria = $pdo->prepare('SELECT * FROM t_productos WHERE habilitar = "1" ORDER BY tipo_producto ASC');
                                        $query_categoria->execute();
                                        $categorias = $query_categoria->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($categorias as $categoria) {
                                            $id = $categoria['id_producto'];
                                            $nombre_categoria = $categoria['tipo_producto'];
                                        ?>
                                        <option value="<?php echo $id; ?>"><?php echo $nombre_categoria; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- Otros campos existentes -->
                        </div>

                        <!-- Campo para escanear código de barras -->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="codigo_barras">Escanear Código de Barras</label>
                                    <input type="text" id="codigo_barras" class="form-control" autofocus onkeypress="agregarSerial(event)">
                                </div>
                            </div>
                        </div>

                        <!-- Tabla para mostrar los códigos escaneados -->
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered" id="tabla_seriales">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Código de Barras</th>
                                        </tr>
                                    </thead>
                                    <tbody id="lista_seriales">
                                        <!-- Aquí se agregan los seriales escaneados -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Campo oculto para enviar los seriales -->
                        <input type="hidden" id="seriales" name="seriales" value="">

                        <div class="row">
                            <div class="col-md-2">
                                <a href="<?php echo $URL."admin/";?>" class="btn btn-default btn-block">Cancelar</a>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary btn-block">Registrar Producto</button>
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

    // Función para procesar el formulario
    function procesarFormulario(event) {
        event.preventDefault(); // Prevenir recarga del formulario
        if (confirm('Seguro de haber diligenciado correctamente los datos?')) {
            const formData = new FormData(document.querySelector('form'));

            fetch('controller_create.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    if (confirm('¿Desea guardar otro producto?')) {
                        // Limpiar el formulario y la tabla de seriales
                        document.querySelector('form').reset();
                        seriales = [];
                        document.getElementById('lista_seriales').innerHTML = "";
                    } else {
                        // Redirigir a la vista principal
                        window.location.href = '<?php echo $URL."admin/";?>';
                    }
                } else {
                    alert('Ocurrió un error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al procesar la solicitud');
            });
        }
    }

    // Asociar la función procesarFormulario al evento submit del formulario
    document.querySelector('form').addEventListener('submit', procesarFormulario);
</script>
