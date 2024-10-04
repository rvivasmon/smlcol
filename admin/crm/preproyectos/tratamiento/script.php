<script>

document.addEventListener('DOMContentLoaded', function() {
    const pitchSelect = document.getElementById('pitch_dispo');
    const xRealInput = document.querySelector('input[name="x_real"]');
    const yRealInput = document.querySelector('input[name="y_real"]');
    const xDispInput = document.getElementById('x_disp');
    const yDispInput = document.getElementById('y_disp');
    const xTotalInput = document.getElementById('x_total');
    const yTotalInput = document.getElementById('y_total');
    const moduloXInput = document.getElementById('modulo_x');
    const moduloYInput = document.getElementById('modulo_y');
    const pixelPorPantallaInput = document.getElementById('pixelxpantalla');
    const checkbox = document.getElementById('intercambiar');
    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');
    const agregarProductoCheckbox = document.getElementById('agregar_Producto');
    const formularioExtra = document.getElementById('formularioExtra');
    const modeloSelect = document.getElementById('modelo');
    const controladoraSelect = document.getElementById('controladora');
    const cantidadControlInput = document.getElementById('cantidadControl');


    let originalXReal, originalYReal;

    function initEvents() {
        pitchSelect.addEventListener('change', onPitchChange);
        checkbox.addEventListener('change', onCheckboxChange);
        modeloSelect.addEventListener('change', onModeloChange);
        agregarProductoCheckbox.addEventListener('change', onAgregarProductoChange);
        xRealInput.addEventListener('input', updatePixelPorPantalla);
        yRealInput.addEventListener('input', updatePixelPorPantalla);
        moduloXInput.addEventListener('input', updatePixelPorPantalla);
        moduloYInput.addEventListener('input', updatePixelPorPantalla);
        document.getElementById('x_real').addEventListener('input', updateTotals);
        document.getElementById('y_real').addEventListener('input', updateTotals);
        document.getElementById('x_disp').addEventListener('input', updateTotals);
        document.getElementById('y_disp').addEventListener('input', updateTotals);

    }

    function onPitchChange() {
        const selectedOption = pitchSelect.options[pitchSelect.selectedIndex];
        xRealInput.value = selectedOption.getAttribute('data-medida-x') || '';
        yRealInput.value = selectedOption.getAttribute('data-medida-y') || '';

        originalXReal = xRealInput.value;
        originalYReal = yRealInput.value;

        updateTotals();
        updateRectangulo();
        updatePixelPorPantalla();
    }

    function onCheckboxChange() {
        if (checkbox.checked) {
            [xRealInput.value, yRealInput.value] = [yRealInput.value, xRealInput.value];
        } else {
            xRealInput.value = originalXReal;
            yRealInput.value = originalYReal;
        }
        updateTotals();
        updateRectangulo();
    }

    function onModeloChange() {
        const modeloId = modeloSelect.value;

        fetch(`get_pitch.php?modelo_id=${modeloId}`)
            .then(response => response.json())
            .then(data => {
                pitchSelect.innerHTML = '<option value="">Seleccione un pitch</option>';
                data.forEach(item => {
                    pitchSelect.innerHTML += `
                        <option value="${item.id_car_mod}" 
                                data-pitch="${item.pitch}" 
                                data-medida-x="${item.medida_x}" 
                                data-medida-y="${item.medida_y}">
                            ${item.pitch} / ${item.medida_x} x ${item.medida_y}
                        </option>`;
                });
                pitchSelect.dispatchEvent(new Event('change'));
            });
    }

    function onAgregarProductoChange() {
        formularioExtra.style.display = agregarProductoCheckbox.checked ? 'block' : 'none';

        if (agregarProductoCheckbox.checked) {
            controladoraSelect.disabled = false;
            const pixelMaxValue = parseFloat(pixelPorPantallaInput.value);
            fetch(`get_controladoras.php?pixel_max=${pixelMaxValue}`)
                .then(response => response.json())
                .then(data => {
                    controladoraSelect.innerHTML = '<option value="">Seleccione una controladora</option>';
                    data.forEach(item => {
                        controladoraSelect.innerHTML += `
                            <option value="${item.id_referencia}">${item.referencia}</option>`;
                    });
                })
                .catch(error => console.error('Error al obtener controladoras:', error));
        } else {
            controladoraSelect.disabled = true;
            controladoraSelect.innerHTML = '<option value="">Seleccione una controladora</option>';
        }
    }

    function updateTotals() {
    const xReal = Number(xRealInput.value) || 1;
    const yReal = Number(yRealInput.value) || 1;
    const xDisp = Number(xDispInput.value) || 0;
    const yDisp = Number(yDispInput.value) || 0;

    const xModulo = Math.floor(xDisp / xReal);
    const yModulo = Math.floor(yDisp / yReal);

    const xTotal = xModulo * xReal;
    const yTotal = yModulo * yReal;

    xTotalInput.value = xTotal;
    yTotalInput.value = yTotal;
    moduloXInput.value = xModulo;
    moduloYInput.value = yModulo;

    // Calcular el resultado de la multiplicación y redondearlo a 2 dígitos después del punto
    let resultadoMultiplicacion = (xTotal * yTotal) / 1000;
    resultadoMultiplicacion = Math.round(resultadoMultiplicacion);  // Redondear

    // Mostrar el resultado en el label con separadores de miles
    document.getElementById('resultadoMultiplicacionLabel').textContent = `Mts²: ${Number(resultadoMultiplicacion).toLocaleString('es')} Mts`;

    // Almacenar el valor sin formato en el input oculto
    document.getElementById('resultadoMultiplicacioninput').value = resultadoMultiplicacion;

    updateFieldColors();
    updatePixelPorPantalla();
}


    function updateFieldColors() {
        const xTotal = parseFloat(xTotalInput.value) || 0;
        const yTotal = parseFloat(yTotalInput.value) || 0;
        const xDisp = parseFloat(xDispInput.value) || 0;
        const yDisp = parseFloat(yDispInput.value) || 0;

        xTotalInput.style.color = (xTotal > xDisp) ? 'red' : 'green';
        yTotalInput.style.color = (yTotal > yDisp) ? 'red' : 'green';
    }

    function updateRectangulo() {
        const xReal = parseFloat(xRealInput.value) || 0;
        const yReal = parseFloat(yRealInput.value) || 0;

        ctx.clearRect(0, 0, canvas.width, canvas.height);
        const maxCanvasSize = 160;
        const scaleFactor = Math.min(maxCanvasSize / xReal, maxCanvasSize / yReal);
        const scaledX = xReal * scaleFactor;
        const scaledY = yReal * scaleFactor;

        ctx.fillStyle = (xReal > yReal) ? 'blue' : (xReal < yReal) ? 'green' : 'red';
        ctx.fillRect(10, 10, scaledX, scaledY);
    }

    function updatePixelPorPantalla() {
        const selectedOption = pitchSelect.options[pitchSelect.selectedIndex];
        const pitch = parseFloat(selectedOption.getAttribute('data-pitch')) || 1;
        let xReal = parseFloat(xRealInput.value) || 0;
        let yReal = parseFloat(yRealInput.value) || 0;
        const moduloX = parseInt(moduloXInput.value) || 0;
        const moduloY = parseInt(moduloYInput.value) || 0;

        if (checkbox.checked) [xReal, yReal] = [yReal, xReal];

        const pixelX = moduloX * Math.round(xReal / pitch);
        const pixelY = moduloY * Math.round(yReal / pitch);
        pixelPorPantallaInput.value = pixelX * pixelY;

        // Mostrar el valor formateado con separadores de miles
        const pixelPorPantallaFormatted = document.getElementById('pixelxpantalla_formatted');
        pixelPorPantallaFormatted.value = (pixelX * pixelY).toLocaleString();
    }

    // Inicializar los eventos
    initEvents();
    updateTotals();
    updateRectangulo();
});

</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Variables
    const controladoraSelect = document.getElementById('controladora');
    const pixelMaxLabel = document.getElementById('pixelMaxLabel');

    function actualizarResultadoResta() {
        const pixelXPantalla = Number(document.getElementById('pixelxpantalla').value);
        const pixelMaxLabelFormatted = Number(document.getElementById('pixelMaxLabel_formatted').value);

        // Realizar la resta
        const resultadoResta = pixelXPantalla - pixelMaxLabelFormatted;

        // Mostrar el resultado en el label con separadores de mil
        document.getElementById('resultadoRestaLabel').textContent = `Resultado: ${resultadoResta.toLocaleString('es')}`;
        
        // Asignar el valor sin formato al campo resultadoresta
        document.getElementById('resultadoresta').value = resultadoResta; // Valor sin formatear
    }

    function onControladoraChange() {
        const controladoraId = controladoraSelect.value;
        
        if (controladoraId) {
            fetch(`get_pixel_max.php?controladora_id=${controladoraId}`)
                .then(response => response.json())
                .then(data => {
                    const pixelMax = Number(data.pixel_max); // Obtener el valor sin formatear
                    const pixelMaxFormatted = pixelMax.toLocaleString('es'); // Formatear con puntos de mil

                    pixelMaxLabel.textContent = `Pixel Max: ${pixelMaxFormatted}`;
                    document.getElementById('pixelMaxLabel_formatted').value = pixelMax; // Almacenar el valor sin puntos de mil
                    
                    // Actualizar el resultado de la resta cuando se cambia la controladora
                    actualizarResultadoResta();
                })
                .catch(error => console.error('Error al obtener el pixel:max:', error));
        } else {
            pixelMaxLabel.textContent = ''; // Limpiar el label si no hay selección
            document.getElementById('pixelMaxLabel_formatted').value = ''; // Limpiar el valor formateado
            document.getElementById('resultadoRestaLabel').textContent = ''; // Limpiar el resultado de la resta
        }
    }

    // Agregar un evento para que se actualice el resultado al cambiar el valor de pixelxpantalla
    document.getElementById('pixelxpantalla').addEventListener('input', actualizarResultadoResta);

    // Agregar el evento de cambio al select de controladora
    controladoraSelect.addEventListener('change', onControladoraChange);

    // Inicializa otros eventos si es necesario
});

</script>

<script>

document.addEventListener('DOMContentLoaded', function() {
    const pitchSelect = document.getElementById('pitch_dispo');
    const modeloSelect = document.getElementById('modelo');
    const agregarProductoCheckbox = document.getElementById('agregar_Producto');
    const formularioExtra = document.getElementById('formularioExtra');
    const controladoraSelect = document.getElementById('controladora');
    const pixelMaxLabel = document.getElementById('pixelMaxLabel'); // Añadir referencia al label
    const pixelMaxLabelInput = document.getElementById('pixelMaxLabel_formatted'); // Añadir referencia al peso sin
    const cantidadControlInput = document.getElementById('cantidadControl');
    const resultadoRestaLabel = document.getElementById('resultadoRestaLabel'); // Añadir referencia al label
    const resultadorestaInput = document.getElementById('resultadoresta'); // Añadir referencia al peso sin
    const resultadoMultiplicacionLabel = document.getElementById('resultadoMultiplicacionLabel'); // Añadir referencia al peso sin
    const resultadoMultiplicacionInput = document.getElementById('resultadoMultiplicacioninput'); // Añadir referencia al peso sin
    const pesoxpantallaLabel = document.getElementById('pesoxpantallaLabel'); // Añadir referencia al peso con
    const pesoxpantallasinInput = document.getElementById('pesoxpantallasin'); // Añadir referencia al peso sin
    const LabelWattsConsumo = document.getElementById('labelWattsConsumo'); // Añadir referencia al peso con
    const InputWattsConsumo = document.getElementById('inputWattsConsumo'); // Añadir referencia al peso sin

    resultadoRestaLabel

    // Inicializar eventos existentes
    initEvents();

    // Nueva función para resetear el formulario extra
    function resetFormularioExtra() {

        controladoraSelect.value = '';  // Resetea
        pixelMaxLabelInput.value = '';  // Resetea
        cantidadControlInput.value = '';    // Resetea
        resultadorestaInput.value = ''; // Resetea
        resultadoMultiplicacionInput.value = '';    // Resetea
        pesoxpantallasinInput.value = '';   // Resetea
        InputWattsConsumo.value = '';   // Resetea
        pixelMaxLabel.textContent = ''; //  Resetea
        resultadoRestaLabel.textContent = '';   //  Resetea
        resultadoMultiplicacionLabel.textContent = '';  //  Resetea
        pesoxpantallaLabel.textContent = '';    //  Resetea
        LabelWattsConsumo.textContent = ''; //  Resetea
        formularioExtra.style.display = 'none'; // Oculta el formulario extra
        agregarProductoCheckbox.checked = false; // Desmarca el checkbox
    }

    // Añadir eventos de cambio para los campos "modelo" y "pitch_dispo"
    modeloSelect.addEventListener('change', resetFormularioExtra);
    pitchSelect.addEventListener('change', resetFormularioExtra);

    // Función que inicializa los eventos
    function initEvents() {
        // Agrega otros eventos que ya tienes...
        agregarProductoCheckbox.addEventListener('change', onAgregarProductoChange);
    }

    // La función existente onAgregarProductoChange (asegúrate de que maneja la visibilidad del formulario extra)
    function onAgregarProductoChange() {
        formularioExtra.style.display = agregarProductoCheckbox.checked ? 'block' : 'none';
        if (agregarProductoCheckbox.checked) {
            controladoraSelect.disabled = false;
            // Lógica para llenar las opciones de controladora
        } else {
            controladoraSelect.disabled = true;
            controladoraSelect.innerHTML = '<option value="">Seleccione una controladora</option>';
        }
    }
});

</script>

<script>
document.getElementById('pitch_dispo').addEventListener('change', function(){
    const idUso = Number(document.getElementById('id_uso1').value);
    const idTipoProducto = document.getElementById('id_tipoproducto').value;
    const resultadoMultiplicacion = Number(document.getElementById('resultadoMultiplicacioninput').value);

    // Verifica si id_uso es 1, 2, 3, 4 o 5
    if ([1, 2, 3, 4, 5].includes(idUso)) {
        // Realiza la consulta a la base de datos (usando AJAX o fetch)
        fetch(`consumo_wats.php?id_uso=${idUso}`)
        .then(response => response.json())
        .then(data => {
            console.log('Datos recibidos:', data);  // Verificar la respuesta

            if (data && data.consumo_wats) {
                const consumoWats = Number(data.consumo_wats); // Obtén el valor del campo "consumo_wats"
                console.log('consumo_wats:', consumoWats);  // Verificar el valor de consumo_wats

                let resultadoConsumo = Math.round((consumoWats * resultadoMultiplicacion) / 1000);
                console.log('Resultado redondeado:', resultadoConsumo);  // Verificar el resultado redondeado

                // Actualiza el input y el label
                document.getElementById('inputWattsConsumo').value = resultadoConsumo;
                document.getElementById('labelWattsConsumo').textContent = `Consumo: ${resultadoConsumo.toLocaleString('es')} Watios`;
            } else {
                console.log('Error: No se encontró consumo_wats.');
            }
        })
        .catch(error => console.log('Error en la solicitud:', error));
    } else {
        console.log('El id_uso no es válido para la búsqueda de consumo_wats.');
    }

    if (idTipoProducto && resultadoMultiplicacion) {
        // Hacer la solicitud AJAX para obtener el peso_producto21
        fetch('get_pesos.php?id_tipoproducto=' + idTipoProducto)
            .then(response => response.json())
            .then(data => {
                if (data.peso_producto21) {
                    const pesoProducto21 = Number(data.peso_producto21);
                    
                    // Calcular el resultado
                    const resultado = ((peso_producto21 * resultadoMultiplicacion) );

                    // Redondear el resultado
                    const resultadoRedondeado = Math.round(resultado);

                    // Formatear el resultado con separador de miles y sin decimales
                    const resultadoConPuntos = resultadoRedondeado.toLocaleString('es-CO', { 
                        minimumFractionDigits: 0, 
                        maximumFractionDigits: 0 
                    });

                    // Actualizar los campos en el formulario
                    document.getElementById('pesoxpantallaLabel').textContent = "Peso: " + resultadoConPuntos + " Kgs";
                    document.getElementById('pesoxpantallasin').value = resultado;
                }
            })
        .catch(error => console.error('Error al obtener el peso_producto21:', error));
    }
});

</script>