<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductoController;
use App\Models\Torta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ── Rutas públicas (sin autenticación) ───────────────────

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// ── Rutas protegidas (requieren sesión) ──────────────────

Route::middleware('auth.check')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/catalogo', [ProductoController::class, 'index'])->name('catalogo');
    Route::get('/catalogo/nuevo', [ProductoController::class, 'create'])->name('productos.create');
    Route::post('/catalogo', [ProductoController::class, 'store'])->name('productos.store');
    Route::get('/catalogo/{producto}/editar', [ProductoController::class, 'edit'])->name('productos.edit');
    Route::put('/catalogo/{producto}', [ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/catalogo/{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');

    Route::get('/carrito', function () {
        return view('pos.carrito');
    })->name('carrito');

    Route::get('/cobro', function () {
        return view('pos.cobro');
    })->name('cobro');

    Route::get('/pago', function () {
        return redirect()->route('cobro');
    })->name('pago');

    Route::get('/reportes', function () {
        return view('pos.reportes');
    })->name('reportes');

    Route::get('/reporte', function () {
        return redirect()->route('reportes');
    });

    Route::get('/contacto', function () {
        return view('pos.contacto');
    })->name('contacto');

    Route::get('/acerca', function () {
        return view('pos.acerca');
    })->name('acerca');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// La raíz manda al dashboard si hay sesión, si no al login
Route::get('/', function () {
    return redirect(Auth::check() ? '/dashboard' : '/login');
});

// ── Rutas de Pastelería La Espiga (Integradora) ──────────

Route::get('/tortas', function () {
    $tortas = Torta::all();
    return view('tortas.lista', ['tortas' => $tortas]);
});

Route::get('/tortas/nuevo', function () {
    return view('tortas.formulario');
});

Route::post('/tortas/nuevo', function () {
    request()->validate([
        'sabor' => 'required',
        'precio' => 'required|integer',
    ], [
        'sabor.required' => 'Indica el sabor de la torta.',
        'precio.required' => 'Indica el precio de la torta.',
        'precio.integer' => 'El precio va en digitos, sin centavos.',
    ]);

    Torta::create([
        'sabor' => request()->input('sabor'),
        'precio' => request()->input('precio'),
    ]);

    return redirect('/tortas');
});
