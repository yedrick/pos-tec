document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('form-horno');
    const aviso = document.getElementById('aviso-horno');

    form.addEventListener('submit', function (e) {
        const nombre = document.getElementById('nombre').value.trim();
        const correo = document.getElementById('correo_electronico').value.trim();
        const pedido = document.getElementById('salteñas').value.trim();

        // Limpiar aviso anterior
        aviso.textContent = '';
        aviso.className = 'aviso';

        // Validar nombre
        if (nombre === '') {
            e.preventDefault();
            aviso.textContent = 'Por favor, ingresa tu nombre completo.';
            aviso.classList.add('error');
            return;
        }

        // Validar correo
        if (correo === '') {
            e.preventDefault();
            aviso.textContent = 'Por favor, ingresa tu correo electrónico.';
            aviso.classList.add('error');
            return;
        }

        // Validar formato de correo
        const regexCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!regexCorreo.test(correo)) {
            e.preventDefault();
            aviso.textContent = 'El correo electrónico no tiene un formato válido.';
            aviso.classList.add('error');
            return;
        }

        // Validar pedido
        if (pedido === '') {
            e.preventDefault();
            aviso.textContent = 'Por favor, indica qué salteñas deseas pedir.';
            aviso.classList.add('error');
            return;
        }

        // Todo bien
        aviso.textContent = 'Enviando pedido...';
        aviso.classList.add('exito');
    });
});
