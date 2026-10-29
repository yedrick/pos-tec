@extends('layouts.pos')

@section('title', 'Reporte del Día - POS Tec')

@section('content')
<!-- ============ REPORTE ============ -->
<section id="reporte">
    <h2>📊 4. Reporte del día</h2>

    <table border="1" cellpadding="6" cellspacing="0">
        <caption><strong>Resumen de ventas - {{ date('d/m/Y') }}</strong></caption>
        <thead>
            <tr>
                <th>Concepto</th>
                <th>Cantidad</th>
                <th>Importe</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>Ventas en efectivo</td><td>18</td><td>$2,340.00</td></tr>
            <tr><td>Ventas con tarjeta</td><td>9</td><td>$1,875.50</td></tr>
            <tr><td>Ventas por transferencia</td><td>3</td><td>$640.00</td></tr>
            <tr><td>Ventas canceladas</td><td>1</td><td>$85.00</td></tr>
        </tbody>
        <tfoot>
            <tr>
                <th>Total del día</th>
                <th>30</th>
                <th>$4,855.50</th>
            </tr>
        </tfoot>
    </table>

    <br>

    <details>
        <summary>Últimos tickets</summary>
        <table border="1" cellpadding="6" cellspacing="0" style="margin-top: 0.75rem;">
            <thead>
                <tr><th>Ticket</th><th>Hora</th><th>Método</th><th>Total</th><th>Estado</th></tr>
            </thead>
            <tbody>
                <tr><td>#000124</td><td>12:45</td><td>Efectivo</td><td>$96.00</td><td>Pagado</td></tr>
                <tr><td>#000123</td><td>12:30</td><td>Tarjeta</td><td>$310.00</td><td>Pagado</td></tr>
                <tr><td>#000122</td><td>12:10</td><td>Efectivo</td><td>$85.00</td><td><del>Cancelado</del></td></tr>
                <tr><td>#000121</td><td>11:52</td><td>Transferencia</td><td>$220.00</td><td>Pagado</td></tr>
            </tbody>
        </table>
    </details>

    <p style="margin-top: 1.5rem; display: flex; gap: 0.75rem; flex-wrap: wrap;">
        <button type="button">📊 Corte de caja</button>
        <button type="button">📤 Exportar reporte</button>
        <a href="{{ route('dashboard') }}" style="margin-left: auto;"><button type="button">⬅ Volver al Inicio</button></a>
    </p>
</section>
@endsection
