<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessarEnvioEmail;
use App\Mail\HelloMail;
use Illuminate\Support\Str;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }
        
        $user = $request->user();

        $codigo = random_int(111111, 999999);
        Redis::set('chave:' . $user->id, $codigo);
        Redis::expire('chave:'. $user->id , 900);

        $titulo = 'Prezado(a) '. $user->name .' Verifique seu Email';
        $mensagem = 'Seu Codigo de verificação é ' .  $codigo;       
    
        dispatch(new ProcessarEnvioEmail($user->email, $titulo, $mensagem))->onQueue('low');

        return back()->with('status', 'verification-link-sent');
    }
}
