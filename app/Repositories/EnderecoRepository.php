<?php

namespace App\Repositories;

use App\Models\Endereco;
use Illuminate\Support\Facades\DB;

class EnderecoRepository
{
    public function getEnderecosWithRelations() : array
    {
        echo "buscando registros...\n";
        echo "\n";

        ini_set('memory_limit', '4096M');
        return DB::table('enderecos')
        ->join('cidades', 'enderecos.cod_municipio', '=', 'cidades.cd_mun')
        ->join('estados', 'enderecos.cod_uf', '=', 'estados.cod_uf')
        ->select(
            'enderecos.*',
            'cidades.nm_mun as cidade',
            'estados.nome as estado',
            'estados.uf as uf'
        )
        ->get()
        ->toArray();
    }

    public function insertCampEndCompleto()
    {
        $enderecos = $this->getEnderecosWithRelations();
        $total = count($enderecos);
        $count = 0;
        foreach ($enderecos as $key => $value) {
            $end_completo['end_completo'] =
                $value->nom_tipo_seglogr . " " .
                $value->nom_titulo_seglogr . " " .
                $value->nom_seglogr. ", " .
                $value->num_endereco . ", "
            ;

            !empty($value->nom_comp_elem1) ? $end_completo['end_completo'] = $end_completo['end_completo'] . $value->nom_comp_elem1 . " ": '';
            !empty($value->val_comp_elem1) ? $end_completo['end_completo'] = $end_completo['end_completo'] . $value->val_comp_elem1 . ", ": '';
            !empty($value->nom_comp_elem2) ? $end_completo['end_completo'] = $end_completo['end_completo'] . $value->nom_comp_elem2 . " ": '';
            !empty($value->val_comp_elem2) ? $end_completo['end_completo'] = $end_completo['end_completo'] . $value->val_comp_elem2 . ", ": '';
            !empty($value->nom_comp_elem3) ? $end_completo['end_completo'] = $end_completo['end_completo'] . $value->nom_comp_elem3 . " ": '';
            !empty($value->val_comp_elem3) ? $end_completo['end_completo'] = $end_completo['end_completo'] . $value->val_comp_elem3 . ", ": '';
            !empty($value->nom_comp_elem4) ? $end_completo['end_completo'] = $end_completo['end_completo'] . $value->nom_comp_elem4 . " ": '';
            !empty($value->val_comp_elem4) ? $end_completo['end_completo'] = $end_completo['end_completo'] . $value->val_comp_elem4 . ", ": '';
            !empty($value->nom_comp_elem5) ? $end_completo['end_completo'] = $end_completo['end_completo'] . $value->nom_comp_elem5 . " ": '';
            !empty($value->val_comp_elem5) ? $end_completo['end_completo'] = $end_completo['end_completo'] . $value->val_comp_elem5 . ", ": '';
            !empty($value->dsc_estabelecimento) ? $end_completo['end_completo'] = $end_completo['end_completo'] . $value->dsc_estabelecimento . ", ": '';
            !empty($value->dsc_localidade) ? $end_completo['end_completo'] = $end_completo['end_completo'] . $value->dsc_localidade . ", ": '';

            $end_completo['end_completo'] = $end_completo['end_completo'] .
                $value->cidade. "/" .
                $value->uf. " " .
                $value->cep
            ;

            $end_completo['end_completo'] = str_replace('  ', ' ', $end_completo['end_completo']);
            $end_completo['end_completo'] = str_replace(', , , , ,', '', $end_completo['end_completo']);
            $end_completo['end_completo'] = str_replace(', , , ,', '', $end_completo['end_completo']);
            $end_completo['end_completo'] = str_replace(', , ,', '', $end_completo['end_completo']);
            $end_completo['end_completo'] = str_replace(', ,', '', $end_completo['end_completo']);

            $end_completo['end_completo'] = strtoupper($end_completo['end_completo']);

            Endereco::where('endereco_id', $value->endereco_id)->update($end_completo);
            $count++;
            echo "\r Total de Registros: " . $total . " | Registros lidos: " . $count;
        }
    }

    public function updateEndereco($id, $data)
    {
        DB::table('enderecos')
            ->where('id', $id)
            ->update($data);
    }

    public function getEnderecos($endereco)
    {
        $dados = explode(' ', $endereco);
        $query = DB::table('enderecos');
        $query->where(function($q) use ($dados) {
            foreach ($dados as $dado) {
                if ($dado != "") {
                    $q->Where('end_completo', 'like', '%' . $dado . '%');
                }
            }
        });
        $query->limit(20);
        $enderecos = $query->get();
        return $enderecos->toArray();

        // return DB::table('enderecos')
        // ->where('end_completo', 'like', '%' . $endereco . '%')
        // ->limit(20)
        // ->get()
        // ->toArray();
    }
}
