@php
include app_path('Includes/settings.php');
@endphp
@php
    $languages = \App\Facades\UtilityFacades::languages();
@endphp
@extends('layouts.main-landing')

@section('content')
  <router-view></router-view>
@endsection
@push('javascript')
    <script>
        // Landing Page Background Image
        document.addEventListener("DOMContentLoaded", function() {
            var bannerSection = document.querySelector(".blog-page-banner");
            var backgroundURL = bannerSection.getAttribute("data-bg-image");
            bannerSection.style.backgroundImage = "url(" + backgroundURL + ")";
        });
        
          
    </script>
     <script src="{{ asset('js/app.js') }}"></script>
@endpush
