# Rango Tech

API REST para gerenciamento de pratos (Dishes) desenvolvida com Symfony.

## Requisitos

- **PHP** 8.2+
- **Composer**
- **Docker** e **Docker Compose** (necessário para o banco de dados PostgreSQL)
- **Symfony CLI** (opcional, recomendado para rodar o servidor)

## Como rodar o projeto

⚙️ Setup do Projeto
1️⃣ Clonar o repositório
git clone <repo-url>
cd nome-do-projeto
2️⃣ Criar o arquivo .env

Copiar o arquivo de exemplo:

cp .env.example .env

Editar as variáveis necessárias:

DATABASE_URL=
APP_SECRET=
JWT_PASSPHRASE=
3️⃣ Instalar dependências
composer install
4️⃣ Subir containers Docker
docker compose up -d
5️⃣ Rodar migrations
php bin/console doctrine:migrations:migrate
🔐 Configuração do JWT
Gerar chaves
php bin/console lexik:jwt:generate-keypair

Isso irá criar:

config/jwt/private.pem
config/jwt/public.pem

⚠ Obrigatório para funcionamento do login.

⚠ Windows (se houver erro de OpenSSL)

Caso ocorra erro ao gerar as chaves:

$env:OPENSSL_CONF="C:\php\extras\ssl\openssl.cnf"

Depois execute novamente:

php bin/console lexik:jwt:generate-keypair
▶ Rodando o Projeto

Opção 1 – Symfony CLI:

symfony serve

Opção 2 – PHP embutido:

php -S localhost:8000 -t public
👤 Criar Usuário

Você pode:

Criar via endpoint de registro

Criar via fixture

Inserir direto no banco

🔑 Autenticação
Login

POST

/api/login_check

Body:

{
  "username": "admin@example.com",
  "password": "123456"
}

Resposta:

{
  "token": "JWT_TOKEN"
}
🔒 Acessando Rotas Protegidas

Adicionar no header:

Authorization: Bearer JWT_TOKEN
📬 Coleções Postman

Collection 1:

https://sousa-leo-alves-5120902.postman.co/...

Collection 2:

https://sousa-leo-alves-5120902.postman.co/...