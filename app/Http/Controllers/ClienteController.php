<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException as DatabaseQueryException;
use App\Models\Cliente;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();
        return view('cliente.index', compact('clientes'));
    }

    public function create()
    {
        return view('cliente.create');
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nome' => 'required|string|max:255',
                'email' => 'required|email',
                'whatsapp' => 'required|string',
                'endereco' => 'required|string',
            ]);
    
            $cliente = Cliente::create([
                'nome' => $request->nome,
                'email' => $request->email,
                'whatsapp' => $request->whatsapp,
                'endereco' => $request->endereco,
            ]);
    
            return redirect()->route('cliente')->with('success', 'Cliente criado com sucesso.');

        } catch (DatabaseQueryException $e) {

            $errorCode = $e->errorInfo[1];
        
            if ($errorCode === 1062) {
                if (str_contains($e->getMessage(), 'email_unique')) {
                    return redirect()->route('cliente')->with('erro', 'Já existe um corretor com esse email.');
                }
            }        
            return redirect()->route('cliente')->with('erro', 'Erro ao cadastrar o corretor: ' . $e->getMessage());
        }  
        
    }

    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('cliente.edit', compact('cliente'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'nome' => 'required|string|max:255',
                'email' => 'required|email',
                'whatsapp' => 'required|string',
                'endereco' => 'required|string',
            ]);
    
            $cliente = Cliente::findOrFail($id);
    
            $cliente->update([
                'nome' => $request->nome,
                'email' => $request->email,
                'whatsapp' => $request->whatsapp,
                'endereco' => $request->endereco,
            ]);
    
            return redirect()->route('cliente')->with('success', 'Cliente atualizado com sucesso!');
        } catch (DatabaseQueryException $e) {

            $errorCode = $e->errorInfo[1];
        
            if ($errorCode === 1062) {
                if (str_contains($e->getMessage(), 'email_unique')) {
                    return redirect()->route('cliente')->with('erro', 'Já existe um Cliente com esse email.');
                }
            }        
            return redirect()->route('cliente')->with('erro', 'Erro ao cadastrar o Cliente: ' . $e->getMessage());
        }  
        
    }

    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        return redirect()->route('cliente')->with('success', 'Cliente deletado com sucesso!');
    }
}
