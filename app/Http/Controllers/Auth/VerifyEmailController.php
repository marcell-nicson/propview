<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Request;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {

        // dd($request);
        // if ($request->user()->hasVerifiedEmail()) {
        //     return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
        // }

        if ($request->user()->markEmailAsVerified()) {            
            event(new Verified($request->user()));
        }

        return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
    }

    public function Verificarocodigo(Request $request): RedirectResponse
    {

        $codigoVerificacao = request('verification_code');

        $user = auth()->user();
        
        $chave = Redis::get('chave:' . $user->id);

        if($codigoVerificacao == $chave){ 

            $user->email_verified_at = Carbon::now();
            $user->save();

            event(new Verified($user));           
                
            return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');

        }

        if($chave === null){
            
            return back()->with('status', 'verification-link-null');

        }

        if($codigoVerificacao !== $chave){

            return back()->with('status', 'verification-link-erro');

        }

        return redirect()->back();
    }
}
