<?php

use App\Http\Controllers\AuthController;
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

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Redirige la raíz al dashboard si está autenticado
    Route::get('/', function () {
        return redirect('/dashboard');
    });
});

// Si no está autenticado y entra a /, lo manda al login
Route::get('/', function () {
    return redirect('/login');
});

// ── Rutas de Pastelería La Espiga (Integradora) ──────────
use App\Models\Torta;

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
