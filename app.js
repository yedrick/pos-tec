// =============================================================================
// POS TEC - LÓGICA DE MODO OSCURO / MODO CLARO (JAVASCRIPT BÁSICO)
// =============================================================================

// 1. SELECCIONAR ELEMENTOS DEL DOM
// Obtenemos el botón y los textos que vamos a modificar cuando el usuario haga clic.
const botonTema = document.getElementById('theme-toggle');
const iconoTema = document.getElementById('theme-icon');
const textoTema = document.getElementById('theme-text');

// 2. FUNCIÓN PARA ACTUALIZAR EL TEXTO E ÍCONO DEL BOTÓN
function actualizarBotonTema(esOscuro) {
    if (esOscuro) {
        iconoTema.textContent = '☀️';
        textoTema.textContent = 'Modo Claro';
    } else {
        iconoTema.textContent = '🌙';
        textoTema.textContent = 'Modo Oscuro';
    }
}

// 3. RECUPERAR PREFERENCIA GUARDADA EN EL NAVEGADOR (localStorage)
// Si el usuario ya había elegido modo oscuro antes, lo aplicamos al cargar la página.
const temaGuardado = localStorage.getItem('tema');

if (temaGuardado === 'oscuro') {
    document.body.classList.add('dark-mode');
    actualizarBotonTema(true);
} else {
    document.body.classList.remove('dark-mode');
    actualizarBotonTema(false);
}

// 4. ESCUCHAR EL CLIC DEL BOTÓN PARA CAMBIAR DE TEMA
botonTema.addEventListener('click', function () {
    // Alternamos la clase 'dark-mode' en el <body>
    const estaEnModoOscuro = document.body.classList.toggle('dark-mode');

    // Actualizamos el ícono y texto
    actualizarBotonTema(estaEnModoOscuro);

    // Guardamos la preferencia en el navegador
    if (estaEnModoOscuro) {
        localStorage.setItem('tema', 'oscuro');
    } else {
        localStorage.setItem('tema', 'claro');
    }
});
