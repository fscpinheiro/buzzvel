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
5. Execute `docker exec setup-php php artisan migrate` para executar as migrações do banco de dados.

## Uso

A API possui os seguintes endpoints:

- `POST /api/holiday-plans`: Cria um novo plano de férias.
- `GET /api/holiday-plans`: Recupera todos os planos de férias.
- `GET /api/holiday-plans/{id}`: Recupera um plano de férias específico pelo ID.
- `PUT /api/holiday-plans/{id}`: Atualiza um plano de férias existente.
- `DELETE /api/holiday-plans/{id}`: Deleta um plano de férias.
- `POST /api/holiday-plans/{id}/pdf`: Gera um PDF para um plano de férias específico.

## Testes

Para executar os testes unitários, execute o seguinte comando:

```bash
docker exec setup-php vendor/bin/phpunit