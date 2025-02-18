<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class EstadosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados = [
            ['nome' => 'Rondônia', 'uf' => 'RO', 'cod_uf' => 11],
            ['nome' => 'Acre', 'uf' => 'AC', 'cod_uf' => 12],
            ['nome' => 'Amazonas', 'uf' => 'AM', 'cod_uf' => 13],
            ['nome' => 'Roraima', 'uf' => 'RR', 'cod_uf' => 14],
            ['nome' => 'Pará', 'uf' => 'PA', 'cod_uf' => 15],
            ['nome' => 'Amapá', 'uf' => 'AP', 'cod_uf' => 16],
            ['nome' => 'Tocantins', 'uf' => 'TO', 'cod_uf' => 17],
            ['nome' => 'Maranhão', 'uf' => 'MA', 'cod_uf' => 21],
            ['nome' => 'Piauí', 'uf' => 'PI', 'cod_uf' => 22],
            ['nome' => 'Ceará', 'uf' => 'CE', 'cod_uf' => 23],
            ['nome' => 'Rio Grande do Norte', 'uf' => 'RN', 'cod_uf' => 24],
            ['nome' => 'Paraíba', 'uf' => 'PB', 'cod_uf' => 25],
            ['nome' => 'Pernambuco', 'uf' => 'PE', 'cod_uf' => 26],
            ['nome' => 'Alagoas', 'uf' => 'AL', 'cod_uf' => 27],
            ['nome' => 'Sergipe', 'uf' => 'SE', 'cod_uf' => 28],
            ['nome' => 'Bahia', 'uf' => 'BA', 'cod_uf' => 29],
            ['nome' => 'Minas Gerais', 'uf' => 'MG', 'cod_uf' => 31],
            ['nome' => 'Espírito Santo', 'uf' => 'ES', 'cod_uf' => 32],
            ['nome' => 'Rio de Janeiro', 'uf' => 'RJ', 'cod_uf' => 33],
            ['nome' => 'São Paulo', 'uf' => 'SP', 'cod_uf' => 35],
            ['nome' => 'Paraná', 'uf' => 'PR', 'cod_uf' => 41],
            ['nome' => 'Santa Catarina', 'uf' => 'SC', 'cod_uf' => 42],
            ['nome' => 'Rio Grande do Sul', 'uf' => 'RS', 'cod_uf' => 43],
            ['nome' => 'Mato Grosso do Sul', 'uf' => 'MS', 'cod_uf' => 50],
            ['nome' => 'Mato Grosso', 'uf' => 'MT', 'cod_uf' => 51],
            ['nome' => 'Goiás', 'uf' => 'GO', 'cod_uf' => 52],
            ['nome' => 'Distrito Federal', 'uf' => 'DF', 'cod_uf' => 53],
        ];

        foreach ($estados as $estado) {
            DB::table('estados')->insert([
                'nome' => $estado['nome'],
                'uf' => $estado['uf'],
                'cod_uf' => $estado['cod_uf'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
