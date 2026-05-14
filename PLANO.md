# PLANO DE IMPLEMENTAÇÃO — SESACRE Legado

## Objetivo
Fazer o sistema legado SESACRE rodar em containers Docker com PostgreSQL.

## Estrutura de Arquivos

```
sesacre-legado/
├── Dockerfile
├── docker-compose.yml
├── .env / .env.example
├── .dockerignore
├── composer.json
├── .htaccess
├── docker/
│   ├── php/php.ini
│   ├── apache/sesacre.conf
│   └── postgres/
│       ├── init.sql      # Schema do banco
│       └── seed.sql      # Dados iniciais
├── tools/
│   └── gerar-senha.php   # Gera hash da senha admin
├── README.md
|-- PLANO.md (este arquivo)
└── config/
    └── conexao.class.php  # (editado para env vars)
```

## Fases

### Fase A — Infraestrutura Docker
- Dockerfile (PHP 8.1 Apache + pdo_pgsql)
- docker-compose.yml (app + db PostgreSQL 13)
- .env / .env.example
- .dockerignore

### Fase B — Configuração PHP
- docker/php/php.ini
- composer.json (raiz)
- docker/apache/sesacre.conf
- .htaccess

### Fase C — Adaptação do Código
- config/conexao.class.php (env vars)

### Fase D — Schema do Banco
- docker/postgres/init.sql (~30 tabelas core)
- docker/postgres/seed.sql (dados iniciais)

### Fase E — Ferramentas e Docs
- tools/gerar-senha.php
- README.md

### Fase F — Build e Teste
- docker compose build
- docker compose up -d
- Verificar login
