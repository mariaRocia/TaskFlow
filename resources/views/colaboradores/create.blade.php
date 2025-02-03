<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Colaborador</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <div class="container">
        <h1>Adicionar Colaborador</h1>

        <form action="{{ route('colaboradores.store') }}" method="POST">
            @csrf
            <div class="input-field">
                <input type="text" name="nome" id="nome" value="{{ old('nome', $colaborador->nome ?? '') }}" required>
                <label for="nome">Nome</label>
                @error('nome')
                <span class="red-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-field">
                <input type="text" name="cpf" id="cpf" value="{{ old('cpf', $colaborador->cpf ?? '') }}" required>
                <label for="cpf">CPF</label>
                @error('cpf')
                <span class="red-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-field">
                <input type="email" name="email" id="email" value="{{ old('email', $colaborador->email ?? '') }}" required>
                <label for="email">E-mail</label>
                @error('email')
                <span class="red-text">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn waves-effect waves-light">Cadastrar</button>
            <a href="{{ route('colaboradores.index') }}" class="btn waves-effect waves-light red">Voltar</a>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            M.updateTextFields();

            // Fechar mensagem de sucesso após 3 segundos
            setTimeout(function() {
                let successMessage = document.getElementById("success-message");
                if (successMessage) {
                    successMessage.style.display = "none";
                }
            }, 3000);

            // Máscara para CPF
            document.getElementById('cpf').addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, ''); // Remove caracteres não numéricos
                if (value.length > 11) value = value.slice(0, 11);

                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');

                e.target.value = value;
            });
        });
    </script>
</body>

</html>