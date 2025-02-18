<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    protected $primaryKey = 'endereco_id';
    protected $table = 'enderecos';

    protected $fillable = [
        'cod_unico_endereco',
        'cod_uf', // codigo do estado
        'cod_municipio', // codigo da cidade
        'cod_distrito',
        'cod_subdistrito',
        'cod_setor',
        'num_quadra',
        'num_face',
        'end_completo',
        'cep',
        'dsc_localidade',
        'nom_tipo_seglogr',
        'nom_titulo_seglogr',
        'nom_seglogr',
        'num_endereco',
        'dsc_modificador',
        'nom_comp_elem1',
        'val_comp_elem1',
        'nom_comp_elem2',
        'val_comp_elem2',
        'nom_comp_elem3',
        'val_comp_elem3',
        'nom_comp_elem4',
        'val_comp_elem4',
        'nom_comp_elem5',
        'val_comp_elem5',
        'latitude',
        'longitude',
        'nv_geo_coord',
        'cod_especie',
        'dsc_estabelecimento',
        'cod_indicador_estab_endereco',
        'cod_indicador_const_endereco',
        'cod_indicador_finalidade_const',
        'cod_tipo_especi'
    ];

    public function cidade()
    {
        return $this->belongsTo(Cidade::class, 'cod_municipio', 'cd_mun');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'cod_uf', 'cod_uf');
    }

    /**
     * Retorna os campos preenchíveis da tabela 'enderecos' como um array.
     *
     * @return array
     */
    public function getFillableFields() : array
    {
        return $this->fillable;
    }

    /**
     * Verifica se os campos no arquivo CSV correspondem aos campos na model.
     * Exibe mensagem no terminal antes de parar a execução em caso false.
     *
     * @param array $campsArchiveCsv Array com os nomes e posições das colunas do arquivo CSV.
     * @var array $campsInModel recebe os campos da tabela em array já com as chaves representando as posições de coluna.
     * @return bool Retorna true se todos as colunas e campos corresponderem, false caso contrário.
     */
    public function verifyCampsTable ($campsArchiveCsv) : bool
    {
        $campsInModel = $this->getFillableFields();

        if (count($campsArchiveCsv) == count($campsInModel))
        {
            for ($i = 0; $i < count($campsArchiveCsv); $i++) {
                if (strtolower($campsArchiveCsv[$i]) == strtolower($campsInModel[$i])) {
                    $i++;
                }else {
                    echo "\n\033[33mHá uma divergência entre a coluna do arquivo '{$i}', com a descrição '{$campsArchiveCsv[$i]}' e o campo do banco de dados '{$campsInModel[$i]}'\033[0m\n";
                    return false;
                }
                return true;
            }
        }
        else
        {
            echo "\n\033[33mOcorreu uma divergência entre a quantidade de colunas do arquivo e a quantidade de campos no banco de dados.\033[0m\n";
            return false;
        }
    }
}
