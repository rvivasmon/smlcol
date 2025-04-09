<!-- GENERAR PDF DE SALIDA DE ARTICULOS
<script>
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
</script>-->