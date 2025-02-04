<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; 

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarefas', function (Blueprint $table) {
            $table->id();
            $table->text('descricao');
            $table->dateTime('prazo_limitado');
            $table->foreignId('responsavel_id')->constrained('colaboradores');
            $table->enum('prioridade', ['Alta', 'Média', 'Baixa']);
            $table->timestamps(); 
            $table->dateTime('data_executada')->nullable();
            $table->timestamp('data_hora_cadastro')->default(DB::raw('CURRENT_TIMESTAMP')); 
            $table->timestamp('data_hora_execucao')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tarefas');
    }
};
