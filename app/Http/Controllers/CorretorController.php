<?php

namespace App\Http\Controllers;

use App\Models\Corretor;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Database\QueryException as DatabaseQueryException;
use Illuminate\Http\Request;

class CorretorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $corretores = Corretor::all();        

        return view('corretor.show', [
            'corretores' => $corretores]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response'
     */
    public function create()
    {
        return view('corretor.show'); // Retorna a view do modal de cadastro
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       try {        
            // Salva os dados do corretor no banco de dados
            $corretor = new Corretor();
            $corretor->nome = $request->nome;
            $corretor->email = $request->email;
            $corretor->whatsapp = $request->whatsapp;
            $corretor->creci = $request->creci;
            
            // Salva a foto (você pode usar uma biblioteca como Intervention Image para lidar com o upload)
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $nomeFoto = time() . '.' . $foto->getClientOriginalExtension();
                $foto->move(public_path('fotos'), $nomeFoto);
                $corretor->foto = $nomeFoto;
            }

            $corretor->save();
            
            return redirect()->route('corretor')->with('success', 'Corretor cadastrado com sucesso.');
       } catch (DatabaseQueryException $e) {

            $errorCode = $e->errorInfo[1];
        
            if ($errorCode === 1062) {
                if (str_contains($e->getMessage(), 'email_unique')) {
                    return redirect()->route('corretor')->with('erro', 'Já existe um corretor com esse email.');
                }
            }        
            return redirect()->route('corretor')->with('erro', 'Erro ao cadastrar o corretor: ' . $e->getMessage());
       }       
       

       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $corretor = Corretor::find($id);
        $corretor->nome = $request->nome;
        $corretor->email = $request->email;
        $corretor->whatsapp = $request->whatsapp;
        $corretor->creci = $request->creci;
 
        
        return view('corretor.show', compact('corretor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $corretor = Corretor::find($id);
    
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $nomeFoto = time() . '.' . $foto->getClientOriginalExtension();
                $foto->move(public_path('fotos'), $nomeFoto);
                $corretor->foto = $nomeFoto; // Atualize o nome do arquivo da foto
            }
            
            $corretor->update([
                'nome' => $request->nome,
                'email' => $request->email,
                'whatsapp' => $request->whatsapp,
                // 'foto' => $request->foto, // Não é necessário atualizar a foto aqui
            ]);
            
            return redirect()->route('corretor')->with('success', 'Corretor atualizado com sucesso!');
        } catch (DatabaseQueryException $e) {

            $errorCode = $e->errorInfo[1];
        
            if ($errorCode === 1062) {
                if (str_contains($e->getMessage(), 'email_unique')) {
                    return redirect()->route('corretor')->with('erro', 'Já existe um corretor com esse email.');
                }
            }        
            return redirect()->route('corretor')->with('erro', 'Erro ao cadastrar o corretor: ' . $e->getMessage());
        }       
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $corretor = Corretor::find($id);
        $corretor->delete();
       
        return redirect()->route('corretor')->with('success', 'Corretor deletado com sucesso!');
    }
}
