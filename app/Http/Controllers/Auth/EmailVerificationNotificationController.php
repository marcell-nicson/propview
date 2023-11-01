<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessarEnvioEmail;
use App\Mail\HelloMail;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

        $emailuser = $user->email;

        $titulo = 'Prezado(a) '. $user->name .' Verifique seu Email';

        $mensagem = 'Seu Codigo de verificação é Douglas123';                
    
        dispatch(new ProcessarEnvioEmail($emailuser, $titulo, $mensagem))->onQueue('low');

        return back()->with('status', 'verification-link-sent');
    }
}
