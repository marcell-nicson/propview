<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
    }

    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('cliente.edit', compact('cliente'));
    }

    public function update(Request $request, $id)
    {
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
    }

    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        return redirect()->route('cliente')->with('success', 'Cliente deletado com sucesso!');
    }
}
