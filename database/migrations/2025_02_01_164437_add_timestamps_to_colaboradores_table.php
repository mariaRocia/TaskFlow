<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimestampsToColaboradoresTable extends Migration
{
    public function up()
    {
        Schema::table('colaboradores', function (Blueprint $table) {
            if (!Schema::hasColumn('colaboradores', 'created_at') && !Schema::hasColumn('colaboradores', 'updated_at')) {
                $table->timestamps();
            }
        });
    }

    public function down()
    {
        Schema::table('colaboradores', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }
}