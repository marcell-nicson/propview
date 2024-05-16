<?php

namespace App\Events;

use App\Models\Visita;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VisitaEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $visita;

    public function __construct(Visita $visita)
    {
        $this->visita = $visita;
    }
}