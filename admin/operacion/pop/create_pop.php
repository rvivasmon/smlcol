<?php

include('../../app/config/config.php');
include('../../app/config/conexion.php');
include('../../layout/admin/sesion.php');
include('../../layout/admin/datos_sesion_user.php');
include('../../layout/admin/parte1.php');

$conta2 = 0;
$conta3 = 0;
$conta1 = 0;
$conta4 = 0;
$conta5 = 0;
$conta6 = 0;


$fecha_creacion = date('Y-m-d');  //Obtiene la fecha actual   

// Obtener el último registro OC
$query_co = $pdo->prepare('SELECT * FROM oc ORDER BY id DESC LIMIT 1');
$query_co->execute();
$last_oc = $query_co->fetch(PDO::FETCH_ASSOC);

// Calcular el número de factura
$num_factura = ($last_oc) ? $last_oc['num_factura'] + 1 : 1;
$num_factura_fecha = str_pad($num_factura, 3, '0', STR_PAD_LEFT) . ' - ' . date('dmY');

// Obtener opciones dinámicas
$query_taunion = $pdo->prepare('SELECT id, consecutivo_primero_oc FROM prefijos LIMIT 2');
$query_taunion->execute();
$unionesa = $query_taunion->fetchAll(PDO::FETCH_ASSOC);

$query_union = $pdo->prepare('SELECT id, consecutivo_segundo_oc FROM prefijos LIMIT 3');
$query_union->execute();
$uniones = $query_union->fetchAll(PDO::FETCH_ASSOC);

// Manejo de formularios
$oci_oc = $_POST['oci_oc'] ?? null;
$sml_psi_tl = $_POST['sml_psi_tl'] ?? null;

if ($oci_oc && $sml_psi_tl) {
    $tipo_pc = 'PC-' . $sml_psi_tl;
    $tipo_oc = $oci_oc . '-' . $sml_psi_tl;

}
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Nuevo Registro</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="card card-blue">
                <div class="card-header">
                    <a href="#" class="d-block"><?php echo $sesion_usuario['nombre']?></a>
                    Introduzca la información correspondiente
                </div>

                <div class="card-body">
                    <form action="controller_create_oc.php" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <!-- Campos del formulario -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="oci_oc">OCI-OC</label>
                                    <select name="oci_oc" id="oci_oc" class="form-control" required>
                                        <option value="">Seleccione el OCI-OC</option>
                                        <?php foreach ($unionesa as $prefijos): ?>
                                            <option value="<?php echo $prefijos['consecutivo_primero_oc']; ?>"><?php echo $prefijos['consecutivo_primero_oc']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sml_psi_tl">SML-PSI-TL</label>
                                    <select name="sml_psi_tl" id="sml_psi_tl" class="form-control" required>
                                        <option value="">Seleccione el SML-PSI-TL</option>
                                        <?php foreach ($uniones as $prefijos): ?>
                                            <option value="<?php echo $prefijos['consecutivo_segundo_oc']; ?>"><?php echo $prefijos['consecutivo_segundo_oc']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-0">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="hidden" name="oc_resultante" id="oc_resultante" class="form-control" hidden>
                                </div>
                            </div>

                            <div class="col-md-0">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="hidden" name="contador_oc" id="contador_oc" class="form-control" hidden>
                                    <input type="hidden" name="conta1" id="conta1" value="<?php echo $conta1; ?>" class="form-control" hidden>
                                    <input type="hidden" name="conta2" id="conta2" value="<?php echo $conta2; ?>"  class="form-control" hidden>
                                    <input type="hidden" name="conta3" id="conta3" value="<?php echo $conta3; ?>" class="form-control" hidden>
                                    <input type="hidden" name="conta4" id="conta4" value="<?php echo $conta4; ?>"  class="form-control" hidden>
                                    <input type="hidden" name="conta5" id="conta5" value="<?php echo $conta5; ?>" class="form-control" hidden>
                                    <input type="hidden" name="conta6" id="conta6" value="<?php echo $conta6; ?>" class="form-control" hidden>
                                </div>
                            </div>

                            <div class="col-md-0">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="hidden" name="tipo_oc" id="tipo_oc" class="form-control" hidden>
                                </div>
                            </div>

                            <div class="col-md-0">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="hidden" name="tipo_pc" id="tipo_pc" class="form-control" hidden>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="pc">PC</label>
                                    <input type="text" name="pc" id="pc" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="oc_cliente">OC Cliente</label>
                                    <input type="text" name="oc_cliente" id="oc_cliente" placeholder="OC Cliente" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-0">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input name="fecha_creacion" id="fecha_creacion" value="<?php echo $fecha_creacion?>" class="form-control" hidden>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fecha_aprovacion">Fecha Aprobación</label>
                                    <input type="date" name="fecha_aprovacion" id="fecha_aprovacion" placeholder="Fecha Aprobación" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="estado_admon">Estado Admon</label>
                                    <input type="text" name="estado_admon" id="estado_admon" placeholder="Estado Admon" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="vendedor">Vendedor</label>
                                    <input type="text" name="vendedor" id="vendedor" placeholder="Vendedor" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="estado_factura">Estado Factura</label>
                                    <input type="text" name="estado_factura" id="estado_factura" placeholder="Estado Factura" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-0">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="text" name="num_factura_fecha" id="num_factura_fecha" value="<?php echo $num_factura_fecha; ?>" class="form-control" hidden>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Acuerdo Pago</label>
                                    <select name="acuerdo_pago" id="acuerdo_pago" class="form-control" required>
                                     <option value="">Seleccione el Acuerdo de Pago</option>
                                        <?php 
                                            $query_prefijos = $pdo->prepare('SELECT acuerdo_pago FROM prefijos LIMIT 3');
                                            $query_prefijos->execute();
                                            $prefi = $query_prefijos->fetchAll(PDO::FETCH_ASSOC);
                                            foreach($prefi as $prefijos) {
                                                $acuerdo_pago = $prefijos['acuerdo_pago'];
                                                echo "<option value='$acuerdo_pago '>$acuerdo_pago</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nom_contacto_admin">Nombre Contacto Admin</label>
                                    <input type="text" name="nom_contacto_admin" id="nom_contacto_admin" placeholder="Nombre Contacto Admin" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="telefono_contacto">Telefono Contacto</label>
                                    <input type="text" name="telefono_contacto" id="telefono_contacto" placeholder="Telefono Contacto" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nom_cliente">Nombre del Cliente</label>
                                    <input type="text" name="nom_cliente" id="nom_cliente" placeholder="Nombre del Cliente" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nom_contacto_cliente">Nombre del Contacto Cliente</label>
                                    <input type="text" name="nom_contacto_cliente" id="nom_contacto_cliente" placeholder="Nombre del Contacto Cliente" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="num_telefono">Numero de Telefono</label>
                                    <input type="text" name="num_telefono" id="num_telefono" placeholder="Numero de Telefono" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="proyecto">Proyecto</label>
                                    <input type="text" name="proyecto" id="proyecto" placeholder="Proyecto" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ciudad">Ciudad</label>
                                    <input type="text" name="ciudad" id="ciudad" placeholder="Ciudad" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="lugar_instalacion">Lugar Instalación</label>
                                    <input type="text" name="lugar_instalacion" id="lugar_instalacion" placeholder="Lugar Instalación" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="estado_logistico">Estado Logístico</label>
                                    <input type="text" name="estado_logistico" id="estado_logistico" placeholder="Estado Logístico" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="dias_pactados">Días Pactados</label>
                                    <input type="number" name="dias_pactados" id="dias_pactados" placeholder="Días Pactados" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="observacion">Observación</label>
                                    <textarea name="observacion" id="observacion" cols="30" rows="4" placeholder="Observación" class="form-control" required></textarea>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <h3>Items</h3>
                                <button type="button" id="addItem" class="btn btn-primary">Agregar Ítem</button>
                            </div>

                            <div id="itemsContainer" class="row"></div>

                            <!-- Los campos de elementos dinámicos se agregarán aquí -->
                            <input type="hidden" name="num_factura" value="<?php echo $num_factura; ?>">
                        </div>
                        
                        <hr>
                        
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <a href="<?php echo $URL."admin/nueva_tarea_8-7-24/index_oc.php";?>" class="btn btn-default btn-block">Cancelar</a>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" onclick="return confirm('¿Está seguro de haber diligenciado correctamente los datos?')" class="btn btn-primary btn-block">Registrar OC</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div><!-- /.content-header -->
</div><!-- /.content-wrapper -->

<?php include('../../layout/admin/parte2.php');?>

<script>
    document.getElementById('addItem').addEventListener('click', function() {
        const container = document.getElementById('itemsContainer');
        const itemIndex = container.children.length / 4; // Cada ítem tiene 4 columnas

        const itemHTML = `
            <div class="col-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="descripcion_${itemIndex}">Descripción</label>
                            <input type="text" name="descripcion[]" id="descripcion_${itemIndex}" placeholder="Descripción" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cantidad_${itemIndex}">Cantidad</label>
                            <input type="number" name="cantidad[]" id="cantidad_${itemIndex}" placeholder="Cantidad" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="instalacion_${itemIndex}">Instalación</label>
                            <select name="instalacion[]" id="instalacion_${itemIndex}" class="form-control" required>
                                <option value="">SI - NO</option>
                                <?php 
                                    $query_tabla_union = $pdo->prepare('SELECT id, consecutivo_instalacion_oc FROM prefijos LIMIT 2');
                                    $query_tabla_union->execute();
                                    $uniones = $query_tabla_union->fetchAll(PDO::FETCH_ASSOC);
                                    foreach($uniones as $prefijos) {
                                        $consecutivo_instalacion_oc = $prefijos['consecutivo_instalacion_oc'];
                                        echo "<option value='$consecutivo_instalacion_oc'>$consecutivo_instalacion_oc</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger btn-sm delete-item">Eliminar</button>
                    </div>
                </div>
                <hr>
            </div>
        `;

        container.insertAdjacentHTML('beforeend', itemHTML);

        // Agregar el evento de eliminación a los nuevos botones
        const newDeleteButton = container.querySelector('.col-12:last-child .delete-item');
        newDeleteButton.addEventListener('click', function() {
            const itemContainer = this.closest('.col-12');
            itemContainer.remove();
        });
    });

    // Agregar eventos de eliminación a los ítems ya existentes (si hay)
    document.querySelectorAll('.delete-item').forEach(button => {
        button.addEventListener('click', function() {
            const itemContainer = this.closest('.col-12');
            itemContainer.remove();
        });
    });

</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('fetch_num_factura_fecha.php')
            .then(response => response.json())
            .then(data => {
                document.getElementById('num_factura_fecha').value = data.num_factura_fecha;
            });
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const ociOcSelect = document.getElementById('oci_oc');
    const smlPsiTlSelect = document.getElementById('sml_psi_tl');
    const ocResultanteInput = document.getElementById('oc_resultante');
    const tipoOcInput = document.getElementById('tipo_oc');
    const tipoPcInput = document.getElementById('tipo_pc');

    function updateResult() {
        const ociOc = ociOcSelect.value;
        const smlPsiTl = smlPsiTlSelect.value;

        if (!ociOc || !smlPsiTl) {
            return;
        }

        const tipoOc = `${ociOc}-${smlPsiTl}`;

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_counter.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);

                if (response.success) {
                    const contadorOc = response.contador_oc;
                    ocResultanteInput.value = `${tipoOc}-${String(contadorOc).padStart(3, '0')}`;

                    document.getElementById('conta1').value = response.conta1;
                    document.getElementById('conta2').value = response.conta2;
                    document.getElementById('conta3').value = response.conta3;
                    document.getElementById('conta4').value = response.conta4;
                    document.getElementById('conta5').value = response.conta5;
                    document.getElementById('conta6').value = response.conta6;

                    tipoOcInput.value = tipoOc;
                    tipoPcInput.value = `PC-${smlPsiTl}`;
                } else {
                    alert('Error al actualizar el contador.');
                }
            }
        };
        xhr.send(`tipo_oc=${encodeURIComponent(tipoOc)}`);
    }

    ociOcSelect.addEventListener('change', updateResult);
    smlPsiTlSelect.addEventListener('change', updateResult);
});

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('oci_oc').addEventListener('change', updateResult);
    document.getElementById('sml_psi_tl').addEventListener('change', updateResult);

    function updateResult() {
        var oci_oc = document.getElementById('oci_oc').value;
        var sml_psi_tl = document.getElementById('sml_psi_tl').value;
        var conta1 = parseInt(document.getElementById('conta1').value) || 0;
        var conta2 = parseInt(document.getElementById('conta2').value) || 0;
        var conta3 = parseInt(document.getElementById('conta3').value) || 0;
        var conta4 = parseInt(document.getElementById('conta4').value) || 0;
        var conta5 = parseInt(document.getElementById('conta5').value) || 0;
        var conta6 = parseInt(document.getElementById('conta6').value) || 0;
        var tipo_oc = oci_oc + '-' + sml_psi_tl;
        var contador_oc = 1;

        switch (tipo_oc) {
            case 'OCI-SML':
                contador_oc = conta1 + 1;
                break;
            case 'OCI-PSI':
                contador_oc = conta2 + 1;
                break;
            case 'OCI-TL':
                contador_oc = conta3 + 1;
                break;
            case 'OC-SML':
                contador_oc = conta4 + 1;
                break;
            case 'OC-PSI':
                contador_oc = conta5 + 1;
                break;
            case 'OC-TL':
                contador_oc = conta6 + 1;
                break;
            default:
                contador_oc = 1;
                break;
        }

        document.getElementById('oc_resultante').value = tipo_oc + '-' + str_pad(contador_oc, 3, '0', 'left');
        document.getElementById('tipo_oc').value = tipo_oc;
        document.getElementById('tipo_pc').value = 'PC-' + sml_psi_tl;
    }

    function str_pad(input, length, pad_string, pad_type) {
        pad_type = pad_type || 'right';
        var str = input.toString();
        var pad = '';
        if (pad_type === 'left') {
            pad = new Array(length - str.length + 1).join(pad_string);
            return pad + str;
        } else {
            pad = new Array(length - str.length + 1).join(pad_string);
            return str + pad;
        }
    }
});
</script>

<?php include('../../layout/admin/parte2.php'); ?>
prueba