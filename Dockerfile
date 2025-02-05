FROM php:8.1

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    unzip \
    curl \
    && docker-php-ext-install pdo_mysql

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Criar diretório de trabalho
WORKDIR /var/www/html

# Copiar arquivos do projeto
COPY . .

# Baixar wait-for-it.sh e torná-lo executável
RUN curl -o /usr/local/bin/wait-for-it.sh https://raw.githubusercontent.com/vishnubob/wait-for-it/master/wait-for-it.sh \
    && chmod +x /usr/local/bin/wait-for-it.sh

# Definir comando de inicialização
CMD ["sh", "-c", "wait-for-it.sh db:3306 --timeout=30 --strict -- && composer install && php artisan migrate && php artisan serve --host=0.0.0.0 --port=8000"]
