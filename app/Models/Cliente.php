<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    
    protected $table = 'clients';

    protected $fillable = ['nome', 'email', 'whatsapp', 'endereco'];
    
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function visitas()
    {
        return $this->hasMany(Visita::class);
    }
}
