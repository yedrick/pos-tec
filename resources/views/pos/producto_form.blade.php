@extends('layouts.pos')

@section('title', ($esEdicion ? 'Editar Producto' : 'Registrar Producto') . ' - POS Tec')

@section('content')
<section class="tarjeta-formulario">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border); padding-bottom: 1rem;">
        <div>
            <h2 style="margin: 0; font-size: 1.5rem;">
                {{ $esEdicion ? '✏️ Editar Producto' : '➕ Registrar Nuevo Producto' }}
            </h2>
            <p style="margin: 0.25rem 0 0 0; color: var(--text-muted); font-size: 0.9rem;">
                {{ $esEdicion ? 'Modifica los datos del producto en la base de datos' : 'Ingresa la información requerida para dar de alta el producto en el catálogo' }}
            </p>
        </div>
        <a href="{{ route('catalogo') }}">
            <button type="button" class="btn-secundario">⬅ Volver al Catálogo</button>
        </a>
    </div>

    @if ($errors->any())
        <div class="alerta alerta-error" style="margin-bottom: 1.5rem;">
            <strong>⚠️ Por favor corrige los siguientes errores:</strong>
            <ul style="margin-top: 0.5rem; padding-left: 1.25rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ $esEdicion ? route('productos.update', $producto) : route('productos.store') }}" class="form-producto-grid">
        @csrf
        @if ($esEdicion)
            @method('PUT')
        @endif

        <div class="grupo-campo">
            <label for="codigo">Código del producto <span class="obligatorio">*</span></label>
            <input type="text" id="codigo" name="codigo" 
                   value="{{ old('codigo', $producto->codigo ?? $codigoSugerido) }}" 
                   placeholder="Ej. 009" required maxlength="50"
                   class="{{ $errors->has('codigo') ? 'campo-invalido' : '' }}">
            <small style="color: var(--text-muted);">Identificador único o código de barras.</small>
        </div>

        <div class="grupo-campo">
            <label for="nombre">Nombre del producto <span class="obligatorio">*</span></label>
            <input type="text" id="nombre" name="nombre" 
                   value="{{ old('nombre', $producto->nombre) }}" 
                   placeholder="Ej. Galletas Oreo 100g" required maxlength="255"
                   class="{{ $errors->has('nombre') ? 'campo-invalido' : '' }}">
            <small style="color: var(--text-muted);">Nombre descriptivo comercial.</small>
        </div>

        <div class="grupo-campo">
            <label for="categoria_id">Categoría <span class="obligatorio">*</span></label>
            <select id="categoria_id" name="categoria_id" required class="{{ $errors->has('categoria_id') ? 'campo-invalido' : '' }}">
                <option value="">-- Seleccionar categoría --</option>
                @foreach ($categorias as $cat)
                    <option value="{{ $cat->id }}" {{ old('categoria_id', $producto->categoria_id) == $cat->id ? 'selected' : '' }}>
                        {{ $cat->nombre }}
                    </option>
                @endforeach
            </select>
            <small style="color: var(--text-muted);">Clasificación dentro de la tienda.</small>
        </div>

        <div class="grupo-campo">
            <label for="precio">Precio de venta ($) <span class="obligatorio">*</span></label>
            <input type="number" id="precio" name="precio" step="0.01" min="0" 
                   value="{{ old('precio', $producto->precio) }}" 
                   placeholder="0.00" required
                   class="{{ $errors->has('precio') ? 'campo-invalido' : '' }}">
            <small style="color: var(--text-muted);">Precio unitario al público en pesos.</small>
        </div>

        <div class="grupo-campo">
            <label for="stock">Stock inicial / actual <span class="obligatorio">*</span></label>
            <input type="number" id="stock" name="stock" min="0" 
                   value="{{ old('stock', $producto->stock ?? 0) }}" 
                   placeholder="0" required
                   class="{{ $errors->has('stock') ? 'campo-invalido' : '' }}">
            <small style="color: var(--text-muted);">Cantidad física disponible en almacén.</small>
        </div>

        <div class="grupo-campo">
            <label for="stock_max">Capacidad máxima (Stock Máx.)</label>
            <input type="number" id="stock_max" name="stock_max" min="1" 
                   value="{{ old('stock_max', $producto->stock_max ?? 50) }}" 
                   placeholder="50"
                   class="{{ $errors->has('stock_max') ? 'campo-invalido' : '' }}">
            <small style="color: var(--text-muted);">Límite para cálculo de la barra de nivel.</small>
        </div>

        <div class="acciones-formulario" style="grid-column: 1 / -1; display: flex; gap: 1rem; align-items: center; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--border);">
            <button type="submit" class="btn-guardar">
                {{ $esEdicion ? '💾 Guardar Cambios' : '✅ Registrar Producto' }}
            </button>
            <a href="{{ route('catalogo') }}" class="btn-cancelar-enlace">
                Cancelar
            </a>
        </div>
    </form>
</section>
@endsection
