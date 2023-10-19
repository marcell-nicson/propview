<?php

namespace App\Http\Controllers;

use App\Models\Visita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class CalendarioController extends Controller
{
    public function index()
    {
        return view('calendario.index');
    }

    public function getEvents(Request $request)
    {
        
        $start = $request->input('start'); 
        $end = $request->input('end');     
        $timezone = $request->input('timezone');

       $visitas = Visita::whereBetween('data_visita', [$request->start, $request->end])
        ->where('timezone', '=', 'UTC') 
        ->get();

        $events = [];

        foreach ($visitas as $visita) {
            $statusColor = '';

            if ($visita->status == 'Não realizado') {
                $statusColor = 'gray';
            } elseif ($visita->status == 'Agendado') {
                $statusColor = 'blue';
            } elseif ($visita->status == 'Realizado') {
                $statusColor = 'green';
            }

            $events[] = [
                'id' => $visita->id,
                'title' => $visita->status,
                'start' => $visita->data_visita,
                'end' => $visita->data_visita,
                'backgroundColor' => $statusColor,
            ];
        }

        return response()->json($events);
    }

}
