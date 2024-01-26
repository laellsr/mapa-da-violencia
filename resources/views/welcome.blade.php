@extends('_template')

@section('content')
    <div id="IndexContent" class="d-flex  flex-column justify-content-center align-items-center mt-5">
        <img src="{{ asset('img/logo_coca.png') }}" class="logo mb-3">
        <div id="searchBar" class="mt-5 bg-white rounded shadow w-50" @mousedown.stop>
            <div class="rounded py-2 ">
                <div class="d-flex justify-content-center align-items-center">
                    <span class="ps-4 pe-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor"
                            class="bi bi-search" viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                        </svg>
                    </span>
                    <input type="text" v-model="query" class="form-control border-0" placeholder="Digite um endereço">
                </div>
            </div>
        </div>
        <small class="text-white w-50 mt-5 pt-1 text-center"> Lorem ipsum dolor sit amet, consectetur adipiscing elit.
        Mauris elementum tempor magna eu dignissim. Praesent porttitor enim lacus, ac pharetra ligula iaculis quis. Duis
        vel ex sit amet magna eleifend tristique eu et libero. Duis ultrices sed justo cursus sodales. Nam tincidunt mi
        vitae dolor fermentum efficitur. Mauris condimentum enim vel pulvinar consectetur. Nam mattis vitae nunc eu
        faucibus.</small>
    </div>
@endsection
