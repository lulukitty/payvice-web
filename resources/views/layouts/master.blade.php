@include('layouts.header')
<body class="">
<div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>

<div id="app">
@yield('content')
</div>
@section('footer')

@extends('layouts.footer')

@show
