<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Tarefa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
</head>

<body>
    <div class="container">
        <h1>Adicionar Tarefa</h1>
        <form action="{{ route('tarefas.store') }}" method="POST">
            @csrf
            <div class="input-field">
                <input type="text" name="descricao" id="descricao" required>
                <label for="descricao">Descrição</label>
            </div>

            <div class="input-field">
                <select name="responsavel_id" required>
                    <option value="" disabled selected>Selecione o Responsável</option>
                    @foreach($colaboradores as $colaborador)
                    <option value="{{ $colaborador->id }}">{{ $colaborador->nome }}</option>
                    @endforeach
                </select>
                <label>Responsável</label>
            </div>

            <div class="input-field">
                <label for="prazo_limitado" class="active">Prazo Limite</label>
                <input type="datetime-local" name="prazo_limitado"
                    value="{{ old('prazo_limitado', \Carbon\Carbon::now()->addHours(24)->format('Y-m-d\TH:i')) }}"
                    min="{{ \Carbon\Carbon::now()->addHours(24)->format('Y-m-d\TH:i') }}" required
                    onchange="this.setAttribute('value', this.value)">

            </div>


            <div class="input-field">
                <select name="prioridade" required>
                    <option value="" disabled selected>Selecione a Prioridade</option>
                    <option value="Baixa">Baixa</option>
                    <option value="Média">Média</option>
                    <option value="Alta">Alta</option>
                </select>
                <label>Prioridade</label>
            </div>

            <div class="form-group">
                <label for="data_hora_execucao">Data/Hora Execução</label>
                <input type="datetime-local" name="data_hora_execucao" id="data_hora_execucao" class="form-control">
            </div>

            <button type="submit" class="btn">Adicionar</button>
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