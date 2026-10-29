@extends('layouts.pos')

@section('title', 'Contacto - POS Tec')

@section('content')
<!-- ============ CONTACTO ============ -->
<section id="contacto">
    <h2>✉️ 5. Contáctanos</h2>
    <p>
        ¿Tienes dudas, sugerencias o requieres soporte técnico con <strong>POS Tec</strong>?
        Completa el siguiente formulario y nos pondremos en contacto contigo a la brevedad.
    </p>

    <form id="form-contacto" class="form-contacto" action="#" method="POST" novalidate>
        @csrf
        <div class="form-grupo">
            <label for="contacto-nombre">Nombre completo <span class="obligatorio" aria-hidden="true">*</span></label>
            <input type="text" id="contacto-nombre" name="nombre" placeholder="Ingresa tu nombre y apellido" autocomplete="name">
            <span class="campo-error" id="error-contacto-nombre" aria-live="polite"></span>
        </div>

        <div class="form-grupo">
            <label for="contacto-email">Correo electrónico <span class="obligatorio" aria-hidden="true">*</span></label>
            <input type="email" id="contacto-email" name="email" placeholder="ejemplo@correo.com" autocomplete="email">
            <span class="campo-error" id="error-contacto-email" aria-live="polite"></span>
        </div>

        <div class="form-grupo">
            <label for="contacto-titulo">Título o Asunto <span class="obligatorio" aria-hidden="true">*</span></label>
            <input type="text" id="contacto-titulo" name="titulo" placeholder="Ej. Duda sobre corte de caja o reporte">
            <span class="campo-error" id="error-contacto-titulo" aria-live="polite"></span>
        </div>

        <div class="form-grupo">
            <label for="contacto-mensaje">Mensaje <span class="obligatorio" aria-hidden="true">*</span></label>
            <textarea id="contacto-mensaje" name="mensaje" rows="4" placeholder="Escribe detalladamente tu mensaje aquí..."></textarea>
            <span class="campo-error" id="error-contacto-mensaje" aria-live="polite"></span>
        </div>

        <div class="form-acciones">
            <button type="submit" id="btn-enviar-contacto" class="btn-contacto-enviar">
                📤 Enviar mensaje
            </button>
            <button type="reset" id="btn-limpiar-contacto" class="btn-contacto-limpiar">
                🧹 Limpiar campos
            </button>
            <a href="{{ route('dashboard') }}" style="margin-left: auto;"><button type="button">⬅ Volver al Inicio</button></a>
        </div>

        <div id="contacto-alerta" class="alerta-formulario" role="alert" aria-live="polite"></div>
    </form>
</section>
@endsection
