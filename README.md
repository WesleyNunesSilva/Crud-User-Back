
# GOVE

CRUD de Usuários desenvolvido em Laravel utilizando Docker, PostgreSQL e Laravel Sail para Linux e Mac.

## Requisitos

Certifique-se de ter as seguintes ferramentas instaladas em sua máquina:

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)
- [Composer](https://getcomposer.org/download/)
- [PHP](https://www.php.net/downloads.php) (versão compatível com o Laravel)

## Instalação

Siga os passos abaixo para configurar o projeto em sua máquina:

### 1. Clone o repositório

```bash
git clone git@github.com:WesleyNunesSilva/Crud-User-Back.git
cd Crud-User-Back
```

### 2. Instale as dependências do Composer

```bash
composer install
```

### 3. Copie o arquivo `.env.example` para `.env`

```bash
cp .env.example .env
```

### 4. Gere a chave de aplicação

```bash
php artisan key:generate
```

### 5. Suba os contêineres do Docker usando o Laravel Sail

```bash
./vendor/bin/sail up -d
```

Isso vai subir os contêineres do Docker com PHP, MySQL e outros serviços.

### 6. Execute as migrações do banco de dados

```bash
./vendor/bin/sail artisan migrate
```

### 7.  Rode os seeders

```bash
./vendor/bin/sail artisan db:seed
```

### 8.  Link do projeto

```bash
http://localhost
```
