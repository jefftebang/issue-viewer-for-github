<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<meta name="description" content="@yield('description')">
<meta name="keywords" content="@yield('keyword')">
<link rel="canonical" href="{{url()->current()}}"/>

<title>@yield('title') Issue Viewer for GitHub</title>

{{-- Fonts --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,300;0,400;0,500;0,600;1,200;1,300;1,400;1,500;1,600&display=swap"
    rel="stylesheet">

{{-- Scripts --}}
<script src="{{ asset('/js/jquery.min.js') }}"></script>
<script src="{{ asset('/js/moment.min.js') }}"></script>
@vite(['resources/css/app.css', 'resources/js/app.js'])