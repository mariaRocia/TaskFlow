<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Tarefa</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <h1>Adicionar Tarefa</h1>

            <form action="{{ route('tarefas.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="data_cadastro">Data do Cadastro</label>
                    <input type="text" class="form-control" id="data_cadastro" name="data_cadastro" value="{{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}" readonly>
                </div>

                <div class="input-field">
                    <textarea name="descricao" id="descricao" class="materialize-textarea">{{ old('descricao') }}</textarea>
                    <label for="descricao">Descrição</label>
                    @error('descricao')
                    <span class="red-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-field">
                    <select name="responsavel_id" required>
                        <option value="resp" disabled selected>Selecione o Responsável</option>
                        @foreach($colaboradores as $colaborador)
                        <option value="{{ $colaborador->id }}" {{ old('responsavel_id') == $colaborador->id ? 'selected' : '' }}>{{ $colaborador->nome }}</option>
                        @endforeach
                    </select>
                    <label>Responsável</label>

                    @error('responsavel_id')
                    <span class="red-text">{{ $message }}</span>
                    @enderror
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
                        <option value="prioridade" disabled selected>Selecione a Prioridade</option>
                        <option value="Alta" {{ old('prioridade') == 'Alta' ? 'selected' : '' }}>Alta</option>
                        <option value="Média" {{ old('prioridade') == 'Média' ? 'selected' : '' }}>Média</option>
                        <option value="Baixa" {{ old('prioridade') == 'Baixa' ? 'selected' : '' }}>Baixa</option>
                    </select>
                    <label>Prioridade</label>
                    @error('prioridade')
                    <span class="red-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="data_hora_execucao">Data/Hora da Conslusão</label>
                    <input type="datetime-local" name="data_executada"
                        value="{{ old('data_executada', $tarefa->data_executada ?? '') }}">
                </div>

                <button type="submit" class="btn">Adicionar</button>
                <a href="{{ route('tarefas.index') }}" class="btn waves-effect waves-light red">Voltar</a>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <script>
        $(document).ready(function() {
            $('select').formSelect();
        });

        function updateClock() {
            var now = new Date();
            var day = String(now.getDate()).padStart(2, '0');
            var month = String(now.getMonth() + 1).padStart(2, '0');
            var year = now.getFullYear();
            var hours = String(now.getHours()).padStart(2, '0');
            var minutes = String(now.getMinutes()).padStart(2, '0');
            var seconds = String(now.getSeconds()).padStart(2, '0');

            var timeString = day + '/' + month + '/' + year + ' ' + hours + ':' + minutes + ':' + seconds;
            document.getElementById('data_cadastro').value = timeString;
        }

        setInterval(updateClock, 1000); // Atualiza a cada 1 segundo
    </script>
</body>

</html>