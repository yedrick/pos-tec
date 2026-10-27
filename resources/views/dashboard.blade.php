@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="dashboard-wrapper">
    {{-- Nav superior --}}
    <nav class="dashboard-nav">
        <span class="brand">🛒 POS Laravel</span>
        <div class="user-info">
            <span class="user-name">{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
            </form>
        </div>
    </nav>

    {{-- Contenido principal --}}
    <div class="dashboard-content">
        <div class="welcome-card">
            <div class="emoji">👋</div>
            <h2>¡Hola, {{ Auth::user()->name }}!</h2>
            <p>Has iniciado sesión correctamente. Tu sesión está protegida por middleware.</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value">✅</div>
                <div class="stat-label">Sesión Activa</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">🔒</div>
                <div class="stat-label">Middleware Auth</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">🗄️</div>
                <div class="stat-label">SQLite</div>
            </div>
        </div>
    </div>
</div>
@endsection
