-- =============================================
-- SESACRE Seed Data
-- =============================================

-- Sistema
INSERT INTO ses_sistema (id_sistema, nm_sistema, st_ativo)
VALUES (1, 'SESACRE', 1);

-- Perfis (conforme config/perfil.php)
INSERT INTO ses_perfil (id_perfil, id_sistema, nm_perfil, st_ativo) VALUES
    (1,  1, 'TI',                              1),
    (2,  1, 'ZEUS',                            1),
    (3,  1, 'FINANCEIRO',                      1),
    (4,  1, 'PLANEJAMENTO',                    1),
    (5,  1, 'FINANCEIRO_ZEUS',                 1),
    (6,  1, 'PLANEJAMENTO_ZEUS',               1),
    (7,  1, 'PLANEJAMENTO_USUARIO',            1),
    (8,  1, 'FINANCEIRO_USUARIO',              1),
    (9,  1, 'RH',                              1),
    (10, 1, 'RH_ZEUS',                         1),
    (11, 1, 'RH_USUARIO',                      1),
    (12, 1, 'CONTRATOS_USUARIO',               1),
    (13, 1, 'COMPRAS_USUARIO',                 1),
    (14, 1, 'PLANEJAMENTO_CENTRAL_DEMANDA',    1),
    (15, 1, 'PLANEJAMENTO_SEC_ADJ_PLA_GESTAO', 1),
    (16, 1, 'PLANEJAMENTO_SEC_ADJ_ADM_FINAN',  1),
    (17, 1, 'PLANEJAMENTO_SEC_ADJ_ATE_SAUDE',  1),
    (18, 1, 'PLANEJAMENTO_SEC_GERAL',          1),
    (19, 1, 'PLANEJAMENTO_CONSELHO',           1),
    (20, 1, 'COMPRAS_TECNICO',                 1),
    (21, 1, 'COMPRAS_ADMINISTRADOR',           1),
    (22, 1, 'CONTRATOS_TECNICO',               1),
    (23, 1, 'CONTRATOS_ADMINISTRADOR',         1),
    (24, 1, 'FINANCEIRO_CENTRAL',              1),
    (25, 1, 'DIARIA_SOLICITACAO',              1),
    (26, 1, 'DIARIA_AUTORIZACAO',              1),
    (27, 1, 'DIARIA_PERMISSAO',                1),
    (28, 1, 'DIARIA_ZEUS',                     1),
    (29, 1, 'FINANCEIRO_SOLICITACAO',          1),
    (30, 1, 'FINANCEIRO_AUTORIZACAO',          1),
    (31, 1, 'FINANCEIRO_ORDEM',                1),
    (32, 1, 'FINANCEIRO_GDOF',                 1),
    (33, 1, 'FINANCEIRO_PAGAMENTO',            1),
    (34, 1, 'FINANCEIRO_ADMINISTRACAO',        1),
    (35, 1, 'CONTABIL_LIQUIDACAO',             1),
    (36, 1, 'CONTABIL_PAGAMENTO',              1),
    (37, 1, 'CONTABIL_ADMINISTRACAO',          1),
    (38, 1, 'CONTABIL_ZEUS',                   1),
    (39, 1, 'CONTABIL_EMPENHO_ANULACAO',       1),
    (40, 1, 'CONTABIL_EMPENHO',                1),
    (41, 1, 'ADMINISTRACAO_ORDEM_ADMINISTRADOR',1);

-- Admin user (senha: admin123)
INSERT INTO ses_pessoa (id_pessoa, nm_pessoa, nm_email, nm_senha, st_ativo)
VALUES (1, 'Administrador', 'admin@ac.gov.br', '$2b$12$T8y7Pd2FAsemDUukFz0IB.0H1.IIzRwJGk5Vf7UKNFSEMQ15MDHvO', 1);

-- Atribuir admin a todos os perfis
INSERT INTO ses_perfil_pessoa (id_perfil_pessoa, id_perfil, id_pessoa)
SELECT generate_series(1, 41), generate_series(1, 41), 1;
