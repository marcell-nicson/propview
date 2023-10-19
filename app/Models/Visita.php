<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
    use HasFactory;

    protected $table = 'visitas';

    protected $fillable = [
        'corretor_id',
        'cliente_id',
        'imovel_id',
        'data_visita',
        'status',
    ];

    public function corretor()
    {
        return $this->belongsTo(Corretor::class, 'corretor_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function imovel()
    {
        return $this->belongsTo(Imovel::class, 'imovel_id');
    }

    public function statusVisita($status)
    {       
        $color     = '';

        switch ($status) {
            case 'Realizado':                
                $color     = 'verde'; 
                break;
            case 'Não realizado':                
                $color     = 'cinza'; 
                break;
            case 'Agendado':               
                $color     = 'azul'; 
                break;
        }

        return [            
            'color'     => $color,
        ];
    }
}
