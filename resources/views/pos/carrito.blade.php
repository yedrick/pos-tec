@extends('layouts.pos')

@section('title', 'Carrito de Compra - POS Tec')

@section('content')
<!-- ============ CARRITO ============ -->
<section id="carrito">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 1rem;">
        <h2 style="margin: 0;">🛒 2. Carrito de compra</h2>
        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ route('catalogo') }}"><button type="button">📦 Seguir comprando</button></a>
            <a href="{{ route('cobro') }}"><button type="button" style="background: var(--primary); color: #fff; border: none; padding: 0.6rem 1.2rem; border-radius: 6px; font-weight: 600; cursor: pointer;">Ir a Cobrar 💳 ➜</button></a>
        </div>
    </div>

    <table border="1" cellpadding="6" cellspacing="0">
        <caption><strong>Ticket #000125</strong></caption>
        <thead>
            <tr>
                <th>#</th>
                <th>Código</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio unitario</th>
                <th>Subtotal</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>001</td>
                <td>Coca Cola 600ml</td>
                <td><input type="number" value="2" min="1" size="3"></td>
                <td>$18.00</td>
                <td>$36.00</td>
                <td><button type="button">🗑 Quitar</button></td>
            </tr>
            <tr>
                <td>2</td>
                <td>003</td>
                <td>Pan Bimbo Grande</td>
                <td><input type="number" value="1" min="1" size="3"></td>
                <td>$45.00</td>
                <td>$45.00</td>
                <td><button type="button">🗑 Quitar</button></td>
            </tr>
            <tr>
                <td>3</td>
                <td>008</td>
                <td>Huevo (docena)</td>
                <td><input type="number" value="1" min="1" size="3"></td>
                <td>$48.00</td>
                <td>$48.00</td>
                <td><button type="button">🗑 Quitar</button></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" align="right">Artículos</td>
                <td colspan="2">4</td>
            </tr>
            <tr>
                <td colspan="5" align="right">Subtotal</td>
                <td colspan="2">$129.00</td>
            </tr>
            <tr>
                <td colspan="5" align="right">Descuento</td>
                <td colspan="2">-$0.00</td>
            </tr>
            <tr>
                <td colspan="5" align="right"><abbr title="Impuesto al Valor Agregado">IVA</abbr> (16%)</td>
                <td colspan="2">$20.64</td>
            </tr>
            <tr>
                <td colspan="5" align="right"><strong>TOTAL A PAGAR</strong></td>
                <td colspan="2"><strong><big>$149.64</big></strong></td>
            </tr>
        </tfoot>
    </table>

    <p style="margin-top: 1rem;">
        <button type="button">🔄 Actualizar totales</button>
        <button type="button">🧹 Vaciar carrito</button>
    </p>

    <figure>
        <figcaption><strong>Vista previa del ticket</strong></figcaption>
<pre>
==============================
         POS TEC
   Abarrotes "Mi Negocio"
   Ticket #000125  Caja 1
   {{ date('d/m/Y') }}   Cajero: {{ Auth::user()->name }}
==============================
2  Coca Cola 600ml     $36.00
1  Pan Bimbo Grande    $45.00
1  Huevo (docena)      $48.00
------------------------------
Subtotal              $129.00
IVA 16%                $20.64
TOTAL                 $149.64
==============================
   ¡Gracias por su compra!
</pre>
    </figure>

    <details style="margin-top: 1rem;">
        <summary>Aplicar descuento o cupón</summary>
        <form style="margin-top: 0.75rem;">
            <label for="cupon">Código de cupón:</label>
            <input type="text" id="cupon" name="cupon" placeholder="Ej. PROMO10">

            <label for="descuento">Descuento (%):</label>
            <input type="number" id="descuento" name="descuento" min="0" max="100" value="0">

            <button type="submit">Aplicar</button>
        </form>
    </details>

    <div style="margin-top: 1.5rem; display: flex; gap: 1rem; justify-content: flex-end;">
        <a href="{{ route('catalogo') }}"><button type="button">⬅ Volver al Catálogo</button></a>
        <a href="{{ route('cobro') }}"><button type="button" style="background: var(--success); color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 6px; font-weight: 700; font-size: 1rem; cursor: pointer;">Proceder al Cobro ($149.64) 💳 ➜</button></a>
    </div>
</section>
@endsection
