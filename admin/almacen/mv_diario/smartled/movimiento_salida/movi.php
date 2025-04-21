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

    // Función para actualizar el campo salida_md
    function actualizarSalidaMd() {
        salidaMdInput.value = entradaMdInput.value; // Establecer el mismo valor que entrada_md
    }

    // Escuchar cambios en el campo entrada_md y llamar a la función actualizarSalidaMd
    entradaMdInput.addEventListener('input', actualizarSalidaMd);
});
</script>

<script>
$(document).ready(function() {
    // Limpiar campos cuando cambie el campo 'producto'
    $('#producto').change(function() {
        limpiarCampos(); // Llama a la función que limpia los campos
    });

    // Función para limpiar todos los campos del formulario, excluyendo el campo 'producto'
    function limpiarCampos() {
    // Limpiar todos los campos de texto, excluyendo los campos de la tabla
    $('input[type="text"]').not('#producto, #almacen_salida_md, #id_producto_categoria, #cantidad1, #producto1, #referencia2, #contador_sale, .observacion2, #op_destino, .cantidad1, #producto_id12, #sub_almacen, #referencia_id12, .producto1, .referencia2, .sub_almacen1').val('');
    $('input[type="number"]').val('');
    $('input[type="file"]').val('');
    $('select').not('#producto, #almacen_salida_md, #almacen_entrada_md').val('');
    $('textarea').val('');

    $('#list').empty(); // Vaciar la lista de imágenes si es necesario
    $('#lista_seriales').empty(); // Vaciar la tabla de seriales

}

    // Función común para manejar las solicitudes AJAX y actualizar selects
    function actualizarSelect(url, data, selectId, optionText) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', url, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                var selectElement = document.getElementById(selectId);
                selectElement.innerHTML = `<option value="">Seleccione ${optionText}</option>` + xhr.responseText;
            }
        };
        xhr.send(data);
    }

    // Detectar cambios en los campos de selección y actualizar los campos correspondientes
    $('#pitch').change(function() {
        var pitchValue = this.value;

        // Limpiar el campo "campo_referencia" cuando cambie el pitch
        document.getElementById('campo_referencia').value = '';

        actualizarSelect('get_serie_modulo.php', 'pitch=' + pitchValue, 'serie_modulo', 'una serie');
    });

    $('#marca_control').change(function() {
        var marcaControlValue = this.value;
        actualizarSelect('get_referencia_control.php', 'marca_control=' + encodeURIComponent(marcaControlValue), 'referencia_control35', 'una referencia');
    });

    $('#marca_fuente').change(function() {
        var marcaFuenteValue = this.value;
        actualizarSelect('get_modelo_fuente.php', 'marca_fuente=' + encodeURIComponent(marcaFuenteValue), 'modelo_fuente35', 'un modelo');
    });

    // Detectar cuando cambian los valores en los selects y asignar el valor al campo correspondiente
    function asignarValor(selectId, inputId) {
        document.getElementById(selectId).addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var selectedId = selectedOption.value;
            document.getElementById(inputId).value = selectedId;
        });
    }

    // Asignar valores a los campos 'id_serie_modulo', 'id_referencia_control', 'id_modelo_fuente'
    asignarValor('serie_modulo', 'id_serie_modulo');
    asignarValor('referencia_control35', 'id_referencia_control');
    asignarValor('modelo_fuente35', 'id_modelo_fuente');

    // Actualizar 'id_producto_categoria' cuando cambie 'producto'
    $('#producto').change(function() {
        var selectedOption = this.options[this.selectedIndex];
        var selectedId = selectedOption.value;
        console.log('ID seleccionado:', selectedId);
        $('#id_producto_categoria').val(selectedId);
    });
});
</script>

<script>
$(document).ready(function () {
    // Inicialmente deshabilitar el select de sub_almacen
    $('#sub_almacen').prop('disabled', true);

    // Escuchar cambios en id_producto_categoria y los 3 selects
    $('#id_producto_categoria, #serie_modulo, #referencia_control35, #modelo_fuente35').change(function () {
        var idProductoCategoria = $('#id_producto_categoria').val();
        var serieModulo = $('#serie_modulo').val();
        var referenciaControl = $('#referencia_control35').val();
        var modeloFuente = $('#modelo_fuente35').val();

        // Si id_producto_categoria está seleccionado y al menos uno de los otros selects tiene valor, habilitar sub_almacen
        if (idProductoCategoria && (serieModulo || referenciaControl || modeloFuente)) {
            $('#sub_almacen').prop('disabled', false);
        } else {
            $('#sub_almacen').prop('disabled', true).val(''); // Deshabilitar y limpiar sub_almacen
        }
    });

    // Escuchar cambios en sub_almacen para actualizar existencia
    $('#sub_almacen').change(function () {
        var idProductoCategoria = $('#id_producto_categoria').val();
        var subAlmacen = $(this).val();
        var valorCampo = $('#serie_modulo, #referencia_control35, #modelo_fuente35').filter(function () {
            return $(this).val() !== "";
        }).val(); // Obtener el primer valor seleccionado de los 3 selects
        var selectId = $('#serie_modulo, #referencia_control35, #modelo_fuente35').filter(function () {
            return $(this).val() !== "";
        }).attr('id'); // Identificar cuál select se usó

        // Limpiar existencia antes de hacer la nueva carga
        $('#existencia').val(0);

        if (!idProductoCategoria || !valorCampo || !subAlmacen) {
            return;
        }

        // Hacer la consulta AJAX
        $.ajax({
            url: 'obtener_datos_alma_smartled.php',
            method: 'POST',
            data: {
                id_producto_categoria: idProductoCategoria,
                valor_campo: valorCampo,
                select_id: selectId,
                sub_almacen: subAlmacen
            },
            success: function (response) {
                var data = JSON.parse(response);

                if (data.error) {
                    alert(data.error);
                    $('#existencia').val(0); // Si no hay coincidencias, existencia será 0
                } else {
                    $('#existencia').val(data.cantidad_plena);

                    // Asegurarse de que el campo de posición está en el formulario
                    $('#ubicacion').val(data.posicion); 
                }
            }
        });
    });
});

</script>

<script>
    document.getElementById('serie_modulo').addEventListener('change', function() {
    var selectedOption = this.options[this.selectedIndex];

        // Limpiar el campo "campo_referencia" cuando cambie el pitch
        document.getElementById('ubicacion').value = '';
        document.getElementById('existencia').value = '';

    // Obtener el valor de referencia desde el atributo 'data-referencia' del option seleccionado
    var referencia = selectedOption.getAttribute('data-referencia');
    var serie = selectedOption.textContent.split(' / ')[0]; // Extraer solo la parte de la serie, antes del "/"

    // Puedes usar estos valores para actualizar otros campos o realizar otras acciones
    console.log('Serie:', serie);  // El valor de serie
    console.log('Referencia:', referencia);  // El valor de referencia

    // Si deseas enviar ambos valores a través de un campo oculto o similar
    document.getElementById('campo_serie').value = serie;  // Asignar serie a un campo oculto (ejemplo)
    document.getElementById('campo_referencia').value = referencia;  // Asignar referencia a otro campo
});

</script>

<style>
    
    /* Estilo para el checkbox */
    .checkbox {
        width: 20px;
        height: 20px;
        margin-left: auto; /* Centra el checkbox horizontalmente */
        margin-right: auto; /* Centra el checkbox horizontalmente */
        display: block; /* Asegura que el checkbox ocupe su propio espacio */
        position: relative;
        top: 10%; /* Centra el checkbox verticalmente */
        transform: translateY(-5%); /* Ajusta el desplazamiento vertical para un centrado perfecto */
    }

    .articuloSeleccionado {
        width: 80px; /* Ajustar el ancho */
        height: 30px; /* Ajustar la altura */
        padding: 10px; /* Controlar el espacio interno */
    }
    .producto1 {
        width: 240px;
        height: 30px;
    }
    .referencia2 {
        width: 240px;
        height: 30px;
    }
    .observacion2 {
        width: 360px;
        height: 30px; /* Diferente altura para este campo */
        padding: 10px; /* Espacio interno más amplio */
    }

    /* Ajustar el input dentro del contenedor */
    .contenedor input {
        width: 100%; /* Ajustar el ancho al del contenedor */
        height: 100%; /* Ajustar la altura al del contenedor */
        box-sizing: border-box; /* Incluir padding y border en el tamaño total */
    }

</style>

<script> // Creaer, limpiar y eliminar filas a las tablas
document.addEventListener('DOMContentLoaded', function () {
    const btnAgregarArticulo = document.getElementById('btnAgregarArticulo');
    const tablaArticulos = document.getElementById('tabla-articulos').getElementsByTagName('tbody')[0];

    btnAgregarArticulo.addEventListener('click', function () {
        // Obtener los valores de los campos
        const cantidad = document.getElementsByName('entrada_md')[0].value;  // Cantidad
        const productoID = document.getElementById('producto').value;       // ID del producto
        const productoTexto = document.getElementById('producto').options[document.getElementById('producto').selectedIndex].text;  // Nombre del producto
        const observacion = document.getElementsByName('observacion')[0].value;

        // Obtener valores de referencia
        const pitch = document.getElementById('pitch').value;  // ID del pitch
        const pitchTexto = document.getElementById('pitch').options[document.getElementById('pitch').selectedIndex]?.text || '';
        const campoReferencia = document.getElementById('serie_modulo').value;  // ID de serie_modulo
        const referenciaTexto = document.getElementById('serie_modulo').options[document.getElementById('serie_modulo').selectedIndex]?.text || '';
        const referenciaControl35 = document.getElementById('referencia_control35').value;  // ID referencia_control35
        const referenciaControl35Texto = document.getElementById('referencia_control35').options[document.getElementById('referencia_control35').selectedIndex]?.text || '';
        const campoModeloFuente = document.getElementById('modelo_fuente35').value;  // ID modelo_fuente35
        const modeloFuenteTexto = document.getElementById('modelo_fuente35').options[document.getElementById('modelo_fuente35').selectedIndex]?.text || '';
        const campoSubAlmacen = document.getElementById('sub_almacen').value.trim() || "0"; // Evita valores vacíos
        const subAlmacenTexto = document.getElementById('sub_almacen').options[document.getElementById('sub_almacen').selectedIndex]?.text || '';

        // Determinar la referencia y su ID
        let referencia = '';
        let referenciaID = '';

        if (pitch && campoReferencia) {
            referencia = "P" + pitchTexto + "/" + referenciaTexto;
            referenciaID = campoReferencia; // Guardar el ID
        } else if (referenciaControl35) {
            referencia = referenciaControl35Texto;
            referenciaID = referenciaControl35;
        } else if (campoModeloFuente) {
            referencia = modeloFuenteTexto;
            referenciaID = campoModeloFuente;
        }

        // Crear una nueva fila
        const nuevaFila = document.createElement('tr');
        nuevaFila.innerHTML = `
            <td>
                <!-- Campo oculto con valor "1", solo se enviará si el checkbox no está marcado -->
                <input type="hidden" name="articuloSeleccionado[]" id="articuloSeleccionado" value="0">

                <!-- Checkbox para marcar -->
                <input type="checkbox" class="checkbox form-check-input" id="articuloSeleccionado" name="articuloSeleccionado[]" value="1">
            </td>
            <td>
                <input type="text" class="form-control cantidad1" id="cantidad1" name="cantidad1[]" value="${cantidad}" readonly>
            </td>
            <td>
                <input type="text" class="form-control producto1" id="producto1" name="producto1[]" value="${productoTexto}" readonly>
                <input type="hidden" id="producto_id12" name="producto_id12[]" value="${productoID}">
            </td>
            <td>
                <input type="text" class="form-control referencia2" id="referencia2" name="referencia2[]" value="${referencia}" readonly>
                <input type="hidden" id="referencia_id12" name="referencia_id12[]" value="${referenciaID}">
            </td>
            <td>
                <input type="text" class="form-control observacion2" id="observacion2" name="observacion2[]" value="${observacion}" readonly>
            </td>
            <td>
                <input type="text" class="form-control sub_almacen1" id="sub_almacen1" name="sub_almacen1[]" value="${subAlmacenTexto}" readonly>
                <input type="hidden" id="sub_almacen" name="sub_almacen[]" value="${campoSubAlmacen}">

            </td>
            <td>
                <button type="button" class="btn btn-danger btnEliminarArticulo">Eliminar</button>
            </td>
        `;

        console.log("ID Sub-Almacén:", campoSubAlmacen);
        console.log("Texto Sub-Almacén:", subAlmacenTexto);

        // Agregar fila a la tabla
        tablaArticulos.appendChild(nuevaFila);

        // Evento para eliminar la fila
        nuevaFila.querySelector('.btnEliminarArticulo').addEventListener('click', function () {
            nuevaFila.remove();
        });

        // Limpiar campos del formulario
        document.getElementsByName('entrada_md')[0].value = '';
        document.getElementById('producto').value = '';
        document.getElementsByName('observacion')[0].value = '';
        document.getElementById('pitch').value = '';
        document.getElementById('serie_modulo').value = '';
        document.getElementById('referencia_control35').value = '';
        document.getElementById('modelo_fuente35').value = '';
        document.getElementById('campo_referencia').value = '';
        document.getElementById('marca_control').value = '';
        document.getElementById('marca_fuente').value = '';
        document.getElementById('ubicacion').value = '';
        document.getElementById('existencia').value = '';
        document.getElementById('sub_almacen').value = '';  
    });
});
</script>

<script>
    const entradaMd = document.getElementById('entrada_md');
    const existencia = document.getElementById('existencia');
    const errorEntrada = document.getElementById('errorEntrada');

    entradaMd.addEventListener('input', function() {
        if (parseInt(this.value) > parseInt(existencia.value)) {
            errorEntrada.style.display = 'block';
            this.value = ''; // Borra el valor si es inválido
        } else {
            errorEntrada.style.display = 'none';
        }
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let almacenEntrada = document.getElementById("almacen_entrada_md");
        let subAlmacenDestino = document.getElementById("sub_almacen_destino");

        almacenEntrada.addEventListener("change", function() {
            if (almacenEntrada.value === "4") {
                subAlmacenDestino.removeAttribute("disabled");
            } else {
                subAlmacenDestino.setAttribute("disabled", "disabled");
            }
        });
    });
</script>

<script>
    document.addEventListener('submit', function (event) {
    document.querySelectorAll('select[name="sub_almacen[]"]').forEach(select => {
        if (select.value.trim() === "") {
            select.remove(); // Elimina el campo vacío para que no se envíe
        }
    });
});

</script>

<script> //GENERAR PDF DE SALIDA DE ARTICULOS
    document.getElementById('generarPdf').addEventListener('click', function () {


        // Obtener el valor del checkbox (asegúrate de que el id de tu checkbox sea correcto)
        const checkbox = document.getElementById('articuloSeleccionado'); // Cambia 'checkbox_id' por el id de tu checkbox
        const isChecked = checkbox.checked ? "1" : "0"; // Si está marcado, es "1", si no, es "0"

        // Validar si el checkbox está marcado (si es "1", no generamos el PDF)
        if (isChecked === "1") {
            alert("No se puede generar el PDF porque el checkbox está marcado.");
            return; // Detener el proceso de generación del PDF
        }

        // Crea una nueva instancia de jsPDF
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF({
            orientation: 'portrait', // Establece la orientación horizontal
            unit: 'mm', // Unidad de medida
            format: [210, 297] // Formato de la hoja
        });

        // Datos adicionales
        const fecha = new Date().toLocaleDateString();
        const contadorSalida = document.getElementById('contador_sale').value || "N/A";
        const almacenDestino = document.getElementById('almacen_entrada_md').options[document.getElementById('almacen_entrada_md').selectedIndex].text || "N/A";
        const asignarA = document.getElementById('op_destino').value || "N/A";

        // Encabezado de la empresa
        const pageWidth = 210; // Ancho total de la hoja en mm

        doc.setFontSize(14);
        doc.text('SMARTLED COLOMBIA', pageWidth / 2, 10, { align: 'center' });

        doc.setFontSize(12);
        doc.text('Salida de Artículos del Almacén', pageWidth / 2, 18, { align: 'center' });

        // Información adicional
        doc.setFontSize(10);
        doc.text(`Fecha: ${fecha}`, 10, 30);
        doc.text(`# Documento: ${contadorSalida}`, 10, 35);
        doc.text(`Almacén destino: ${almacenDestino}`, 10, 40);
        doc.text(`Asignar a: ${asignarA}`, 10, 45);

        // Crear los datos para la tabla
        const tablaArticulos = document.getElementById('tabla-articulos').getElementsByTagName('tbody')[0];
        const datosTabla = []; // Aquí almacenaremos las filas de datos

        for (let i = 0; i < tablaArticulos.rows.length; i++) {
            const fila = tablaArticulos.rows[i];

            // Extraer valores de los inputs en las celdas
            const cantidad = fila.querySelector('.cantidad1').value || "";
            const producto = fila.querySelector('.producto1').value || "";
            const referencia = fila.querySelector('.referencia2').value || "";
            const observacion = fila.querySelector('.observacion2').value || "";

            // Agregar la fila de datos como un array
            datosTabla.push([cantidad, producto, referencia, observacion]);
        }

        // Usar autoTable para crear la tabla
        doc.autoTable({
            head: [['Cantidad', 'Producto', 'Referencia', 'Observación']], // Encabezados
            body: datosTabla, // Datos de la tabla
            startY: 55, // Posición inicial
            styles: { fontSize: 8 }, // Tamaño de fuente
            columnStyles: {
            0: { cellWidth: 20 },  // Cantidad
            1: { cellWidth: 50 },  // Producto
            2: { cellWidth: 50 },  // Referencia
            3: { cellWidth: 60 }   // Observación
        },
            theme: 'grid', // Tema con bordes para la tabla
            margin: { left: 10, right: 10 } // Márgenes laterales
        });

        // Agregar líneas para firma
        const finalY = doc.lastAutoTable.finalY + 15; // Obtener la posición final de la tabla y dar espacio

        // Dibujar líneas horizontales
        doc.line(20, finalY, 70, finalY); // Línea para "Entrega"
        doc.line(100, finalY, 150, finalY); // Línea para "Recibe"

        // Agregar textos debajo de las líneas
        doc.setFontSize(10);
        doc.text("Entrega", 35, finalY + 5); // Texto debajo de la línea de "Entrega"
        doc.text("Recibe", 115, finalY + 5); // Texto debajo de la línea de "Recibe"

        // Guardar el PDF con un nombre específico
        doc.save('reporte_articulos.pdf');
    });
</script>

<script> // GENERAR EL PDF DE MATERIAL SEPARADO DEL ALMACEN
    document.getElementById('btnValidarMaterial').addEventListener('click', function () {
        fetch('validar_registros.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ action: 'validar_material' })
})
    .then(response => response.json())
    .then(data => {
        console.log('Respuesta del servidor:', data);  // Verifica la respuesta completa
        if (data.success) {
            console.log('Registros obtenidos:', data.registros);  // Verifica los registros obtenidos
            let contenidoTabla = `<table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Separar</th>
                                <th>Producto</th>
                                <th>Referencia</th>
                                <th>Cantidad</th>
                                <th>Observaciones</th>
                                <th>Asignado a:</th>
                                <th>N° Movimiento</th>
                                <th>Almacen Destino</th>
                            </tr>
                        </thead>
                        <tbody>`;

data.registros.forEach(registro => {
    contenidoTabla += `<tr>
                        <td>
                            <input type="checkbox" class="checkbox-material" data-id="${registro.id_movimiento_diario}">
                        </td>
                        <td>${registro.nombre_producto}</td>
                        <td>${registro.nombre_referencia_2}</td>
                        <td>${registro.cantidad_entrada}</td>
                        <td>${registro.observaciones}</td>
                        <td>${registro.op}</td>
                        <td>${registro.consecu_sale}</td>
                        <td>${registro.almacen_destino}</td>
                        </tr>`;
});

contenidoTabla += `</tbody></table>`;
document.getElementById('contenidoTablaMaterial').innerHTML = contenidoTabla;

        } else {
            alert('No se encontraron registros.');
        }
    })
    .catch(error => console.error('Error:', error));

    });

    document.getElementById('btnGenerarPdfModal').addEventListener('click', function () {
    const checkboxes = document.querySelectorAll('.checkbox-material:checked');
    const registrosSeleccionados = [];
    const idsActualizar = [];

    // Inicializa variables para los datos adicionales
    let fecha = new Date().toLocaleDateString();
    let contadorSalida = "N/A";
    let almacenDestino = "N/A";
    let asignarA = "N/A";

    checkboxes.forEach(checkbox => {
        const fila = checkbox.closest('tr');
        const columnas = Array.from(fila.querySelectorAll('td'));

        // Asignar manualmente los valores que deseas extraer
        const cantidad = columnas[3]?.textContent || "N/A"; // Cantidad
        const producto = columnas[1]?.textContent || "N/A"; // Producto
        const referencia = columnas[2]?.textContent || "N/A"; // Referencia
        const observacion = columnas[4]?.textContent || "N/A"; // Observación

         // Solo toma los datos adicionales del primer registro (si son comunes a todos)
        if (!contadorSalida || contadorSalida === "N/A") contadorSalida = columnas[6]?.textContent || "N/A";
        if (!almacenDestino || almacenDestino === "N/A") almacenDestino = columnas[7]?.textContent || "N/A";
        if (!asignarA || asignarA === "N/A") asignarA = columnas[5]?.textContent || "N/A";

        registrosSeleccionados.push([cantidad, producto, referencia, observacion]);

        // También puedes asignar columnas específicas directamente a variables globales, si es necesario
        idsActualizar.push(checkbox.dataset.id); // Almacenar el ID seleccionado
    });

    if (registrosSeleccionados.length === 0) {
        alert('Por favor, selecciona al menos un registro.');
        return;
    }

    // Generar el PDF con los datos seleccionados
    generarPDF(registrosSeleccionados, fecha, contadorSalida, almacenDestino, asignarA);

    // Llamar a la función para actualizar registros en la base de datos
    actualizarRegistros(idsActualizar);
});

// Función para generar el PDF con los datos
function generarPDF(registrosSeleccionados, fecha, contadorSalida, almacenDestino, asignarA) {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({
        orientation: 'portrait', // Orientación horizontal
        unit: 'mm', // Unidad de medida
        format: [210, 297] // Media carta (ancho x alto)
    });

    // Encabezado de la empresa
    const pageWidth = 210; // Ancho total de la hoja en mm

    doc.setFontSize(14);
    doc.text('SMARTLED COLOMBIA', pageWidth / 2, 10, { align: 'center' });

    doc.setFontSize(12);
    doc.text('Salida de Artículos del Almacén', pageWidth / 2, 18, { align: 'center' });

    // Información adicional
    doc.setFontSize(10);
    doc.text(`Fecha: ${fecha}`, 10, 30);
    doc.text(`# Documento: ${contadorSalida}`, 10, 35);
    doc.text(`Almacén destino: ${almacenDestino}`, 10, 40);
    doc.text(`Asignar a: ${asignarA}`, 10, 45);

    // Crear la tabla con autoTable
    doc.autoTable({
        head: [['Cantidad', 'Producto', 'Referencia', 'Observación']], // Encabezados
        body: registrosSeleccionados, // Datos de la tabla
        startY: 55, // Posición inicial
        styles: { fontSize: 8 }, // Tamaño de fuente
        columnStyles: {
            0: { cellWidth: 20 },  // Cantidad
            1: { cellWidth: 50 },  // Producto
            2: { cellWidth: 50 },  // Referencia
            3: { cellWidth: 60 }   // Observación
        },
        theme: 'grid',
        margin: { left: 10, right: 10 } // Márgenes laterales
    });

    // Agregar líneas para firmas
    const finalY = doc.lastAutoTable.finalY + 15; // Posición después de la tabla

    doc.line(20, finalY, 70, finalY); // Línea para "Entrega"
    doc.line(100, finalY, 150, finalY); // Línea para "Recibe"

    // Agregar textos para firmas
    doc.setFontSize(10);
    doc.text("Entrega", 35, finalY + 5); // Texto debajo de la línea de "Entrega"
    doc.text("Recibe", 115, finalY + 5); // Texto debajo de la línea de "Recibe"

    // Guardar el PDF
    doc.save('material_validado.pdf');
}

function actualizarRegistros(ids) {
    console.log('IDs enviados al servidor:', ids); // Verifica los IDs enviados
    fetch('actualizar_registros.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ ids: ids })
    })
        .then(response => response.json())
        .then(data => {
            console.log('Respuesta del servidor:', data); // Verifica la respuesta del servidor
            if (data.success) {
                alert('Los registros se han actualizado correctamente.');
            } else {
                alert('Hubo un problema al actualizar los registros: ' + (data.message || 'Error desconocido.'));
            }
        })
        .catch(error => console.error('Error:', error));
}
</script>

<!--
<script> //GENERAR PDF DE SALIDA DE ARTICULOS
let registrosSeleccionados = [];
let idsActualizar = [];
let fecha = new Date().toLocaleDateString();
let contadorSalida = "N/A";
let almacenDestino = "N/A";
let asignarA = "N/A";

// Función para manejar la generación del PDF
function manejarGeneracionPDF() {
    generarPDF(registrosSeleccionados, fecha, contadorSalida, almacenDestino, asignarA);
    actualizarRegistros(idsActualizar, document.getElementById('tecnico_recibe').value);
}

// Evento principal al hacer clic en el botón
document.getElementById('btnGenerarPdfModal').addEventListener('click', function () {
    const checkboxes = document.querySelectorAll('.checkbox-material:checked');
    registrosSeleccionados = [];
    idsActualizar = [];

    const articuloSeleccionado = document.getElementById('articuloSeleccionado');

    checkboxes.forEach(checkbox => {
        const fila = checkbox.closest('tr');
        const columnas = Array.from(fila.querySelectorAll('td'));

        const cantidad = columnas[3]?.textContent || "N/A";
        const producto = columnas[1]?.textContent || "N/A";
        const referencia = columnas[2]?.textContent || "N/A";
        const observacion = columnas[4]?.textContent || "N/A";

        if (!contadorSalida || contadorSalida === "N/A") contadorSalida = columnas[6]?.textContent || "N/A";
        if (!almacenDestino || almacenDestino === "N/A") almacenDestino = columnas[7]?.textContent || "N/A";
        if (!asignarA || asignarA === "N/A") asignarA = columnas[5]?.textContent || "N/A";

        registrosSeleccionados.push([cantidad, producto, referencia, observacion]);
        idsActualizar.push(checkbox.dataset.id);
    });

    if (registrosSeleccionados.length === 0) {
        alert('Por favor, selecciona al menos un registro.');
        return;
    }

    // ✅ SI articuloSeleccionado NO está marcado, abrir modal técnico
    if (!articuloSeleccionado.checked) {
        $('#modalSeleccionTecnico').modal('show');
    } else {
        // ✅ SI está marcado, guardar info + generar PDF
        document.getElementById('tecnico_recibe').value = asignarA;
        manejarGeneracionPDF(); // esto incluye guardar y generar PDF
    }
});

// ✅ Confirmar técnico (solo guarda, NO genera PDF)
document.getElementById('confirmarTecnico').addEventListener('click', function () {
    const tecnico = document.getElementById('selectTecnico').value;
    const tecnicoTexto = document.getElementById('selectTecnico').options[document.getElementById('selectTecnico').selectedIndex].text;

    if (!tecnico) {
        alert('Por favor selecciona un técnico.');
        return;
    }

    document.getElementById('tecnico_recibe').value = tecnicoTexto;
    $('#modalSeleccionTecnico').modal('hide');

    // ✅ Solo guardar datos, SIN generar PDF
    actualizarRegistros(idsActualizar, tecnicoTexto);
});


// Confirmación del técnico en el modal
document.getElementById('confirmarTecnico').addEventListener('click', function () {
    const tecnico = document.getElementById('selectTecnico').value;
    const tecnicoTexto = document.getElementById('selectTecnico').options[document.getElementById('selectTecnico').selectedIndex].text;

    if (!tecnico) {
        alert('Por favor selecciona un técnico.');
        return;
    }

    document.getElementById('tecnico_recibe').value = tecnicoTexto;
    $('#modalSeleccionTecnico').modal('hide');
    manejarGeneracionPDF();
});

function generarPDF(registrosSeleccionados, fecha, contadorSalida, almacenDestino, asignarA) {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({ orientation: 'portrait', unit: 'mm', format: [210, 297] });

    const pageWidth = 210;

    doc.setFontSize(14);
    doc.text('SMARTLED COLOMBIA', pageWidth / 2, 10, { align: 'center' });
    doc.setFontSize(12);
    doc.text('Salida de Artículos del Almacén', pageWidth / 2, 18, { align: 'center' });

    doc.setFontSize(10);
    doc.text(`Fecha: ${fecha}`, 10, 30);
    doc.text(`# Documento: ${contadorSalida}`, 10, 35);
    doc.text(`Almacén destino: ${almacenDestino}`, 10, 40);
    doc.text(`Asignar a: ${document.getElementById('tecnico_recibe').value}`, 10, 45);

    doc.autoTable({
        head: [['Cantidad', 'Producto', 'Referencia', 'Observación']],
        body: registrosSeleccionados,
        startY: 55,
        styles: { fontSize: 8 },
        columnStyles: {
            0: { cellWidth: 20 },
            1: { cellWidth: 50 },
            2: { cellWidth: 50 },
            3: { cellWidth: 60 }
        },
        theme: 'grid',
        margin: { left: 10, right: 10 }
    });

    const finalY = doc.lastAutoTable.finalY + 15;
    doc.line(20, finalY, 70, finalY);
    doc.line(100, finalY, 150, finalY);
    doc.setFontSize(10);
    doc.text("Entrega", 35, finalY + 5);
    doc.text("Recibe", 115, finalY + 5);
    doc.save('material_validado.pdf');
}

function actualizarRegistros(ids, tecnicoRecibe) {
    fetch('actualizar_registros.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ ids: ids, tecnico_recibe: tecnicoRecibe })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Registros actualizados correctamente.');
        } else {
            alert('Error al actualizar: ' + (data.message || 'Desconocido'));
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>

<script> // GENERAR EL PDF DE MATERIAL SEPARADO DEL ALMACEN
    document.getElementById('btnValidarMaterial').addEventListener('click', function () {
        fetch('validar_registros.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ action: 'validar_material' })
})
    .then(response => response.json())
    .then(data => {
        console.log('Respuesta del servidor:', data);  // Verifica la respuesta completa
        if (data.success) {
            console.log('Registros obtenidos:', data.registros);  // Verifica los registros obtenidos
            let contenidoTabla = `<table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Separar</th>
                                <th>Producto</th>
                                <th>Referencia</th>
                                <th>Cantidad</th>
                                <th>Observaciones</th>
                                <th>Asignado a:</th>
                                <th>N° Movimiento</th>
                                <th>Almacen Destino</th>
                            </tr>
                        </thead>
                        <tbody>`;

data.registros.forEach(registro => {
    contenidoTabla += `<tr>
                        <td>
                            <input type="checkbox" class="checkbox-material" data-id="${registro.id_movimiento_diario}">
                        </td>
                        <td>${registro.nombre_producto}</td>
                        <td>${registro.nombre_referencia_2}</td>
                        <td>${registro.cantidad_entrada}</td>
                        <td>${registro.observaciones}</td>
                        <td>${registro.op}</td>
                        <td>${registro.consecu_sale}</td>
                        <td>${registro.almacen_destino}</td>
                        </tr>`;
});

contenidoTabla += `</tbody></table>`;
document.getElementById('contenidoTablaMaterial').innerHTML = contenidoTabla;

        } else {
            alert('No se encontraron registros.');
        }
    })
    .catch(error => console.error('Error:', error));

    });

    document.getElementById('btnGenerarPdfModal').addEventListener('click', function () {
    const checkboxes = document.querySelectorAll('.checkbox-material:checked');
    registrosSeleccionados = [];
    idsActualizar = [];

    const articuloSeleccionado = document.getElementById('articuloSeleccionado');

    checkboxes.forEach(checkbox => {
        const fila = checkbox.closest('tr');
        const columnas = Array.from(fila.querySelectorAll('td'));

        const cantidad = columnas[3]?.textContent || "N/A";
        const producto = columnas[1]?.textContent || "N/A";
        const referencia = columnas[2]?.textContent || "N/A";
        const observacion = columnas[4]?.textContent || "N/A";

        if (!contadorSalida || contadorSalida === "N/A") contadorSalida = columnas[6]?.textContent || "N/A";
        if (!almacenDestino || almacenDestino === "N/A") almacenDestino = columnas[7]?.textContent || "N/A";
        if (!asignarA || asignarA === "N/A") asignarA = columnas[5]?.textContent || "N/A";

        registrosSeleccionados.push([cantidad, producto, referencia, observacion]);
        idsActualizar.push(checkbox.dataset.id);
    });

    if (registrosSeleccionados.length === 0) {
        alert('Por favor, selecciona al menos un registro.');
        return;
    }

    // ✅ SI articuloSeleccionado NO está marcado, abrir modal técnico
    if (!articuloSeleccionado.checked) {
        $('#modalSeleccionTecnico').modal('show');
    } else {
        // ✅ SI está marcado, guardar info + generar PDF
        document.getElementById('tecnico_recibe').value = asignarA;
        manejarGeneracionPDF(); // esto incluye guardar y generar PDF
    }
});

// ✅ Confirmar técnico (solo guarda, NO genera PDF)
document.getElementById('confirmarTecnico').addEventListener('click', function () {
    const tecnico = document.getElementById('selectTecnico').value;
    const tecnicoTexto = document.getElementById('selectTecnico').options[document.getElementById('selectTecnico').selectedIndex].text;

    if (!tecnico) {
        alert('Por favor selecciona un técnico.');
        return;
    }

    document.getElementById('tecnico_recibe').value = tecnicoTexto;
    $('#modalSeleccionTecnico').modal('hide');

    // ✅ Solo guardar datos, SIN generar PDF
    actualizarRegistros(idsActualizar, tecnicoTexto);
});


// Función para generar el PDF con los datos
function generarPDF(registrosSeleccionados, fecha, contadorSalida, almacenDestino, asignarA) {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({
        orientation: 'portrait', // Orientación horizontal
        unit: 'mm', // Unidad de medida
        format: [210, 297] // Media carta (ancho x alto)
    });

    // Encabezado de la empresa
    const pageWidth = 210; // Ancho total de la hoja en mm

    doc.setFontSize(14);
    doc.text('SMARTLED COLOMBIA', pageWidth / 2, 10, { align: 'center' });

    doc.setFontSize(12);
    doc.text('Salida de Artículos del Almacén', pageWidth / 2, 18, { align: 'center' });

    // Información adicional
    doc.setFontSize(10);
    doc.text(`Fecha: ${fecha}`, 10, 30);
    doc.text(`# Documento: ${contadorSalida}`, 10, 35);
    doc.text(`Almacén destino: ${almacenDestino}`, 10, 40);
    doc.text(`Asignar a: ${asignarA}`, 10, 45);

    // Crear la tabla con autoTable
    doc.autoTable({
        head: [['Cantidad', 'Producto', 'Referencia', 'Observación']], // Encabezados
        body: registrosSeleccionados, // Datos de la tabla
        startY: 55, // Posición inicial
        styles: { fontSize: 8 }, // Tamaño de fuente
        columnStyles: {
            0: { cellWidth: 20 },  // Cantidad
            1: { cellWidth: 50 },  // Producto
            2: { cellWidth: 50 },  // Referencia
            3: { cellWidth: 60 }   // Observación
        },
        theme: 'grid',
        margin: { left: 10, right: 10 } // Márgenes laterales
    });

    // Agregar líneas para firmas
    const finalY = doc.lastAutoTable.finalY + 15; // Posición después de la tabla

    doc.line(20, finalY, 70, finalY); // Línea para "Entrega"
    doc.line(100, finalY, 150, finalY); // Línea para "Recibe"

    // Agregar textos para firmas
    doc.setFontSize(10);
    doc.text("Entrega", 35, finalY + 5); // Texto debajo de la línea de "Entrega"
    doc.text("Recibe", 115, finalY + 5); // Texto debajo de la línea de "Recibe"

    // Guardar el PDF
    doc.save('material_validado.pdf');
}

function actualizarRegistros(ids) {
    console.log('IDs enviados al servidor:', ids); // Verifica los IDs enviados
    fetch('actualizar_registros.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ ids: ids })
    })
        .then(response => response.json())
        .then(data => {
            console.log('Respuesta del servidor:', data); // Verifica la respuesta del servidor
            if (data.success) {
                alert('Los registros se han actualizado correctamente.');
            } else {
                alert('Hubo un problema al actualizar los registros: ' + (data.message || 'Error desconocido.'));
            }
        })
        .catch(error => console.error('Error:', error));
}
</script>
-->