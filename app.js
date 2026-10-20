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

// Función auxiliar para quitar acentos y normalizar texto
function normalizarTexto(cadena) {
    return (cadena || '')
        .toLowerCase()
        .normalize('NFD')
        .replace(/[̀-ͯ]/g, '')
        .trim();
}

function filtrarProductos() {
    if (!tablaCatalogo) return;

    const texto = normalizarTexto(inputBuscar.value);
    const categoria = normalizarTexto(selectCategoria.value);
    const filas = tablaCatalogo.querySelectorAll('tbody tr');

    filas.forEach(function (fila) {
        const textoFila = normalizarTexto(fila.textContent);
        const categoriaFila = fila.children[2] ? normalizarTexto(fila.children[2].textContent) : '';

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

// -----------------------------------------------------------------------------
// 6. MENÚ DE HAMBURGUESA (RESPONSIVO Y BÁSICO)
// -----------------------------------------------------------------------------
const btnMenu = document.getElementById('btn-menu');
const iconoMenu = document.getElementById('icono-menu');
const navPrincipal = document.getElementById('nav-principal');

if (btnMenu && navPrincipal) {
    // Al hacer clic en el botón de hamburguesa:
    btnMenu.addEventListener('click', function () {
        // Alternar la clase 'activo'
        const estaAbierto = navPrincipal.classList.toggle('activo');

        // Cambiar el icono entre ☰ y ✕
        if (estaAbierto) {
            iconoMenu.textContent = '✕';
        } else {
            iconoMenu.textContent = '☰';
        }
    });

    // Cerrar automáticamente el menú al hacer clic en un enlace
    const enlacesNav = navPrincipal.querySelectorAll('a');
    enlacesNav.forEach(function (enlace) {
        enlace.addEventListener('click', function () {
            navPrincipal.classList.remove('activo');
            if (iconoMenu) {
                iconoMenu.textContent = '☰';
            }
        });
    });
}

// -----------------------------------------------------------------------------
// 7. FORMULARIO DE CONTACTO: VALIDACIÓN CON JAVASCRIPT (novalidate)
// -----------------------------------------------------------------------------
const formContacto = document.getElementById('form-contacto');
const inputNombre = document.getElementById('contacto-nombre');
const inputEmail = document.getElementById('contacto-email');
const inputTitulo = document.getElementById('contacto-titulo');
const inputMensaje = document.getElementById('contacto-mensaje');
const alertaContacto = document.getElementById('contacto-alerta');

// Funciones para marcar error o éxito visual en cada campo
function marcarErrorCampo(input, elementoErrorId, mensaje) {
    if (!input) return;
    input.classList.add('input-error');
    input.classList.remove('input-valido');
    const spanError = document.getElementById(elementoErrorId);
    if (spanError) {
        spanError.textContent = '⚠️ ' + mensaje;
        spanError.classList.add('visible');
    }
}

function marcarCampoValido(input, elementoErrorId) {
    if (!input) return;
    input.classList.remove('input-error');
    input.classList.add('input-valido');
    const spanError = document.getElementById(elementoErrorId);
    if (spanError) {
        spanError.textContent = '';
        spanError.classList.remove('visible');
    }
}

function limpiarEstadoCampo(input, elementoErrorId) {
    if (!input) return;
    input.classList.remove('input-error', 'input-valido');
    const spanError = document.getElementById(elementoErrorId);
    if (spanError) {
        spanError.textContent = '';
        spanError.classList.remove('visible');
    }
}

// Validación de formato de email con expresión regular estándar
function validarFormatoEmail(correo) {
    const patronEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return patronEmail.test(correo);
}

// Validación específica del Nombre
function validarNombre() {
    const valor = inputNombre.value.trim();
    if (valor === '') {
        marcarErrorCampo(inputNombre, 'error-contacto-nombre', 'El nombre es obligatorio.');
        return 'El campo "Nombre" no puede estar vacío.';
    } else if (valor.length < 3) {
        marcarErrorCampo(inputNombre, 'error-contacto-nombre', 'Debe tener al menos 3 caracteres.');
        return 'El "Nombre" debe tener al menos 3 caracteres.';
    } else {
        marcarCampoValido(inputNombre, 'error-contacto-nombre');
        return null;
    }
}

// Validación específica del Email
function validarEmail() {
    const valor = inputEmail.value.trim();
    if (valor === '') {
        marcarErrorCampo(inputEmail, 'error-contacto-email', 'El correo electrónico es obligatorio.');
        return 'El campo "Correo electrónico" es obligatorio.';
    } else if (!validarFormatoEmail(valor)) {
        marcarErrorCampo(inputEmail, 'error-contacto-email', 'Ingresa un correo válido (ej. usuario@correo.com).');
        return 'El "Correo electrónico" no tiene un formato válido (ejemplo: usuario@correo.com).';
    } else {
        marcarCampoValido(inputEmail, 'error-contacto-email');
        return null;
    }
}

// Validación del Título / Asunto
function validarTitulo() {
    const valor = inputTitulo.value.trim();
    if (valor === '') {
        marcarErrorCampo(inputTitulo, 'error-contacto-titulo', 'El asunto o título es obligatorio.');
        return 'El campo "Título o Asunto" es obligatorio.';
    } else if (valor.length < 3) {
        marcarErrorCampo(inputTitulo, 'error-contacto-titulo', 'Debe tener al menos 3 caracteres.');
        return 'El "Título o Asunto" debe tener al menos 3 caracteres.';
    } else {
        marcarCampoValido(inputTitulo, 'error-contacto-titulo');
        return null;
    }
}

// Validación del Mensaje
function validarMensaje() {
    const valor = inputMensaje.value.trim();
    if (valor === '') {
        marcarErrorCampo(inputMensaje, 'error-contacto-mensaje', 'El mensaje no puede estar vacío.');
        return 'El campo "Mensaje" no puede estar vacío.';
    } else if (valor.length < 10) {
        marcarErrorCampo(inputMensaje, 'error-contacto-mensaje', 'El mensaje debe tener al menos 10 caracteres.');
        return 'El "Mensaje" debe contener al menos 10 caracteres explicativos.';
    } else {
        marcarCampoValido(inputMensaje, 'error-contacto-mensaje');
        return null;
    }
}

// Inicialización de escuchadores de eventos para el formulario
if (formContacto) {
    // Validación interactiva mientras el usuario escribe o corrige
    inputNombre.addEventListener('input', validarNombre);
    inputEmail.addEventListener('input', validarEmail);
    inputTitulo.addEventListener('input', validarTitulo);
    inputMensaje.addEventListener('input', validarMensaje);

    // Evento Submit: validación principal al hacer clic en "Enviar"
    formContacto.addEventListener('submit', function (evento) {

        const listaErrores = [];

        // Ejecutar validaciones y recopilar errores
        const errorNombre = validarNombre();
        if (errorNombre) listaErrores.push(errorNombre);

        const errorEmail = validarEmail();
        if (errorEmail) listaErrores.push(errorEmail);

        const errorTitulo = validarTitulo();
        if (errorTitulo) listaErrores.push(errorTitulo);

        const errorMensaje = validarMensaje();
        if (errorMensaje) listaErrores.push(errorMensaje);

        // Si existen errores, bloquear el envío y mostrarlos
        if (listaErrores.length > 0) {
            evento.preventDefault();

            alertaContacto.className = 'alerta-formulario alerta-error';
            alertaContacto.innerHTML = `
                <div class="alerta-titulo">❌ Corrige los siguientes errores antes de continuar:</div>
                <ul class="alerta-lista">
                    ${listaErrores.map(function (err) { return '<li>' + err + '</li>'; }).join('')}
                </ul>
            `;
            alertaContacto.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

            // Enfocar automáticamente el primer campo que tuvo error
            if (errorNombre) {
                inputNombre.focus();
            } else if (errorEmail) {
                inputEmail.focus();
            } else if (errorTitulo) {
                inputTitulo.focus();
            } else if (errorMensaje) {
                inputMensaje.focus();
            }
        }
        // Si no hay errores, el formulario se envía normalmente al PHP
    });

    // Evento Reset: limpiar formulario y remover mensajes/alertas
    formContacto.addEventListener('reset', function () {
        setTimeout(function () {
            limpiarEstadoCampo(inputNombre, 'error-contacto-nombre');
            limpiarEstadoCampo(inputEmail, 'error-contacto-email');
            limpiarEstadoCampo(inputTitulo, 'error-contacto-titulo');
            limpiarEstadoCampo(inputMensaje, 'error-contacto-mensaje');
            alertaContacto.className = 'alerta-formulario';
            alertaContacto.innerHTML = '';
        }, 10);
    });
}


