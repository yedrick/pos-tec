
const botonConfirmar = document.querySelector("#btn-confirmar");

function confirmarEncargo() {
    const mensaje = document.querySelector("#mensaje");

    mensaje.textContent = "Encargo recibido - te atiende Yerson Jarandilla Vicente";

    mensaje.classList.remove("oculto");
}

botonConfirmar.addEventListener("click", confirmarEncargo);
