# TaskFlow - Configuração do Ambiente

## Pré-requisitos

1. Baixar e instalar o Docker na máquina: [Docker Download](https://app.docker.com)
2. Clonar o projeto:
   ```sh
   git clone https://github.com/mariaRocia/TaskFlow.git
   ```

## Configuração e Execução

### 1. Subindo o ambiente com Docker

Após instalar o Docker e clonar o repositório, abra o terminal e execute o seguinte comando na raiz do projeto:

```sh
docker compose up -d --build
```

Esse comando será responsável por:
- Instalar o PHP, Composer, MySQL e as dependências do projeto.
- Criar e iniciar os containers necessários.
- Configurar o ambiente de execução do Laravel.

### 2. Tempo de Configuração

Na primeira execução, pode haver um tempo maior de espera, pois todas as configurações e instalações serão realizadas.

Após a criação das imagens, o terminal exibirá mensagens como estas:

```sh
✔ Service app                Built                                                                 
✔ Network taskflow_default   Created                                                              
✔ Volume "taskflow_db_data"  Created                                                              
✔ Container laravel_app      Started                                                              
✔ Container mysql_db         Started
```

### 3. Verificação das Instalações

Para acompanhar os logs da aplicação e verificar se tudo foi instalado corretamente, execute:

```sh
docker logs -f laravel_app 
```

Isso mostrará informações como:

#### **Instalando dependências**
```sh
Installing dependencies from lock file (including require-dev)
Verifying lock file contents can be installed on current platform.
Nothing to install, update or remove
Generating optimized autoload files
```

#### **Gerando a migration**
```sh
INFO  Discovering packages.
```

#### **Projeto Ativo**
```sh
INFO  Server running on [http://0.0.0.0:8000].
```

### 4. Acesso ao Projeto

Após a finalização da configuração, o site estará disponível em:

```
http://localhost:8000
