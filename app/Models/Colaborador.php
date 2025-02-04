<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colaborador extends Model
{
    use HasFactory;

    protected $table = 'colaboradores';
    protected $fillable = ['nome', 'cpf', 'email'];

    public $timestamps = false;

    public function tarefas()
    {
        return $this->hasMany(Tarefa::class, 'responsavel_id');
    }
}
