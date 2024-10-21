<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E-Learning Platform')</title>
    <link rel="shortcut icon" href="{{ asset('img/fav/indonesia.png') }}" type="image/x-icon">

    @vite('resources/css/app.css')

    {{-- demo --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
</head>
<body class="font-sans">
    <!-- Include Navbar -->
    @include('components.navbar')

    <!-- Main Content -->
    <div class="">
        @yield('content')
    </div>

    <!-- Include Footer -->
    @include('components.footer')
</body>
</html>
