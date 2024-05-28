<?php

namespace App\Listeners;

use App\Events\VisitaEvent;
use App\Jobs\ProcessarEnvioEmail;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;

class EnviarEmailVisita implements ShouldQueue
{
    public function handle(VisitaEvent $event)
    {
        $visita = $event->visita;

        if ($visita->created_at >= now()->subMinute()) {
            $this->enviarEmailVisitaCriada($visita);
        } else {
            $this->enviarEmailVisitaCancelada($visita);
        }
    }

    private function enviarEmailVisitaCriada($visita)
    {

        $dataVisita = Carbon::parse($visita->data_visita)->format('d/m/Y H:i:s');
        if ($visita->corretor->email) {
            $titulo = 'Nova visita agendada!';
            $mensagem = 'Você tem uma nova visita agendada para: ' . $dataVisita . ' no endereço: ' . $visita->imovel->endereco;
            dispatch(new ProcessarEnvioEmail($visita->corretor->email, $titulo, $mensagem))->onQueue('default');
        }

        if ($visita->cliente->email) {
            $titulo = 'Nova visita agendada!';
            $mensagem = 'Você tem uma nova visita agendada para: ' . $dataVisita . ' no endereço: ' . $visita->imovel->endereco;
            dispatch(new ProcessarEnvioEmail($visita->cliente->email, $titulo, $mensagem))->onQueue('default');
        }
    }

    private function enviarEmailVisitaCancelada($visita)
    {

        $dataVisita = Carbon::parse($visita->data_visita)->format('d/m/Y H:i:s');
        if ($visita->corretor->email) {
            $titulo = 'Visita cancelada!';
            $mensagem = 'A visita agendada para: ' . $dataVisita . ' no endereço: ' . $visita->imovel->endereco . ' foi cancelada.';
            dispatch(new ProcessarEnvioEmail($visita->corretor->email, $titulo, $mensagem))->onQueue('default');
        }

        if ($visita->cliente->email) {
            $titulo = 'Visita cancelada!';
            $mensagem = 'A visita agendada para: ' . $dataVisita . ' no endereço: ' . $visita->imovel->endereco . ' foi cancelada.';
            dispatch(new ProcessarEnvioEmail($visita->cliente->email, $titulo, $mensagem))->onQueue('default');
        }
    }
}
