<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Tarefa extends Model
{
    use HasFactory;

    protected $table = 'tarefas';
    protected $fillable = ['descricao', 'responsavel_id', 'prazo_limitado', 'prioridade', 'data_executada'];

    public $timestamps = false;

    public function colaborador()
    {
        return $this->belongsTo(Colaborador::class, 'responsavel_id');
    }

    public function getPrazoLimitadoAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y H:i');
    }

    // Novo método para formatar a data de execução
    public function getDataExecutadaAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d/m/Y H:i') : null;
    }
}
