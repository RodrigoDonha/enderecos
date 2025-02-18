<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cidade extends Model
{
    use HasFactory;

    protected $primaryKey = 'cidade_id';
    protected $table = 'cidades';

    protected $fillable = [
        'cd_mun', // codigo cidade
        'nm_mun', // nome cidade
        'cd_rgi',
        'nm_rgi',
        'cd_rgint',
        'nm_rgint',
        'cd_uf', // codigo do estado
        'nm_uf', // nome do estado
        'cd_regiao',
        'nm_regiao',
        'cd_concurb',
        'nm_concurb',
        'area_km2',

    ];

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'cod_uf', 'cod_uf');
    }

    public function enderecos()
    {
        return $this->hasMany(Endereco::class, 'cod_municipio', 'cd_mun');
    }
}
