# Worklog

## Objetivo atual
Dockerizar o sistema legado SESACRE (vanilla PHP + PostgreSQL) e fazê-lo rodar completamente com PHP 8.1, sem warnings no console do dashboard.

## Estado atual

### O que já foi feito (sessão anterior)
- Dockerfile (PHP 8.1 Apache + pdo_pgsql, zip, mbstring, gd, composer 2)
- docker-compose.yml (app:8080, db:5432/5433, healthcheck, init+seed scripts)
- Removido `version: '3.8'` obsoleto do docker-compose.yml
- .env / .env.example com DB_HOST, DB_PORT, DB_NAME, DB_USER, DB_PASSWORD
- .dockerignore
- docker/php/php.ini (timezone, limites, debug, output_buffering=On, ~E_DEPRECATED)
- docker/apache/sesacre.conf (VirtualHost)
- .htaccess (rewrite rules, assets bypass)
- config/conexao.class.php: lê de getenv()
- docker/postgres/init.sql: schema com ~40 tabelas (ses_*, rec_*, fin_*)
- docker/postgres/seed.sql: 41 perfis, admin user (admin@ac.gov.br / admin123)
- tools/gerar-senha.php: script para gerar hash bcrypt
- README.md e PLANO.md
- class/util/Metodos.class.php: corrigido `{}` → `[]` (PHP 8.1)
- Login funcional e dashboard carregando

### O que foi feito (sessão atual - 2026-05-14)
1. **mPDF atualizado** 7.0.3 → 8.3.1 (compatível PHP 8.1)
2. **PHP 8.1 compatibilidade**: scan — nenhuma quebra adicional
3. **DataTables warnings corrigidos**: 5 endpoints retornam `[]` em vez de erros SQL
4. **Schema completo gerado (40 → 224 tabelas)**:
   - Script `tools/gen_schema.php` extrai colunas de 206 classes modelo
   - Gera CREATE TABLE com tipos inferidos dos nomes das colunas
   - Adicionadas manualmente ~20 tabelas sem modelo (gco_*, fin_vigencia, ses_telefone, etc.)
   - init.sql expandido de 433 linhas para 2169 linhas
   - Container rebuild do zero (`docker compose down -v && up`)
   - Dashboard: 5 endpoints retornam JSON válido (sem dados ainda)

## Próximos passos
- Limpar/otimizar gen_schema.php (algumas colunas com nomes genéricos)
- Popular tabelas-base (órgãos, fornecedores, classificações contábeis)

## Pendências
- Algumas colunas podem ter tipos incorretos (gen_schema.php usa heurística)
- DaoSesPessoaJuridica retorna string em vez de array quando vazio (pre-existing, não-blocante)

## Decisões
- 2026-05-14: `~E_DEPRECATED` no php.ini suficiente para warnings `trim(null)`
- 2026-05-14: Dashboard endpoints retornam `[]` em vez de recriar schema
- 2026-05-14: mPDF 8.3.1 (compatível PHP 8.1)
- 2026-05-14: Schema gerado de 206 classes modelo + INSERTs dos DAOs

## Histórico recente
- 2026-05-14: mPDF atualizado 7.0.3→8.3.1
- 2026-05-14: 5 endpoints dashboard corrigidos
- 2026-05-14: WORKLOG.md criado
- 2026-05-14: Schema 40→224 tabelas gerado e aplicado
- 2026-05-14: Dashboard endpoints retornando JSON (válido, vazio)
- 2026-05-14: Testes de 8 módulos concluídos — HTTP 200 em todos, sem PHP errors/fatal
