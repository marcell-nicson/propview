<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Obrigado por se inscrever! Antes de começar, Enviamos um codigo de verificação para seu e-mail! Se você não recebeu o e-mail, teremos prazer em lhe enviar outro.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('Um novo link de verificação foi enviado para o endereço de e-mail que você forneceu durante o registro.') }}
        </div>
    @endif

    @if (session('status') == 'verification-link-null')
        <div class="mb-4 font-medium text-sm text-red-600">
            {{ __('Seu código de verificação expirou.') }}
        </div>
    @endif
    @if (session('status') == 'verification-link-erro')
        <div class="mb-4 font-medium text-sm text-red-600">
            {{ __('Seu código de verificação é inválido.') }}
        </div>
    @endif

    <div style="text-align: center;" >        
        
        <form method="POST" action="{{ route('verify-email') }}">
            @csrf
            <div class="mb-4">
                <label for="verification_code" class="block text-sm font-medium text-gray-700">Código de Verificação</label>
                <input placeholder="Insira seu codigo" type="number" name="verification_code" id="verification_code" class="mt-1 p-2 border rounded-md" required>
            </div>

            <x-primary-button>
                {{ __('Confirmar Código') }}
            </x-primary-button>
        </form>

        <p class="mt-2 text-gray-600">
            {{ __('OU') }}
        </p>

        <form class="mt-2"  method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button>
                {{ __('Reenviar Código via Email') }}
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="underline text-sm text-gray-500 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Sair') }}
            </button>
        </form>      

    </div>
    
</x-guest-layout>