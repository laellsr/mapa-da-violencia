@extends('_template')

@push('styles')
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/register.css') }}">
@endpush

@section('content')
    <div class="bg_gradient">
        <div class="container">
            <div class="row panel">

                <div name="leftpanel" class="col leftpanel fs-5">
                    <img src="{{ Vite::asset('resources/img/logo_1.png') }}" class="home-logo" alt="Safety Map - Percorra com segurança">
                </div>
                <div name="rightpanel" class="col rightpanel fs-5" >
                    <label class="fs-4 me-2">Cadastro</label>
                    <form id="reg_form" class="">
                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <label class="me-2">Nome:</label>
                                <input name="nome" required placeholder="Nome" type="text" class="form-control me-3" id="nameForm" aria-describedby="nameForm">
                            </div>
                            <div>
                                <label class="form-label me-2">Nascimento:</label>
                                <input name="dt_birthday" class="form-control w-auto" type="date"  id="birthdayForm">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <label class="me-2">Email:</label>
                                <input name="email" required placeholder="Email" type="email" class="form-control me-3" id="emailForm" aria-describedby="emailForm">
                            </div>
                            <div>
                                <label class="me-2">Senha:</label>
                                <input name="senha" required placeholder="Senha" type="password" class="form-control w-auto" id="passForm" aria-describedby="passForm">
                            </div>
                        </div>
                        <div class="d-flex flex-row position-relative">
                            <a onclick="window.location='{{ route('welcome') }}'" class="btn btn-secondary px-3 text-uppercase fw-bolder">Cancelar</a>
                            <button type="submit" class="position-absolute btn btn-primary px-3 text-uppercase fw-bolder start-50 translate-middle-x">Cadastrar</button>
                        </div> 
                    </form>
                </div>

            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ Vite::asset('resources/js/components/Register.js') }}" type="module"></script>
    @endpush
@endsection
