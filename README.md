# BUZZVEL TESTE

## Descrição

Este projeto é uma API RESTful construída com Laravel para gerenciar planos de férias para o ano de 2024. A API permite que os usuários realizem operações CRUD (Criar, Ler, Atualizar, Deletar) em planos de férias.

## Requisitos

- Docker
- Composer
- PHP 8.0 ou superior
- MySQL 8.0 ou superior

## Configuração

1. Clone o repositório para a sua máquina local.
2. Navegue até o diretório do projeto.
3. Execute `docker-compose up -d --build` para iniciar os serviços.
4. Execute `docker exec setup-php composer install` para instalar as dependências do projeto.
5. Execute `docker exec setup-php php artisan migrate:fresh --seed` para executar as migrações e popular o banco com dados.
6. Execute `docker exec setup-php php artisan passport:install` para configurar o Passport.

## Uso

A API possui os seguintes endpoints:

- `POST /api/v1/login`: Realiza o login e obtem o token para fazer as demais operações.
- `POST /api/v1/logout`: Realiza o logout do usuario na aplicação.
- `POST /api/v1/holiday-plans`: Cria um novo plano de férias.
- `GET /api/v1/holiday-plans`: Recupera todos os planos de férias.
- `GET /api/v1/holiday-plans/{id}`: Recupera um plano de férias específico pelo ID.
- `PUT /api/v1/holiday-plans/{id}`: Atualiza um plano de férias existente.
- `DELETE /api/v1/holiday-plans/{id}`: Deleta um plano de férias.
- `POST /api/v1/holiday-plans/{id}/pdf`: Gera um PDF para um plano de férias específico.

## Instruções 

Se você fez o comando `php artisan migrate:fresh --seed`, poderá utilizar o usuário definido dentro de UsersTableSeeder.php
O usuário por padrão para os testes é `fscpinheiro@gmail.com` e a senha `12345678`.

a. Com exceção de login, todas as APIS devem ter no Headers a key: `Authorization` com o value: `Bearer <token>`.
b. Apis POST e PUT devem ter a key: `Content-type` e value: `application/json`.
c. Para o metodo store e update o body deve ser json, por exemplo:
```bash
{
    "title": "Férias no Litoral",
    "description": "blaskdh kjashd as k jasdhakshdkajshdka",
    "date": "2025-10-01",
    "location": "Brasil",
    "participants": "Família"
}
```

## Testes

Para executar os testes unitários, execute o seguinte comando:

```bash
php artisan test tests/Feature/Unit/Controller/HolidayPlanControllerTest.php