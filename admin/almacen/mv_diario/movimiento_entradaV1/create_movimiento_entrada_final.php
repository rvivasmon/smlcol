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
                    <h1 class="m-0">Movimientos de Entrada Almacén Principal</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card card-blue">
                <div class="card-header">
                    Introduzca la información correspondiente
                </div>
                <div class="card-body">
                    <form action="controller_create_final.php" method="POST">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="fecha">Fecha</label>
                                    <input type="date" id="fecha" name="fecha" class="form-control" placeholder="Fecha" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="hora">Hora</label>
                                    <input type="time" id="hora" name="hora" class="form-control" placeholder="Hora" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="producto">Categoría</label>
                                    <select name="producto" id="producto" class="form-control" required>
                                        <option value="">Seleccione un Producto</option>
                                        <?php
                                        $query_producto = $pdo->prepare('SELECT id_producto, tipo_producto FROM t_productos WHERE habilitar = "1" ORDER BY tipo_producto ASC');
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
                                <div class="form-group"> <!-- Se coloca aquí el usuario que está trabajando el archivo -->
                                    <input  class="form-control"  id="idusuario" name="idusuario" value="<?php echo $sesion_usuario['nombre']?>" hidden>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h1 class="m-0">Validar Producto</h1>
                            </div>
                        </div>

                            <!-- MODULO -->

                        <div class="row">
                            <div class="col-md-2 campo Modulo">
                                <div class="form-group">
                                    <label for="pitch">Pitch</label>
                                    <select id="pitch" name="pitch" class="form-control">
                                        <option value="">Seleccione un pitch</option>
                                        <?php 
                                        $query_pitch = $pdo->prepare('SELECT id, pitch FROM tabla_pitch ORDER BY pitch ASC');
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
                                    <label for="serie_modulo">Serie</label>
                                    <select id="serie_modulo" name="serie_modulo" class="form-control">
                                        <option value="">Seleccione una Serie</option>
                                        <!-- Las opciones se llenarán dinámicamente vía AJAX -->
                                    </select>
                                </div>
                            </div>
                        </div>

                            <!-- CONTROLADORA -->

                        <div class="row">
                            <div class="col-md-2 campo Control">
                                <div class="form-group">
                                    <label for="marca_control">Marca</label>
                                    <select id="marca_control" name="marca_control" class="form-control" >
                                        <option value="">Seleccione una marca</option>
                                        <?php 
                                        $query_marca_control = $pdo->prepare('SELECT id_car_ctrl, marca_control FROM caracteristicas_control WHERE marca_control IS NOT NULL AND marca_control != "" ORDER BY marca_control ASC');
                                        $query_marca_control->execute();
                                        $marcas_controles = $query_marca_control->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($marcas_controles as $marca_control): ?>
                                        <option value="<?php echo $marca_control['id_car_ctrl']; ?>">
                                            <?php echo $marca_control['marca_control']; ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2 campo Control">
                                <div class="form-group">
                                    <label for="referencia_control35">Referencia</label>
                                    <select id="referencia_control35" name="referencia_control35" class="form-control" >
                                        <option value="">Seleccione una Referencia</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-0">
                            </div>
                        </div>

                            <!-- FUENTE -->

                        <div class="row">
                            <div class="col-md-2 campo Fuente">
                                <div class="form-group">
                                    <label for="marca_fuente">Marca</label>
                                    <select name="marca_fuente" id="marca_fuente" class="form-control">
                                        <option value="">Seleccione una Marca</option>
                                        <?php 
                                        $query_modelo_fuente = $pdo->prepare('SELECT id_car_fuen, marca_fuente FROM caracteristicas_fuentes WHERE marca_fuente IS NOT NULL AND marca_fuente != ""  ORDER BY marca_fuente ASC');
                                        $query_modelo_fuente->execute();
                                        $modelos_fuentes = $query_modelo_fuente->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($modelos_fuentes as $modelo_fuente): ?>
                                        <option value="<?php echo $modelo_fuente['id_car_fuen']; ?>">
                                            <?php echo $modelo_fuente['marca_fuente']; ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2 campo Fuente">
                                <div class="form-group">
                                    <label for="modelo_fuente35">Modelo</label>
                                    <select name="modelo_fuente35" id="modelo_fuente35" class="form-control">
                                        <option value="">Seleccione un Modelo</option>
                                    </select>
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

                            <!-- ALMACEN -->

                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label for="salida_md">Almacén Origen</label>
                                                <select name="almacen_salida_md" id="almacen_salida_md" class="form-control" required>
                                                    <option value="">Almacén Origen</option>
                                                    <?php 
                                                    $query_almacen  = $pdo->prepare('SELECT * FROM t_asignar_todos_almacenes WHERE id_asignacion != 3 AND nombre_almacen != "Principal"');
                                                        $query_almacen->execute();
                                                        $almacenes = $query_almacen->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach($almacenes as $almacen) {
                                                            echo '<option value="' . $almacen['id_asignacion'] . '">' . $almacen['nombre_almacen'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                                <input class="form-control" name="almacen_salida_md_id" id="almacen_salida_md_id" hidden>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="salida_md">Cantidad</label>
                                                <input type="text" name="salida_md" class="form-control" placeholder="Entrada" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-7" hidden>
                                            <div class="form-group">
                                                <label for="entrada_md">Almacén Destino</label>
                                                <select name="almacen_entrada_md" id="almacen_entrada_md" class="form-control" >
                                                    <option value="">Almacén Destino</option>
                                                <?php 
                                                $query_almacen_entra = $pdo->prepare('SELECT * FROM t_asignar_todos_almacenes');
                                                $query_almacen_entra->execute();
                                                $almacenes_entras = $query_almacen_entra->fetchAll(PDO::FETCH_ASSOC);
                                                foreach($almacenes_entras as $almacen_entra) {
                                                    $selected = ($almacen_entra['id_asignacion'] == 3) ? 'selected' : '';
                                                    echo '<option value="' . $almacen_entra['id_asignacion'] . '" ' . $selected . '>' . $almacen_entra['nombre_almacen'] . '</option>';
                                                }
                                                ?>
                                                </select>
                                                <input class="form-control" name="almacen_entrada_md_id" id="almacen_entrada_md_id" hidden>
                                            </div>
                                        </div>
                                        <div class="col-md-3" hidden>
                                            <div class="form-group">
                                                <label for="entrada_md">Entrada</label>
                                                <input type="text" name="entrada_md" class="form-control" placeholder="Cantidad Entrada" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <label for="op_destino">Asignar a:</label>
                                                <input type="text" name="op_destino" class="form-control" placeholder="Asignar" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <label for="observacion">Observaciones</label>
                                                <textarea name="observacion" id="observacion" cols="30" rows="4" class="form-control" placeholder="Observaciones"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <a href="<?php echo $URL."admin/almacen/mv_diario/";?>" class="btn btn-default btn-block">Cancelar</a>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button type="submit" onclick="return confirm('Seguro de haber diligenciado correctamente los datos?')" class="btn btn-primary btn-block">Crear Movimiento</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
</div>

    <?php include('../../../../layout/admin/parte2.php');?>

    <script>
        // Obtener la fecha actual en el formato yyyy-mm-dd
        var today = new Date().toISOString().split('T')[0];
        // Establecer el valor del campo de fecha
        document.getElementById('fecha').value = today;

        // Obtener la hora actual en el formato hh:mm
        var now = new Date();
        var hours = String(now.getHours()).padStart(2, '0');
        var minutes = String(now.getMinutes()).padStart(2, '0');
        var currentTime = hours + ':' + minutes;
        document.getElementById('hora').value = currentTime;

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

    //visualizar los id de almacen
    document.addEventListener('DOMContentLoaded', function() {
        const selectSalida = document.getElementById('almacen_salida_md');
        const salidaID = document.getElementById('almacen_salida_md_id');
        const selectEntrada = document.getElementById('almacen_entrada_md');
        const entradaID = document.getElementById('almacen_entrada_md_id');

        selectSalida.addEventListener('change', function() {
            salidaID.value = selectSalida.value;
        });

        selectEntrada.addEventListener('change', function() {
            entradaID.value = selectEntrada.value;
        });
    });

    document.addEventListener('DOMContentLoaded', function() {

        // Agregar funcionalidad para verificar si Almacén Origen y Almacén Destino son iguales
        const selectSalida = document.getElementById('almacen_salida_md');
        const selectEntrada = document.getElementById('almacen_entrada_md');

        function verificarAlmacenes() {
            if (selectSalida.value && selectEntrada.value && selectSalida.value === selectEntrada.value) {
                alert("El Almacén Origen y el Almacén Destino no pueden ser iguales. Por favor, seleccione almacenes diferentes.");
                selectEntrada.value = ''; // Vaciar el campo de Almacén Destino para obligar a seleccionar uno diferente
            }
        }

        selectSalida.addEventListener('change', verificarAlmacenes);
        selectEntrada.addEventListener('change', verificarAlmacenes);
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Obtener referencias a los campos de entrada y salida
        const salidaMdInput = document.getElementsByName('salida_md')[0];
        const entradaMdInput = document.getElementsByName('entrada_md')[0];

        // Función para actualizar el campo entrada_md
        function actualizarEntradaMd() {
            entradaMdInput.value = salidaMdInput.value; // Establecer el mismo valor que salida_md
        }

        // Escuchar cambios en el campo salida_md y llamar a la función actualizarEntradaMd
        salidaMdInput.addEventListener('input', actualizarEntradaMd);
    });
    </script>

    <script>
        // Script para MODULOS
    document.getElementById('producto').addEventListener('change', function() {
        document.getElementById('serie_modulo').value = '';  // Limpia el campo 'serie_modulo'
        document.getElementById('referencia_control35').value = '';
        document.getElementById('modelo_fuente35').value = '';
        document.getElementById('marca_control').value = '';
        document.getElementById('marca_fuente').value = '';
        document.getElementById('pitch').value = '';
    });

    document.getElementById('pitch').addEventListener('change', function() {
    var pitchValue = this.value;

    // Hacer una solicitud AJAX para obtener los registros filtrados
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'get_serie_modulo.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Actualizar el contenido del campo serie_modulo
            document.getElementById('serie_modulo').innerHTML = xhr.responseText;

            // Agregar un evento para detectar cuando cambie la selección
            document.getElementById('serie_modulo').addEventListener('change', function() {
                var selectedOption = this.options[this.selectedIndex];
                var selectedId = selectedOption.value; // Obtiene el "id" de la serie seleccionada

                // Asignar el valor del "id" al campo id_serie_modulo
                document.getElementById('id_serie_modulo').value = selectedId;
            });
        }
    };
    xhr.send('pitch=' + pitchValue);
});


document.getElementById('marca_control').addEventListener('change', function() {
    var marcaControlValue = this.value;

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'get_referencia_control.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            document.getElementById('referencia_control35').innerHTML = xhr.responseText;
        }
    };
    xhr.send('marca_control=' + marcaControlValue);
});

document.getElementById('marca_fuente').addEventListener('change', function() {
    var marcaFuenteValue = this.value;

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'get_modelo_fuente.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            document.getElementById('modelo_fuente35').innerHTML = xhr.responseText;
        }
    };
    xhr.send('marca_fuente=' + marcaFuenteValue);
});
    </script>