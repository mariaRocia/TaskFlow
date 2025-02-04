<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Colaboradores</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 bg-light p-3 vh-100">
                <h4>Menu</h4>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tarefas.index') }}">Tarefas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('colaboradores.index') }}">Colaboradores</a>
                    </li>
                </ul>
            </div>

            <div class="col-md-9 col-lg-10 p-4">
                <h1>Colaboradores</h1>
                <a href="{{ route('colaboradores.create') }}" class="btn waves-effect waves-light">Adicionar Colaborador</a>
                <table class="table table-striped table-fixed">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>E-mail</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($colaboradores as $colaborador)
                        <tr>
                            <td>{{ $colaborador->nome }}</td>
                            <td>{{ $colaborador->cpf }}</td>
                            <td>{{ $colaborador->email }}</td>
                            <td>
                                <a href="{{ route('colaboradores.edit', $colaborador->id) }}" class="btn-small orange">Editar</a>
                                <form action="{{ route('colaboradores.destroy', $colaborador->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-small red">Excluir</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-4">
                    <ul class="pagination pagination-rounded">
                        @if ($colaboradores->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">Anterior</span>
                        </li>
                        @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $colaboradores->previousPageUrl() }}">Anterior</a>
                        </li>
                        @endif

                        @foreach ($colaboradores->getUrlRange(1, $colaboradores->lastPage()) as $page => $url)
                        @if ($page == $colaboradores->currentPage())
                        <li class="page-item active" aria-current="page">
                            <span class="page-link">{{ $page }}</span>
                        </li>
                        @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                        @endif
                        @endforeach

                        @if ($colaboradores->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $colaboradores->nextPageUrl() }}">Próxima</a>
                        </li>
                        @else
                        <li class="page-item disabled">
                            <span class="page-link">Próxima</span>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>