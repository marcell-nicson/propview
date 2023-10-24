<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }

        .link {
            text-decoration: none;
            color: #3490dc;
        }

        .link:hover {
            text-decoration: underline;
        }

        .version {
            font-size: 12px;
            color: #9ca3af;
        }

        .large-text {
            font-size: 24px; /* Defina o tamanho da fonte desejado */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Já tem uma conta ?</h1>
        @if (Route::has('login'))
            <div>
                @auth
                    <a href="{{ url('/dashboard') }}" class="link">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="link large-text">Faça Login - </a> <!-- Aplicando estilo "large-text" -->
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="link large-text">Registre-se</a> <!-- Aplicando estilo "large-text" -->
                    @endif
                @endauth
            </div>
        @endif
        <p class="version">Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</p>
    </div>
</body>
</html>
