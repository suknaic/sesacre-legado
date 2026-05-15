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
-- =============================================
-- Missing Tables (~139) - Gerado automaticamente
-- =============================================


CREATE TABLE pla_tipo_gasto (
    id_tipo_gasto INTEGER,
    nm_tipo_gasto VARCHAR(255)
);

CREATE TABLE cha_condicao (
    id_condicao INTEGER,
    nm_condicao VARCHAR(255),
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE cha_anotacao (
    id_anotacao INTEGER,
    id_chamado INTEGER,
    id_pessoa INTEGER,
    ds_anotacao TEXT,
    dh_anotacao TIMESTAMP
);

CREATE TABLE cha_servico_material (
    id_servico_material INTEGER,
    id_servico INTEGER,
    id_material INTEGER,
    qt_material INTEGER,
    vl_material NUMERIC(15,2)
);

CREATE TABLE cha_form_infraestrutura (
    id_form_infraestrutura INTEGER,
    id_chamado INTEGER,
    tp_liberacao VARCHAR(50),
    nm_pessoa VARCHAR(255),
    id_cargo INTEGER,
    id_funcao INTEGER,
    id_lotacao INTEGER,
    nm_email VARCHAR(255),
    ds_andar TEXT,
    qt_pontos INTEGER,
    qt_cabos INTEGER,
    nm_app VARCHAR(255),
    qt_patch_cord INTEGER,
    ds_justificativa TEXT,
    nr_vlan VARCHAR(20),
    qt_keystone INTEGER,
    qt_rj45 INTEGER,
    qt_rack INTEGER,
    nm_pasta VARCHAR(255),
    ds_destino TEXT,
    qt_computador INTEGER,
    qt_impressora INTEGER,
    qt_telefone INTEGER,
    ds_ip_gateway TEXT,
    id_pessoa_solicitante INTEGER,
    nr_telefone VARCHAR(20)
);

CREATE TABLE cha_material (
    id_material INTEGER,
    nm_material VARCHAR(255),
    dt_aquisicao DATE,
    ds_marca TEXT,
    ds_modelo TEXT,
    nr_patrimonio VARCHAR(20),
    vl_preco NUMERIC(15,2),
    qt_meses_garantia INTEGER,
    nm_serie VARCHAR(255),
    tp_estado VARCHAR(50),
    id_unidade_medida INTEGER,
    qt_memoria_ram INTEGER,
    ds_processador TEXT,
    qt_hd INTEGER,
    qt_fonte INTEGER,
    fl_wireless SMALLINT DEFAULT 1
);

CREATE TABLE cha_form_telefonia (
    id_form_telefonia INTEGER,
    id_chamado INTEGER,
    nr_ramal VARCHAR(20),
    ds_tipo TEXT,
    ds_destino TEXT,
    nr_patrimonio VARCHAR(20),
    ds_marca TEXT,
    ds_modelo TEXT,
    ds_localizacao TEXT
);

CREATE TABLE cha_form_material (
    id_form_material INTEGER,
    id_condicao INTEGER,
    nm_form_material VARCHAR(255),
    ds_marca TEXT,
    ds_modelo TEXT,
    nr_patrimonio VARCHAR(20),
    ds_localizacao TEXT,
    nm_serie VARCHAR(255),
    tp_estado VARCHAR(50),
    id_unidade_medida INTEGER,
    ds_destino TEXT
);

CREATE TABLE cha_form_sistema (
    id_form_sistemas INTEGER,
    id_chamado INTEGER,
    nm_pessoa VARCHAR(255),
    ds_email TEXT,
    nr_telefone VARCHAR(20),
    nr_cartao_sus VARCHAR(255),
    nr_cpf VARCHAR(20),
    nr_rg VARCHAR(20),
    nr_telefone_setor VARCHAR(255),
    nr_matricula VARCHAR(20),
    nm_modulo VARCHAR(255),
    nr_portaria VARCHAR(20),
    nm_setor VARCHAR(255),
    cd_setor VARCHAR(20),
    nm_responsavel VARCHAR(255),
    nr_participantes VARCHAR(255),
    ds_senha_desejada TEXT,
    nm_exame VARCHAR(255),
    ds_exame_parametro TEXT,
    nm_permissao VARCHAR(255),
    nm_conselho VARCHAR(255),
    nr_conselho VARCHAR(255),
    dt_inicial DATE,
    dt_fim DATE,
    dt_nascimento DATE,
    id_cargo INTEGER,
    id_funcao INTEGER,
    id_lotacao INTEGER,
    id_vinculo INTEGER,
    id_pessoa_solicitante INTEGER
);

CREATE TABLE cha_pessoa_atendimento (
    id_pessoa_atendimento INTEGER,
    id_chamado INTEGER,
    id_pessoa INTEGER
);

CREATE TABLE cha_categoria_principal (
    id_categoria_principal INTEGER,
    nm_categoria_principal VARCHAR(255),
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE cha_categoria_secundaria (
    id_categoria_secundaria INTEGER,
    id_categoria_primaria INTEGER,
    nm_categoria_secundaria VARCHAR(255),
    vl_categoria_secundaria NUMERIC(15,2),
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE cha_categoria_primaria (
    id_categoria_primaria INTEGER,
    id_categoria_tipo INTEGER,
    nm_categoria_primaria VARCHAR(255),
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE cha_chamado (
    id_chamado INTEGER,
    id_categoria_secundaria INTEGER,
    id_pessoa_solicitante INTEGER,
    id_pessoa_servico INTEGER,
    dh_abertura TIMESTAMP,
    ds_chamado TEXT,
    nr_telefone_solicitante VARCHAR(255),
    ds_finalizado TEXT,
    dh_finalizado TIMESTAMP,
    nr_avaliacao VARCHAR(255),
    dh_avaliacao TIMESTAMP,
    ds_avaliacao TEXT,
    vl_chamado NUMERIC(15,2),
    id_status INTEGER,
    dh_agendamento TIMESTAMP,
    id_prioridade INTEGER,
    dh_cancelamento TIMESTAMP,
    ds_cancelamento TEXT,
    dt_prazo DATE
);

CREATE TABLE cha_prioridade (
    id_prioridade INTEGER,
    nm_prioridade VARCHAR(255),
    cs_prioridade VARCHAR(50),
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE cha_anexo (
    id_anexo INTEGER,
    id_chamado INTEGER,
    lk_anexo TEXT,
    ds_anexo TEXT
);

CREATE TABLE cha_categoria_tipo (
    id_categoria_tipo INTEGER,
    id_categoria_principal INTEGER,
    nm_categoria_tipo VARCHAR(255),
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE cha_servico (
    id_servico INTEGER,
    id_chamado INTEGER,
    id_categoria_secundaria INTEGER,
    hr_trabalhadas TIME,
    ds_ordem_servico TEXT,
    vl_ordem_servico NUMERIC(15,2),
    qt_ordem_servico INTEGER,
    vl_total_servico NUMERIC(15,2),
    vl_despesa NUMERIC(15,2),
    ds_despesa TEXT
);

CREATE TABLE cha_status (
    id_status INTEGER,
    nm_status VARCHAR(255),
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE for_fornecedor_material_consumo (
    id_fornecedor_material_consumo INTEGER,
    id_fornecedor INTEGER,
    id_material_consumo INTEGER
);

CREATE TABLE for_fornecedor (
    id_fornecedor INTEGER,
    id_pessoa INTEGER,
    nm_empresa VARCHAR(255),
    medicamento VARCHAR(255),
    servico VARCHAR(255),
    email_adicional VARCHAR(255),
    material_consumo VARCHAR(255),
    material_permanente VARCHAR(255),
    fl_distribuidora SMALLINT DEFAULT 1,
    fl_exclusiva SMALLINT DEFAULT 1
);

CREATE TABLE for_fornecedor_servico (
    id_fornecedor_servico INTEGER,
    id_fornecedor INTEGER,
    id_servico INTEGER
);

CREATE TABLE for_material_permanente (
    id_material_permanente INTEGER,
    nm_material_permanente VARCHAR(255)
);

CREATE TABLE for_fornecedor_material_permanente (
    id_fornecedor_material_permanente INTEGER,
    id_fornecedor INTEGER,
    id_material_permanente INTEGER
);

CREATE TABLE for_servico (
    id_servio INTEGER,
    nm_servico VARCHAR(255)
);

CREATE TABLE for_material_consumo (
    id_material_consumo INTEGER,
    nm_material_consumo VARCHAR(255)
);

CREATE TABLE for_medicamento (
    id_medicamento INTEGER,
    nm_medicamento VARCHAR(255)
);

CREATE TABLE for_fornecedor_medicamento (
    id_fornecedor_medicamento INTEGER,
    id_fornecedor INTEGER,
    id_medicamento INTEGER
);

CREATE TABLE fin_documento_fiscal_anotacao (
    id_documento_fiscal_anotacao INTEGER,
    id_pessoa INTEGER,
    id_documento_fiscal INTEGER,
    dh_documento_fiscal_anotacao TIMESTAMP,
    ds_documento_fiscal_anotacao TEXT
);

CREATE TABLE fin_doc_lotacao (
    id_doc_lotacao INTEGER,
    id_doc_tipo_lotacao INTEGER,
    id_lotacao INTEGER,
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE fin_doc_vinc_recebimento (
    id_doc_vinc_recebimento INTEGER,
    id_doc_lotacao INTEGER,
    id_pessoa INTEGER
);

CREATE TABLE fin_documento_situacao (
    id_documento_situacao INTEGER,
    nm_situacao VARCHAR(255),
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE fin_entrega_documento (
    id_entrega_documento INTEGER,
    id_documento_fiscal INTEGER,
    id_entrega_confirmacao INTEGER,
    vl_entrega_documento NUMERIC(15,2),
    vl_entrega_saldo NUMERIC(15,2)
);

CREATE TABLE fin_doc_tramitacao (
    id_doc_tramitacao INTEGER,
    id_documento_fiscal INTEGER,
    id_pessoa INTEGER,
    dh_doc_tramitacao TIMESTAMP,
    ds_doc_tramitacao TEXT,
    id_doc_origem INTEGER,
    id_doc_destino INTEGER,
    id_documento_situacao INTEGER,
    id_tipo_tramitacao INTEGER,
    fl_pesquisa SMALLINT DEFAULT 1
);

CREATE TABLE fin_doc_tipo_lotacao (
    id_doc_tipo_lotacao INTEGER,
    nm_doc_tipo_lotacao VARCHAR(255)
);

CREATE TABLE fin_documento_fiscal (
    id_documento_fiscal INTEGER,
    nr_processo_administrativo VARCHAR(255),
    nr_documento_fiscal VARCHAR(255),
    mm_competencia VARCHAR(255),
    aa_competencia INTEGER,
    dt_emissao DATE,
    dt_atesto DATE,
    vl_documento NUMERIC(15,2),
    vl_documento_saldo NUMERIC(15,2),
    fl_encontro_contas SMALLINT DEFAULT 1,
    nr_encontro_dae VARCHAR(255),
    fl_grp SMALLINT DEFAULT 1,
    nr_grp_numero VARCHAR(255),
    ds_observacao TEXT,
    st_ativo SMALLINT DEFAULT 1,
    id_lotacao INTEGER,
    id_tipo_documento INTEGER,
    id_doc_tramitacao INTEGER,
    id_documento_situacao INTEGER,
    id_pedido INTEGER,
    dt_vencimento DATE
);

CREATE TABLE fin_doc_vinc_encaminhamento (
    id_doc_vinc_encaminhamento INTEGER,
    id_doc_lotacao INTEGER,
    id_pessoa INTEGER
);

CREATE TABLE fin_doc_parm_tramitacao (
    id_doc_parm_tramitacao INTEGER,
    id_doc_tipo_remetente INTEGER,
    id_doc_tipo_destinatario INTEGER,
    tp_doc_parm_tramitacao VARCHAR(50),
    id_documento_situacao INTEGER
);

CREATE TABLE fin_tipo_documento (
    id_tipo_documento INTEGER,
    nm_tipo_documento VARCHAR(255),
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE fin_pre_ordem (
    id_pre_ordem INTEGER,
    id_cont_itens INTEGER,
    id_pedido INTEGER,
    id_fornecedor INTEGER,
    qt_itens_pre INTEGER,
    vl_itens_pre NUMERIC(15,2),
    vl_total NUMERIC(15,2)
);

CREATE TABLE fin_qdd (
    id_qdd INTEGER,
    aa_qdd INTEGER
);

CREATE TABLE fin_autoriza_atividade (
    id_autoriza_atividade INTEGER,
    dt_ini DATE,
    dt_fim DATE,
    sit_ativo SMALLINT DEFAULT 1,
    id_pessoa INTEGER,
    id_lotacao INTEGER
);

CREATE TABLE fin_autoriza_orcamento (
    id_autoriza_orcamento INTEGER,
    dt_ini DATE,
    dt_fim DATE,
    st_ativo SMALLINT DEFAULT 1,
    id_pessoa INTEGER
);

CREATE TABLE fin_tipo_administracao (
    id_tipo_administracao INTEGER,
    nm_tipo_administracao VARCHAR(255),
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE fin_bloco_orcamentario (
    nm_bloc_orcamentario VARCHAR(255),
    id_bloc_orcamentario INTEGER
);

CREATE TABLE fin_administracao_solicitacao (
    id_administracao_solicitacao INTEGER,
    id_tipo_administracao INTEGER,
    id_tipo_solicitacao INTEGER
);

CREATE TABLE fin_portaria (
    id_portaria INTEGER,
    id_rede_tematica INTEGER,
    nm_portaria VARCHAR(255),
    dt_portaria DATE,
    st_portaria SMALLINT DEFAULT 1,
    vl_total NUMERIC(15,2)
);

CREATE TABLE fin_autorizacao_ordenado (
    id_autorizacao_ordenado INTEGER,
    dt_ini DATE,
    dt_fim DATE,
    st_ativo SMALLINT DEFAULT 1,
    id_pessoa INTEGER
);

CREATE TABLE fin_prog_trab_programa (
    cod_programa VARCHAR(255),
    id_cod_programa INTEGER
);

CREATE TABLE fin_conta (
    id_conta INTEGER,
    id_conta_financeira INTEGER,
    id_fonte_tipo INTEGER,
    id_fonte INTEGER,
    id_portaria_ds INTEGER,
    id_convenio INTEGER
);

CREATE TABLE fin_fonte (
    id_fonte INTEGER,
    nr_fonte VARCHAR(255),
    st_fonte SMALLINT DEFAULT 1
);

CREATE TABLE fin_rede_tematica (
    nm_rede_tematica VARCHAR(255),
    id_rede_tematica INTEGER,
    id_bloc_orcamentario INTEGER
);

CREATE TABLE fin_central_responsavel (
    id_central_responsavel INTEGER,
    id_lotacao INTEGER,
    id_pessoa INTEGER,
    id_tipo_administracao INTEGER
);

CREATE TABLE fin_convenio (
    id_convenio INTEGER,
    id_fonte INTEGER,
    nm_convenio VARCHAR(255),
    vl_total NUMERIC(15,2)
);

CREATE TABLE fin_autorizacao_financeiro (
    id_autorizacao_financeiro INTEGER,
    dt_ini DATE,
    dt_fim DATE,
    st_ativo SMALLINT DEFAULT 1,
    id_pessoa INTEGER
);

CREATE TABLE fin_qdd_sup_red_trans (
    id_qdd_sup_red_trans INTEGER,
    id_qdd_sup_red INTEGER,
    id_qdd_valor INTEGER,
    vl_qdd_sup_red_trans NUMERIC(15,2),
    tp_qdd_sup_red_trans VARCHAR(50)
);

CREATE TABLE fin_qdd_sup_red (
    id_qdd_sup_red INTEGER,
    id_qdd INTEGER,
    id_pessoa INTEGER,
    dh_qdd_sup_red TIMESTAMP,
    ds_qdd_sup_red TEXT,
    tp_qdd_sup_red VARCHAR(50),
    st_qdd_sup_red SMALLINT DEFAULT 1,
    id_pessoa_st INTEGER
);

CREATE TABLE fin_prog_trab_subfuncao (
    cod_sub_funcao VARCHAR(255),
    id_cod_sub_funcao INTEGER
);

CREATE TABLE fin_prog_trab_funcao (
    cod_funcao VARCHAR(255),
    id_cod_funcao INTEGER
);

CREATE TABLE fin_tramitacao (
    id_tramitacao INTEGER,
    nm_tramitacao VARCHAR(255),
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE fin_qdd_valor (
    id_qdd_valor INTEGER,
    id_qdd INTEGER,
    id_fonte INTEGER,
    id_programa_trabalho INTEGER,
    id_despesa_elemento INTEGER,
    vl_qdd_inical NUMERIC(15,2),
    vl_qdd_suplementado NUMERIC(15,2),
    vl_qdd_reduzido NUMERIC(15,2),
    vl_empenhado NUMERIC(15,2),
    vl_bloqueado NUMERIC(15,2),
    vl_liberado NUMERIC(15,2),
    vl_saldo NUMERIC(15,2)
);

CREATE TABLE fin_tipo_solicitacao (
    id_tipo_solicitacao INTEGER,
    nm_tipo_solicitacao VARCHAR(255)
);

CREATE TABLE fin_autoriza_central (
    id_autoriza_central INTEGER,
    dt_ini DATE,
    dt_fim DATE,
    st_ativo SMALLINT DEFAULT 1,
    id_pessoa INTEGER,
    id_lotacao INTEGER,
    tipo_autorizacao VARCHAR(255)
);

CREATE TABLE fin_pedido_situacao (
    id_pedido_situacao INTEGER,
    nm_pedido_situacao VARCHAR(255),
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE fin_pedido_anotacao (
    id_pedido_anotacao INTEGER,
    dh_pedido_anotacao TIMESTAMP,
    ds_pedido_anotacao TEXT,
    id_pessoa INTEGER,
    id_pedido INTEGER
);

CREATE TABLE fin_pedido (
    id_pedido INTEGER,
    nr_pedido VARCHAR(255),
    id_tipo_solicitacao INTEGER,
    id_fornecedor INTEGER,
    id_portatia INTEGER,
    id_convenio INTEGER,
    id_fonte INTEGER,
    id_programa_trabalho INTEGER,
    id_despesa_elemento INTEGER,
    id_despesa INTEGER,
    id_tipo_gasto INTEGER,
    id_lotacao INTEGER,
    ds_pedido TEXT,
    vl_pedido NUMERIC(15,2),
    dt_pedido DATE,
    st_pedido SMALLINT DEFAULT 1,
    id_pedido_situacao INTEGER
);

CREATE TABLE fin_central_demanda (
    id_central_demanda INTEGER,
    id_lotacao INTEGER
);

CREATE TABLE fin_ordem (
    id_ordem INTEGER,
    id_pedido INTEGER,
    id_lotacao INTEGER,
    id_pessoa INTEGER,
    nr_ordem INTEGER,
    dh_ordem TIMESTAMP,
    aa_ordem INTEGER,
    nr_prazo_ordem INTEGER,
    tp_ordem VARCHAR(50),
    sit_ordem SMALLINT DEFAULT 1,
    dt_ini_ordem DATE,
    dt_fim_ordem DATE,
    nr_pedido VARCHAR(255),
    central VARCHAR(255),
    ano VARCHAR(255)
);

CREATE TABLE fin_protocolo (
    id_protocolo INTEGER,
    nm_representante VARCHAR(255),
    nr_rg_cpf VARCHAR(255),
    nm_email_representante VARCHAR(255),
    qt_entrega INTEGER,
    dh_recebimento_sistema TIMESTAMP,
    dh_recimento TIMESTAMP,
    ds_protocolo TEXT,
    id_ordem INTEGER,
    id_pessoa INTEGER,
    st_ativo SMALLINT DEFAULT 1,
    nr_entrega_protocolo VARCHAR(255),
    dt_entrega DATE,
    dt_confirmacao DATE,
    nr_qtd_entrega VARCHAR(255),
    st_protocolo SMALLINT DEFAULT 1
);

CREATE TABLE fin_ordem_itens (
    id_ordem_itens INTEGER,
    id_ordem INTEGER,
    id_pre_ordem INTEGER,
    id_fornecedor INTEGER,
    qd_itens_pre VARCHAR(255),
    vl_itens_pre NUMERIC(15,2)
);

CREATE TABLE fin_entrega_itens (
    id_entrega_itens INTEGER,
    id_entrega_confirmacao INTEGER,
    id_ordem_itens INTEGER,
    qt_itens_entrega INTEGER,
    vl_itens_entrega NUMERIC(15,2),
    tp_entrega VARCHAR(50),
    dh_entrega TIMESTAMP
);

CREATE TABLE fin_entrega_confirmacao (
    id_entrega_confirmacao INTEGER,
    id_ordem INTEGER,
    id_protocolo INTEGER,
    nr_entrega_confirmacao VARCHAR(255),
    dt_entrega DATE,
    dh_cadastramento TIMESTAMP,
    sit_entrega SMALLINT DEFAULT 1
);

CREATE TABLE fin_ordem_administracao_anotacao (
    id_ordem_administracao_anotacao INTEGER,
    id_ordem_administracao INTEGER,
    ds_ordem_administracao_anotacao TEXT,
    dh_ordem_administracao_anotacao TIMESTAMP,
    id_pessoa INTEGER
);

CREATE TABLE fin_ordem_administracao (
    id_ordem_administracao INTEGER,
    id_ordem INTEGER,
    id_protocolo INTEGER,
    id_solicitante INTEGER,
    id_lotacao_solicitante INTEGER,
    dt_solicitacao DATE,
    id_autorizado INTEGER,
    id_lotacao_autorizado INTEGER,
    dt_autorizacao DATE,
    tp_administracao VARCHAR(50)
);

CREATE TABLE fin_autorizacao (
    id_autorizacao INTEGER,
    id_pedido INTEGER,
    st_nivel SMALLINT DEFAULT 1,
    dt_autorizacao DATE,
    ds_autorizacao TEXT,
    id_pessoa INTEGER
);

CREATE TABLE fin_central_liberacao (
    id_central_liberacao INTEGER,
    dh_central_liberacao TIMESTAMP,
    ds_central_liberacao TEXT,
    tp_central_liberacao VARCHAR(50),
    id_pessoa INTEGER,
    id_lotacao INTEGER,
    st_central_liberacao SMALLINT DEFAULT 1,
    id_pessoa_valida INTEGER,
    id_tipo_gasto INTEGER
);

CREATE TABLE fin_central_liberacao_trans (
    id_central_liberacao_trans INTEGER,
    id_central_liberacao INTEGER,
    id_qdd_valor INTEGER,
    vl_central_liberacao_trans NUMERIC(15,2),
    tp_central_liberacao_trans VARCHAR(50)
);

CREATE TABLE fin_empenho_situacao (
    id_empenho_situacao INTEGER,
    nm_empenho_situacao VARCHAR(255),
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE fin_empenho_anotacao (
    id_empenho_anotacao INTEGER,
    id_empenho INTEGER,
    id_pessoa INTEGER,
    ds_empenho_anotacao TEXT,
    dh_empenho_anotacao TIMESTAMP
);

CREATE TABLE fin_empenho_status (
    id_empenho_status INTEGER,
    nm_empenho_status VARCHAR(255),
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE fin_empenho_historico (
    id_empenho_historico INTEGER,
    id_empenho INTEGER,
    id_pessoa INTEGER,
    id_lotacao INTEGER,
    id_doc_tipo_lotacao INTEGER,
    id_empenho_situacao INTEGER,
    id_empenho_status INTEGER,
    dh_empenho_historico TIMESTAMP,
    ds_empenho_historico TEXT
);

CREATE TABLE fin_empenho (
    id_empenho INTEGER,
    id_pedido INTEGER,
    id_pessoa INTEGER,
    id_tipo_empenho INTEGER,
    nr_empenho VARCHAR(255),
    dt_empenho_sistema DATE,
    dt_empenho_safira DATE,
    vl_empenho NUMERIC(15,2),
    ds_empenho TEXT,
    sit_empenho SMALLINT DEFAULT 1,
    id_empenho_status INTEGER,
    id_doc_tipo_lotacao INTEGER,
    id_lotacao INTEGER
);

CREATE TABLE pla_tipo_gasto_despesa_elemento (
    id_tipo_gasto_despesa_elemento INTEGER,
    id_tipo_gasto INTEGER,
    id_despesa_elemento INTEGER,
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE pla_eixo_ppa_proj_ati (
    id_eixo_ppa_proj_ati INTEGER,
    id_eixo INTEGER,
    id_ppa_proj_ati INTEGER
);

CREATE TABLE pla_pta_item_recebido (
    id_pta_item_recebido INTEGER,
    id_ordem_destino INTEGER,
    id_pta_acao_det INTEGER,
    dh_recebido TIMESTAMP,
    ds_pta_item_recebido TEXT,
    qt_pta_item_recebido INTEGER,
    id_tipo_gasto INTEGER,
    id_tipo_gasto_categoria INTEGER,
    dh_pta_item_recebido TIMESTAMP,
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE pla_pas_acao (
    id_pas_acao INTEGER,
    id_pas INTEGER,
    id_acao INTEGER,
    id_ppa_proj_ati INTEGER,
    ds_parceria TEXT,
    ds_meta_programacao TEXT,
    ds_indicador_programacao TEXT,
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE pla_pas_acao_indicador (
    id_pas_acao_indicador INTEGER,
    id_pas INTEGER,
    id_acao INTEGER,
    id_indicador_saude INTEGER
);

CREATE TABLE pla_central_pessoa (
    id_central_pessoa INTEGER,
    id_pessoa INTEGER,
    id_lotacao INTEGER
);

CREATE TABLE pla_tipo_gasto_categoria (
    id_tipo_gasto_categoria INTEGER,
    nm_tipo_gasto_categoria VARCHAR(255),
    id_tipo_gasto INTEGER,
    id_lotacao INTEGER,
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE pla_indicador_saude (
    id_indicador_saude INTEGER,
    nm_indicador_saude VARCHAR(255),
    aa_indicador_saude INTEGER,
    cd_nota VARCHAR(20),
    tp_indicador_saude VARCHAR(50),
    ds_meta TEXT,
    ds_unidade TEXT
);

CREATE TABLE pla_pta_titulo (
    id_pta_titulo INTEGER,
    id_pta INTEGER,
    nm_pta_titulo VARCHAR(255),
    id_programa_trabalho INTEGER,
    id_ppa_proj_ati INTEGER,
    ds_objeto TEXT,
    ds_justificativa TEXT,
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE pla_pta_item_validacao_item (
    id_pta_item_validacao_item INTEGER,
    id_pta_item INTEGER,
    id_lotacao INTEGER,
    id_pessoa INTEGER,
    dh_pta_item_validacao_item TIMESTAMP
);

CREATE TABLE pla_pta_item (
    id_pta_item INTEGER,
    id_pta_titulo INTEGER,
    id_material INTEGER,
    ds_pta_item TEXT,
    id_pta_acao_det INTEGER,
    id_tipo_gasto INTEGER,
    id_tipo_gasto_categoria INTEGER,
    id_unidade_medida INTEGER,
    id_fonte INTEGER,
    tp_fonte VARCHAR(50),
    id_portaria INTEGER,
    id_convenio INTEGER,
    qt_pta_item INTEGER,
    vl_pta_item NUMERIC(15,2),
    st_pta_item SMALLINT DEFAULT 1
);

CREATE TABLE pla_pta (
    id_pta INTEGER,
    id_pas INTEGER,
    nm_pta VARCHAR(255),
    dt_inicio DATE,
    dt_fim DATE,
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE pla_unidade_medida (
    id_unidade_medida INTEGER,
    nm_unidade_medida VARCHAR(255),
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE pla_acao (
    id_acao INTEGER,
    id_objetivo INTEGER,
    nm_acao VARCHAR(255),
    ds_indicador TEXT,
    ds_meta_plano TEXT,
    tp_cadastro VARCHAR(50),
    st_ativo SMALLINT DEFAULT 1,
    id_lotacao INTEGER
);

CREATE TABLE pla_material (
    id_material INTEGER,
    cd_material VARCHAR(255),
    nm_material VARCHAR(255),
    cd_desc_material VARCHAR(20),
    nm_desc_material VARCHAR(255),
    cd_grupo VARCHAR(20),
    nm_grupo VARCHAR(255),
    cd_sub_grupo VARCHAR(20),
    nm_sub_grupo VARCHAR(255),
    tp_material VARCHAR(50),
    cd_elemento_despesa VARCHAR(20),
    id_despesa INTEGER
);

CREATE TABLE pla_pre_loa (
    id_pre_loa INTEGER,
    aa_pre_loa INTEGER,
    st_pre_loa SMALLINT DEFAULT 1,
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE pla_pre_loa_historico (
    id_pre_loa_historico INTEGER,
    id_pre_loa INTEGER,
    id_pessoa INTEGER,
    ds_pre_loa_historico TEXT,
    dh_pre_loa_historico TIMESTAMP,
    st_pre_loa SMALLINT DEFAULT 1
);

CREATE TABLE pla_pta_acao_det (
    id_pta_acao_det INTEGER,
    id_pta INTEGER,
    id_acao INTEGER,
    nm_pta_acao_det VARCHAR(255),
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE pla_pta_item_validacao (
    id_pta_item_validacao INTEGER,
    id_pas INTEGER,
    id_tipo_gasto_categoria INTEGER,
    id_pessoa INTEGER,
    ds_pta_item_validacao TEXT,
    dh_pta_item_validacao TIMESTAMP,
    st_pta_item_validacao SMALLINT DEFAULT 1
);

CREATE TABLE pla_pas_validacao (
    id_pas_validacao INTEGER,
    id_pas INTEGER,
    id_pessoa INTEGER,
    dh_pas_validacao TIMESTAMP,
    ds_pas_validacao TEXT,
    st_pas_validacao SMALLINT DEFAULT 1
);

CREATE TABLE pla_objetivo (
    id_objetivo INTEGER,
    id_diretriz INTEGER,
    nm_objetivo VARCHAR(255),
    nr_ordem INTEGER,
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE pla_pas (
    id_pas INTEGER,
    id_pes INTEGER,
    id_lotacao INTEGER,
    nm_pas VARCHAR(255),
    dt_inicio DATE,
    dt_fim DATE,
    id_pessoa_resp INTEGER,
    id_pessoa_exec INTEGER,
    ds_observacao TEXT,
    st_pas SMALLINT DEFAULT 1,
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE pla_pas_alteracao (
    id_pas_alteracao INTEGER,
    id_pessoa INTEGER,
    id_pas INTEGER,
    ds_tela TEXT,
    dh_pas_alteracao TIMESTAMP,
    ds_pas_alteracao TEXT,
    tp_pas_alteracao VARCHAR(50),
    id_pta_titulo INTEGER,
    id_pta INTEGER,
    id_pta_item INTEGER
);

CREATE TABLE pla_liberacao_fonte_unidade_trans (
    id_liberacao_fonte_unidade_trans INTEGER,
    id_pessoa INTEGER,
    id_liberacao_fonte_unidade INTEGER,
    vl_liberacao_fonte_unidade_trans NUMERIC(15,2),
    tp_liberacao_fonte_unidade_trans VARCHAR(50)
);

CREATE TABLE pla_pre_loa_valores (
    id_pre_loa_valores INTEGER,
    id_pre_loa INTEGER,
    id_programa_trabalho INTEGER,
    id_despesa_elemento INTEGER,
    id_fonte INTEGER,
    vl_pre_loa_valores NUMERIC(15,2)
);

CREATE TABLE pla_pas_pessoa_lotacao (
    id_pas_pessoa_lotacao INTEGER,
    id_pessoa INTEGER,
    id_lotacao INTEGER
);

CREATE TABLE pla_pes (
    id_pes INTEGER,
    nm_pes VARCHAR(255),
    aa_vigencia_inicio INTEGER,
    aa_vigencia_fim INTEGER,
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE pla_diretriz (
    id_diretriz INTEGER,
    id_eixo INTEGER,
    nm_diretriz VARCHAR(255),
    nr_ordem INTEGER,
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE pla_liberacao_fonte_unidade (
    id_liberacao_fonte_unidade INTEGER,
    id_liberacao_fonte INTEGER,
    id_lotacao INTEGER,
    id_programa_trabalho INTEGER,
    id_despesa_elemento INTEGER,
    vl_inicial NUMERIC(15,2),
    vl_suplementado NUMERIC(15,2),
    vl_reduzido NUMERIC(15,2)
);

CREATE TABLE pla_eixo (
    id_eixo INTEGER,
    id_pes INTEGER,
    nm_eixo VARCHAR(255),
    nr_ordem INTEGER,
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE pla_ppa_proj_ati (
    id_ppa_proj_ati INTEGER,
    nm_ppa_proj_ati VARCHAR(255),
    id_ppa_prog INTEGER,
    tp_ppa_proj_ati VARCHAR(50),
    cd_ppa_proj_ati VARCHAR(255),
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE pla_ppa_prog (
    id_ppa_prog INTEGER,
    cd_ppa_prog VARCHAR(255),
    nm_ppa_prog VARCHAR(255),
    aa_inicio INTEGER,
    aa_fim INTEGER,
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE pla_liberacao_fonte (
    id_liberacao_fonte INTEGER,
    id_fonte INTEGER,
    aa_liberacao_fonte INTEGER,
    vl_liberacao_fonte NUMERIC(15,2)
);

CREATE TABLE con_pagamento_anotacao (
    id_pagamento_anotacao INTEGER,
    id_pessoa INTEGER,
    id_pagamento INTEGER,
    dh_pagamento_anotacao TIMESTAMP,
    ds_pagamento_anotacao TEXT
);

CREATE TABLE con_pagamento (
    id_pagamento INTEGER,
    id_pagamento_situacao INTEGER,
    id_pagamento_status INTEGER,
    id_liquidacao INTEGER,
    id_liquidacao_situacao INTEGER,
    id_lotacao INTEGER,
    id_doc_tipo_lotacao INTEGER,
    nr_pagamento VARCHAR(255),
    dt_pagamento DATE,
    vl_pagamento NUMERIC(15,2),
    vl_pagamento_saldo NUMERIC(15,2),
    ds_pagamento TEXT,
    st_ativo SMALLINT DEFAULT 1,
    docs_pagamento VARCHAR(255)
);

CREATE TABLE con_pagamento_doc (
    id_pagamento_doc INTEGER,
    id_pagamento INTEGER,
    id_documento_fiscal INTEGER,
    id_documento_situacao INTEGER,
    vl_documento_fiscal NUMERIC(15,2),
    vl_pagamento_doc_saldo NUMERIC(15,2)
);

CREATE TABLE con_pagamento_historico (
    id_pagamento_historico INTEGER,
    id_pagamento INTEGER,
    id_pessoa INTEGER,
    id_lotacao INTEGER,
    id_doc_tipo_lotacao INTEGER,
    id_pagamento_situacao INTEGER,
    id_pagamento_status INTEGER,
    dh_pagamento_historico TIMESTAMP,
    ds_pagamento_historico TEXT
);

CREATE TABLE con_liquidacao_doc (
    id_liquidacao_doc INTEGER,
    id_liquidacao INTEGER,
    id_documento_fiscal INTEGER,
    vl_liquidacao_doc NUMERIC(15,2),
    vl_liquidacao_doc_saldo NUMERIC(15,2),
    id_documento_situacao INTEGER
);

CREATE TABLE con_liquidacao_anotacao (
    id_liquidacao_anotacao INTEGER,
    id_pessoa INTEGER,
    id_liquidacao INTEGER,
    dh_liquidacao_anotacao TIMESTAMP,
    ds_liquidacao_anotacao TEXT
);

CREATE TABLE con_liquidacao_situacao (
    id_liquidacao_situacao INTEGER,
    nm_liquidacao_situacao VARCHAR(255),
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE con_liquidacao_historico (
    id_liquidacao_historico INTEGER,
    id_liquidacao INTEGER,
    id_pessoa INTEGER,
    id_lotacao INTEGER,
    id_liquidacao_situacao INTEGER,
    id_liquidacao_status INTEGER,
    dh_liquidacao_historico TIMESTAMP,
    ds_liquidacao TEXT,
    id_doc_tipo_lotacao INTEGER
);

CREATE TABLE con_liquidacao_status (
    id_liquidacao_status INTEGER,
    nm_liquidacao_status VARCHAR(255),
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE con_liquidacao (
    id_liquidacao INTEGER,
    nr_liquidacao VARCHAR(255),
    id_empenho INTEGER,
    id_liquidacao_situacao INTEGER,
    id_liquidacao_status INTEGER,
    id_lotacao INTEGER,
    id_doc_tipo_lotacao INTEGER,
    dt_liquidacao DATE,
    vl_liquidacao NUMERIC(15,2),
    vl_liquidacao_saldo NUMERIC(15,2),
    ds_liquidacao TEXT,
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE con_empenho_anulacao_anotacao (
    id_empenho_anulacao_anotacao INTEGER,
    id_pessoa INTEGER,
    id_empenho_anulacao INTEGER,
    ds_empenho_anulacao_anotacao TEXT,
    dh_empenho_anulacao_anotacao TIMESTAMP
);

CREATE TABLE con_empenho_anulacao_historico (
    id_empenho_anulacao_historico INTEGER,
    id_empenho_anulacao INTEGER,
    id_empenho_anulacao_situacao INTEGER,
    id_empenho_anulacao_status INTEGER,
    id_pessoa INTEGER,
    ds_empenho_anulacao_historico TEXT,
    dh_empenho_anulacao_historico TIMESTAMP,
    id_lotacao INTEGER,
    id_doc_tipo_lotacao INTEGER
);

CREATE TABLE con_empenho_anulacao_situacao (
    id_empenho_anulacao_situacao INTEGER,
    nm_empenho_anulacao_situacao VARCHAR(255),
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE con_empenho_anulacao_item (
    id_empenho_anulacao_item INTEGER,
    id_empenho_anulacao INTEGER,
    id_pre_ordem INTEGER,
    qt_item INTEGER,
    vl_item NUMERIC(15,2),
    qt_anulacao INTEGER,
    vl_anulado NUMERIC(15,2),
    vl_saldo NUMERIC(15,2),
    vl_utilizado NUMERIC(15,2),
    qt_utilizado INTEGER
);

CREATE TABLE con_empenho_anulacao_status (
    id_empenho_anulacao_status INTEGER,
    nm_empenho_anulacao_status VARCHAR(255),
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE con_empenho_anulacao (
    id_empenho_anulacao INTEGER,
    id_pedido INTEGER,
    nr_empenho_anulacao VARCHAR(255),
    dt_empenho_anulacao DATE,
    dh_empenho_anulacao TIMESTAMP,
    vl_empenho_anulacao NUMERIC(15,2),
    vl_empenho_antigo NUMERIC(15,2),
    id_empenho_anulacao_situacao INTEGER,
    id_empenho_anulacao_status INTEGER,
    id_pessoa INTEGER,
    id_lotacao INTEGER,
    id_doc_tipo_lotacao INTEGER,
    vl_empenho_saldo NUMERIC(15,2)
);

CREATE TABLE fin_fornecedor (
    id_fornecedor INTEGER,
    id_contrato INTEGER,
    id_ata INTEGER,
    id_pessoa INTEGER,
    sit_fornecedor SMALLINT DEFAULT 1
);

CREATE TABLE fin_contrato_instrumento (
    id_contrato_instrumento INTEGER,
    nm_contrato_instrumento VARCHAR(255),
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE fin_contrato_finalidade (
    id_contrato_finalidade INTEGER,
    nm_contrato_finalidade VARCHAR(255),
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE fin_cont_itens_grupo (
    id_cont_itens_grupo INTEGER,
    dh_cont_itens_grupo TIMESTAMP
);

CREATE TABLE fin_contrato_unidade_calculo (
    id_contrato_unidade_calculo INTEGER,
    nm_contrato_unidade_calculo VARCHAR(255),
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE fin_cont_itens_saldo (
    id_cont_itens_saldo INTEGER,
    id_cont_itens_grupo INTEGER,
    id_cont_itens INTEGER,
    id_cont_itens_original INTEGER,
    vl_cont_itens_saldo NUMERIC(15,2),
    dh_cont_itens_saldo TIMESTAMP,
    ds_cont_itens_saldo TEXT,
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE fin_fiscal (
    id_fiscal INTEGER,
    id_ata INTEGER,
    id_contrato INTEGER,
    id_pessoa INTEGER,
    tp_fiscal VARCHAR(50),
    dt_ini_fiscal DATE,
    dt_fim_fiscal DATE,
    sit_ativo SMALLINT DEFAULT 1
);

CREATE TABLE fin_contrato (
    id_contrato INTEGER,
    nr_contrato VARCHAR(255),
    nr_prazo_entrega INTEGER,
    id_processo INTEGER,
    id_pessoa INTEGER,
    ds_objeto TEXT,
    fl_servico_continuado SMALLINT DEFAULT 1,
    dt_ini_vigencia_contrato DATE,
    dt_fim_vigencia_contrato DATE,
    dt_assinatura DATE,
    dt_publicacao DATE,
    ds_obs_contrato TEXT,
    st_ativo SMALLINT DEFAULT 1,
    id_modalidade INTEGER,
    id_programa_trabalho INTEGER,
    id_fonte INTEGER,
    ds_area_abrangencia TEXT,
    id_tipo_gasto INTEGER,
    ds_unidade_contemplada TEXT,
    vl_contrato NUMERIC(15,2),
    tp_contrato VARCHAR(50),
    fl_carona SMALLINT DEFAULT 1,
    id_contrato_alt INTEGER,
    sq_contrato VARCHAR(255),
    id_contrato_aditivo_pai INTEGER,
    id_fornecedor INTEGER,
    id_pessoa_fornecedor INTEGER,
    id_cont_central INTEGER,
    id_lotacao_central INTEGER,
    id_gestor INTEGER,
    id_pessoa_gestor_titular INTEGER,
    id_pessoa_gestor_substituto INTEGER,
    id_fiscal INTEGER,
    id_pessoa_fiscal_titular INTEGER,
    id_pessoa_fiscal_substituto INTEGER,
    id_sub_fiscal INTEGER,
    id_pessoa_sub_fiscal_titular INTEGER,
    id_pessoa_sub_fiscal_substituto INTEGER,
    id_orgao_gerenciador INTEGER
);

CREATE TABLE fin_contrato_motivo (
    id_contrato_motivo INTEGER,
    nm_contrato_motivo VARCHAR(255),
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE fin_sub_fiscal (
    id_sub_fiscal INTEGER,
    id_ata INTEGER,
    id_contrato INTEGER,
    id_pessoa INTEGER,
    tp_sub_fiscal VARCHAR(50),
    dt_ini_sub_fiscal DATE,
    dt_fim_sub_fiscal DATE,
    sit_ativo SMALLINT DEFAULT 1
);

CREATE TABLE fin_cont_itens (
    id_cont_itens INTEGER,
    nr_item VARCHAR(255),
    nr_lote VARCHAR(255),
    nm_marca VARCHAR(255),
    nm_modelo VARCHAR(255),
    qt_itens INTEGER,
    vl_itens NUMERIC(15,2),
    pc_desconto NUMERIC(15,2),
    id_material INTEGER,
    id_fornecedor INTEGER,
    id_cont_itens_alt INTEGER,
    cd_desc_material VARCHAR(20),
    desc_item VARCHAR(255),
    id_unidade_medida INTEGER,
    fl_valor_variavel SMALLINT DEFAULT 1,
    id_cont_itens_aditivo INTEGER,
    qt_itens_aux INTEGER
);

CREATE TABLE fin_centrais (
    id_ata_central INTEGER,
    id_ata INTEGER,
    st_ativo_ata SMALLINT DEFAULT 1,
    id_cont_central INTEGER,
    id_contrato INTEGER,
    st_ativo_contrato SMALLINT DEFAULT 1,
    id_lotacao INTEGER
);

CREATE TABLE fin_cont_itens_grupo_item (
    id_cont_itens_grupo_item INTEGER,
    id_cont_itens_grupo INTEGER,
    id_cont_itens INTEGER
);

CREATE TABLE fin_contrato_base_calculo (
    id_contrato_base_calculo INTEGER,
    nm_contrato_base_caculo VARCHAR(255),
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE fin_gestor (
    id_gestor INTEGER,
    id_pessoa INTEGER,
    id_contrato INTEGER,
    id_ata INTEGER,
    tp_gestor VARCHAR(50),
    dt_ini_gestor DATE,
    dt_fim_gestor DATE,
    sit_ativo SMALLINT DEFAULT 1
);

CREATE TABLE fin_contrato_aquisicao (
    id_contrato_aquisicao INTEGER,
    nm_contrato_aquisicao VARCHAR(255),
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE fin_contrato_aditivo (
    id_contrato_aditivo INTEGER,
    id_contrato INTEGER,
    id_contrato_motivo INTEGER,
    id_contrato_finalidade INTEGER,
    id_contrato_instrumento INTEGER,
    id_contrato_base_calculo INTEGER,
    id_contrato_unidade_calculo INTEGER,
    id_contrato_aquisicao INTEGER,
    ds_justificativa TEXT,
    nr_aditivo VARCHAR(255),
    dt_inicial DATE,
    dt_final DATE,
    nr_percentual_indice VARCHAR(255),
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE fin_ata (
    id_ata INTEGER,
    id_processo INTEGER,
    id_pessoa_juridica INTEGER,
    fl_carona SMALLINT DEFAULT 1,
    nr_ata VARCHAR(255),
    ds_objeto TEXT,
    dt_ini_vigencia_ata DATE,
    dt_fim_vigencia_ata DATE,
    dt_assinatura DATE,
    dt_publicacao DATE,
    ds_obs_ata TEXT,
    st_ata SMALLINT DEFAULT 1,
    orgao_gerenciador VARCHAR(255),
    id_programa_trabalho INTEGER,
    id_fonte INTEGER
);

CREATE TABLE dia_classe (
    id_classe INTEGER,
    nm_classe VARCHAR(255),
    cd_classe VARCHAR(255),
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE dia_relatorio_anexo (
    id_relatorio_anexo INTEGER,
    id_relatorio INTEGER,
    nm_relatorio_anexo VARCHAR(255),
    lk_relatorio_anexo TEXT,
    aq_relatorio_anexo TEXT,
    nm_mime_type VARCHAR(255)
);

CREATE TABLE dia_diaria_destino (
    id_diaria_destino INTEGER,
    id_diaria INTEGER,
    id_cidade_inicio INTEGER,
    id_cidade_fim INTEGER,
    dh_inicio TIMESTAMP,
    dh_fim TIMESTAMP,
    id_transporte INTEGER,
    id_decreto INTEGER,
    id_classe INTEGER,
    fl_pernoite SMALLINT DEFAULT 1,
    qt_diaria_destino INTEGER,
    vl_diaria_destino NUMERIC(15,2)
);

CREATE TABLE dia_transporte_tipo (
    id_transporte_tipo INTEGER,
    nm_transporte_tipo VARCHAR(255),
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE dia_diaria_historico (
    id_diaria_historico INTEGER,
    id_diaria INTEGER,
    id_pessoa INTEGER,
    dh_diaria_historico TIMESTAMP,
    ds_diaria_historico TEXT
);

CREATE TABLE dia_diaria (
    id_diaria INTEGER,
    id_tipo INTEGER,
    id_pessoa_proponente INTEGER,
    id_funcao_proponente INTEGER,
    id_lotacao_proponente INTEGER,
    id_pessoa_proposto INTEGER,
    id_funcao_proposto INTEGER,
    id_lotacao_proposto INTEGER,
    ds_servico_executado TEXT,
    ds_locais_executado TEXT,
    ds_obs TEXT,
    dt_criacao DATE,
    dh_diaria TIMESTAMP,
    id_pessoa_solicitante INTEGER,
    id_lotacao_solicitante INTEGER,
    id_central_solicitante INTEGER,
    fl_retorno SMALLINT DEFAULT 1,
    id_pedido INTEGER,
    id_diaria_pai INTEGER,
    id_relatorio INTEGER,
    st_estagio SMALLINT DEFAULT 1,
    st_ativo SMALLINT DEFAULT 1,
    nr_protocolo VARCHAR(255)
);

CREATE TABLE dia_decreto (
    id_decreto INTEGER,
    nm_decreto VARCHAR(255),
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE dia_relatorio_destino (
    id_relatorio_destino INTEGER,
    id_relatorio INTEGER,
    id_cidade_inicio INTEGER,
    id_cidade_fim INTEGER,
    dh_inicio TIMESTAMP,
    dh_fim TIMESTAMP,
    id_transporte INTEGER,
    id_transporte_tipo INTEGER,
    ds_transporte_tipo TEXT
);

CREATE TABLE dia_transporte (
    id_transporte INTEGER,
    nm_transporte VARCHAR(255),
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE dia_tipo (
    id_tipo INTEGER,
    nm_tipo VARCHAR(255),
    st_ativo SMALLINT DEFAULT 1
);

CREATE TABLE dia_transporte_tem_tipo (
    id_transporte_tem_tipo INTEGER,
    id_transporte INTEGER,
    id_transporte_tipo INTEGER
);

CREATE TABLE dia_relatorio (
    id_relatorio INTEGER,
    ds_servico_executado TEXT,
    ds_locais_executado TEXT,
    dt_relatorio_destino DATE,
    fl_retorno SMALLINT DEFAULT 1
);

CREATE TABLE dia_decreto_valor (
    id_decreto_valor INTEGER,
    id_decreto INTEGER,
    id_classe INTEGER,
    tp_decreto_valor VARCHAR(50),
    vl_decreto_valor NUMERIC(15,2)
);

CREATE TABLE dia_anexo (
    id_anexo INTEGER,
    id_diaria INTEGER,
    nm_anexo VARCHAR(255),
    aq_anexo TEXT,
    nm_mime_type VARCHAR(255)
);

-- =============================================
-- Tables without model classes (extraidas de INSERTs e classes Extd)
-- =============================================

CREATE SEQUENCE IF NOT EXISTS gco_processo_id_processo_seq;
CREATE TABLE gco_processo (
    id_processo INTEGER PRIMARY KEY DEFAULT nextval('gco_processo_id_processo_seq'),
    cd_ada_cpr VARCHAR(20),
    cd_pregao VARCHAR(20),
    vl_total_est NUMERIC(15,2),
    vl_total_hom NUMERIC(15,2),
    dt_processo DATE,
    id_objeto INTEGER,
    id_modalidade INTEGER,
    id_anotacao INTEGER,
    nr_ano INTEGER,
    nr_tecnico VARCHAR(255),
    nr_tipo_gasto INTEGER,
    nr_area INTEGER,
    nr_situacao INTEGER,
    nr_user INTEGER,
    st_ativo SMALLINT DEFAULT 1
);

CREATE SEQUENCE IF NOT EXISTS gco_modalidade_id_modalidade_seq;
CREATE TABLE gco_modalidade (
    id_modalidade INTEGER PRIMARY KEY DEFAULT nextval('gco_modalidade_id_modalidade_seq'),
    nm_modalidade VARCHAR(255)
);

CREATE SEQUENCE IF NOT EXISTS gco_objeto_id_objeto_seq;
CREATE TABLE gco_objeto (
    id_objeto INTEGER PRIMARY KEY DEFAULT nextval('gco_objeto_id_objeto_seq'),
    nm_objeto VARCHAR(255)
);

CREATE SEQUENCE IF NOT EXISTS gco_situacao_id_situacao_seq;
CREATE TABLE gco_situacao (
    id_situacao INTEGER PRIMARY KEY DEFAULT nextval('gco_situacao_id_situacao_seq'),
    nm_situacao VARCHAR(255)
);

CREATE SEQUENCE IF NOT EXISTS gco_unidade_contempladas_id_unidade_contempladas_seq;
CREATE TABLE gco_unidade_contempladas (
    id_unidade_contempladas INTEGER PRIMARY KEY DEFAULT nextval('gco_unidade_contempladas_id_unidade_contempladas_seq'),
    nm_unidade_contempladas VARCHAR(255)
);

CREATE SEQUENCE IF NOT EXISTS gco_anexo_id_anexo_seq;
CREATE TABLE gco_anexo (
    id_anexo INTEGER PRIMARY KEY DEFAULT nextval('gco_anexo_id_anexo_seq'),
    id_processo INTEGER,
    ds_anexo TEXT,
    nm_mime_type VARCHAR(255),
    aq_anexo TEXT,
    lk_anexo TEXT
);

CREATE SEQUENCE IF NOT EXISTS gco_anotacao_id_anotacao_seq;
CREATE TABLE gco_anotacao (
    id_anotacao INTEGER PRIMARY KEY DEFAULT nextval('gco_anotacao_id_anotacao_seq'),
    id_processo INTEGER,
    id_situacao INTEGER,
    id_pessoa INTEGER,
    id_usuario INTEGER,
    ds_anotacao TEXT,
    dh_anotacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE gco_area_abrangencia (
    id_cidade INTEGER,
    id_processo INTEGER
);

CREATE TABLE gco_processo_central (
    id_processo INTEGER,
    id_lotacao INTEGER
);

CREATE TABLE gco_processo_tipo_gasto (
    id_processo INTEGER,
    id_tipo_gasto INTEGER,
    vl_processo_tipo_gasto NUMERIC(15,2)
);

CREATE TABLE gco_processo_unidade (
    id_processo INTEGER,
    id_unidade_contempladas INTEGER
);

CREATE SEQUENCE IF NOT EXISTS fin_ata_central_id_ata_central_seq;
CREATE TABLE fin_ata_central (
    id_ata_central INTEGER PRIMARY KEY DEFAULT nextval('fin_ata_central_id_ata_central_seq'),
    id_ata INTEGER,
    id_lotacao INTEGER,
    st_ativo SMALLINT DEFAULT 1
);

CREATE SEQUENCE IF NOT EXISTS fin_cont_central_id_cont_central_seq;
CREATE TABLE fin_cont_central (
    id_cont_central INTEGER PRIMARY KEY DEFAULT nextval('fin_cont_central_id_cont_central_seq'),
    id_contrato INTEGER,
    id_lotacao INTEGER,
    st_ativo SMALLINT DEFAULT 1
);

CREATE SEQUENCE IF NOT EXISTS fin_licitacao_id_licitacao_seq;
CREATE TABLE fin_licitacao (
    id_licitacao INTEGER PRIMARY KEY DEFAULT nextval('fin_licitacao_id_licitacao_seq'),
    nm_licitacao VARCHAR(255),
    st_ativo SMALLINT DEFAULT 1
);

CREATE SEQUENCE IF NOT EXISTS fin_tipo_empenho_id_tipo_empenho_seq;
CREATE TABLE fin_tipo_empenho (
    id_tipo_empenho INTEGER PRIMARY KEY DEFAULT nextval('fin_tipo_empenho_id_tipo_empenho_seq'),
    nm_tipo_empenho VARCHAR(255),
    st_ativo SMALLINT DEFAULT 1
);

CREATE SEQUENCE IF NOT EXISTS fin_vigencia_id_vigencia_seq;
CREATE TABLE fin_vigencia (
    id_vigencia INTEGER PRIMARY KEY DEFAULT nextval('fin_vigencia_id_vigencia_seq'),
    id_contrato INTEGER,
    vigencia_data_ini DATE,
    vigencia_data_fim DATE
);

CREATE SEQUENCE IF NOT EXISTS ses_contrato_situacao_id_contrato_situacao_seq;
CREATE TABLE ses_contrato_situacao (
    id_contrato_situacao INTEGER PRIMARY KEY DEFAULT nextval('ses_contrato_situacao_id_contrato_situacao_seq'),
    nm_contrato_situacao VARCHAR(255),
    st_ativo SMALLINT DEFAULT 1
);

CREATE SEQUENCE IF NOT EXISTS ses_natureza_id_natureza_seq;
CREATE TABLE ses_natureza (
    id_natureza INTEGER PRIMARY KEY DEFAULT nextval('ses_natureza_id_natureza_seq'),
    nm_natureza VARCHAR(255),
    st_ativo SMALLINT DEFAULT 1
);

CREATE SEQUENCE IF NOT EXISTS ses_telefone_id_telefone_seq;
CREATE TABLE ses_telefone (
    id_telefone INTEGER PRIMARY KEY DEFAULT nextval('ses_telefone_id_telefone_seq'),
    nr_telefone VARCHAR(20),
    st_principal SMALLINT DEFAULT 0,
    id_lotacao INTEGER,
    id_lotacao_detalhe INTEGER
);

CREATE SEQUENCE IF NOT EXISTS con_liquidacao_pes_lot_id_liquidacao_pes_lot_seq;
CREATE TABLE con_liquidacao_pes_lot (
    id_liquidacao_pes_lot INTEGER PRIMARY KEY DEFAULT nextval('con_liquidacao_pes_lot_id_liquidacao_pes_lot_seq'),
    id_pessoa INTEGER,
    id_lotacao INTEGER
);

CREATE SEQUENCE IF NOT EXISTS pla_liberacao_unidade_valor_id_liberacao_unidade_valor_seq;
CREATE TABLE pla_liberacao_unidade_valor (
    id_liberacao_unidade_valor INTEGER PRIMARY KEY DEFAULT nextval('pla_liberacao_unidade_valor_id_liberacao_unidade_valor_seq'),
    id_liberacao_fonte_unidade INTEGER,
    vl_liberacao_unidade_valor NUMERIC(15,2),
    st_ativo SMALLINT DEFAULT 1
);
