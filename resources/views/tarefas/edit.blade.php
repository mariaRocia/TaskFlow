<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tarefa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
</head>

<body>
    <div class="container">
        <h1>Editar Tarefa</h1>

        <form action="{{ route('tarefas.update', $tarefa->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="input-field">
                <input type="text" name="descricao" id="descricao" value="{{ old('descricao', $tarefa->descricao) }}" required>
                <label for="descricao" class="active">Descrição</label>
            </div>

            <div class="input-field">
                <div class="select-wrapper">
                    <select name="responsavel_id" id="responsavel_id" required>
                        <option value="" disabled selected>Selecione o Responsável</option>
                        @foreach($colaboradores as $colaborador)
                        <option value="{{ $colaborador->id }}"
                            {{ old('responsavel_id', $tarefa->responsavel_id) == $colaborador->id ? 'selected' : '' }}>
                            {{ $colaborador->nome }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <label for="responsavel_id">Responsável</label>
            </div>



            <div class="input-field">
                <input type="datetime-local" name="prazo_limitado"
                    value="{{ old('prazo_limitado', \Carbon\Carbon::parse($tarefa->prazo_limitado)->format('Y-m-d\TH:i')) }}" required>
                <label for="prazo_limitado" class="active">Prazo Limite</label>
            </div>

            <div class="input-field">
                <select name="prioridade" required>
                    <option value="Baixa" {{ old('prioridade', $tarefa->prioridade) == 'Baixa' ? 'selected' : '' }}>Baixa</option>
                    <option value="Média" {{ old('prioridade', $tarefa->prioridade) == 'Média' ? 'selected' : '' }}>Média</option>
                    <option value="Alta" {{ old('prioridade', $tarefa->prioridade) == 'Alta' ? 'selected' : '' }}>Alta</option>
                </select>
                <label>Prioridade</label>
            </div>

            <button type="submit" class="btn waves-effect waves-light">Atualizar</button>
            <a href="{{ route('tarefas.index') }}" class="btn waves-effect waves-light red">Voltar</a>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <script>
        $(document).ready(function() {
            $('select').formSelect();
        });
    </script>
</body>

</html>