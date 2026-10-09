// =============================================================================
// POS TEC - FUNCIONALIDADES BÁSICAS EN JAVASCRIPT
// Código ligero, fácil de entender y sin librerías externas
// =============================================================================

// -----------------------------------------------------------------------------
// 1. MODO OSCURO / MODO CLARO
// -----------------------------------------------------------------------------
const botonTema = document.getElementById('theme-toggle');
const iconoTema = document.getElementById('theme-icon');
const textoTema = document.getElementById('theme-text');

function actualizarBotonTema(esOscuro) {
    if (esOscuro) {
        iconoTema.textContent = '☀️';
        textoTema.textContent = 'Modo Claro';
    } else {
        iconoTema.textContent = '🌙';
        textoTema.textContent = 'Modo Oscuro';
    }
}

// Cargar preferencia guardada
const temaGuardado = localStorage.getItem('tema');
if (temaGuardado === 'oscuro') {
    document.body.classList.add('dark-mode');
    actualizarBotonTema(true);
}

// Alternar tema al hacer clic
botonTema.addEventListener('click', function () {
    const estaEnModoOscuro = document.body.classList.toggle('dark-mode');
    actualizarBotonTema(estaEnModoOscuro);
    localStorage.setItem('tema', estaEnModoOscuro ? 'oscuro' : 'claro');
});

// -----------------------------------------------------------------------------
// 2. BUSCADOR Y FILTRO DE PRODUCTOS EN EL CATÁLOGO
// -----------------------------------------------------------------------------
const inputBuscar = document.getElementById('buscar');
const selectCategoria = document.getElementById('categoria');
const btnLimpiar = document.getElementById('btn-limpiar-filtro');
const tablaCatalogo = document.getElementById('tabla-catalogo');

function filtrarProductos() {
    if (!tablaCatalogo) return;

    const texto = inputBuscar.value.toLowerCase().trim();
    const categoria = selectCategoria.value.toLowerCase().trim();
    const filas = tablaCatalogo.querySelectorAll('tbody tr');

    filas.forEach(function (fila) {
        const textoFila = fila.textContent.toLowerCase();
        const categoriaFila = fila.children[2] ? fila.children[2].textContent.toLowerCase() : '';

        const coincideTexto = texto === '' || textoFila.includes(texto);
        const coincideCategoria = categoria === '' || categoriaFila.includes(categoria);

        if (coincideTexto && coincideCategoria) {
            fila.style.display = '';
        } else {
            fila.style.display = 'none';
        }
    });
}

// Filtrar al escribir o al cambiar categoría
if (inputBuscar) {
    inputBuscar.addEventListener('input', filtrarProductos);
}

if (selectCategoria) {
    selectCategoria.addEventListener('change', filtrarProductos);
}

if (btnLimpiar) {
    btnLimpiar.addEventListener('click', function () {
        inputBuscar.value = '';
        selectCategoria.value = '';
        filtrarProductos();
    });
}

// -----------------------------------------------------------------------------
// 3. BOTONES "AGREGAR" EN EL CATÁLOGO
// -----------------------------------------------------------------------------
const botonesAgregar = document.querySelectorAll('#catalogo tbody button');

botonesAgregar.forEach(function (boton) {
    boton.addEventListener('click', function () {
        // Obtenemos el nombre del producto de la fila correspondiente
        const fila = boton.closest('tr');
        const nombreProducto = fila ? fila.children[1].textContent : 'Producto';
        const cantidadInput = fila ? fila.querySelector('input[type="number"]') : null;
        const cantidad = cantidadInput ? cantidadInput.value : 1;

        alert('✅ Se agregaron ' + cantidad + ' unidad(es) de "' + nombreProducto + '" al carrito.');
    });
});

// -----------------------------------------------------------------------------
// 4. CÁLCULO AUTOMÁTICO DE CAMBIO (PAGO)
// -----------------------------------------------------------------------------
const inputTotal = document.getElementById('total');
const inputRecibido = document.getElementById('recibido');
const inputCambio = document.getElementById('cambio');

// Total base numérico ($149.64)
const totalPagar = 149.64;

if (inputRecibido && inputCambio) {
    inputRecibido.addEventListener('input', function () {
        const montoRecibido = parseFloat(inputRecibido.value);

        if (isNaN(montoRecibido) || montoRecibido <= 0) {
            inputCambio.value = '$0.00';
            inputCambio.style.color = '';
            return;
        }

        const cambio = montoRecibido - totalPagar;

        if (cambio >= 0) {
            inputCambio.value = '$' + cambio.toFixed(2);
            inputCambio.style.color = 'var(--success, #059669)';
        } else {
            const falta = Math.abs(cambio);
            inputCambio.value = 'Faltan $' + falta.toFixed(2);
            inputCambio.style.color = 'var(--danger, #dc2626)';
        }
    });
}

// -----------------------------------------------------------------------------
// 5. PROCESAR VENTA (FORMULARIO DE PAGO)
// -----------------------------------------------------------------------------
const formPago = document.getElementById('form-pago');
const btnEspera = document.getElementById('btn-espera');

if (formPago) {
    formPago.addEventListener('submit', function (evento) {
        evento.preventDefault(); // Evitamos que la página se recargue

        const montoRecibido = parseFloat(inputRecibido.value);
        const metodoEfectivo = document.getElementById('efectivo').checked;

        // Validación sencilla para efectivo
        if (metodoEfectivo && (!montoRecibido || montoRecibido < totalPagar)) {
            alert('⚠️ El monto recibido es menor al total a pagar ($' + totalPagar.toFixed(2) + ').');
            inputRecibido.focus();
            return;
        }

        const requiereImprimir = document.getElementById('imprimir').checked;

        alert('🎉 ¡Venta procesada con éxito!\nTotal cobrado: $' + totalPagar.toFixed(2));

        if (requiereImprimir) {
            window.print();
        }

        formPago.reset();
        inputCambio.value = '$0.00';
    });
}

if (btnEspera) {
    btnEspera.addEventListener('click', function () {
        alert('⏸ Venta puesta en espera. Puedes continuar atendiendo a otro cliente.');
    });
}
