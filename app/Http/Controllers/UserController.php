<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessarEnvioEmail;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Validation\ValidationException as ValidationValidationException;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {       
        try {

            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
                'whatsapp' => 'required', 
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'whatsapp' => $request->whatsapp,
                'password' => Hash::make($request->password),
            ]);

            // $user = $request->user();
            
            $codigo = random_int(111111, 999999);
            Redis::set('chave:' . $user->id, $codigo);
            Redis::expire('chave:'. $user->id , 900);

            $titulo = 'Prezado(a) '. $user->name .' Verifique seu Email';
            $mensagem = 'Seu Codigo de verificação é ' . $codigo;
        
            dispatch(new ProcessarEnvioEmail($user->email, $titulo, $mensagem))->onQueue('low');
    
            return redirect()->route('users')->with('success', 'Usuário criado com sucesso.');
        } catch (ValidationValidationException $e) {
            $errors = $e->validator->errors();
        
            if ($errors->has('email')) {
                return redirect()->route('corretor')->with('erro', 'Já existe um Usuário com esse email.');
            }
        
            return redirect()->route('corretor')->with('erro', 'Erro ao cadastrar o Usuário.');
        }
        
        
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $id,
                'whatsapp' => 'required', // Adicione as regras de validação necessárias para o campo WhatsApp
            ]);
    
            $user = User::findOrFail($id);
    
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'whatsapp' => $request->whatsapp,
            ]);
    
            return redirect()->route('users')->with('success', 'Usuário atualizado com sucesso!');
        } catch (ValidationValidationException $e) {
            $errors = $e->validator->errors();
        
            if ($errors->has('email')) {
                return redirect()->route('corretor')->with('erro', 'Já existe um Usuário com esse email.');
            }
        
            return redirect()->route('corretor')->with('erro', 'Erro ao cadastrar o Usuário.');
        }        
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users')->with('success', 'Usuário deletado com sucesso!');
    }
}
