<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EnderecoService;
use Illuminate\Http\JsonResponse;

class EnderecoController extends Controller
{
    protected $enderecoService;

    public function __construct(EnderecoService $enderecoService)
    {
        $this->enderecoService = $enderecoService;
    }

    public function atualizarEndCompleto(Request $request)
    {
        $this->enderecoService->atualizarEnderecos();
        return response()->json(['message' => 'Endereços atualizados com sucesso!']);
    }

    public function insertCampEndCompleto()
    {
        $this->enderecoService->insertCampEndCompleto();
    }

    public function enderecos()
    {
        return view('buscar-endereco');
    }

    public function getEnderecos(Request $request) : JsonResponse
    {
        $endereco = $request->input('end_completo');
        $resultados = $this->enderecoService->getEnderecos($endereco);
        return response()->json($resultados);
    }
}
