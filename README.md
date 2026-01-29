# rango_tech

Projeto Symfony 7.4 (PHP >= 8.2).

## Subir localmente (Git Bash)

### 1) Instalar dependências PHP

```bash
cd /c/Projetos/rango_tech
composer install
```

### 2) Subir o Postgres com Docker

```bash
docker compose up -d
```

### 3) Criar estrutura do banco (se houver migrations)

```bash
php bin/console doctrine:migrations:migrate
```

### 4) Subir o servidor

- Com Symfony CLI:

```bash
symfony serve --no-tls
```

- Alternativa (sem Symfony CLI):

```bash
php -S 127.0.0.1:8000 -t public
```

Abra `http://127.0.0.1:8000/` (rota `home`).

