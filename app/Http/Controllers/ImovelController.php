<?php

namespace App\Http\Controllers;

use App\Models\Imovel;
use Illuminate\Http\Request;

class ImovelController extends Controller
{
    public function index()
    {
        $imoveis = Imovel::all();
        return view('imoveis.index', compact('imoveis'));
    }

    public function create()
    {
        return view('imoveis.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'tipo_negocio' => 'required|string',
            'endereco' => 'required|string',
        ]);

        $imovel = Imovel::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'tipo_negocio' => $request->tipo_negocio,
            'endereco' => $request->endereco,
        ]);

        return redirect()->route('imovel')->with('success', 'Imóvel cadastrado com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'tipo_negocio' => 'required|string',
            'endereco' => 'required|string',
        ]);

        $imovel = Imovel::findOrFail($id);

        $imovel->update([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'tipo_negocio' => $request->tipo_negocio,
            'endereco' => $request->endereco,
        ]);

        return redirect()->route('imovel')->with('success', 'Imóvel Atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $imovel = Imovel::findOrFail($id);
        $imovel->delete();

        return redirect()->route('imovel')->with('success', 'Imóvel deletado com sucesso!');
    }
}
