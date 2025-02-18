<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;

    protected $primaryKey = 'estado_id';
    protected $table = 'estados';

    protected $fillable = [
        'id',
        'uf',
        'cod_uf',
        'nome'
    ];

    public function cidades()
    {
        return $this->hasMany(Cidade::class, 'cd_uf', 'cod_uf');
    }
}
