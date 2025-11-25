<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Bancaire</title>

    <!-- Global CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">

    @yield('styles')
</head>

<body>

    <div class="wrapper">

        <!-- ==================== NAVBAR ==================== -->
        <nav class="navbar">
            
            <!-- Logo -->
            <a href="{{ route('dashboard') }}" class="navbar-brand">
                Ma Banque
            </a>

            <!-- Menu -->
            <ul class="navbar-menu">

                <li>
                    <a href="{{ route('dashboard') }}"
                       class="{{ Request::routeIs('dashboard') ? 'active' : '' }}">
                        Tableau de bord
                    </a>
                </li>

                <li>
                    <a href="{{ route('clients.index') }}"
                       class="{{ Request::routeIs('clients.*') ? 'active' : '' }}">
                        Clients
                    </a>
                </li>

                <li>
                    <a href="{{ route('comptes.index') }}"
                       class="{{ Request::routeIs('comptes.*') ? 'active' : '' }}">
                        Comptes
                    </a>
                </li>

                <li>
                    <a href="{{ route('virements.index') }}"
                       class="{{ Request::routeIs('virements.*') ? 'active' : '' }}">
                        Virements
                    </a>
                </li>

            </ul>
        </nav>
        <!-- ==================== FIN NAVBAR ==================== -->


        <!-- ==================== CONTENU ==================== -->
        <div class="main-content">
            @yield('content')
        </div>

    </div>

</body>
</html>
