<?php

namespace App\Http\Controllers;

use App\Models\Tarefa;
use App\Models\Colaborador;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TarefaController extends Controller
{

    public function index(Request $request)
    {
        $colaboradores = Colaborador::all();
        $tarefas = Tarefa::query();

        if ($request->filled('prioridade')) {
            $tarefas->where('prioridade', $request->prioridade);
        }

        if ($request->filled('responsavel_id')) {
            $tarefas->where('responsavel_id', $request->responsavel_id);
        }

        if ($request->filled('prazo_limitado')) {
            $prazo = $request->prazo_limitado;

            $tarefas->whereDate('prazo_limitado', '=', $prazo);
        }

        $tarefas->orderByRaw("IF(data_executada IS NULL, 0, 1) ASC")
            ->orderBy('data_executada', 'desc');

        $tarefas = $tarefas->paginate(5);

        return view('tarefas.index', compact('tarefas', 'colaboradores'));
    }

    public function create()
    {
        $colaboradores = Colaborador::all();
        return view('tarefas.create', compact('colaboradores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required|string|max:300',
            'responsavel_id' => 'required|exists:colaboradores,id',
            'prazo_limitado' => 'required|date|after_or_equal:' . Carbon::now()->addHours(24)->format('Y-m-d H:i'),
            'prioridade' => 'required|in:Alta,Média,Baixa',
        ], [
            'descricao.required' => 'O campo descrição é obrigatório.',
            'descricao.max' => 'A descrição não pode ter mais de 300 caracteres.',
            'responsavel_id.required' => 'Por gentileza, selecione um responsável.',
            'prazo_limitado.required' => 'O campo prazo é obrigatório.',
            'prioridade.required' => 'Por gentileza, selecione uma prioridade.',
        ]);


        Tarefa::create([
            'descricao' => $request->descricao,
            'responsavel_id' => $request->responsavel_id,
            'prazo_limitado' => $request->prazo_limitado,
            'data_executada' => $request->data_executada,
            'prioridade' => $request->prioridade,
        ]);

        return redirect()->route('tarefas.index')->with('success', 'Tarefa criada com sucesso!');
    }

    public function edit($id)
    {
        $tarefa = Tarefa::findOrFail($id);
        $colaboradores = Colaborador::all();

        return view('tarefas.edit', compact('tarefa', 'colaboradores'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'descricao' => 'required|string|max:300',
            'responsavel_id' => 'required|exists:colaboradores,id',
            'prazo_limitado' => 'required|date|after_or_equal:',
            'prioridade' => 'required|in:Alta,Média,Baixa',
        ], [
            'descricao.required' => 'O campo descrição é obrigatório.',
            'descricao.max' => 'A descrição não pode ter mais de 300 caracteres.',
            'responsavel_id.required' => 'Por gentileza, selecione um responsável.',
            'prazo_limitado.required' => 'O campo prazo é obrigatório.',
            'prazo_limitado.after_or_equal' => 'O prazo deve ser ao menos 24 horas à frente da data e hora atual.',
            'prioridade.required' => 'Por gentileza, selecione uma prioridade.',
        ]);

        $tarefa = Tarefa::findOrFail($id);
        $tarefa->descricao = $request->descricao;
        $tarefa->responsavel_id = $request->responsavel_id;
        $tarefa->prazo_limitado = $request->prazo_limitado;
        $tarefa->prioridade = $request->prioridade;
        $tarefa->save();

        return redirect()->route('tarefas.index')->with('success', 'Tarefa atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $tarefa = Tarefa::findOrFail($id);
        $tarefa->delete();

        return redirect()->route('tarefas.index')->with('success', 'Tarefa excluída com sucesso!');
    }


    public function updateDataExecutada(Request $request, $id)
    {
        $tarefa = Tarefa::findOrFail($id);


        $tarefa->update([
            'data_executada' => $request->data_executada
        ]);

        return response()->json(['success' => true]);
    }

    public function concluir($id)
    {
        $tarefa = Tarefa::findOrFail($id);


        $tarefa->data_executada = Carbon::now('America/Sao_Paulo');

        $tarefa->save();


        return redirect()->route('tarefas.index')->with('success', 'Tarefa concluída com sucesso!');
    }
}
