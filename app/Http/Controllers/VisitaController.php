<?php

namespace App\Http\Controllers;

use App\Events\VisitaEvent;
use App\Jobs\ProcessarEnvioEmail;
use App\Mail\HelloMail;
use App\Models\Cliente;
use App\Models\Corretor;
use App\Models\Imovel;
use Illuminate\Http\Request;
use App\Models\Visita;
use Carbon\Carbon;
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
    
        if ($visita) {
            event(new VisitaEvent($visita));

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

        if($request->status == 'NÃO REALIZADO'){            
            event(new VisitaEvent($visita));
        }

        $visita->update($request->all());

        return redirect()->route('visita')
            ->with('success', 'Visita atualizada com sucesso.');
    }

    public function destroy(Visita $visita)
    {                 
        event(new VisitaEvent($visita));
        
        $visita->delete();

        return redirect()->route('visita')
            ->with('success', 'Visita excluída com sucesso.');
    }


}
