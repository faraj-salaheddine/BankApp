<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Bancaire</title>
     <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <!-- Custom CSS -->
    @yield('styles')
  <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <!-- jQuery (requis pour Select2) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Global CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
<!-- Lucide Icons CDN -->
<script src="https://unpkg.com/lucide@latest"></script>
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
<script>
    lucide.createIcons();
</script>
</body>
</html>
