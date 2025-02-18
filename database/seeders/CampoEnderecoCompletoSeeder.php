<?php

namespace Database\Seeders;

use App\Http\Controllers\EnderecoController;
use App\Repositories\EnderecoRepository;
use App\Services\EnderecoService;
use Illuminate\Database\Seeder;

class CampoEnderecoCompletoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=CampoEnderecoCompletoSeeder
     */
    public function run(): void
    {
        $enderecoRepository = new EnderecoRepository();
        $enderecoRepository->insertCampEndCompleto();
    }
}
