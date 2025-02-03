<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tarefas</title>

    <link rel="stylesheet" href="{{ asset('css/pagination.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
</head>

<body>
    <div class="container">
        <h1>Lista de Tarefas</h1>

        <a href="{{ route('tarefas.create') }}" class="btn btn-green mb-3">Adicionar Tarefa</a>

        <form method="GET" action="{{ route('tarefas.index') }}">
            <div class="input-field">
                <select name="prioridade">
                    <option value="">Todas as Prioridades</option>
                    <option value="Baixa" {{ request('prioridade') == 'Baixa' ? 'selected' : '' }}>Baixa</option>
                    <option value="Média" {{ request('prioridade') == 'Média' ? 'selected' : '' }}>Média</option>
                    <option value="Alta" {{ request('prioridade') == 'Alta' ? 'selected' : '' }}>Alta</option>
                </select>
                <label>Prioridade</label>
            </div>

            <div class="input-field">
                <select name="responsavel_id">
                    <option value="">Todos os Responsáveis</option>
                    @foreach($colaboradores as $colaborador)
                    <option value="{{ $colaborador->id }}" {{ request('responsavel_id') == $colaborador->id ? 'selected' : '' }}>
                        {{ $colaborador->nome }}
                    </option>
                    @endforeach
                </select>
                <label>Responsável</label>
            </div>

            <div class="input-field">
                <input type="date" name="prazo_limitado" value="{{ request('prazo_limitado') ? request('prazo_limitado') : '' }}">
                <label>Prazo Limite</label>
            </div>


            <button type="submit" class="btn">Filtrar</button>
        </form>


        <table class="table table-striped table-fixed">
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Responsável</th>
                    <th>Prazo Limite</th>
                    <th>Prioridade</th>
                    <th>Data/Hora Executada</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tarefas as $tarefa)
                <tr>
                    <td>{{ $tarefa->descricao }}</td>
                    <td>{{ $tarefa->colaborador->nome }}</td>
                    <td>{{ $tarefa->prazo_limitado }}</td>
                    <td>{{ $tarefa->prioridade }}</td>
                    <td>
                        @if($tarefa->data_executada)
                        {{ \Carbon\Carbon::parse($tarefa->data_executada)->format('d/m/Y H:i') }}
                        @else
                        <span class="text-muted">Ainda não concluída</span>
                        @endif
                    </td>
                    <td>
                        @if($tarefa->data_executada)
                        <button class="btn-small green" disabled>Concluída</button>
                        <a href="{{ route('tarefas.edit', $tarefa->id) }}" class="btn-small orange" disabled>Editar</a>
                        <form action="{{ route('tarefas.destroy', $tarefa->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-small red" disabled>Excluir</button>
                        </form>
                        @else
                        <form action="{{ route('tarefas.concluir', $tarefa->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn-small green">Concluir</button>
                        </form>
                        <a href="{{ route('tarefas.edit', $tarefa->id) }}" class="btn-small orange">Editar</a>
                        <form action="{{ route('tarefas.destroy', $tarefa->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-small red">Excluir</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center mt-4">
            <ul class="pagination pagination-rounded">
                @if ($tarefas->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">Anterior</span>
                </li>
                @else
                <li class="page-item">
                    <a class="page-link" href="{{ $tarefas->previousPageUrl() . '&prioridade=' . request('prioridade') . '&responsavel_id=' . request('responsavel_id') . '&prazo_limitado=' . request('prazo_limitado') }}">Anterior</a>
                </li>
                @endif

                @foreach ($tarefas->getUrlRange(1, $tarefas->lastPage()) as $page => $url)
                @if ($page == $tarefas->currentPage())
                <li class="page-item active" aria-current="page">
                    <span class="page-link">{{ $page }}</span>
                </li>
                @else
                <li class="page-item">
                    <a class="page-link" href="{{ $url . '&prioridade=' . request('prioridade') . '&responsavel_id=' . request('responsavel_id') . '&prazo_limitado=' . request('prazo_limitado') }}">{{ $page }}</a>
                </li>
                @endif
                @endforeach

                @if ($tarefas->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $tarefas->nextPageUrl() . '&prioridade=' . request('prioridade') . '&responsavel_id=' . request('responsavel_id') . '&prazo_limitado=' . request('prazo_limitado') }}">Próxima</a>
                </li>
                @else
                <li class="page-item disabled">
                    <span class="page-link">Próxima</span>
                </li>
                @endif
            </ul>
        </div>


        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var elems = document.querySelectorAll('select');
                M.FormSelect.init(elems);
            });
        </script>
</body>

</html>