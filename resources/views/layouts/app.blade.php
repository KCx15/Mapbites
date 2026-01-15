<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MapBites</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/mapbites.css') }}">


</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark mb-4">
    <div class="container">

       
        <a class="navbar-brand fw-bold" href="{{ route('restaurants.index') }}">
            🍴 MapBites
        </a>

        
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('restaurants.*') ? 'active' : '' }}"
                   href="{{ route('restaurants.index') }}">
                    Restaurants
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('cuisines.*') ? 'active' : '' }}"
                   href="{{ route('cuisines.index') }}">
                    Cuisines
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('map.index') ? 'active' : '' }}"
                   href="{{ route('map.index') }}">
                    Map
                </a>
            </li>
        </ul>

    </div>
</nav>


<main class="container py-4">
    @include('partials.alerts')
    @yield('content')
</main>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
