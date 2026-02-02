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

## Rotas da API

| Método | Endpoint      | Descrição              |
|--------|---------------|------------------------|
| POST   | `/api/dish`   | Criar novo prato       |
| GET    | `/api/dish`   | Listar todos os pratos |
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
