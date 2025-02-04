<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColaboradorController;
use App\Http\Controllers\TarefaController;

Route::get('/', function () {
    return redirect()->route('colaboradores.index');
});

Route::resource('colaboradores', ColaboradorController::class);
Route::resource('tarefas', TarefaController::class);
Route::post('/tarefas/{id}/concluir', [TarefaController::class, 'concluir'])->name('tarefas.concluir');
