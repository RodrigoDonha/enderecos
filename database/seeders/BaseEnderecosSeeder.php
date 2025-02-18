<?php

namespace Database\Seeders;

use App\Models\Endereco;
use Illuminate\Database\Seeder;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\DB;


use function Laravel\Prompts\progress;

class BaseEnderecosSeeder extends Seeder
{
    /**
     * Inclui/atualiza registros na tabela enderecos no banco de dados.
     *
     * @var directory define o nome do diretório em que os arquivos base de endereços estão.
     * @var files recebe os nomes na integra dos arquivos, removendo os arquivos/niveis .. e .
     * Lê linha por linha de cada arquivo, comparando a primeira linha (nomes das colunas)
     * com os campos do banco de dados.
     * Se os registros da linha do arquivo existirem na tabela do banco de dados,
     * atualizará conforme registro na linha do arquivo. Se o registro ainda não existir,
     * serão inseridos os dados (novos) no banco de dados.
     * A cada iteração de linha do arquivo exibirá o status com porcentagem ou concusão.
     * Havendo erro, exibirá a mensagem de erro.
     */
    public function run(): void
    {
        $directory = getenv('PATH_DATABASE_ENDERECOS');
        $files = array_diff(scandir($directory), array('..', '.'));
        $totalFiles = count($files);
        $endereco = new Endereco();
        $modelEndereco = $endereco->getFillableFields();
        $progress = array();

        echo "Progresso\n";
        echo "Total de arquivos: $totalFiles\n";

        foreach ($files as $key => $value) {
            $progress[] = [
                "name" => $value,
                "progress" => 'aguardando'
            ];
        }

        $eraseDatabase = true;
        for ($i=0; $i < count($files); $i++) {
            $fileName = $progress[$i]["name"];
            $path = $directory.$fileName;
            if (($addresses = fopen($path, "r")) !== FALSE) {
                $fileTotalLines =   $this->countLineFile($path);
                $fileReadingLine = 0;

                while (($data = fgetcsv($addresses, 0, ";")) !== FALSE) {
                    if ($fileReadingLine == 0) {
                        if ($endereco->verifyCampsTable($data))
                        {
                            /**
                             * remove todos os registros de endereços da tabela do banco de dados
                             * e zera o indice de incremento antes de iniciar a primeira inserção e logo após
                             * todas as verificações serem realizadas.
                             * assim teremos uma base de dados sempre atualizada.
                             */
                            if ($eraseDatabase) {
                                //DB::table('enderecos')->truncate();
                                $eraseDatabase = false;
                            }
                        }
                        else
                        {
                            exit();
                        }
                    }else
                    {
                        $novoEndereco = array();
                        foreach ($data as $key => $value) {
                            $novoEndereco += ["$modelEndereco[$key]" => "$value"];
                        }

                        if (Endereco::create($novoEndereco)) {

                        }else {
                            echo "\n\033[31mOcorreu um erro ao tentar registrar o endereco do arquivo: '{$files[$i]}', linha: '{$fileReadingLine}'\033[0m\n";
                            exit();
                        }
                    }

                    $fileReadingLine++;
                    echo $this->progress($fileName, $fileTotalLines, $fileReadingLine);
                }

                fclose($addresses);
                echo "\r$fileName => \033[32mConcluído\033[0m\n";
            }else
            {
                echo "\n\033[31mOcorreu um erro ao tentar ler o arquivo: '{$files[$i]}'.\033[0m\n";
            }
        }

    }

    /**
     * Atualiza o status de execução de cada arquivo lido com porcentagem do processo.
     * @param $fileName (string) Nome do arquivo em progresso
     * @param $fileTotalLines (int) quantidade total de linhas do arquivo em pogresso
     * @param $fileReadingLine (int) linha em leitura do arquivo em progresso.
     * @return string
     */
    private function progress($fileName, $fileTotalLines, $fileReadingLine) : string
    {
        $progress = "";
        $percentProgressReadingFile = round(($fileReadingLine / $fileTotalLines) * 100, 2);
        return "\r$fileName => $percentProgressReadingFile%";
    }

    /**
     * Conta a quantidade de linhas que tem em um arquivo para ser usado de base na porcentagem do progresso de execução
     * @param $path caminho do arquivo
     * @return int
     */
    private function countLineFile($path) : int
    {
        $file = new \SplFileObject($path, 'r');
        $file->seek(PHP_INT_MAX);
        return $file->key() + 1;
    }
}
