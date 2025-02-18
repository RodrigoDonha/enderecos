<?php

namespace App\Services;

use App\Repositories\EnderecoRepository;

class EnderecoService
{
    protected $enderecoRepository;

    public function __construct(EnderecoRepository $enderecoRepository)
    {
        $this->enderecoRepository = $enderecoRepository;
    }

    public function atualizarEnderecos()
    {
        $enderecos = $this->enderecoRepository->getEnderecosWithRelations();

        foreach ($enderecos as $endereco) {
            $end_completo = $endereco->logradouro . ', ' . $endereco->numero . ', ' . $endereco->bairro . ', ' . $endereco->nome_municipio . ', ' . $endereco->nome_estado . ', ' . $endereco->cep;

            $this->enderecoRepository->updateEndereco($endereco->id, ['end_completo' => $end_completo]);
        }
    }

    public function insertCampEndCompleto()
    {
        $enderecos = $this->enderecoRepository->insertCampEndCompleto();
    }

    public function getEnderecos($endereco) : array
    {
        return $this->enderecoRepository->getEnderecos($endereco);
    }
}
