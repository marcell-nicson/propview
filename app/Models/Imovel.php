<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Imovel
 *
 * @property int $id
 * @property string $titulo
 * @property string $descricao
 * @property float $latitude
 * @property float $longitude
 * @property string $tipo_negocio
 * @property string $endereco
 *
 * @package App\Models
 */
class Imovel extends Model
{
    use HasFactory;

    protected $table = 'imoveis';

    protected $fillable = ['titulo', 'descricao', 'latitude', 'longitude', 'tipo_negocio', 'endereco'];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
    
    public function visitas()
    {
        return $this->hasMany(Visita::class);
    }
}
