@extends('_template')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.locatecontrol/dist/L.Control.Locate.min.css" />
@endpush

@section('content')
    <div id="app">
        <div id="map" @focusin="barFocus=false"></div>
        <div id="boxes-layer">
            <div id="SearchBar" class="mt-3 ms-3 ps-1 bg-white rounded shadow" @mousedown.stop>
                <div class="rounded pt-1 mb-2">
                    <div class="d-flex justify-content-center align-items-center">
                        <span class="ps-4 pe-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor"
                                class="bi bi-search" viewBox="0 0 16 16">
                                <path
                                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                            </svg>
                        </span>
                        <input type="text" v-model="query" class="form-control border-0" placeholder="Digite um endereço" @focusin="barFocus=true">
                    </div>
                </div>
                <ul class="list-group recommendations">
                    <li v-show="barFocus" v-for="(item, index) in recommendations" class="list-group-item border-0 shadow" v-html="item.display" @click="selectSearchBarItem(index)"></li>
                </ul>
            </div>
            <img class="map-logo ms-3 mb-3" src="{{ Vite::asset('resources/img/logo_2.png') }}" draggable="false" alt="Safety Map - Percorra com segurança">
            

            <div v-if="currentLocation">
                <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#LocationInfo" aria-controls="LocationInfo">Enable body scrolling</button>
                <div class="offcanvas offcanvas-start h-75 ms-3 shadow rounded show" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1"
                    id="LocationInfo" aria-labelledby="LocationInfoLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="LocationInfoLabel" v-html="currentLocation.name"></h5><span class="text-black-50" v-html="currentLocation.country"></span>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <p>Try scrolling the rest of the page to see this option in action.</p>
                    </div>
                </div>
            </div>


        </div>
        
    </div>
    <input type="hidden" id="assetUrl" value="{{Vite::asset('resources/img/')}}" >
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin="">
          var map = L.map('map')
      L.marker([-9.663136558749533, -35.71422457695007],).addTo(map);
    </script>
    <script src="https://unpkg.com/leaflet.locatecontrol/dist/L.Control.Locate.min.js" charset="utf-8">
    </script>
    <script src="{{ Vite::asset('resources/js/app.js') }}" type="module"></script>
@endpush