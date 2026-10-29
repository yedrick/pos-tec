@extends('layouts.base')

@section('contenido')

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="/tortas/nuevo" method="POST">
        @csrf

        <label for="sabor">Sabor de la torta</label>
        <input type="text" id="sabor" name="sabor">

        <br>

        <label for="precio">Precio en Bs</label>
        <input type="number" id="precio" name="precio">

        <br>

        <label for="stock">Stock</label>
        <input type="number" id="stock" name="stock">

        <br>

        <button type="submit">Registrar torta</button>
    </form>

    <a href="/tortas">Volver a la lista</a>

@endsection
