<x-guest-layout>
    <!DOCTYPE html>
    <html>
    <head>
    </head>
    <body>
        <div class="container">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/users') }}" class="link">Painel</a>
                @else
                    <div style="text-align: center;">
                        <h1>Já tem uma conta ?</h1>
                        <a href="{{ route('login') }}" class="link large-text">
                            <x-primary-button class="ml-8">
                                {{ __('Faça Login') }}
                            </x-primary-button>
                        </a>
                        <a> OU </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="link large-text">
                                <x-primary-button class="ml-8">
                                    {{ __('Registre-se') }}
                                </x-primary-button>
                            </a>
                        @endif
                    </div>
                @endauth
            @endif
            <p class="version">Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</p>
        </div>
    </body>
    </html>
</x-guest-layout>
