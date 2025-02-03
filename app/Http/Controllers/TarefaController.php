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
            $tarefas->where('prazo_limitado', '>=', $request->prazo_limitado);
        }

        $tarefas->orderByRaw("IF(data_executada IS NULL, 0, 1) ASC")
            ->orderByRaw("FIELD(prioridade, 'Alta', 'Média', 'Baixa')");

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
            'descricao' => 'required|string|max:255',
            'responsavel_id' => 'required|exists:colaboradores,id',
            'prazo_limitado' => 'required|date',
            'prioridade' => 'required|in:Baixa,Média,Alta',
        ]);


        Tarefa::create([
            'descricao' => $request->descricao,
            'responsavel_id' => $request->responsavel_id,
            'prazo_limitado' => $request->prazo_limitado,
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
            'descricao' => 'required|string|max:255',
            'responsavel_id' => 'required|exists:colaboradores,id',
            'prazo_limitado' => 'required|date',
            'prioridade' => 'required|in:Baixa,Média,Alta',
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
