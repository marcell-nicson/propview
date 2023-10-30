<?php

namespace App\Jobs;

use App\Mail\HelloMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ProcessarEnvioEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;

    protected $titulo;

    protected $mensagem;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $titulo, $mensagem)
    {

        $this->email = $email;
        $this->titulo = $titulo;
        $this->mensagem = $mensagem;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = $this->email;
        $titulo = $this->titulo;
        $mensagem = $this->mensagem;

        try {

            Mail::to($email)->send(new HelloMail($titulo, $mensagem));

        } catch (\Exception $e) {
            Log::info($e);
        }


        
    }
}
