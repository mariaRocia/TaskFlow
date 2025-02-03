<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use Illuminate\Http\Request;

class ColaboradorController extends Controller
{
    public function index()
    {
        $colaboradores = Colaborador::paginate(5); // Mostra 10 por página
        return view('colaboradores.index', compact('colaboradores'));
    }

    public function create()
    {
        return view('colaboradores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|unique:colaboradores',
            'email' => 'required|email|unique:colaboradores',
        ], [
            'cpf.unique' => 'Este CPF já está cadastrado.',
            'email.unique' => 'Este e-mail já está cadastrado, por gentileza troque.',
        ]);

        Colaborador::create($request->all());

        return redirect()->route('colaboradores.index')->with('success', 'Colaborador criado com sucesso!');
    }
    public function edit($id)
    {
        $colaborador = Colaborador::findOrFail($id);
        return view('colaboradores.edit', compact('colaborador'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required',
            'cpf' => 'required|unique:colaboradores,cpf,' . $id,
            'email' => 'required|email|unique:colaboradores,email,' . $id,
        ], [
            'cpf.unique' => 'Este CPF já está cadastrado. Por gentileza, insira outro.',
            'email.unique' => 'Este e-mail já está cadastrado. Por gentileza, escolha outro.',
        ]);

        $colaborador = Colaborador::findOrFail($id);
        $colaborador->update($request->all());

        return redirect()->route('colaboradores.index')->with('success', 'Colaborador atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $colaborador = Colaborador::findOrFail($id);
        $colaborador->delete();

        return redirect()->route('colaboradores.index');
    }
}
