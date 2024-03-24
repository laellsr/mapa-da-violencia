@extends('_template')

@push('styles')
    <style>
        body {
            background:  var(--bg-main-color);
        }
    </style>
@endpush

@section('content')
    <div id="IndexContent" class="d-flex  flex-column justify-content-center align-items-center mt-5 text-white">
    </div>
    <div class="container text-center text-white">
        <img src="{{ Vite::asset('resources/img/logo_1.png') }}" class="home-logo" alt="Safety Map - Percorra com segurança">
        <div class="mt-4">
            <h3>Verifique o nível de criminalidade do seu local de destino</h3>
            <p class="mt-3 lh-base">Pretende visitar ou morar em um local desconhecido?<br>Use o nosso mapa para ter acesso aos índices de violência em qualquer lugar do mundo!</p>
            <a class="btn btn-secondary px-3 text-uppercase fw-bolder" href="map">Acessar mapa</a>
        </div>
    </div>
    <div class="d-flex justify-content-center mt-5">
        <a class="btn btn-secondary px-3 text-uppercase fw-bolder" href="register">Cadastrar</a>
    </div>
@endsection