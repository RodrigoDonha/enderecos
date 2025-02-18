<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('enderecos', function (Blueprint $table) {
            $table->id('endereco_id'); // Identificador único
            $table->string('cod_unico_endereco')->unique();
            $table->string('cod_uf'); // Código do estado
            $table->string('cod_municipio'); // Código do município
            $table->string('cod_distrito');
            $table->string('cod_subdistrito');
            $table->string('cod_setor');
            $table->integer('num_quadra');
            $table->integer('num_face');
            $table->string('cep', 10);
            $table->string('dsc_localidade'); // conjunto habitacional chacara vila
            $table->string('end_completo', 255); // endereço completo em um único campo
            $table->string('nom_tipo_seglogr'); // avenida rua travessa
            $table->string('nom_titulo_seglogr'); // titulo (DR PROFESSOR)
            $table->string('nom_seglogr'); // logradouro
            $table->integer('num_endereco'); // numero do endereço
            $table->string('dsc_modificador');
            $table->string('nom_comp_elem1')->nullable(); // nome complemento EDIFICIO (BLOCO) / LOJA
            $table->string('val_comp_elem1')->nullable(); // numero complemento (BLOCO 2) / (1076 E)
            $table->string('nom_comp_elem2')->nullable(); // complemento em caso de predio (APARTAMENTO)
            $table->string('val_comp_elem2')->nullable(); // // numero do APARTAMENTO
            $table->string('nom_comp_elem3')->nullable();
            $table->string('val_comp_elem3')->nullable();
            $table->string('nom_comp_elem4')->nullable();
            $table->string('val_comp_elem4')->nullable();
            $table->string('nom_comp_elem5')->nullable();
            $table->string('val_comp_elem5')->nullable();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->string('nv_geo_coord');
            $table->string('cod_especie');
            $table->string('dsc_estabelecimento'); // TIPO DE ESTABELECIMENTO (NOME) EX BORRACHARIA VISTA ALEGRE 2
            $table->string('cod_indicador_estab_endereco');
            $table->string('cod_indicador_const_endereco');
            $table->string('cod_indicador_finalidade_const');
            $table->string('cod_tipo_especi');
            $table->foreign('cod_uf')->references('cod_uf')->on('estados')->onDelete('cascade'); // Chave estrangeira para estados
            $table->foreign('cod_municipio')->references('cd_mun')->on('cidades')->onDelete('cascade'); // Chave estrangeira para cidades
            $table->timestamps();
        });

        // Índices para cod_uf, cod_municipio, e cep
        Schema::table('enderecos', function (Blueprint $table) {
            $table->index('cod_uf');
            $table->index('cod_municipio');
            $table->index('cep');
        });

        Schema::table('enderecos', function (Blueprint $table) {
            $table->index('end_completo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enderecos');
    }
};
