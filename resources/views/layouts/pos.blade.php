<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="POS Tec - Punto de venta básico en HTML y Laravel">
    <title>@yield('title', 'POS Tec - Punto de Venta')</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>

<body>

    <header id="inicio">
        <div class="header-top">
            <h1>🛒 <a href="{{ route('dashboard') }}" style="color: inherit; text-decoration: none;">POS Tec</a></h1>
            <div class="header-actions">
                {{-- Info del usuario y logout --}}
                <span style="color: #94a3b8; font-size: 0.9rem;">👤 {{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" style="display:inline; margin:0;">
                    @csrf
                    <button type="submit"
                        style="background: rgba(255,107,107,0.2); color: #ff6b6b; border: 1px solid rgba(255,107,107,0.3); padding: 0.4rem 0.8rem; border-radius: 6px; font-size: 0.85rem; font-weight: 600; cursor: pointer;">Cerrar
                        Sesión</button>
                </form>
                <button id="theme-toggle" class="btn-theme" type="button" aria-label="Cambiar modo de color">
                    <span id="theme-icon">🌙</span> <span id="theme-text">Modo Oscuro</span>
                </button>
                <button id="btn-menu" class="btn-menu" type="button" aria-label="Abrir o cerrar menú de navegación">
                    <span id="icono-menu">☰</span> <span>Menú</span>
                </button>
            </div>
        </div>
        <p><em>Sistema de <abbr title="Point of Sale">POS</abbr> (Punto de Venta) para pequeños negocios</em></p>
        <nav id="nav-principal" aria-label="Navegación principal">
            <ul>
                <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'activo' : '' }}">🏠
                        Inicio</a></li>
                <li><a href="{{ route('catalogo') }}" class="{{ request()->routeIs('catalogo') ? 'activo' : '' }}">📦
                        Catálogo</a></li>
                <li><a href="{{ route('carrito') }}" class="{{ request()->routeIs('carrito') ? 'activo' : '' }}">🛒
                        Carrito</a></li>
                <li><a href="{{ route('cobro') }}"
                        class="{{ request()->routeIs('cobro') || request()->routeIs('pago') ? 'activo' : '' }}">💳
                        Cobro</a></li>
                <li><a href="{{ route('reportes') }}" class="{{ request()->routeIs('reportes') ? 'activo' : '' }}">📊
                        Reportes</a></li>
                <li><a href="{{ route('contacto') }}" class="{{ request()->routeIs('contacto') ? 'activo' : '' }}">✉️
                        Contacto</a></li>
                <li><a href="{{ route('acerca') }}" class="{{ request()->routeIs('acerca') ? 'activo' : '' }}">ℹ️ Acerca
                        de</a></li>
            </ul>
        </nav>
        <hr>
    </header>

    <main>
        @yield('content')
    </main>

    <hr>

    <footer>
        <nav aria-label="Navegación secundaria">
            <ul>
                <li><a href="{{ route('dashboard') }}">Inicio</a></li>
                <li><a href="{{ route('catalogo') }}">Catálogo</a></li>
                <li><a href="{{ route('carrito') }}">Carrito</a></li>
                <li><a href="{{ route('cobro') }}">Cobro</a></li>
                <li><a href="{{ route('reportes') }}">Reportes</a></li>
                <li><a href="{{ route('contacto') }}">Contacto</a></li>
                <li><a href="{{ route('acerca') }}">Acerca de</a></li>
            </ul>
        </nav>
        <address>
            Abarrotes "Mi Negocio" &middot; Calle Principal #123, Centro &middot;
            Tel. <a href="tel:+525512345678">55 1234 5678</a>
        </address>
        <p><small>&copy; 2026 POS Tec &middot; Proyecto escolar de la materia Tecnologías &middot; Hecho con Laravel +
                HTML5</small></p>
    </footer>

    <script src="{{ asset('app.js') }}"></script>
    <script>
        // Compatibilidad: si el usuario ingresa con hash como #catalogo redirigir a la página correspondiente
        (function () {
            const hashRutas = {
                '#catalogo': "{{ route('catalogo') }}",
                '#carrito': "{{ route('carrito') }}",
                '#pago': "{{ route('cobro') }}",
                '#reporte': "{{ route('reportes') }}",
                '#reportes': "{{ route('reportes') }}",
                '#contacto': "{{ route('contacto') }}",
                '#acerca': "{{ route('acerca') }}"
            };
            if (window.location.hash && hashRutas[window.location.hash]) {
                const destino = hashRutas[window.location.hash];
                if (window.location.pathname !== new URL(destino, window.location.origin).pathname) {
                    window.location.replace(destino);
                }
            }
        })();
    </script>
    @stack('scripts')
</body>

</html>