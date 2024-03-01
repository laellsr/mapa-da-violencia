@extends('_template')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.locatecontrol/dist/L.Control.Locate.min.css" />
@endpush

@section('content')
    <div id="app">
        <div id="map" @focusin="barFocus=false"></div>
        <div id="boxes-layer">
            @include('_search-bar')
            <img class="map-logo ms-3 mb-3" src="{{ Vite::asset('resources/img/logo_2.png') }}" draggable="false" alt="Safety Map - Percorra com segurança">
            @include('_statistics-offcanvas')
            @include('_report-modal')
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet.heat@0.2.0/dist/leaflet-heat.min.js"></script>
    <script src="https://unpkg.com/leaflet.locatecontrol/dist/L.Control.Locate.min.js" charset="utf-8"></script>
    <script src="{{ Vite::asset('resources/js/components/Map.js') }}" type="module"></script>
@endpush
