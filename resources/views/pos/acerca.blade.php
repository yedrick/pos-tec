@extends('layouts.pos')

@section('title', 'Acerca de - POS Tec')

@section('content')
<!-- ============ ACERCA DE ============ -->
<section id="acerca">
    <h2>ℹ️ 6. Acerca de</h2>
    <details open>
        <summary>Información del proyecto</summary>
        <table border="1" cellpadding="6" cellspacing="0" style="margin-top: 0.75rem;">
            <tr><th>Proyecto</th><td>POS Tec</td></tr>
            <tr><th>Versión</th><td>1.0</td></tr>
            <tr><th>Materia</th><td>Tecnologías</td></tr>
            <tr><th>Tecnología</th><td>Laravel + HTML5</td></tr>
            <tr><th>Autor</th><td>Yerson Jarandilla</td></tr>
        </table>
    </details>
    <br>
    <address>
        Repositorio: <a href="https://github.com/yedrick/pos-tec" target="_blank" rel="noopener noreferrer">github.com/yedrick/pos-tec</a>
    </address>

    <div style="margin-top: 1.5rem;">
        <a href="{{ route('dashboard') }}"><button type="button">⬅ Volver al Inicio</button></a>
    </div>
</section>
@endsection
