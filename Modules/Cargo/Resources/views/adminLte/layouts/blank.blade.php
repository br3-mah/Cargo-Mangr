@extends('theme.layout.layout-theme')

@section('content')

<style>
    .bd-content-bg {
        background: url('https://images.pexels.com/photos/3140204/pexels-photo-3140204.jpeg') no-repeat center center;
        background-size: cover;
        background-attachment: fixed;
        min-height: 100vh;
        width: 100%;
        position: relative;
    }
    .bd-content-bg::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(255,255,255,0.35);
        backdrop-filter: blur(12px);
        z-index: 0;
        pointer-events: none;
    }
    .bd-content-bg > .bd-container-post {
        position: relative;
        z-index: 1;
        overflow-y: auto;
        max-height: 100vh;
        scroll-behavior: smooth;
        scrollbar-width: none; /* Firefox */
        -ms-overflow-style: none;  /* IE 10+ */
    }
    .bd-content-bg > .bd-container-post::-webkit-scrollbar {
        display: none; /* Chrome/Safari/Webkit */
    }
</style>

<div class="bd-content-wrap bd-content-bg" style="transform: none;">
    <div class="cfix"></div>
    <div class="clearfix"></div>

    @yield('before-content')

    <!-- .slider-area -->
    <div class="bd-container-post entry-content-only" style="transform: none;">
        <div class="bd-row" style="transform: none;">
            @yield('page-content')
        </div>
    </div>

    @yield('after-content')

</div>

@endsection