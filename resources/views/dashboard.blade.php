@extends('layouts.pos')

@section('title', 'Inicio - POS Tec')

@section('content')
<!-- ============ BIENVENIDA ============ -->
<section id="bienvenida">
    <h2>¡Bienvenido, {{ Auth::user()->name }}!</h2>
    <p>
        <strong>POS Tec</strong> es un sistema de punto de venta pensado para
        tiendas de abarrotes, papelerías, cafeterías y cualquier negocio que
        necesite registrar sus ventas de forma rápida, ordenada e intuitiva.
    </p>

    {{-- Accesos rápidos a cada sección/página --}}
    <h3 style="margin-top: 1.5rem; margin-bottom: 0.75rem;">Módulos del Sistema:</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
        <a href="{{ route('catalogo') }}" style="text-decoration: none;">
            <div style="background: var(--bg-muted); border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 1rem; text-align: center; transition: transform 0.15s, border-color 0.15s;">
                <div style="font-size: 2rem;">📦</div>
                <strong style="color: var(--text-main); display: block; margin-top: 0.5rem;">Catálogo</strong>
                <small style="color: var(--text-muted);">Buscar y agregar productos</small>
            </div>
        </a>

        <a href="{{ route('carrito') }}" style="text-decoration: none;">
            <div style="background: var(--bg-muted); border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 1rem; text-align: center; transition: transform 0.15s, border-color 0.15s;">
                <div style="font-size: 2rem;">🛒</div>
                <strong style="color: var(--text-main); display: block; margin-top: 0.5rem;">Carrito</strong>
                <small style="color: var(--text-muted);">Ver ticket actual #000125</small>
            </div>
        </a>

        <a href="{{ route('cobro') }}" style="text-decoration: none;">
            <div style="background: var(--bg-muted); border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 1rem; text-align: center; transition: transform 0.15s, border-color 0.15s;">
                <div style="font-size: 2rem;">💳</div>
                <strong style="color: var(--text-main); display: block; margin-top: 0.5rem;">Cobro</strong>
                <small style="color: var(--text-muted);">Efectivo, tarjeta o transaccional</small>
            </div>
        </a>

        <a href="{{ route('reportes') }}" style="text-decoration: none;">
            <div style="background: var(--bg-muted); border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 1rem; text-align: center; transition: transform 0.15s, border-color 0.15s;">
                <div style="font-size: 2rem;">📊</div>
                <strong style="color: var(--text-main); display: block; margin-top: 0.5rem;">Reportes</strong>
                <small style="color: var(--text-muted);">Ventas y corte de caja</small>
            </div>
        </a>
    </div>

    <ul>
        <li><strong>Vender rápido:</strong> agrega productos por código o desde el catálogo.</li>
        <li><strong>Controlar inventario:</strong> consulta el stock disponible de cada producto.</li>
        <li><strong>Cobrar como prefieras:</strong> efectivo, tarjeta o transferencia.</li>
        <li><strong>Imprimir tickets:</strong> genera el comprobante de cada venta.</li>
        <li><strong>Ver reportes:</strong> resumen de ventas del día.</li>
    </ul>

    <blockquote>
        "Desde que usamos POS Tec cerramos la caja en cinco minutos."
        <br><cite>— Doña Lupita, Abarrotes La Esquina</cite>
    </blockquote>

    <p style="margin-top: 1rem;">
        <a href="{{ route('catalogo') }}">
            <button type="button" style="background: var(--primary); color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 6px; font-weight: 600; cursor: pointer;">
                Comenzar a vender en el Catálogo ➜
            </button>
        </a>
    </p>
</section>

<hr>

<!-- ============ ASIDE: AVISOS Y AYUDA ============ -->
<aside id="avisos">
    <h2>Avisos y ayuda rápida</h2>

    <article>
        <h3>📢 Promoción de la semana</h3>
        <p><time datetime="2026-10-01">1 de octubre</time> al <time datetime="2026-10-07">7 de octubre</time>:
           2x1 en Galletas Marías usando el cupón <mark>PROMO10</mark>.</p>
    </article>

    <article>
        <h3>⚠️ Inventario</h3>
        <p>Productos con stock bajo: <mark>Agua Ciel 1L</mark>. Producto agotado: <mark>Jabón Zote</mark>.
           Avisar al encargado para resurtir.</p>
    </article>

    <article>
        <h3>⌨️ Atajos de teclado</h3>
        <dl>
            <dt><kbd>F2</kbd></dt><dd>Buscar producto en catálogo</dd>
            <dt><kbd>F4</kbd></dt><dd>Ir al carrito</dd>
            <dt><kbd>F8</kbd></dt><dd>Cobrar venta</dd>
            <dt><kbd>Esc</kbd></dt><dd>Cancelar venta</dd>
        </dl>
    </article>
</aside>

<hr>

<!-- ============ SESIÓN ============ -->
<section id="sesion">
    <h2>Sesión actual</h2>
    <table border="1" cellpadding="6" cellspacing="0">
        <tr>
            <th>Cajero</th><td>{{ Auth::user()->name }}</td>
            <th>Caja</th><td>1</td>
            <th>Fecha</th><td><time datetime="{{ date('Y-m-d') }}">{{ date('d/m/Y') }}</time></td>
            <th>Turno</th><td>Matutino</td>
            <th>Ticket</th><td>#000125</td>
        </tr>
    </table>
</section>
@endsection
