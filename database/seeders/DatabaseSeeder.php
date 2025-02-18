<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'testuser@example.com',
        //     'password' => 'testuser'
        // ]);

        $this->call([
            //EstadosTableSeeder::class, // implementar um método para fazer update caso já existam registros para não duplicar estados na tabela.
            //CidadesTableSeeder::class, // implementar um método para fazer update caso já existam registros para não duplicar cidades na tabela.
            //EnderecosTableSeeder::class, // já ha um método para fazer update caso hajam registros na tabela.
            //CampoEnderecoCompletoSeeder::class // atualiza o campo end_completo na tabela endereços, é nela que os endereços são buscados.
        ]);
    }
}
