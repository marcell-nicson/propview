<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImovelPhoto extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'descricao', 'url'];

    // Define o relacionamento com o modelo Imovel
    public function imovel()
    {
        return $this->belongsTo(Imovel::class, 'imovel_id');
    }
}
