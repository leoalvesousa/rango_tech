# Rango Tech

API REST para gerenciamento de pratos (Dishes) desenvolvida com Symfony.

## Requisitos

- **PHP** 8.2+
- **Composer**
- **Docker** e **Docker Compose** (necessário para o banco de dados PostgreSQL)
- **Symfony CLI** (opcional, recomendado para rodar o servidor)

## Como rodar o projeto

### 1. Instalar dependências

```bash
composer install
```

### 2. Subir o banco de dados com Docker

É necessário ter o **Docker** instalado e em execução.

```bash
docker compose up -d
```

Isso irá subir o container do PostgreSQL na porta 5432.

### 3. Configurar variáveis de ambiente

Copie o arquivo `.env` de exemplo e configure as variáveis de conexão com o banco:

```bash
cp .env .env.local
```

Edite o `.env.local` e ajuste as credenciais do PostgreSQL, se necessário:

- `DATABASE_URL="postgresql://app:!ChangeMe!@127.0.0.1:5432/app?serverVersion=16&charset=utf8"`

### 4. Executar as migrations

```bash
php bin/console doctrine:migrations:migrate
```

### 5. Iniciar o servidor Symfony

```bash
symfony serve
```

O servidor ficará disponível em `http://localhost:8000` (ou outra porta exibida no terminal).

---

## Coleção Postman

Para facilitar os testes da API, foi incluída uma coleção Postman com todas as rotas.

**[Acessar coleção no Postman](https://sousa-leo-alves-5120902.postman.co/workspace/Leonardo-Sousa's-Workspace~9ec091c2-9277-432c-832a-73cbe4f7b364/collection/49270181-12fcc1ef-4da3-4237-ab12-6a1b52d8e7c2?action=share&source=copy-link&creator=49270181)**

**Ou importar o arquivo local:**

1. Abra o Postman
2. Clique em **Import** e selecione o arquivo `postman_collection.json` na raiz do projeto
3. Ou arraste o arquivo para dentro do Postman

**Variável de ambiente sugerida:**

- `base_url`: `http://localhost:8000/api` (ajuste a porta se o `symfony serve` usar outra)

---

## Autenticação (Login)

A API usa **JWT** para autenticação. Para acessar as rotas protegidas (pratos, listar/editar usuários etc.), é necessário primeiro criar um usuário e depois fazer login para obter o token.

### 1. Criar usuário (POST /users)

Crie um usuário enviando um `POST` para `/users` com o corpo em JSON:

```bash
POST http://localhost:8000/users
Content-Type: application/json

{
  "email": "seu@email.com",
  "password": "SuaSenha123!"
}
```

**Requisitos da senha:** mínimo 8 caracteres, pelo menos uma letra maiúscula, uma minúscula, um número e um caractere especial.

**Resposta (201):**
```json
{
  "message": "User created successfully!"
}
```

### 2. Fazer login (POST /users_login)

Envie um `POST` para `/users_login` com o mesmo `email` e `password` do usuário criado:

```bash
POST http://localhost:8000/users_login
Content-Type: application/json

{
  "username": "seu@email.com",
  "password": "SuaSenha123!"
}
```

**Importante:** o campo no JSON é `username`, mas o valor deve ser o **email** do usuário.

**Resposta (200):** a API retorna um token JWT no corpo, por exemplo:

```json
{
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9..."
}
```

### 3. Usar o token nas requisições

Inclua o token no cabeçalho `Authorization` de todas as requisições às rotas protegidas:

```
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...
```

No Postman: em **Authorization** → Type: **Bearer Token** → cole o valor do `token` retornado no login.

---

## Rotas da API

| Método | Endpoint      | Descrição              |
|--------|---------------|------------------------|
| POST   | `/users`      | Criar usuário (público) |
| POST   | `/users_login` | Login (obter JWT)     |
| GET    | `/api/dish`   | Listar todos os pratos |
| POST   | `/api/dish`   | Criar novo prato       |
| GET    | `/api/dish/{id}` | Buscar prato por ID |
| PUT    | `/api/dish/{id}` | Atualizar prato     |
| DELETE | `/api/dish/{id}` | Excluir prato      |

### Exemplo de criação (POST /api/dish)

```json
{
  "name": "Feijoada",
  "description": "Feijoada completa com farofa e couve",
  "price": 35.90,
  "category": "Prato Principal"
}
```
