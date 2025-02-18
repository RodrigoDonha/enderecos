<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use PhpParser\Node\Stmt\TryCatch;

class EnderecosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pegar o horário de início do processo
        $startTime = microtime(true);

        /**
         * existem 27 estados com muitas cidades, então será executado por estado e terá que
         * informar o nome do arquivo a cada execução.
         * também deve gravar o arquivo dentro do diretório enderecos assim ficará organizado
         */
        $fileName = "35_SP.csv";
        $path = 'database/seeders/Base_de_enderecos/enderecos/';

        /**
         * informar as cidades que devem ter seus endereços registrados, pois no estado de São Paulo
         * há aproximadamente 22 milhões de endereços e portanto é melhor filtrar por cidade que
         * será atendida pelas aplicações que irão utilizar esses endereços.
         */
        $cidadesHabilitadas = [
            'Adamantina',
            'Álvares Machado',
            'Anhumas',
            'Caiabu',
            'Dracena',
            'Emilianópolis',
            'Estrela do Norte',
            'Euclides da Cunha Paulista',
            'Flora Rica',
            'Flórida Paulista',
            'Iepê',
            'Indiana',
            'Inúbia Paulista',
            'Irapuru',
            'João Ramalho',
            'Junqueirópolis',
            'Lucélia',
            'Mariápolis',
            'Martinópolis',
            'Mirante do Paranapanema',
            'Narandiba',
            'Osvaldo Cruz',
            'Paraguaçu Paulista',
            'Presidente Bernardes',
            'Presidente Epitácio',
            'Presidente Prudente',
            'Rancharia',
            'Regente Feijó',
            'Ribeirão dos Índios',
            'Rosana',
            'Sandovalina',
            'Santo Anastácio',
            'Taciba',
            'Tarabai',
            'Teodoro Sampaio',
            'Tupi Paulista'
        ];

        /**
         * buscar os códigos dos municipios pelo nomes das cidades
         */
        $cod_municipios = DB::table('cidades')
        ->select('cd_mun')
        ->whereIn('nm_mun', $cidadesHabilitadas)
        ->orderBy('nm_mun')
        ->get()
        ->pluck('cd_mun')
        ->toArray();

        // Caminho para o arquivo CSV
        $csvFile = fopen(base_path($path . $fileName), 'r');

        // Ignorar a primeira linha (cabeçalho)
        fgetcsv($csvFile);

        // buscar a quantidade de linhas do arquivo
        echo "\n";
        echo "Buscando o todal de linhas existentes no arquivo, isso levará um tempo.\n";
        echo "\n";
        echo "\n";
        $totalLinesFile = $this->countLineFile(base_path($path . $fileName));

        // exibir alguns valores para acompanhamento do processo
        echo "Arquivo: " .  $fileName . "\n";
        echo "Total de linhas: " . number_format($totalLinesFile, 0, ',', '.') . "\n";
        echo "\n";
        echo "\n";

        $count = 0;
        $includeRegisters = 0;

        // Iterar sobre cada linha do CSV e inserir no banco de dados
        while (($data = fgetcsv($csvFile, 0, ",")) !== FALSE) {

            /**
             * somente para testes com parada de execução após 10 iterações
             */
            // if ($count == 5000) {
            //     $entrou = "";
            // }

            // transformar a string data e array
            $data = explode(';', $data[0]);

            // verificar se há o cod_municipio dentro da lista de cidades habilitadas
            if (in_array($data[2], $cod_municipios)) {
                try {

                    // popular o array endreço com os dados conforme seus campos correspondentes
                    $endereco = [
                        'cod_unico_endereco'    => $data[0],
                        'cod_uf'                => $data[1],
                        'cod_municipio'         => $data[2],
                        'cod_distrito'          => $data[3],
                        'cod_subdistrito'       => $data[4],
                        'cod_setor'             => $data[5],
                        'num_quadra'            => $data[6],
                        'num_face'              => $data[7],
                        'cep'                   => $data[8],
                        'dsc_localidade'        => $data[9],
                        'nom_tipo_seglogr'      => $data[10],
                        'nom_titulo_seglogr'    => $data[11],
                        'nom_seglogr'           => $data[12],
                        'num_endereco'          => $data[13],
                        'dsc_modificador'       => $data[14],
                        'nom_comp_elem1' => $data[15],
                        'val_comp_elem1' => $data[16],
                        'nom_comp_elem2' => $data[17],
                        'val_comp_elem2' => $data[18],
                        'nom_comp_elem3' => $data[19],
                        'val_comp_elem3' => $data[20],
                        'nom_comp_elem4' => $data[21],
                        'val_comp_elem4' => $data[22],
                        'nom_comp_elem5' => $data[23],
                        'val_comp_elem5' => $data[24],
                        'latitude'          => $data[25],
                        'longitude'         => $data[26],
                        'nv_geo_coord'      => $data[27],
                        'cod_especie'       => $data[28],
                        'dsc_estabelecimento'               => $data[29],
                        'cod_indicador_estab_endereco'      => $data[30],
                        'cod_indicador_const_endereco'      => $data[31],
                        'cod_indicador_finalidade_const'    => $data[32],
                        'cod_tipo_especi'                   => $data[33],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ];
                    $insertEndereco = array_merge($endereco, ['created_at' => Carbon::now()]);

                    // Atualizar ou insere o registro baseado no cod_unico_endereco
                    DB::table('enderecos')->updateOrInsert(
                        ['cod_unico_endereco' => $endereco['cod_unico_endereco']],
                        $insertEndereco
                    );

                    // incrementar a quantidade de registros incluídos
                    $includeRegisters++;

                } catch (\Throwable $th) {
                    // Exibir a mensagem de erro
                    echo "\nOcorreu um erro: " . $th->getMessage();
                    exit();
                }
            }

            // incrementar a quantidade de linhas processadas
            $count++;

            //calcular a porcentagem entre o total de linhas do arquivo e o total de linhas processadas
            $percent = $count == 0 ? "0%" : round(($count / $totalLinesFile) * 100, 2) . "%";

            // exibir os números do processamento
            echo "\rLinhas Executadas: " . number_format($count, 0, ',', '.') . " | Registro Incluidos/Atualizados: " . number_format($includeRegisters, 0, ',', '.') . " | Porcent.: " . $percent;
        }

        // Fechar o arquivo CSV
        fclose($csvFile);

        // Pegar o horário de término do processo
        $endTime = microtime(true);
        // Calcular o tempo decorrido em segundos
        $elapsedTime = $endTime - $startTime;

        // Converter o tempo decorrido para horas, minutos e segundos
        $hours = floor($elapsedTime / 3600);
        $minutes = floor(($elapsedTime / 60) % 60);
        $seconds = $elapsedTime % 60;

        // Formatar o horário de início e término para exibição (opcional)
        $formattedStartTime = date('Y-m-d H:i:s', (int)$startTime);
        $formattedEndTime = date('Y-m-d H:i:s', (int)$endTime);

        // Exibir os resultados
        echo "\n";
        echo "O processo começou em: " . $formattedStartTime . "\n";
        echo "O processo terminou em: " . $formattedEndTime . "\n";
        echo "O tempo total decorrido foi de: " . $hours . " horas, " . $minutes . " minutos e " . number_format($seconds, 2) . " segundos\n";
    }

    /**
     * Contar a quantidade de linhas que tem em um arquivo para ser
     * usado de base na porcentagem do progresso de execução.
     * @param $path caminho do arquivo.
     * @return int retorna a quantidade de linhas.
     */
    private function countLineFile($path) : int
    {
        $file = new \SplFileObject($path, 'r');
        $file->seek(PHP_INT_MAX);
        return $file->key() + 1;
    }
}
