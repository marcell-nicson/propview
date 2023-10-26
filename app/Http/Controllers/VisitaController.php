<?php

namespace App\Http\Controllers;

use App\Mail\HelloMail;
use App\Models\Cliente;
use App\Models\Corretor;
use App\Models\Imovel;
use Illuminate\Http\Request;
use App\Models\Visita;
use Illuminate\Support\Facades\Mail;

class VisitaController extends Controller
{
    public function index()
    {
        $visitas = Visita::all();
        $corretores = Corretor::all();
        $clientes = Cliente::all();
        $imoveis = Imovel::all();

        return view('visita.index', compact('visitas', 'corretores', 'clientes', 'imoveis'));
    }

    public function create()
    {
        $corretores = Corretor::all();
        $clientes = Cliente::all();
        $imoveis = Imovel::all();

        return view('visita.create', compact('corretores', 'clientes', 'imoveis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'corretor_id' => 'required',
            'cliente_id' => 'required',
            'imovel_id' => 'required',
            'data_visita' => 'required|date',
            'status' => 'required',
        ]);

        $visita = Visita::create($request->all());


        $emailcorretor = $visita->corretor->email ? $visita->corretor->email : null;
        $emailcliente = $visita->cliente->email ? $visita->cliente->email : null;

        $dataVisita = \Carbon\Carbon::parse($visita->data_visita)->format('d/m/Y H:i:s');

        if ($visita and $emailcorretor != null) {           

            $titulo = 'Olá, '. $visita->corretor->nome .' há nova visita para você!';
            $mensagem = 'Sua visita está agendada para: ' . $dataVisita . 
            ' com o cliente: ' . $visita->cliente->nome . 
            ' no endereço: ' . $visita->imovel->endereco;
        
            Mail::to($emailcorretor)->send(new HelloMail($titulo, $mensagem));                   

        }
        if($visita and $emailcliente != null){

            $titulo = 'Olá, '. $visita->cliente->nome .' há nova visita para você!';
            $mensagem = 'Sua visita está agendada para: ' . $dataVisita . 
            ' com o Corretor ' . $visita->corretor->nome . 
            ' no endereço: ' . $visita->imovel->endereco;

            Mail::to($emailcliente)->send(new HelloMail($titulo, $mensagem));
        
        }

        return redirect()->route('visita')
            ->with('success', 'Visita criada com sucesso.');
    }

    public function edit(Visita $visita)
    {
        $corretores = Corretor::all();
        $clientes = Cliente::all();
        $imoveis = Imovel::all();



        return view('visita.edit', compact('visita', 'corretores', 'clientes', 'imoveis'));
    }

    public function update(Request $request)
    {   
        $visita = Visita::find($request->id);   

        $request->validate([
            'corretor_id' => 'required',
            'cliente_id' => 'required',
            'imovel_id' => 'required',
            'data_visita' => 'required|date',
            'status' => 'required',
        ]);

        $visita->update($request->all());

        return redirect()->route('visita')
            ->with('success', 'Visita atualizada com sucesso.');
    }

    public function destroy(Visita $visita)
    {
        $visita->delete();

        return redirect()->route('visita')
            ->with('success', 'Visita excluída com sucesso.');
    }
}
