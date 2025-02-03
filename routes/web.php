<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColaboradorController;
use App\Http\Controllers\TarefaController;

Route::resource('colaboradores', ColaboradorController::class);
Route::resource('tarefas', TarefaController::class);
Route::post('/tarefas/{id}/concluir', [TarefaController::class, 'concluir'])->name('tarefas.concluir');

