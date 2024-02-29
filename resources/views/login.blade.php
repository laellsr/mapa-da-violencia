@extends('_template')

@push('styles')
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/login.css') }}">
@endpush

@section('content')
    <div class="bg_gradient">
        <div class="container">
            <div class="row panel">

                <div name="leftpanel" class="col leftpanel fs-5">
                    <img src="{{ Vite::asset('resources/img/logo_1.png') }}" class="home-logo" alt="Safety Map - Percorra com segurança" onclick="window.location='{{ route ('map')}}'">
                </div>
                <div name="rightpanel" class="col rightpanel fs-5" >
                    <div class="inrightpanel">

                        <label class="fs-4 me-2">Login</label>
                        <form id="reg_form" class="">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <label class="me-2">Email:</label>
                                    <input name="email" required placeholder="Email" type="email" class="form-control me-3" id="emailForm" aria-describedby="emailForm">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
    
                                <div>
                                    <label class="me-2">Senha:</label>
                                    <input name="senha" required placeholder="Senha" type="password" class="form-control me-3" id="passForm" aria-describedby="passForm">
                                </div>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary px-3 text-uppercase fw-bolder w-100">Logar</button>
                            </div> 
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ Vite::asset('resources/js/components/Register.js') }}" type="module"></script>
    @endpush
@endsection
