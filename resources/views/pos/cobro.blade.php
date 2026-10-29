@extends('layouts.pos')

@section('title', 'Cobro y Pago - POS Tec')

@section('content')
<!-- ============ CLIENTE Y PAGO ============ -->
<section id="pago">
    <h2>💳 3. Cliente y pago</h2>

    <form id="form-pago">
        <fieldset>
            <legend>Datos del cliente (opcional)</legend>

            <label for="cliente">Nombre:</label>
            <input type="text" id="cliente" name="cliente" placeholder="Público en general">

            <label for="telefono">Teléfono:</label>
            <input type="tel" id="telefono" name="telefono" placeholder="10 dígitos">

            <label for="correo">Correo:</label>
            <input type="email" id="correo" name="correo" placeholder="cliente@correo.com">
            <br><br>

            <input type="checkbox" id="factura" name="factura">
            <label for="factura">Requiere factura</label>

            <label for="rfc"><abbr title="Registro Federal de Contribuyentes">RFC</abbr>:</label>
            <input type="text" id="rfc" name="rfc" maxlength="13" placeholder="XAXX010101000">
        </fieldset>

        <br>

        <fieldset>
            <legend>Método de pago</legend>

            <input type="radio" id="efectivo" name="metodo" value="efectivo" checked>
            <label for="efectivo">💵 Efectivo</label>

            <input type="radio" id="tarjeta" name="metodo" value="tarjeta">
            <label for="tarjeta">💳 Tarjeta</label>

            <input type="radio" id="transferencia" name="metodo" value="transferencia">
            <label for="transferencia">🏦 Transferencia</label>

            <input type="radio" id="mixto" name="metodo" value="mixto">
            <label for="mixto">Mixto</label>

            <br><br>

            <table border="0" cellpadding="4">
                <tr>
                    <td><label for="total">Total a pagar:</label></td>
                    <td><input type="text" id="total" name="total" value="$149.64" readonly></td>
                </tr>
                <tr>
                    <td><label for="recibido">Monto recibido:</label></td>
                    <td><input type="number" id="recibido" name="recibido" step="0.01" min="0" placeholder="0.00"></td>
                </tr>
                <tr>
                    <td><label for="cambio">Cambio:</label></td>
                    <td><input type="text" id="cambio" name="cambio" value="$0.00" readonly></td>
                </tr>
                <tr>
                    <td><label for="referencia">Referencia / autorización:</label></td>
                    <td><input type="text" id="referencia" name="referencia" placeholder="Solo tarjeta o transferencia"></td>
                </tr>
            </table>
        </fieldset>

        <br>

        <fieldset>
            <legend>Comprobante</legend>
            <input type="radio" id="imprimir" name="comprobante" value="imprimir" checked>
            <label for="imprimir">🖨 Imprimir ticket</label>

            <input type="radio" id="enviar" name="comprobante" value="correo">
            <label for="enviar">📧 Enviar por correo</label>

            <input type="radio" id="sin" name="comprobante" value="ninguno">
            <label for="sin">Sin comprobante</label>
        </fieldset>

        <br>

        <label for="notas">Notas de la venta:</label><br>
        <textarea id="notas" name="notas" rows="3" cols="50" placeholder="Observaciones..."></textarea>

        <br><br>

        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap; align-items: center;">
            <button type="submit" id="btn-cobrar" style="background: var(--success); color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 6px; font-weight: 700; cursor: pointer;">
                <strong>✅ COBRAR $149.64</strong>
            </button>
            <button type="button" id="btn-espera">⏸ Poner en espera</button>
            <button type="reset" id="btn-cancelar">❌ Cancelar venta</button>
            <a href="{{ route('carrito') }}" style="margin-left: auto;"><button type="button">⬅ Volver al Carrito</button></a>
        </div>
    </form>
</section>
@endsection
