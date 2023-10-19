<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Corretor extends Model
{
    use HasFactory;

    protected $table = 'corretores'; 
    
    protected $fillable = [
        'nome',
        'email',
        'whatsapp',
        'foto',
        'creci',
    ];
    
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    
    public function visitas()
    {
        return $this->hasMany(Visita::class, 'corretor_id');
    }
}
