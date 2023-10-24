<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Arquivo;
use Exception;

class ArquivoController extends Controller
{
    public function index()
    {
        // Recupere todos os arquivos
        $arquivos = Arquivo::all();

        return view('arquivos.index', compact('arquivos'));
    }

    public function create()
    {
        return view('arquivos.create');
    }

    public function store(Request $request)
    {
        
        try {

            $request->validate([
                'arquivo' => 'required|file|max:2048',
            ]);
    
            if ($request->hasFile('arquivo')) {
                $path = $request->file('arquivo')->store('arquivos');
                $arquivo = new Arquivo([
                    'titulo' => $request->input('titulo'),
                    'descricao' => $request->input('descricao'),
                    'url' => $path,
                ]);
                $arquivo->save();
    
                return redirect()->route('arquivos')
                    ->with('success', 'Arquivo enviado com sucesso.');
            }
    
            return back()->with('error', 'Erro ao enviar o arquivo.');
        } catch (Exception $e) {

            info($e->getMessage());
        }
       
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'arquivo' => 'nullable|file|max:2048',
            ]);
           
            $arquivo = Arquivo::findOrFail($id);

            if ($request->hasFile('arquivo')) {
               
                $path = $request->file('arquivo')->store('arquivos');
                $arquivo->url = $path;
            }
           
            $arquivo->titulo = $request->input('titulo');
            $arquivo->descricao = $request->input('descricao');

            $arquivo->save();

            return redirect()->route('arquivos')
                ->with('success', 'Arquivo atualizado com sucesso.');
        } catch (Exception $e) {
            info($e->getMessage());
            return back()->with('error', 'Erro ao atualizar o arquivo.');
        }
    }

    public function show($id)
    {
        $arquivo = Arquivo::find($id);

        return response()->file(storage_path("app/{$arquivo->url}"));
    }

    public function destroy($id)
    {
        $arquivo = Arquivo::find($id);
        $arquivo->delete();
       
        return redirect()->route('arquivos')->with('success', 'Arquivo deletado com sucesso!');
    }

    
}
