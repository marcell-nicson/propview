<?php

namespace App\Console\Commands;

use App\Mail\HelloMail;
use App\Models\Cliente;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class AniversarioClientes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'processar:aniversarioclientes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando de aniversario dos clientes diario';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
   
        $clientes = Cliente::whereMonth('nascimento', '=', now()->month)
            ->whereDay('nascimento', '=', now()->day)
            ->get();            

       
        foreach ($clientes as $cliente) {                                        

            $titulo = 'Prezado(a) '. $cliente->nome .' Parabéns pelo seu dia!';

            $mensagem = 'Hoje é um dia especial, pois celebramos o seu aniversário! 🎉

            Em nome de toda a equipe da Propview gostaríamos de aproveitar esta ocasião para lhe desejar um dia repleto de alegria, sucesso e prosperidade.
            
            O seu apoio contínuo e a confiança que você deposita em nossa empresa são muito valorizados. É graças a clientes como você que podemos crescer e servir cada vez melhor.
            
            Que este novo ano de vida lhe traga saúde, felicidade e a realização de todos os seus sonhos e objetivos. Que cada dia seja repleto de conquistas e momentos memoráveis.
            
            Uma vez mais, feliz aniversário! Esperamos que este dia seja tão especial quanto você é para nós.
            
            Atenciosamente,
            
            A Equipe Propview';                
        
            Mail::to($cliente->email)->send(new HelloMail($titulo, $mensagem));

        }
        
        $this->info('E-mails de parabéns enviados com sucesso!');
    }
}
