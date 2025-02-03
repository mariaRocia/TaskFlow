<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimestampsToTarefasTable extends Migration
{
    public function up()
    {
        Schema::table('tarefas', function (Blueprint $table) {
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('tarefas', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }
}
