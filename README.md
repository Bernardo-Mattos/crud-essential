# Como rodar este projeto

CRUD de clientes em Laravel: cadastro, edição e exclusão de clientes, com upload de foto,
listagem em tabela com busca/ordenação/paginação e notificações de sucesso/erro.

## Requisitos

- PHP 8.3 ou superior
- Composer
- Node.js 20+ (com npm)

Não é necessário instalar MySQL, Postgres ou qualquer banco externo — o projeto já vem
configurado para usar **SQLite**, com o banco incluído no repositório.

## Passo a passo

Execute os comandos abaixo, na raiz do projeto, nesta ordem:

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link
npm install
npm run build
php artisan serve
```

O que cada passo faz:

1. `composer install` — instala as dependências PHP.
2. `cp .env.example .env` — cria o arquivo de configuração local.
3. `php artisan key:generate` — gera a chave de criptografia da aplicação.
4. `php artisan migrate` — aplica as migrations no banco SQLite.
5. `php artisan storage:link` — cria o link `public/storage`, necessário para as fotos de
   clientes aparecerem (sem esse passo, o upload funciona mas a imagem não é exibida).
6. `npm install` — instala as dependências de front-end (Tailwind CSS, DataTables, jQuery).
7. `npm run build` — compila o CSS/JS.
8. `php artisan serve` — sobe o servidor local.

## Acessando

Abra **http://localhost:8000** no navegador. Não há tela de login — a URL raiz já leva direto
para a listagem de clientes.

## Rodando os testes automatizados (opcional)

```bash
php artisan test
```
