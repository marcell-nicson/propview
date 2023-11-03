<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessarEnvioEmail;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // event(new Registered($user));
        
        $codigo = random_int(111111, 999999);

        Redis::set('chave:' . $user->id, $codigo);
        Redis::expire('chave:'. $user->id , 90);

        $titulo = 'Prezado(a) '. $user->name .' Verifique seu Email';
        $mensagem = 'Seu Codigo de verificação é ' . $codigo;
    
        dispatch(new ProcessarEnvioEmail($user->email, $titulo, $mensagem))->onQueue('low');

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
