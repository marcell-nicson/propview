<?php

namespace App\Http\Controllers;

use App\Models\Imovel;
use App\Models\ImovelPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
    
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $foto) {
                // Salve cada foto em uma pasta e registre-a no imóvel
                $path = $foto->store('fotos_imoveis');
                $imovel->photos()->create([
                    'titulo' => 'Título da Foto', // Você pode obter o título da foto do formulário se quiser
                    'descricao' => 'Descrição da Foto', // Você pode obter a descrição da foto do formulário se quiser
                    'url' => $path,
                ]);
            }
        }
    
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

    public function exibirFoto($fotoId)
    {
        $foto = ImovelPhoto::find($fotoId);

        if (!$foto) {
            abort(404);
        }

        $path = storage_path('app/' . $foto->url); 
        return response()->file($path);
    }

    public function excluirFoto(Request $request, $fotoId)
    {
        $foto = ImovelPhoto::find($fotoId);

        if (!$foto) {
            return response()->json(['error' => 'Foto não encontrada'], 404);
        }

        // Excluir a foto do disco
        Storage::delete($foto->url);

        // Excluir o registro da foto do banco de dados
        $foto->delete();

        return response()->json(['message' => 'Foto excluída com sucesso']);
    }

}
