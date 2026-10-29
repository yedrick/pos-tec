@extends('layouts.pos')

@section('title', 'Catálogo de Productos - POS Tec')

@section('content')
<!-- ============ CATÁLOGO ============ -->
<section id="catalogo">
    {{-- Notificación de éxito --}}
    @if (session('success'))
        <div class="alerta alerta-exito" style="margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between;">
            <span>🎉 {{ session('success') }}</span>
            <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; font-size: 1.1rem; cursor: pointer; color: inherit;">✕</button>
        </div>
    @endif

    {{-- Cabecera del catálogo con acciones principales --}}
    <div class="catalogo-header">
        <div>
            <h2>📦 1. Catálogo de productos</h2>
            <p style="margin: 0.25rem 0 0 0; color: var(--text-muted); font-size: 0.9rem;">
                Administra inventario, agrega productos al ticket de venta o registra nuevos artículos.
            </p>
        </div>
        <div class="catalogo-botones-principales">
            <a href="{{ route('productos.create') }}">
                <button type="button" class="btn-nuevo-producto">
                    ➕ Registrar Nuevo Producto
                </button>
            </a>
            <a href="{{ route('carrito') }}">
                <button type="button" class="btn-ir-carrito">
                    🛒 Ver Carrito ➜
                </button>
            </a>
        </div>
    </div>

    {{-- Barra de búsqueda y filtrado interactivo --}}
    <form id="form-catalogo" class="form-filtro-catalogo">
        <div class="filtro-campo">
            <label for="buscar">Buscar producto:</label>
            <input type="search" id="buscar" name="buscar" list="productos-lista" placeholder="Nombre o código...">
            <datalist id="productos-lista">
                @foreach ($productos as $p)
                    <option value="{{ $p->codigo }} - {{ $p->nombre }}">
                @endforeach
            </datalist>
        </div>

        <div class="filtro-campo">
            <label for="categoria">Categoría:</label>
            <select id="categoria" name="categoria">
                <option value="">Todas las categorías</option>
                @foreach ($categorias as $cat)
                    <option value="{{ strtolower($cat->nombre) }}">{{ $cat->nombre }}</option>
                @endforeach
            </select>
        </div>

        <button type="button" id="btn-limpiar-filtro" class="btn-limpiar">
            🧹 Limpiar
        </button>

        <div class="contador-catalogo" style="margin-left: auto; align-self: flex-end; color: var(--text-muted); font-size: 0.85rem;">
            Total: <strong>{{ $productos->count() }}</strong> productos
        </div>
    </form>

    <div class="tabla-contenedor" style="margin-top: 1.5rem;">
        <table id="tabla-catalogo" class="tabla-pos" border="1" cellpadding="8" cellspacing="0">
            <caption><strong>Productos registrados en el sistema</strong></caption>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Nivel</th>
                    <th>Cantidad</th>
                    <th>Vender</th>
                    <th style="text-align: center;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($productos as $producto)
                    @php
                        $agotado = $producto->stock <= 0;
                        $stockBajo = $producto->stock > 0 && $producto->stock < 10;
                    @endphp
                    <tr>
                        <td><span class="badge-codigo">{{ $producto->codigo }}</span></td>
                        <td>
                            <strong>{{ $producto->nombre }}</strong>
                            @if ($stockBajo)
                                <small style="display: block; color: var(--warning, #d97706); font-weight: 600;">⚠️ Resurtir pronto</small>
                            @elseif ($agotado)
                                <small style="display: block; color: var(--danger, #dc2626); font-weight: 600;">❌ Sin existencias</small>
                            @endif
                        </td>
                        <td>
                            <span class="badge-categoria">
                                {{ $producto->categoria->nombre ?? 'Sin categoría' }}
                            </span>
                        </td>
                        <td class="col-precio">${{ number_format($producto->precio, 2) }}</td>
                        <td>
                            @if ($agotado)
                                <span class="badge-stock badge-agotado">0</span>
                            @elseif ($stockBajo)
                                <span class="badge-stock badge-bajo">{{ $producto->stock }}</span>
                            @else
                                <span class="badge-stock badge-disponible">{{ $producto->stock }}</span>
                            @endif
                        </td>
                        <td>
                            <meter value="{{ $producto->stock }}" 
                                   min="0" 
                                   max="{{ $producto->stock_max ?: 50 }}" 
                                   low="{{ min(10, ($producto->stock_max ?: 50) / 2) }}" 
                                   optimum="{{ $producto->stock_max ?: 50 }}">
                                {{ $producto->stock }}
                            </meter>
                        </td>
                        <td>
                            <input type="number" 
                                   value="{{ $agotado ? 0 : 1 }}" 
                                   min="{{ $agotado ? 0 : 1 }}" 
                                   max="{{ $producto->stock }}" 
                                   size="3" 
                                   class="input-cantidad"
                                   {{ $agotado ? 'disabled' : '' }}>
                        </td>
                        <td>
                            @if ($agotado)
                                <button type="button" class="btn-agregar-catalogo btn-deshabilitado" disabled>
                                    Agotado
                                </button>
                            @else
                                <button type="button" class="btn-agregar-catalogo" data-id="{{ $producto->id }}">
                                    ➕ Agregar
                                </button>
                            @endif
                        </td>
                        <td>
                            <div class="acciones-fila">
                                <a href="{{ route('productos.edit', $producto) }}" title="Editar producto">
                                    <button type="button" class="btn-accion-editar">
                                        ✏️ Editar
                                    </button>
                                </a>
                                <form method="POST" action="{{ route('productos.destroy', $producto) }}" 
                                      style="display: inline; margin: 0;"
                                      onsubmit="return confirm('¿Estás seguro de que deseas eliminar \'{{ addslashes($producto->nombre) }}\'? Esta acción no se puede deshacer.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-accion-eliminar" title="Eliminar producto">
                                        🗑 Borrar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 2rem; color: var(--text-muted);">
                            No hay productos registrados en el catálogo.
                            <br><br>
                            <a href="{{ route('productos.create') }}">
                                <button type="button" class="btn-nuevo-producto">➕ Registrar el primer producto</button>
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <p style="margin-top: 1rem;"><small>La barra de nivel visualiza el inventario en rojo cuando el stock está bajo (menos de 10 unidades).</small></p>

    <div style="margin-top: 1.5rem; display: flex; gap: 1rem; justify-content: flex-end; flex-wrap: wrap;">
        <a href="{{ route('dashboard') }}"><button type="button" class="btn-secundario">⬅ Volver al Inicio</button></a>
        <a href="{{ route('carrito') }}"><button type="button" class="btn-ir-carrito">Ir al Carrito 🛒 ➜</button></a>
    </div>
</section>
@endsection
