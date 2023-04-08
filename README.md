# Instalar dependências e rodar o projeto

## 1 - Instalar dependências
- composer install
## 2 - Environment
- Criar uma cópia do arquivo .env.example e renomear para .env
## 3 - Rodar migrations
- php artisan migrate
## 4 - Rodar seeder
- php artisan db:seed --class=DatabaseSeeder
## 5 - Rodar o projeto
- php artisan serve
## >> Teste de requisições no arquivo Insomnia_vagas.json
