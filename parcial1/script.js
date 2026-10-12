// Seleccionar el botón "Confirmar encargo"
const botonConfirmar = document.querySelector("#btn-confirmar");

// Función que gestiona la confirmación del encargo
function confirmarEncargo() {
    // 1. Seleccionar el párrafo con document.querySelector
    const mensaje = document.querySelector("#mensaje");

    // 2. Colocar el texto con textContent incluyendo el nombre completo
    mensaje.textContent = "Encargo recibido - te atiende Yerson Jarandilla Vicente";

    // 3. Quitar la clase "oculto" con classList.remove para que sea visible
    mensaje.classList.remove("oculto");
}

// Conectar la función al botón con addEventListener
botonConfirmar.addEventListener("click", confirmarEncargo);
