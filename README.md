# SESACRE Legado

Sistema Integrado de Gestão da Secretaria Estadual de Saúde do Acre.

## Stack

- PHP 8.1 + Apache
- PostgreSQL 13
- Docker + Docker Compose

## Pré-requisitos

- Docker 20.10+
- Docker Compose 1.29+

## Setup rápido

```bash
# 1. Configure as variáveis de ambiente
cp .env.example .env

# 2. Suba os containers
docker compose up -d

# 3. Gere a senha do admin
docker compose exec app php tools/gerar-senha.php

# Copie o hash gerado e atualize no banco:
docker compose exec db psql -U postgres -d sesacre \
  -c "UPDATE ses_pessoa SET nm_senha = '<hash>' WHERE id_pessoa = 1;"

# 4. Acesse
http://localhost:8080
Login: admin@ac.gov.br / 123456
```

## Docker Compose Services

| Serviço | Porta | Descrição |
|---------|-------|-----------|
| `app`   | 8080  | PHP 8.1 Apache |
| `db`    | 5432  | PostgreSQL 13 |

## Comandos úteis

```bash
# Logs do app
docker compose logs -f app

# Acessar o banco
docker compose exec db psql -U postgres -d sesacre

# Acessar o container do app
docker compose exec app bash

# Parar tudo
docker compose down

# Parar e remover volumes (destrói dados do banco)
docker compose down -v
```

## Estrutura de diretórios

```
├── class/           # Modelos, DAOs, lógica de negócio
├── model/           # Loaders e handlers AJAX
├── pages/           # Views PHP
├── layout/          # Header, footer, menus
├── config/          # Configurações, strings, perfis
├── assets/          # CSS, JS, imagens, libs
├── docker/          # Docker configs
│   ├── apache/      # VirtualHost
│   ├── php/         # php.ini
│   └── postgres/    # init.sql, seed.sql
└── tools/           # Scripts auxiliares
```

## Troubleshooting

**Erro "SessaoExpirada" no login:**
Verifique se o banco foi populado corretamente:
```bash
docker compose exec db psql -U postgres -d sesacre \
  -c "SELECT id_pessoa, nm_email, length(nm_senha) as senha_len FROM ses_pessoa;"
```

**Erro de conexão com banco:**
```bash
docker compose logs db
docker compose exec app php -r "new PDO('pgsql:host=db;port=5432;dbname=sesacre', 'postgres', 'postgres'); echo 'OK\n';"
```

**Permissão negada em assets:**
```bash
docker compose exec app chmod -R 755 assets/
```
