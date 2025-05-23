<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Videos App' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f6f9fc;
            margin: 0;
            padding: 0;
            color: #2c2c2c;
        }

        /* Header Styles */
        .app-header {
            background-color: #5a5aff;
            color: #ffffff;
            padding: 22px;
            text-align: center;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .app-header-title {
            font-size: 25px;
            font-weight: bold;
            margin: 0;
            letter-spacing: 1px;
        }

        /* Navbar Styles */
        .navbar {
            background-color: #4747d1;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
        }

        .navbar-nav {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
        }

        .navbar-nav li {
            margin: 0 12px;
        }

        .navbar-nav a {
            color: #ffffff;
            text-decoration: none;
            font-size: 15px;
            font-weight: bold;
            transition: color 0.2s;
        }

        .navbar-nav a:hover {
            text-decoration: underline;
            color: #80ff80;
        }

        .auth-nav {
            margin-right: 20px;
        }

        .user-info {
            color: #ffffff;
            margin-right: 15px;
            font-weight: bold;
        }

        .navbar-nav-a {
            color: #ffffff;
            text-decoration: none;
            font-weight: bold;
            margin-left: 10px;
        }

        .navbar-nav-a:hover {
            color: #80ff80;
        }

        /* Mobile Menu Button */
        .mobile-menu-button {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
        }

        /* Mobile Menu */
        .mobile-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background-color: #4747d1;
            z-index: 100;
            padding: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .mobile-menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .mobile-menu li {
            margin: 10px 0;
        }

        .mobile-menu a {
            color: #ffffff;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            display: block;
            padding: 8px 0;
        }

        .mobile-menu a:hover {
            color: #80ff80;
        }

        .mobile-auth {
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            margin-top: 10px;
            padding-top: 10px;
        }

        main {
            padding: 20px;
            min-height: calc(100vh - 200px);
        }

        /* Footer Styles */
        .app-footer {
            background-color: #e3e8ee;
            color: #444;
            padding: 12px 20px;
            text-align: center;
            border-top: 1px solid #ccc;
            margin-top: 30px;
        }

        .app-footer-text {
            font-size: 14px;
            margin: 0;
            color: #5a5aff;
        }

        /* Toast Notification */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }

        .toast {
            padding: 12px 20px;
            border-radius: 4px;
            margin-bottom: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-width: 250px;
            max-width: 350px;
            animation: slideIn 0.3s ease-out forwards;
        }

        .toast-success {
            background-color: #d4edda;
            border-left: 4px solid #28a745;
            color: #155724;
        }

        .toast-error {
            background-color: #f8d7da;
            border-left: 4px solid #dc3545;
            color: #721c24;
        }

        .toast-close {
            background: none;
            border: none;
            color: inherit;
            font-size: 16px;
            cursor: pointer;
            opacity: 0.7;
        }

        .toast-close:hover {
            opacity: 1;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        .toast-out {
            animation: slideOut 0.3s ease-in forwards;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .navbar-nav {
                display: none;
            }

            .auth-nav {
                display: none;
            }

            .mobile-menu-button {
                display: block;
            }

            .mobile-menu.active {
                display: block;
            }
        }

        /* Button Styles */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 16px;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-primary {
            background-color: #5a5aff;
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background-color: #4747d1;
            transform: translateY(-1px);
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c82333;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            transform: translateY(-1px);
        }

        /* Card Styles */
        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            padding: 16px;
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
        }

        .card-body {
            padding: 16px;
        }

        .card-footer {
            padding: 16px;
            background-color: #f8f9fa;
            border-top: 1px solid #e9ecef;
        }

        /* Grid System */
        .row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }

        .col {
            flex: 1 0 0%;
            padding-right: 15px;
            padding-left: 15px;
        }

        .col-12 {
            flex: 0 0 100%;
            max-width: 100%;
            padding-right: 15px;
            padding-left: 15px;
        }

        @media (min-width: 576px) {
            .col-sm-6 {
                flex: 0 0 50%;
                max-width: 50%;
            }
        }

        @media (min-width: 768px) {
            .col-md-4 {
                flex: 0 0 33.333333%;
                max-width: 33.333333%;
            }
            .col-md-6 {
                flex: 0 0 50%;
                max-width: 50%;
            }
        }

        @media (min-width: 992px) {
            .col-lg-3 {
                flex: 0 0 25%;
                max-width: 25%;
            }
            .col-lg-4 {
                flex: 0 0 33.333333%;
                max-width: 33.333333%;
            }
        }
    </style>

    @vite('resources/css/app.css')
</head>
<body data-success="{{ session('success') }}" data-error="{{ session('error') }}">
<header class="app-header">
    <h1 class="app-header-title">Videos App</h1>
</header>

<!-- Navbar -->
<nav class="navbar">
    <button class="mobile-menu-button" id="mobile-menu-toggle">
        <i class="fas fa-bars"></i>
    </button>

    <ul class="navbar-nav">
        <li><a href="{{ route('videos.index') }}">Inici</a></li>
        @auth
            @can('manage videos')
                <li><a href="{{ route('videos.manage.index') }}">Gestió de Vídeos</a></li>
            @endcan
            @can('manage users')
                <li><a href="{{ route('users.manage.index') }}">Gestió d'usuaris</a></li>
            @endcan
            @can('manage series')
                <li><a href="{{ route('series.manage.index') }}">Gestió de Sèries</a></li>
            @endcan
        @endauth
    </ul>

    <div class="auth-nav">
        @auth
            <span class="user-info">{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); this.closest('form').submit();"
                   class="navbar-nav-a">
                    Tancar sessió
                </a>
            </form>
        @else
            <a href="{{ route('login') }}" class="navbar-nav-a">Iniciar sessió</a>
            @if(Route::has('register'))
                <a href="{{ route('register') }}" class="navbar-nav-a">Registrar-se</a>
            @endif
        @endauth
    </div>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobile-menu">
        <ul>
            <li><a href="{{ route('videos.index') }}">Inici</a></li>
            @auth
                @can('manage videos')
                    <li><a href="{{ route('videos.manage.index') }}">Gestió de Vídeos</a></li>
                @endcan
                @can('manage users')
                    <li><a href="{{ route('users.manage.index') }}">Gestió d'usuaris</a></li>
                @endcan
                @can('manage series')
                    <li><a href="{{ route('series.manage.index') }}">Gestió de Sèries</a></li>
                @endcan
            @endauth
        </ul>

        <div class="mobile-auth">
            @auth
                <div class="user-info" style="margin-bottom: 10px;">{{ Auth::user()->name }}</div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); this.closest('form').submit();"
                       class="navbar-nav-a" style="display: block; margin: 0;">
                        <i class="fas fa-sign-out-alt mr-2"></i> Tancar sessió
                    </a>
                </form>
            @else
                <a href="{{ route('login') }}" class="navbar-nav-a" style="display: block; margin: 10px 0;">
                    <i class="fas fa-sign-in-alt mr-2"></i> Iniciar sessió
                </a>
                @if(Route::has('register'))
                    <a href="{{ route('register') }}" class="navbar-nav-a" style="display: block; margin: 10px 0;">
                        <i class="fas fa-user-plus mr-2"></i> Registrar-se
                    </a>
                @endif
            @endauth
        </div>
    </div>
</nav>

<!-- Toast Container -->
<div class="toast-container" id="toast-container"></div>

<main>
    {{ $slot }}
</main>

<footer class="app-footer">
    <p class="app-footer-text">&copy; {{ date('Y') }} Videos App | Ivan</p>
</footer>

<script>
    // Mobile Menu Toggle
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileMenuToggle && mobileMenu) {
            mobileMenuToggle.addEventListener('click', function() {
                mobileMenu.classList.toggle('active');
            });
        }

        // Toast Notifications
        function showToast(message, type = 'success', duration = 5000) {
            const toastContainer = document.getElementById('toast-container');

            // Create toast element
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;

            // Create toast content
            toast.innerHTML = `
                    <div>${message}</div>
                    <button class="toast-close" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                `;

            // Add to container
            toastContainer.appendChild(toast);

            // Set up close button
            const closeButton = toast.querySelector('.toast-close');
            closeButton.addEventListener('click', function() {
                closeToast(toast);
            });

            // Auto close after duration
            setTimeout(function() {
                closeToast(toast);
            }, duration);
        }

        function closeToast(toast) {
            toast.classList.add('toast-out');
            setTimeout(function() {
                toast.remove();
            }, 300);
        }

        // Check for flash messages
        const successMessage = document.body.getAttribute('data-success');
        const errorMessage = document.body.getAttribute('data-error');

        if (successMessage && successMessage !== 'null') {
            showToast(successMessage, 'success');
        }

        if (errorMessage && errorMessage !== 'null') {
            showToast(errorMessage, 'error');
        }

        // Make showToast available globally
        window.showToast = showToast;
    });
</script>
@vite('resources/js/app.js')
</body>
</html>
