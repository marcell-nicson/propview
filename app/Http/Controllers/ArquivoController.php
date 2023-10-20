<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Arquivo;

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
        // Valide e armazene o arquivo enviado
        $request->validate([
            'arquivo' => 'required|file|mimes:pdf,docx,doc|max:2048',
        ]);

        if ($request->hasFile('arquivo')) {
            $path = $request->file('arquivo')->store('arquivos');
            $arquivo = new Arquivo([
                'titulo' => $request->input('titulo'),
                'descricao' => $request->input('descricao'),
                'url' => $path,
            ]);
            $arquivo->save();

            return redirect()->route('arquivos.index')
                ->with('success', 'Arquivo enviado com sucesso.');
        }

        return back()->with('error', 'Erro ao enviar o arquivo.');
    }

    public function show($id)
    {
        $arquivo = Arquivo::find($id);

        return response()->file(storage_path("app/{$arquivo->url}"));
    }
}
