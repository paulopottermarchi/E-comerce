<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield("title", "Marchese Store")</title>

    <!-- Google Font: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to bottom right, #f8f9fa, #ffffff);
            padding-top: 70px;
        }

        .navbar {
            background-color: #ffffff !important;
            border-bottom: 1px solid #dee2e6;
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }

        .nav-link {
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #0d6efd;
        }

        footer {
            margin-top: 100px;
            padding: 20px 0;
            background-color: #f1f3f5;
            text-align: center;
            font-size: 0.9rem;
            color: #6c757d;
        }

        .container {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 4rem 0;
            background-color: #fff;
            flex-wrap: wrap;
        }
        .hero-text {
            max-width: 500px;
            padding-right: 2rem;
        }
        .hero-text h2 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        .hero-text p {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            color: #666;
        }
        .hero-text a {
            background-color: #000;
            color: #fff;
            text-decoration: none;
            padding: 1rem 2rem;
            font-size: 1rem;
            border-radius: 8px;
            transition: background-color 0.3s;
        }
        .hero-text a:hover {
            background-color: #333;
        }
        .hero img {
            max-width: 600px;
            border-radius: 12px;
        }
    </style>

    @yield('style')
</head>
<body>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-light fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Marchese Store</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('order.history') }}">Orders</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('cart.show') }}">Cart</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}">Logout</a></li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <div class="container hero">
        <div class="hero-text">
            <h2>Bem-vindo à Marchese Store</h2>
            <p>Descubra nossa nova coleção com ofertas especiais e produtos exclusivos.</p>
            <a href="#">Compre Agora</a>
        </div>
        <img src="{{ asset('assets/img/hero-woman.png') }}" alt="Cliente feliz">
    </div>

    {{-- Conteúdo principal --}}
    <div class="container py-4">
        @yield('content')
    </div>

    {{-- Footer --}}
    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} Marchese Store. Todos os direitos reservados.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    @yield('script')
</body>
</html>
