@extends('layouts.base')

@section('contenido')

    <p>Bienvenidos a La Espiga, la pasteleria de barrio donde cada torta se prepara con recetas caseras y mucho carino.</p>

    <p>Hay {{ count($tortas) }} tortas en la vitrina.</p>

    @foreach ($tortas as $torta)
        <p>{{ $torta->sabor }} - {{ $torta->precio }} Bs</p>
    @endforeach

    <p>Vitrina atendida por Yerson Jarandilla</p>

    <a href="/tortas/nuevo">Registrar nueva torta</a>

@endsection