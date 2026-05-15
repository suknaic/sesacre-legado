<?php
function toSnake($s) {
    return strtolower(preg_replace("/([a-z])([A-Z])/", "$1_$2", $s));
}

function inferType($col) {
    $c = strtolower($col);
    if ($c === "sucesso" || $c === "mensagem") return null;
    if (preg_match("/^(st_|fl_|is_|sit_)/", $c)) return "SMALLINT DEFAULT 1";
    if (preg_match("/^(qt_|nr_ordem|nr_nivel|nr_prazo|nr_ano|aa_)/", $c)) return "INTEGER";
    if ($c === "id_pai" || preg_match("/^id_/", $c)) return "INTEGER";
    if (preg_match("/^(nr_)/", $c)) {
        if (in_array($c, ["nr_cpf","nr_cnpj","nr_cep","nr_telefone","nr_celular","nr_rg","nr_cns","nr_matricula","nr_patrimonio","nr_ramal","nr_serie","nr_vlan","nr_portaria","nr_controle","nr_safira","nr_prazo"])) return "VARCHAR(20)";
        return "VARCHAR(255)";
    }
    if (preg_match("/^(nm_)/", $c)) return "VARCHAR(255)";
    if (preg_match("/^(tp_|cs_)/", $c)) return "VARCHAR(50)";
    if (preg_match("/^(cd_)/", $c)) {
        if (in_array($c, ["cd_ada_cpr","cd_pregao","cd_setor","cd_desc_material","cd_nota","cd_grupo","cd_sub_grupo","cd_elemento_despesa"])) return "VARCHAR(20)";
        return "VARCHAR(255)";
    }
    if (preg_match("/^(ds_|lk_|aq_)/", $c)) return "TEXT";
    if (preg_match("/^(dt_)/", $c)) return "DATE";
    if (preg_match("/^(dh_)/", $c)) return "TIMESTAMP";
    if (preg_match("/^(hr_)/", $c)) return "TIME";
    if (preg_match("/^(vl_|pc_)/", $c)) return "NUMERIC(15,2)";
    if (preg_match("/^(mp_)/", $c)) return "VARCHAR(50)";
    return "VARCHAR(255)";
}

function getTableName($cls) {
    $map = [
        "AdminPlaTipoGasto" => "pla_tipo_gasto",
        "ChaAnexo" => "cha_anexo",
        "ChaAnotacao" => "cha_anotacao",
        "ChaCategoriaPrimaria" => "cha_categoria_primaria",
        "ChaCategoriaPrincipal" => "cha_categoria_principal",
        "ChaCategoriaSecundaria" => "cha_categoria_secundaria",
        "ChaCategoriaTipo" => "cha_categoria_tipo",
        "ChaChamado" => "cha_chamado",
        "ChaCondicao" => "cha_condicao",
        "ChaFormInfraestrutura" => "cha_form_infraestrutura",
        "ChaFormMaterial" => "cha_form_material",
        "ChaFormSistemas" => "cha_form_sistema",
        "ChaFormTelefonia" => "cha_form_telefonia",
        "ChaMaterial" => "cha_material",
        "ChaPessoaAtendimento" => "cha_pessoa_atendimento",
        "ChaPrioridade" => "cha_prioridade",
        "ChaServico" => "cha_servico",
        "ChaServicoMaterial" => "cha_servico_material",
        "ChaStatus" => "cha_status",
        "ConEmpenhoAnulacao" => "con_empenho_anulacao",
        "ConEmpenhoAnulacaoAnotacao" => "con_empenho_anulacao_anotacao",
        "ConEmpenhoAnulacaoHistorico" => "con_empenho_anulacao_historico",
        "ConEmpenhoAnulacaoItem" => "con_empenho_anulacao_item",
        "ConEmpenhoAnulacaoSituacao" => "con_empenho_anulacao_situacao",
        "ConEmpenhoAnulacaoStatus" => "con_empenho_anulacao_status",
        "ConLiquidacao" => "con_liquidacao",
        "ConLiquidacaoAnotacao" => "con_liquidacao_anotacao",
        "ConLiquidacaoDoc" => "con_liquidacao_doc",
        "ConLiquidacaoHistorico" => "con_liquidacao_historico",
        "ConLiquidacaoPesLot" => "con_liquidacao_pes_lot",
        "ConLiquidacaoSituacao" => "con_liquidacao_situacao",
        "ConLiquidacaoStatus" => "con_liquidacao_status",
        "ConPagamentoTb" => "con_pagamento",
        "ConPagamentoDocTb" => "con_pagamento_doc",
        "ConPagamentoHistoricoTb" => "con_pagamento_historico",
        "ConPagamentoAnotacoesTb" => "con_pagamento_anotacao",
        "DiaAnexo" => "dia_anexo",
        "DiaClasse" => "dia_classe",
        "DiaDecreto" => "dia_decreto",
        "DiaDecretoValor" => "dia_decreto_valor",
        "DiaDiaria" => "dia_diaria",
        "DiaDiariaDestino" => "dia_diaria_destino",
        "DiaDiariaHistorico" => "dia_diaria_historico",
        "DiaRelatorio" => "dia_relatorio",
        "DiaRelatorioAnexo" => "dia_relatorio_anexo",
        "DiaRelatorioDestino" => "dia_relatorio_destino",
        "DiaTipo" => "dia_tipo",
        "DiaTransporte" => "dia_transporte",
        "DiaTransporteTemTipo" => "dia_transporte_tem_tipo",
        "DiaTransporteTipo" => "dia_transporte_tipo",
        "FinAdministracaoSolicitacao" => "fin_administracao_solicitacao",
        "FinAdministracaoAnotacaoTb" => "fin_ordem_administracao_anotacao",
        "FinAtaTb" => "fin_ata",
        "FinAutorizaAtividade" => "fin_autoriza_atividade",
        "FinAutorizaCentral" => "fin_autoriza_central",
        "FinAutorizaOrcamento" => "fin_autoriza_orcamento",
        "FinAutorizacaoFinanceiro" => "fin_autorizacao_financeiro",
        "FinAutorizacaoOrdenado" => "fin_autorizacao_ordenado",
        "FinAutorizacoesTb" => "fin_autorizacao",
        "FinCentraisTb" => "fin_centrais",
        "FinCentralLiberacaoTb" => "fin_central_liberacao",
        "FinCentralLiberacaoTransTb" => "fin_central_liberacao_trans",
        "FinCentralResponsavel" => "fin_central_responsavel",
        "FinCentralTb" => "fin_central_demanda",
        "FinContItensGrupoItemTb" => "fin_cont_itens_grupo_item",
        "FinContItensGrupoTb" => "fin_cont_itens_grupo",
        "FinContItensSaldotb" => "fin_cont_itens_saldo",
        "FinConta" => "fin_conta",
        "FinContratoAditivoTb" => "fin_contrato_aditivo",
        "FinContratoAquisicaoTb" => "fin_contrato_aquisicao",
        "FinContratoBaseCalculoTb" => "fin_contrato_base_calculo",
        "FinContratoFinalidadeTb" => "fin_contrato_finalidade",
        "FinContratoInstrumentoTb" => "fin_contrato_instrumento",
        "FinContratoMotivoTb" => "fin_contrato_motivo",
        "FinContratoTb" => "fin_contrato",
        "FinContratoUnidadeCalculoTb" => "fin_contrato_unidade_calculo",
        "FinConvenio" => "fin_convenio",
        "FinDocLotacao" => "fin_doc_lotacao",
        "FinDocParmTramitacao" => "fin_doc_parm_tramitacao",
        "FinDocTipoLotacao" => "fin_doc_tipo_lotacao",
        "FinDocTramitacao" => "fin_doc_tramitacao",
        "FinDocVincEncaminhamento" => "fin_doc_vinc_encaminhamento",
        "FinDocVincRecebimento" => "fin_doc_vinc_recebimento",
        "FinDocumentoFiscalTb" => "fin_documento_fiscal",
        "FinDocumentoFiscalAnotacaoTb" => "fin_documento_fiscal_anotacao",
        "FinDocumentoSituacaoTb" => "fin_documento_situacao",
        "FinEmpenhoTb" => "fin_empenho",
        "FinEmpenhoAnotacaoTb" => "fin_empenho_anotacao",
        "FinEmpenhoHistoricoTb" => "fin_empenho_historico",
        "FinEmpenhoSituacaoTb" => "fin_empenho_situacao",
        "FinEmpenhoStatusTb" => "fin_empenho_status",
        "FinEntregaConfirmacaoTb" => "fin_entrega_confirmacao",
        "FinEntregaDocumentoTb" => "fin_entrega_documento",
        "FinEntregaItensTb" => "fin_entrega_itens",
        "FinFiscaisModelTb" => "fin_fiscal",
        "FinFonte" => "fin_fonte",
        "FinFornecedoresTb" => "fin_fornecedor",
        "FinGestorTb" => "fin_gestor",
        "FinItensTb" => "fin_cont_itens",
        "FinOrdemAdministracaoTb" => "fin_ordem_administracao",
        "FinOrdemItensTb" => "fin_ordem_itens",
        "FinOrdemTb" => "fin_ordem",
        "FinPedidoAnotacao" => "fin_pedido_anotacao",
        "FinPedidoSituacao" => "fin_pedido_situacao",
        "FinPedidoTb" => "fin_pedido",
        "FinPortaria" => "fin_portaria",
        "FinPreOrdemTb" => "fin_pre_ordem",
        "FinProtocoloTb" => "fin_protocolo",
        "FinQdd" => "fin_qdd",
        "FinQddSupRed" => "fin_qdd_sup_red",
        "FinQddSupRedTrans" => "fin_qdd_sup_red_trans",
        "FinsQddValorTb" => "fin_qdd_valor",
        "FinSubFiscalTb" => "fin_sub_fiscal",
        "FinTipoAdministracao" => "fin_tipo_administracao",
        "FinTipoDocumentoTb" => "fin_tipo_documento",
        "FinTipoSolicitacao" => "fin_tipo_solicitacao",
        "FinTramitacao" => "fin_tramitacao",
        "ForFornecedor" => "for_fornecedor",
        "ForFornecedorMaterialConsumo" => "for_fornecedor_material_consumo",
        "ForFornecedorMaterialPermanente" => "for_fornecedor_material_permanente",
        "ForFornecedorMedicamento" => "for_fornecedor_medicamento",
        "ForFornecedorServico" => "for_fornecedor_servico",
        "ForMaterialPermanente" => "for_material_permanente",
        "ForMedicamento" => "for_medicamento",
        "ForMetarialConsumo" => "for_material_consumo",
        "ForServico" => "for_servico",
        "PlaAcao" => "pla_acao",
        "PlaCentralPessoa" => "pla_central_pessoa",
        "PlaDiretriz" => "pla_diretriz",
        "PlaEixo" => "pla_eixo",
        "PlaEixoPpaProjAti" => "pla_eixo_ppa_proj_ati",
        "PlaIndicadorSaude" => "pla_indicador_saude",
        "PlaLiberacaoFonte" => "pla_liberacao_fonte",
        "PlaLiberacaoFonteUnidade" => "pla_liberacao_fonte_unidade",
        "PlaLiberacaoFonteUnidadeTrans" => "pla_liberacao_fonte_unidade_trans",
        "PlaMaterial" => "pla_material",
        "PlaObjetivo" => "pla_objetivo",
        "PlaPas" => "pla_pas",
        "PlaPasAcao" => "pla_pas_acao",
        "PlaPasAcaoIndicador" => "pla_pas_acao_indicador",
        "PlaPasAlteracao" => "pla_pas_alteracao",
        "PlaPasPessoaLotacao" => "pla_pas_pessoa_lotacao",
        "PlaPasValidacao" => "pla_pas_validacao",
        "PlaPes" => "pla_pes",
        "PlaPpaProg" => "pla_ppa_prog",
        "PlaPpaProjAti" => "pla_ppa_proj_ati",
        "PlaPreLoa" => "pla_pre_loa",
        "PlaPreLoaHistorico" => "pla_pre_loa_historico",
        "PlaPreLoaValores" => "pla_pre_loa_valores",
        "PlaPta" => "pla_pta",
        "PlaPtaAcaoDet" => "pla_pta_acao_det",
        "PlaPtaItem" => "pla_pta_item",
        "PlaPtaItemRecebido" => "pla_pta_item_recebido",
        "PlaPtaItemValidacao" => "pla_pta_item_validacao",
        "PlaPtaItemValidacaoItem" => "pla_pta_item_validacao_item",
        "PlaPtaTitulo" => "pla_pta_titulo",
        "PlaTipoGasto" => "pla_tipo_gasto",
        "PlaTipoGastoCategoria" => "pla_tipo_gasto_categoria",
        "PlaUnidadeMedida" => "pla_unidade_medida",
        "PlatipoGastoDespesaElementoTb" => "pla_tipo_gasto_despesa_elemento",
        "RecGrupoPessoa" => "rec_grupo_pessoa",
        "RecGrupoPessoaGrupoRecurso" => "rec_grupo_pessoa_grupo_recurso",
        "RecGrupoPessoaRecurso" => "rec_grupo_pessoa_recurso",
        "RecGrupoRecurso" => "rec_grupo_recurso",
        "RecPessoaGrupoPessoa" => "rec_pessoa_grupo_pessoa",
        "RecPessoaGrupoRecurso" => "rec_pessoa_grupo_recurso",
        "RecPessoaRecurso" => "rec_pessoa_recurso",
        "RecRecurso" => "rec_recurso",
        "RecRecursoGrupoRecurso" => "rec_recurso_grupo_recurso",
        "TabelaBlocOrcamentario" => "fin_bloco_orcamentario",
        "TabelaProgTrabFuncao" => "fin_prog_trab_funcao",
        "TabelaProgTrabPrograma" => "fin_prog_trab_programa",
        "TabelaProgTrabSubFuncao" => "fin_prog_trab_subfuncao",
        "TabelaRedeTematica" => "fin_rede_tematica",
        "TipoGastoElementoTb" => "pla_tipo_gasto_despesa_elemento",
    ];
    return $map[$cls] ?? null;
}

$models = [];
$baseDir = __DIR__ . "/../class/tabelas";
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($baseDir, RecursiveDirectoryIterator::SKIP_DOTS)
);

foreach ($files as $f) {
    if ($f->getExtension() !== "php") continue;
    $content = file_get_contents($f->getPathname());
    preg_match("/class\s+(\w+)/", $content, $cls);
    if (!$cls) continue;
    preg_match_all("/private\s+\\$(\w+)\s*=\s*null/", $content, $props);
    if (empty($props[1])) continue;
    $models[$cls[1]] = $props[1];
}

// Tables that already exist in init.sql
$existingTables = ["ses_pais","ses_estado","ses_cidade","ses_regional_saude","ses_regional_geo","ses_escolaridade","ses_formacao","ses_estado_civil","ses_vinculo","ses_tramitacao","ses_cargo","ses_funcao","ses_competencia","ses_lotacao_categoria","ses_sistema","ses_perfil","ses_pessoa","ses_perfil_pessoa","ses_pessoa_fisica","ses_pessoa_juridica","ses_lotacao","ses_contrato","ses_contrato_lotacao","ses_contrato_historico","ses_contrato_recadastramento","ses_vincular_tramitacao","ses_lotacao_detalhe","ses_log","rec_recurso","rec_grupo_recurso","rec_grupo_pessoa","rec_pessoa_recurso","rec_pessoa_grupo_recurso","rec_recurso_grupo_recurso","rec_grupo_pessoa_recurso","rec_grupo_pessoa_grupo_recurso","rec_pessoa_grupo_pessoa","fin_despesa","fin_despesa_elemento","fin_programa_trabalho"];

echo "-- =============================================\n";
echo "-- Missing Tables (~139) - Gerado automaticamente\n";
echo "-- =============================================\n\n";

$processedTables = [];

foreach ($models as $cls => $cols) {
    $table = getTableName($cls);
    if (!$table) continue;
    if (isset($processedTables[$table]) || in_array($table, $existingTables)) continue;
    $processedTables[$table] = true;

    $columns = [];
    foreach ($cols as $col) {
        $colName = toSnake($col);
        $type = inferType($colName);
        if ($type === null) continue;
        if (isset($columns[$colName])) continue;
        $columns[$colName] = $colName . " " . $type;
    }

    if (empty($columns)) continue;

    echo "\nCREATE TABLE " . $table . " (\n";
    $colList = [];
    foreach ($columns as $c) {
        $colList[] = "    " . $c;
    }
    echo implode(",\n", $colList);
    echo "\n);\n";
}

echo "\n-- Tables sem modelo: fin_ata_central, fin_cont_central, fin_licitacao, fin_tipo_empenho\n";
echo "-- fin_vigencia, ses_contrato_situacao, ses_natureza, ses_telefone\n";
echo "-- gco_* (compras/GCON): gco_anexo, gco_anotacao, gco_area_abrangencia,\n";
echo "-- gco_modalidade, gco_objeto, gco_processo, gco_processo_central,\n";
echo "-- gco_processo_tipo_gasto, gco_situacao, gco_unidade_contempladas\n";
