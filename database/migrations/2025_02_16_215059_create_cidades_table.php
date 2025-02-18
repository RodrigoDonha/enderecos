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
        Schema::create('cidades', function (Blueprint $table) {
            $table->id('cidade_id'); // Identificador único
            $table->string('cd_mun')->unique(); // Código do município
            $table->string('nm_mun'); // Nome do município
            $table->string('cd_rgi');
            $table->string('nm_rgi');
            $table->string('cd_rgint');
            $table->string('nm_rgint');
            $table->string('cd_uf'); // Código do estado
            $table->string('nm_uf');
            $table->string('cd_regiao');
            $table->string('nm_regiao');
            $table->string('cd_concurb');
            $table->string('nm_concurb');
            $table->float('area_km2');
            $table->foreign('cd_uf')->references('cod_uf')->on('estados')->onDelete('cascade'); // Chave estrangeira para estados
            $table->timestamps();
        });

        // Índices para cd_mun e cd_uf
        Schema::table('cidades', function (Blueprint $table) {
            $table->index('cd_mun');
            $table->index('cd_uf');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cidades');
    }
};
