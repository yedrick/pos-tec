<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Muestra la lista del catálogo de productos.
     */
    public function index(Request $request)
    {
        $query = Producto::with('categoria');

        if ($request->filled('buscar')) {
            $buscar = $request->input('buscar');
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre', 'like', "%{$buscar}%")
                  ->orWhere('codigo', 'like', "%{$buscar}%");
            });
        }

        if ($request->filled('categoria')) {
            $cat = $request->input('categoria');
            $query->whereHas('categoria', function ($q) use ($cat) {
                $q->where('nombre', 'like', "%{$cat}%");
            });
        }

        $productos = $query->orderBy('codigo')->get();
        $categorias = Categoria::orderBy('nombre')->get();

        return view('pos.catalogo', compact('productos', 'categorias'));
    }

    /**
     * Muestra el formulario para registrar un nuevo producto.
     */
    public function create()
    {
        $producto = new Producto();
        $categorias = Categoria::orderBy('nombre')->get();
        $esEdicion = false;

        // Sugerir siguiente código numérico
        $ultimoId = Producto::max('id') ?? 0;
        $codigoSugerido = str_pad($ultimoId + 1, 3, '0', STR_PAD_LEFT);

        return view('pos.producto_form', compact('producto', 'categorias', 'esEdicion', 'codigoSugerido'));
    }

    /**
     * Guarda un producto nuevo en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:50|unique:productos,codigo',
            'nombre' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'stock_max' => 'nullable|integer|min:1',
        ], [
            'codigo.required' => 'El código del producto es obligatorio.',
            'codigo.unique' => 'Ese código ya está en uso por otro producto.',
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'categoria_id.required' => 'Selecciona una categoría válida.',
            'categoria_id.exists' => 'La categoría seleccionada no existe.',
            'precio.required' => 'Ingresa el precio del producto.',
            'precio.numeric' => 'El precio debe ser un número válido.',
            'precio.min' => 'El precio no puede ser negativo.',
            'stock.required' => 'Indica el stock inicial disponible.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'stock.min' => 'El stock no puede ser negativo.',
            'stock_max.min' => 'El stock máximo debe ser al menos 1.',
        ]);

        Producto::create([
            'codigo' => trim($request->input('codigo')),
            'nombre' => trim($request->input('nombre')),
            'categoria_id' => $request->input('categoria_id'),
            'precio' => $request->input('precio'),
            'stock' => $request->input('stock'),
            'stock_max' => $request->input('stock_max') ?: 50,
        ]);

        return redirect()->route('catalogo')->with('success', '¡Producto registrado exitosamente en el catálogo!');
    }

    /**
     * Muestra el formulario para editar un producto.
     */
    public function edit(Producto $producto)
    {
        $categorias = Categoria::orderBy('nombre')->get();
        $esEdicion = true;
        $codigoSugerido = $producto->codigo;

        return view('pos.producto_form', compact('producto', 'categorias', 'esEdicion', 'codigoSugerido'));
    }

    /**
     * Actualiza el producto en la base de datos.
     */
    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'codigo' => 'required|string|max:50|unique:productos,codigo,' . $producto->id,
            'nombre' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'stock_max' => 'nullable|integer|min:1',
        ], [
            'codigo.required' => 'El código del producto es obligatorio.',
            'codigo.unique' => 'Ese código ya está en uso por otro producto.',
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'categoria_id.required' => 'Selecciona una categoría válida.',
            'categoria_id.exists' => 'La categoría seleccionada no existe.',
            'precio.required' => 'Ingresa el precio del producto.',
            'precio.numeric' => 'El precio debe ser un número válido.',
            'precio.min' => 'El precio no puede ser negativo.',
            'stock.required' => 'Indica el stock disponible.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'stock.min' => 'El stock no puede ser negativo.',
            'stock_max.min' => 'El stock máximo debe ser al menos 1.',
        ]);

        $producto->update([
            'codigo' => trim($request->input('codigo')),
            'nombre' => trim($request->input('nombre')),
            'categoria_id' => $request->input('categoria_id'),
            'precio' => $request->input('precio'),
            'stock' => $request->input('stock'),
            'stock_max' => $request->input('stock_max') ?: 50,
        ]);

        return redirect()->route('catalogo')->with('success', '¡Producto "' . $producto->nombre . '" actualizado con éxito!');
    }

    /**
     * Elimina el producto del catálogo.
     */
    public function destroy(Producto $producto)
    {
        $nombre = $producto->nombre;
        $producto->delete();

        return redirect()->route('catalogo')->with('success', 'Producto "' . $nombre . '" eliminado del catálogo.');
    }
}
