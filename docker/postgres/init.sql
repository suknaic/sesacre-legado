-- =============================================
-- SESACRE Database Schema
-- PostgreSQL 13
-- Gerado a partir dos DAOs e classes de entidade
-- =============================================

CREATE EXTENSION IF NOT EXISTS unaccent;

-- =============================================
-- LOOKUP TABLES (sem FK)
-- =============================================

CREATE SEQUENCE IF NOT EXISTS ses_pais_id_pais_seq;
CREATE TABLE ses_pais (
    id_pais   INTEGER PRIMARY KEY DEFAULT nextval('ses_pais_id_pais_seq'),
    nm_sigla  VARCHAR(10),
    nm_pais   VARCHAR(255),
    st_ativo  SMALLINT DEFAULT 1
);

CREATE SEQUENCE IF NOT EXISTS ses_estado_id_estado_seq;
CREATE TABLE ses_estado (
    id_estado INTEGER PRIMARY KEY DEFAULT nextval('ses_estado_id_estado_seq'),
    id_pais   INTEGER REFERENCES ses_pais(id_pais),
    nm_sigla  VARCHAR(10),
    nm_estado VARCHAR(255),
    st_ativo  SMALLINT DEFAULT 1
);

CREATE SEQUENCE IF NOT EXISTS ses_cidade_id_cidade_seq;
CREATE TABLE ses_cidade (
    id_cidade         INTEGER PRIMARY KEY DEFAULT nextval('ses_cidade_id_cidade_seq'),
    id_estado         INTEGER REFERENCES ses_estado(id_estado),
    id_regional_saude INTEGER,
    id_regional_geo   INTEGER,
    nm_cidade         VARCHAR(255),
    st_ativo          SMALLINT DEFAULT 1
);

CREATE SEQUENCE IF NOT EXISTS ses_regional_saude_id_regional_saude_seq;
CREATE TABLE ses_regional_saude (
    id_regional_saude INTEGER PRIMARY KEY DEFAULT nextval('ses_regional_saude_id_regional_saude_seq'),
    nm_regional_saude VARCHAR(255),
    st_ativo          SMALLINT DEFAULT 1
);

CREATE SEQUENCE IF NOT EXISTS ses_regional_geo_id_regional_geo_seq;
CREATE TABLE ses_regional_geo (
    id_regional_geo INTEGER PRIMARY KEY DEFAULT nextval('ses_regional_geo_id_regional_geo_seq'),
    nm_regional_geo VARCHAR(255),
    st_ativo        SMALLINT DEFAULT 1
);

CREATE SEQUENCE IF NOT EXISTS ses_escolaridade_id_escolaridade_seq;
CREATE TABLE ses_escolaridade (
    id_escolaridade  INTEGER PRIMARY KEY DEFAULT nextval('ses_escolaridade_id_escolaridade_seq'),
    nm_escolaridade  VARCHAR(255),
    id_pessoa_fisica INTEGER,
    st_ativo         SMALLINT DEFAULT 1
);

CREATE TABLE ses_formacao (
    id_escolaridade_formacao INTEGER PRIMARY KEY,
    nm_escolaridade_formacao VARCHAR(255),
    id_escolaridade          INTEGER,
    st_ativo                 SMALLINT DEFAULT 1
);

CREATE TABLE ses_estado_civil (
    id_estado_civil INTEGER PRIMARY KEY,
    nm_estado_civil VARCHAR(255)
);

CREATE TABLE ses_vinculo (
    id_vinculo INTEGER PRIMARY KEY,
    nm_vinculo VARCHAR(255),
    st_ativo   SMALLINT DEFAULT 1
);

CREATE TABLE ses_tramitacao (
    id_tramitacao INTEGER PRIMARY KEY,
    nm_tramitacao VARCHAR(255),
    st_ativo      SMALLINT DEFAULT 1
);

CREATE TABLE ses_cargo (
    id_cargo INTEGER PRIMARY KEY,
    nm_cargo VARCHAR(255),
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE ses_funcao (
    id_funcao INTEGER PRIMARY KEY,
    nm_funcao VARCHAR(255),
    st_ativo  SMALLINT DEFAULT 1
);

CREATE TABLE ses_competencia (
    id_competencia INTEGER PRIMARY KEY,
    nm_competencia VARCHAR(255)
);

CREATE TABLE ses_lotacao_categoria (
    id_lotacao_categoria INTEGER PRIMARY KEY,
    nm_lotacao_categoria VARCHAR(255)
);

-- =============================================
-- CORE SYSTEM TABLES
-- =============================================

CREATE SEQUENCE IF NOT EXISTS ses_sistema_id_sistema_seq;
CREATE TABLE ses_sistema (
    id_sistema INTEGER PRIMARY KEY DEFAULT nextval('ses_sistema_id_sistema_seq'),
    nm_sistema VARCHAR(255),
    st_ativo   SMALLINT DEFAULT 1
);

CREATE SEQUENCE IF NOT EXISTS ses_perfil_id_perfil_seq;
CREATE TABLE ses_perfil (
    id_perfil  INTEGER PRIMARY KEY DEFAULT nextval('ses_perfil_id_perfil_seq'),
    id_sistema INTEGER REFERENCES ses_sistema(id_sistema),
    nm_perfil  VARCHAR(255),
    st_ativo   SMALLINT DEFAULT 1
);

CREATE SEQUENCE IF NOT EXISTS ses_pessoa_id_pessoa_seq;
CREATE TABLE ses_pessoa (
    id_pessoa               INTEGER PRIMARY KEY DEFAULT nextval('ses_pessoa_id_pessoa_seq'),
    nm_pessoa               VARCHAR(255),
    id_naturalidade         INTEGER REFERENCES ses_cidade(id_cidade),
    ds_logradouro           VARCHAR(255),
    ds_bairro               VARCHAR(255),
    ds_complemento          VARCHAR(255),
    nr_cep                  VARCHAR(20),
    nr_numero               INTEGER,
    id_cidade               INTEGER REFERENCES ses_cidade(id_cidade),
    nr_telefone_residencial VARCHAR(20),
    nr_telefone_celular     VARCHAR(20),
    nm_email                VARCHAR(255),
    nm_senha                VARCHAR(255),
    ds_observacao           TEXT,
    dh_login                TIMESTAMP,
    st_login                SMALLINT DEFAULT 1,
    st_ativo                SMALLINT DEFAULT 1
);
CREATE INDEX idx_ses_pessoa_email ON ses_pessoa(nm_email);

CREATE SEQUENCE IF NOT EXISTS ses_perfil_pessoa_id_perfil_pessoa_seq;
CREATE TABLE ses_perfil_pessoa (
    id_perfil_pessoa INTEGER PRIMARY KEY DEFAULT nextval('ses_perfil_pessoa_id_perfil_pessoa_seq'),
    id_perfil        INTEGER REFERENCES ses_perfil(id_perfil),
    id_pessoa        INTEGER REFERENCES ses_pessoa(id_pessoa)
);

CREATE SEQUENCE IF NOT EXISTS ses_pessoa_fisica_id_pessoa_fisica_seq;
CREATE TABLE ses_pessoa_fisica (
    id_pessoa_fisica         INTEGER PRIMARY KEY DEFAULT nextval('ses_pessoa_fisica_id_pessoa_fisica_seq'),
    id_pessoa                INTEGER REFERENCES ses_pessoa(id_pessoa),
    tp_sexo                  VARCHAR(1),
    nm_civil                 VARCHAR(50),
    nr_cpf                   VARCHAR(14),
    nr_rg                    VARCHAR(20),
    ds_orgao_expedidor       VARCHAR(50),
    id_estado_expedidor      INTEGER REFERENCES ses_estado(id_estado),
    id_estado_civil          INTEGER REFERENCES ses_estado_civil(id_estado_civil),
    id_escolaridade_formacao INTEGER REFERENCES ses_formacao(id_escolaridade_formacao),
    ds_habilidade            TEXT,
    nm_pai                   VARCHAR(255),
    nm_mae                   VARCHAR(255),
    dt_nascimento            DATE,
    nr_cns                   VARCHAR(20),
    lk_foto                  TEXT,
    st_ativo                 SMALLINT DEFAULT 1
);

CREATE TABLE ses_pessoa_juridica (
    id_pessoa_juridica  INTEGER PRIMARY KEY,
    id_pessoa           INTEGER REFERENCES ses_pessoa(id_pessoa),
    nr_cnae             VARCHAR(20),
    nr_cnpj             VARCHAR(18),
    ds_insc_estadual    VARCHAR(20),
    ds_insc_municipal   VARCHAR(20),
    dt_fundacao         DATE,
    id_natureza         INTEGER,
    nm_fantasia         VARCHAR(255),
    nr_safira           VARCHAR(50)
);

CREATE SEQUENCE IF NOT EXISTS ses_lotacao_id_lotacao_seq;
CREATE TABLE ses_lotacao (
    id_lotacao           INTEGER PRIMARY KEY DEFAULT nextval('ses_lotacao_id_lotacao_seq'),
    id_pai               INTEGER REFERENCES ses_lotacao(id_lotacao),
    id_lotacao_categoria INTEGER REFERENCES ses_lotacao_categoria(id_lotacao_categoria),
    nm_lotacao           VARCHAR(255),
    nr_cnpj              VARCHAR(18),
    id_cidade            INTEGER REFERENCES ses_cidade(id_cidade),
    ds_logradouro        VARCHAR(255),
    ds_bairro            VARCHAR(255),
    nr_cep               VARCHAR(20),
    nm_email             VARCHAR(255),
    nr_telefone          VARCHAR(20),
    mp_latitude          VARCHAR(50),
    mp_longitute         VARCHAR(50),
    st_ativo             SMALLINT DEFAULT 1,
    id_pessoa            INTEGER REFERENCES ses_pessoa(id_pessoa),
    id_pessoa_juridica   INTEGER,
    st_principal         SMALLINT DEFAULT 0,
    id_telefone          INTEGER
);

CREATE SEQUENCE IF NOT EXISTS ses_contrato_id_contrato_seq;
CREATE TABLE ses_contrato (
    id_contrato            INTEGER PRIMARY KEY DEFAULT nextval('ses_contrato_id_contrato_seq'),
    nr_matricula           VARCHAR(20),
    dt_admissao            DATE,
    nr_carga_horaria       INTEGER,
    dt_demissao            DATE,
    id_pessoa_fisica       INTEGER REFERENCES ses_pessoa_fisica(id_pessoa_fisica),
    id_vinculo             INTEGER REFERENCES ses_vinculo(id_vinculo),
    id_pessoa_juridica     INTEGER,
    id_cargo               INTEGER REFERENCES ses_cargo(id_cargo),
    st_ativo               SMALLINT DEFAULT 1,
    ds_observacao          TEXT
);

CREATE SEQUENCE IF NOT EXISTS ses_contrato_lotacao_id_contrato_lotacao_seq;
CREATE TABLE ses_contrato_lotacao (
    id_contrato_lotacao   INTEGER PRIMARY KEY DEFAULT nextval('ses_contrato_lotacao_id_contrato_lotacao_seq'),
    id_contrato           INTEGER REFERENCES ses_contrato(id_contrato),
    id_lotacao            INTEGER REFERENCES ses_lotacao(id_lotacao),
    id_funcao             INTEGER REFERENCES ses_funcao(id_funcao),
    carga_horaria_lotacao INTEGER,
    dt_inicio             DATE,
    dt_fim                DATE
);

CREATE SEQUENCE IF NOT EXISTS ses_contrato_historico_id_contrato_historico_seq;
CREATE TABLE ses_contrato_historico (
    id_contrato_historico INTEGER PRIMARY KEY DEFAULT nextval('ses_contrato_historico_id_contrato_historico_seq'),
    id_contrato           INTEGER REFERENCES ses_contrato(id_contrato),
    id_lotacao            INTEGER REFERENCES ses_lotacao(id_lotacao),
    id_funcao             INTEGER REFERENCES ses_funcao(id_funcao),
    dt_historico          TIMESTAMP,
    dt_inicio             DATE,
    dt_fim                DATE
);

CREATE SEQUENCE IF NOT EXISTS ses_contrato_recadastramento_id_contrato_recadastramento_seq;
CREATE TABLE ses_contrato_recadastramento (
    id_contrato_recadastramento  INTEGER PRIMARY KEY DEFAULT nextval('ses_contrato_recadastramento_id_contrato_recadastramento_seq'),
    id_contrato                  INTEGER REFERENCES ses_contrato(id_contrato),
    id_pessoa                    INTEGER REFERENCES ses_pessoa(id_pessoa),
    dh_contrato_recadastramento  TIMESTAMP,
    is_recadastramento           SMALLINT DEFAULT 0,
    aa_recadastramento           INTEGER,
    is_ativo                     SMALLINT DEFAULT 1
);

CREATE SEQUENCE IF NOT EXISTS ses_vincular_tramitacao_id_vincular_tramitacao_seq;
CREATE TABLE ses_vincular_tramitacao (
    id_vincular_tramitacao INTEGER PRIMARY KEY DEFAULT nextval('ses_vincular_tramitacao_id_vincular_tramitacao_seq'),
    id_tramitacao          INTEGER REFERENCES ses_tramitacao(id_tramitacao),
    id_pessoa              INTEGER REFERENCES ses_pessoa(id_pessoa),
    id_lotacao             INTEGER REFERENCES ses_lotacao(id_lotacao),
    id_doc_tipo_lotacao    INTEGER
);

CREATE SEQUENCE IF NOT EXISTS ses_lotacao_detalhe_id_lotacao_detalhe_seq;
CREATE TABLE ses_lotacao_detalhe (
    id_lotacao_detalhe   INTEGER PRIMARY KEY DEFAULT nextval('ses_lotacao_detalhe_id_lotacao_detalhe_seq'),
    id_pai               INTEGER,
    id_lotacao_categoria INTEGER,
    nm_lotacao_detalhe   VARCHAR(255),
    nr_cnpj              VARCHAR(18),
    id_cidade            INTEGER REFERENCES ses_cidade(id_cidade),
    ds_logradouro        VARCHAR(255),
    ds_bairro            VARCHAR(255),
    nr_cep               VARCHAR(20),
    nm_email             VARCHAR(255),
    nr_telefone          VARCHAR(20),
    mp_latitude          VARCHAR(50),
    mp_longitute         VARCHAR(50),
    st_ativo             SMALLINT DEFAULT 1,
    id_pessoa            INTEGER,
    id_pessoa_juridica   INTEGER,
    st_principal         SMALLINT DEFAULT 0,
    id_telefone          INTEGER
);

-- =============================================
-- LOG TABLE
-- =============================================

CREATE SEQUENCE IF NOT EXISTS ses_log_id_log_seq;
CREATE TABLE ses_log (
    id_log             INTEGER PRIMARY KEY DEFAULT nextval('ses_log_id_log_seq'),
    ds_tabela          VARCHAR(255),
    id_tabela_pk       INTEGER,
    tp_log             VARCHAR(1),
    id_pessoa          INTEGER REFERENCES ses_pessoa(id_pessoa),
    ds_ip              VARCHAR(45),
    dh_log             TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ds_campos_atuais   TEXT,
    ds_campos_antigos  TEXT
);
CREATE INDEX idx_ses_log_pessoa ON ses_log(id_pessoa);
CREATE INDEX idx_ses_log_tabela ON ses_log(ds_tabela);

-- =============================================
-- RESOURCE / PERMISSION TABLES (rec_*)
-- =============================================

CREATE SEQUENCE IF NOT EXISTS rec_recurso_id_recurso_seq;
CREATE TABLE rec_recurso (
    id_recurso  INTEGER PRIMARY KEY DEFAULT nextval('rec_recurso_id_recurso_seq'),
    id_sistema  INTEGER REFERENCES ses_sistema(id_sistema),
    nm_recurso  VARCHAR(255),
    lk_recurso  VARCHAR(255),
    ds_recurso  TEXT,
    st_ativo    SMALLINT DEFAULT 1
);

CREATE SEQUENCE IF NOT EXISTS rec_grupo_recurso_id_grupo_recurso_seq;
CREATE TABLE rec_grupo_recurso (
    id_grupo_recurso INTEGER PRIMARY KEY DEFAULT nextval('rec_grupo_recurso_id_grupo_recurso_seq'),
    nm_grupo_recurso VARCHAR(255),
    st_ativo         SMALLINT DEFAULT 1
);

CREATE SEQUENCE IF NOT EXISTS rec_grupo_pessoa_id_grupo_pessoa_seq;
CREATE TABLE rec_grupo_pessoa (
    id_grupo_pessoa INTEGER PRIMARY KEY DEFAULT nextval('rec_grupo_pessoa_id_grupo_pessoa_seq'),
    nm_grupo_pessoa VARCHAR(255),
    st_ativo        SMALLINT DEFAULT 1
);

CREATE SEQUENCE IF NOT EXISTS rec_pessoa_recurso_id_pessoa_recurso_seq;
CREATE TABLE rec_pessoa_recurso (
    id_pessoa_recurso INTEGER PRIMARY KEY DEFAULT nextval('rec_pessoa_recurso_id_pessoa_recurso_seq'),
    id_pessoa         INTEGER REFERENCES ses_pessoa(id_pessoa),
    id_recurso        INTEGER REFERENCES rec_recurso(id_recurso),
    fl_cadastrar      SMALLINT DEFAULT 0,
    fl_editar         SMALLINT DEFAULT 0,
    fl_excluir        SMALLINT DEFAULT 0
);

CREATE SEQUENCE IF NOT EXISTS rec_pessoa_grupo_recurso_id_pessoa_grupo_recurso_seq;
CREATE TABLE rec_pessoa_grupo_recurso (
    id_pessoa_grupo_recurso INTEGER PRIMARY KEY DEFAULT nextval('rec_pessoa_grupo_recurso_id_pessoa_grupo_recurso_seq'),
    id_pessoa               INTEGER REFERENCES ses_pessoa(id_pessoa),
    id_grupo_recurso        INTEGER REFERENCES rec_grupo_recurso(id_grupo_recurso)
);

CREATE SEQUENCE IF NOT EXISTS rec_recurso_grupo_recurso_id_recurso_grupo_recurso_seq;
CREATE TABLE rec_recurso_grupo_recurso (
    id_recurso_grupo_recurso INTEGER PRIMARY KEY DEFAULT nextval('rec_recurso_grupo_recurso_id_recurso_grupo_recurso_seq'),
    id_recurso               INTEGER REFERENCES rec_recurso(id_recurso),
    id_grupo_recurso         INTEGER REFERENCES rec_grupo_recurso(id_grupo_recurso),
    fl_cadastrar             SMALLINT DEFAULT 0,
    fl_editar                SMALLINT DEFAULT 0,
    fl_excluir               SMALLINT DEFAULT 0
);

CREATE SEQUENCE IF NOT EXISTS rec_grupo_pessoa_recurso_id_grupo_pessoa_recurso_seq;
CREATE TABLE rec_grupo_pessoa_recurso (
    id_grupo_pessoa_recurso INTEGER PRIMARY KEY DEFAULT nextval('rec_grupo_pessoa_recurso_id_grupo_pessoa_recurso_seq'),
    id_grupo_pessoa         INTEGER REFERENCES rec_grupo_pessoa(id_grupo_pessoa),
    id_recurso              INTEGER REFERENCES rec_recurso(id_recurso),
    fl_cadastrar            SMALLINT DEFAULT 0,
    fl_editar               SMALLINT DEFAULT 0,
    fl_excluir              SMALLINT DEFAULT 0
);

CREATE SEQUENCE IF NOT EXISTS rec_grupo_pessoa_grupo_recurso_id_grupo_pessoa_grupo_recurso_seq;
CREATE TABLE rec_grupo_pessoa_grupo_recurso (
    id_grupo_pessoa_grupo_recurso INTEGER PRIMARY KEY DEFAULT nextval('rec_grupo_pessoa_grupo_recurso_id_grupo_pessoa_grupo_recurso_seq'),
    id_grupo_pessoa               INTEGER REFERENCES rec_grupo_pessoa(id_grupo_pessoa),
    id_grupo_recurso              INTEGER REFERENCES rec_grupo_recurso(id_grupo_recurso)
);

CREATE SEQUENCE IF NOT EXISTS rec_pessoa_grupo_pessoa_id_pessoa_grupo_pessoa_seq;
CREATE TABLE rec_pessoa_grupo_pessoa (
    id_pessoa_grupo_pessoa INTEGER PRIMARY KEY DEFAULT nextval('rec_pessoa_grupo_pessoa_id_pessoa_grupo_pessoa_seq'),
    id_pessoa              INTEGER REFERENCES ses_pessoa(id_pessoa),
    id_grupo_pessoa        INTEGER REFERENCES rec_grupo_pessoa(id_grupo_pessoa)
);

-- =============================================
-- FINANCEIRO/BUDGET TABLES (para as views)
-- =============================================

CREATE SEQUENCE IF NOT EXISTS fin_despesa_id_despesa_seq;
CREATE TABLE fin_despesa (
    id_despesa  INTEGER PRIMARY KEY DEFAULT nextval('fin_despesa_id_despesa_seq'),
    cd_despesa  VARCHAR(20),
    nm_despesa  VARCHAR(255),
    st_ativo    SMALLINT DEFAULT 1
);

CREATE SEQUENCE IF NOT EXISTS fin_despesa_elemento_id_despesa_elemento_seq;
CREATE TABLE fin_despesa_elemento (
    id_despesa_elemento  INTEGER PRIMARY KEY DEFAULT nextval('fin_despesa_elemento_id_despesa_elemento_seq'),
    cd_despesa_elemento  VARCHAR(20),
    nm_despesa_elemento  VARCHAR(255),
    id_despesa           INTEGER REFERENCES fin_despesa(id_despesa),
    st_ativo             SMALLINT DEFAULT 1
);

CREATE SEQUENCE IF NOT EXISTS fin_programa_trabalho_id_programa_trabalho_seq;
CREATE TABLE fin_programa_trabalho (
    id_programa_trabalho  INTEGER PRIMARY KEY DEFAULT nextval('fin_programa_trabalho_id_programa_trabalho_seq'),
    cd_programa_trabalho  VARCHAR(50),
    nm_programa_trabalho  VARCHAR(255),
    st_ativo              SMALLINT DEFAULT 1
);

-- =============================================
-- VIEWS
-- =============================================

CREATE OR REPLACE VIEW view_despesa_elemento AS
    SELECT id_despesa_elemento, cd_despesa_elemento, nm_despesa_elemento,
           id_despesa, st_ativo
    FROM fin_despesa_elemento;

CREATE OR REPLACE VIEW view_despesa AS
    SELECT id_despesa, cd_despesa, nm_despesa, st_ativo
    FROM fin_despesa;

CREATE OR REPLACE VIEW view_programa_trabalho AS
    SELECT id_programa_trabalho, cd_programa_trabalho, nm_programa_trabalho, st_ativo
    FROM fin_programa_trabalho;
