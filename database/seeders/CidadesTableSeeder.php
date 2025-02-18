<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class CidadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Caminho para o arquivo CSV
        $csvFile = fopen(base_path('database/seeders/Base_de_enderecos/cidades/SP_Municipios_2023.csv'), 'r');

        // Ignorar a primeira linha (cabeçalho)
        fgetcsv($csvFile);

        // Iterar sobre cada linha do CSV e inserir no banco de dados
        while (($data = fgetcsv($csvFile, 0, ";")) !== FALSE) {
            // Substituir vírgula por ponto no valor de area_km2
            $data[12] = str_replace(',', '.', $data[12]);

            DB::table('cidades')->insert([
                'cd_mun' => $data[0],
                'nm_mun' => $data[1],
                'cd_rgi' => $data[2],
                'nm_rgi' => $data[3],
                'cd_rgint' => $data[4],
                'nm_rgint' => $data[5],
                'cd_uf' => $data[6],
                'nm_uf' => $data[7],
                'cd_regiao' => $data[8],
                'nm_regiao' => $data[9],
                'cd_concurb' => $data[10],
                'nm_concurb' => $data[11],
                'area_km2' => $data[12],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        // Fechar o arquivo CSV
        fclose($csvFile);
    }
}
