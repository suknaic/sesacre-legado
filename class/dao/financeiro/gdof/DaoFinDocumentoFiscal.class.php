<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/gdof/FinDocumentoFiscalTb.class.php";

class DaoFinDocumentoFiscal extends FinDocumentoFiscalTb {

    private $sucesso = false;
    private $msgRetorno = null;

    function sucesso() {
        return $this->sucesso;
    }

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    public function cadasTraDocumentoFiscal(PDO $pdo) {
        try {
            if (empty($pdo)) {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
                return false;
            }

            $sql = "insert into fin_documento_fiscal (nr_processo_administrativo, nr_documento_fiscal, mm_competencia, aa_competencia, dt_emissao, dt_atesto, 
                    vl_documento, fl_encontro_contas, fl_grp, nr_grp_numero, id_lotacao, id_tipo_documento) values(:processo, :nrDocumento, 
                    :mmCompetencia, :aaCompetencia, :dtEmissao, :dtAtesto, :vlDocumento, :flContas, :flGrp, :nrGrp, :idLotacao, :idTipoDocumento)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":processo", $this->getNrProcessoAdministrativo(), PDO::PARAM_STR);
            $stmt->bindValue(":nrDocumento", $this->getNrDocumentoFiscal(), PDO::PARAM_STR);
            $stmt->bindValue(":mmCompetencia", $this->getMmCompetencia(), PDO::PARAM_INT);
            $stmt->bindValue(":aaCompetencia", $this->getAaCompetencia(), PDO::PARAM_INT);
            $stmt->bindValue(":dtEmissao", $this->getDtEmissao(), PDO::PARAM_STR);
            $stmt->bindValue(":dtAtesto", $this->getDtAtesto(), PDO::PARAM_STR);
            $stmt->bindValue(":vlDocumento", $this->getVlDocumento(), PDO::PARAM_STR);
            $stmt->bindValue(":flContas", $this->getFlEncontroContas(), PDO::PARAM_INT);
            $stmt->bindValue(":flGrp", $this->getFlGrp(), PDO::PARAM_INT);
            $stmt->bindValue(":nrGrp", $this->getNrGrpNumero(), PDO::PARAM_INT);
            $stmt->bindValue(":idLotacao", $this->getIdLotacao(), PDO::PARAM_INT);
            $stmt->bindValue(":idTipoDocumento", $this->getIdTipoDocumento(), PDO::PARAM_INT);
            $stmt->execute();
            $this->sucesso = true;
        } catch (PDOException $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
    function update(PDO $pdo = null){
        try {
            if (!empty($pdo)) {
                $sql = "UPDATE fin_documento_fiscal SET nr_processo_administrativo = :nrProcessoAdministrativo"
                        . " , nr_documento_fiscal = :nrDocumentoFiscal, mm_competencia = :mmCompetencia"
                        . " , aa_competencia = :aaCompetencia, dt_emissao = :dtEmissao"
                        . " , dt_atesto = :dtAtesto, vl_documento = :vlDocumento"
                        . " , fl_grp = :flGrp, nr_grp_numero = :nrGrpNumero"
                        . " , id_tipo_documento = :idTipoDocumento"
                        . " WHERE id_documento_fiscal = :idDocumentoFiscal";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':idDocumentoFiscal', $this->getIdDocumentoFiscal(), PDO::PARAM_INT);
                $stmt->bindValue(":nrProcessoAdministrativo", $this->getNrProcessoAdministrativo(), PDO::PARAM_STR);
                $stmt->bindValue(":nrDocumentoFiscal", $this->getNrDocumentoFiscal(), PDO::PARAM_STR);
                $stmt->bindValue(":mmCompetencia", $this->getMmCompetencia(), PDO::PARAM_INT);
                $stmt->bindValue(":aaCompetencia", $this->getAaCompetencia(), PDO::PARAM_INT);
                $stmt->bindValue(":dtEmissao", $this->getDtEmissao(), PDO::PARAM_STR);
                $stmt->bindValue(":dtAtesto", $this->getDtAtesto(), PDO::PARAM_STR);
                $stmt->bindValue(":vlDocumento", $this->getVlDocumento(), PDO::PARAM_STR);                
                $stmt->bindValue(":flGrp", $this->getFlGrp(), PDO::PARAM_INT);
                $stmt->bindValue(":nrGrpNumero", $this->getNrGrpNumero(), PDO::PARAM_STR);                
                $stmt->bindValue(":idTipoDocumento", $this->getIdTipoDocumento(), PDO::PARAM_INT);
                                
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (PDOException $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    function atualizaSituacaoDocumentoFiscal(PDO $pdo = null){
        try {
            if (!empty($pdo)) {
                $sql = "update fin_documento_fiscal set id_documento_situacao = :id_documento_situacao where id_documento_fiscal = :id_documento_fiscal";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':id_documento_situacao', $this->getIdDocumentoSituacao(), PDO::PARAM_INT);
                $stmt->bindValue(':id_documento_fiscal', $this->getIdDocumentoFiscal(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (PDOException $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

    /**
     * Retorna as informaçoes do contrato por id do documento fiscal 
     * @param PDO $pdo
     */
    public function retornaIfContratoPorIdDocumento(PDO $pdo) {
        try {
            $sql = "select DISTINCT(cont.nr_contrato), cont.nr_contrato, processo.cd_pregao, tp.nm_tipo_gasto, obj.nm_objeto,
                    mod.nm_modalidade, p.nm_pessoa,
                    case 
                            when pf.nr_cpf is not null then pf.nr_cpf
                        when pf.nr_cpf is null then pj.nr_cnpj
                    end as cpfCnpj
                    from fin_documento_fiscal as doc
                    inner join fin_entrega_documento as entDoc
                    on entDoc.id_documento_fiscal = doc.id_documento_fiscal 
                    inner join fin_entrega_confirmacao as entrega
                    on entrega.id_entrega_confirmacao = entDoc.id_entrega_confirmacao
                    inner join fin_ordem as ordem
                    on ordem.id_ordem = entrega.id_ordem
                    inner join fin_pedido as pedido 
                    on pedido.id_pedido = ordem.id_pedido
                    inner join fin_fornecedor as f
                    on f.id_fornecedor  =  pedido.id_fornecedor
                    inner join fin_contrato as cont
                    on cont.id_contrato = f.id_contrato
                    inner join gco_processo as processo
                    on processo.id_processo = cont.id_processo
                    inner join gco_objeto as obj
                    on obj.id_objeto = processo.id_objeto
                    inner join pla_tipo_gasto as tp
                    on tp.id_tipo_gasto = cont.id_tipo_gasto
                    inner join gco_modalidade as mod
                    on mod.id_modalidade = processo.id_modalidade
                    inner join ses_pessoa as p
                    on p.id_pessoa = f.id_pessoa 
                    left join ses_pessoa_fisica as pf
                    on pf.id_pessoa = p.id_pessoa
                    left join ses_pessoa_juridica as pj
                    on pj.id_pessoa = p.id_pessoa
                    where doc.id_documento_fiscal = :documento";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":documento", $this->getIdDocumentoFiscal(), PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "Não foi possível Localizar o Contrato";
                $this->sucesso = false;
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    /**
     * retorna as informaçoes do pedido por id do documento fiscal
     * @param PDO $pdo
     */
    public function retornaIfPedidoPorIdDocumento(PDO $pdo) {
        try {
            $sql = "select DISTINCT (p.nr_pedido), p.nr_pedido, p.id_lotacao, p.ds_pedido, f.nr_fonte,
                    programa.cd_programa_trabalho, programa.ds_programa_trabalho,
                    despesa.cd_despesa_elemento, despesa.ds_despesa_elemento,
                    p.vl_pedido, desp.cd_despesa, desp.ds_despesa
                    from fin_documento_fiscal as doc
                    inner join fin_entrega_documento as entDocumento
                    on entDocumento.id_documento_fiscal  = doc.id_documento_fiscal
                    inner join fin_entrega_confirmacao as confirmacao
                    on confirmacao.id_entrega_confirmacao = entDocumento.id_entrega_confirmacao
                    inner join fin_ordem as ordem
                    on ordem.id_ordem = confirmacao.id_ordem
                    inner join fin_pedido as p
                    on p.id_pedido = ordem.id_pedido
                    inner join fin_fonte as f
                    on f.id_fonte = p.id_fonte
                    inner join view_programa_trabalho as programa
                    on programa.id_programa_trabalho = p.id_programa_trabalho
                    inner join view_despesa_elemento as despesa
                    on despesa.id_despesa_elemento = p.id_despesa_elemento
                    inner join fin_despesa as desp
                    on desp.id_despesa = p.id_despesa
                    where doc.id_documento_fiscal = :documento";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":documento", $this->getIdDocumentoFiscal(), PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "Não foi possível Localizar o Contrato";
                $this->sucesso = false;
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    /**
     * retorna informacoes do empenho por id do documento fiscal
     * @param PDO $pdo
     */
    public function retornaIfEmpenhoPorIdDocumento(PDO $pdo) {
        try {
            $sql = "select DISTINCT (emp.nr_empenho), emp.nr_empenho, to_char(emp.dt_empenho_safira, 'DD/MM/YYYY') as dataEmpenho,
                    tpEmp.nm_tipo_empenho, emp.vl_empenho
                    from fin_documento_fiscal as doc
                    inner join fin_entrega_documento as entDoc
                    on entDoc.id_documento_fiscal = doc.id_documento_fiscal
                    inner join fin_entrega_confirmacao as entrega
                    on entrega.id_entrega_confirmacao = entDoc.id_entrega_confirmacao
                    inner join fin_ordem as ordem
                    on ordem.id_ordem = entrega.id_ordem
                    inner join fin_empenho as emp
                    on emp.id_pedido =  ordem.id_pedido
                    inner join fin_tipo_empenho as tpEmp
                    on tpEmp.id_tipo_empenho = emp.id_tipo_empenho
                    where doc.id_documento_fiscal = :documento";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":documento", $this->getIdDocumentoFiscal(), PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "Não foi possível Localizar o Contrato";
                $this->sucesso = false;
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function retornaOrdemVinculadaAoDocumentoFiscal(PDO $pdo) {
        try {
//            $sql = "select ordem.id_ordem, concat(concat(ordem.nr_ordem, '/'),ordem.aa_ordem) as ordem,
//                    case 
//                            when ordem.tp_ordem = '1' then 'Entrega'
//                            when ordem.tp_ordem = '2' then 'Serviço/Execução'
//                    end tipo,
//                    sum(ordemItens.qt_itens_ordem * ordemItens.vl_itens_ordem) as valor
//                    from fin_documento_fiscal as documento
//                    inner join fin_entrega_documento as entDoc
//                    on entDoc.id_documento_fiscal = documento.id_documento_fiscal
//                    inner join fin_entrega_confirmacao as entrega
//                    on entrega.id_entrega_confirmacao = entDoc.id_entrega_confirmacao
//                    inner join fin_ordem as ordem
//                    on ordem.id_ordem  = entrega.id_ordem
//                    inner join fin_ordem_itens as ordemItens
//                    on ordemItens.id_ordem = ordem.id_ordem
//                    where documento.id_documento_fiscal = :documento
//                    and ordem.sit_ordem <> '0'
//                    group by ordem.id_ordem";
            $sql = "select ordem.id_ordem, concat(concat(ordem.nr_ordem, '/'),ordem.aa_ordem) as ordem,
                    case 
                        when ordem.tp_ordem = '1' then 'Entrega'
                        when ordem.tp_ordem = '2' then 'Serviço/Execução'
                    end tipo,
                    case
                        when ordem.sit_ordem = '0' then 'Cancelada'
                        when ordem.sit_ordem = '1' then 'Cadastrada'
                        when ordem.sit_ordem = '2' then 'Requisitada'
                        when ordem.sit_ordem = '3' then 'Finalizada'
                    end situacao,
                    (select sum(ordemValor.qt_itens_ordem * ordemValor.vl_itens_ordem) from fin_ordem_itens as ordemValor where ordemValor.id_ordem = ordem.id_ordem) as valor
                    from fin_documento_fiscal as documento
                    inner join fin_entrega_documento as entDoc
                    on entDoc.id_documento_fiscal = documento.id_documento_fiscal
                    inner join fin_entrega_confirmacao as entrega
                    on entrega.id_entrega_confirmacao = entDoc.id_entrega_confirmacao
                    inner join fin_ordem as ordem
                    on ordem.id_ordem  = entrega.id_ordem
                    inner join fin_ordem_itens as ordemItens
                    on ordemItens.id_ordem = ordem.id_ordem
                    where documento.id_documento_fiscal = :documento
                    group by ordem.id_ordem";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":documento", $this->getIdDocumentoFiscal(), PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "Não foi possível Localizar o Contrato";
                $this->sucesso = false;
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
    public function retornaEntregaVinculadoAoDocumentoFiscalVer(PDO $pdo) {
        try {
            $sql = "select
                        entrega.id_entrega_confirmacao,
                        entrega.nr_entrega_confirmacao,
                        ordem.id_ordem,
                        docEnt.id_entrega_documento,
                        (
                           ordem.nr_ordem || '/' || ordem.aa_ordem 
                        )
                        as ordem,
                        to_char(protocolo.dh_recebimento, 'DD/MM/YYYY') as dataaviso,
                        to_char(protocolo.dt_entrega, 'DD/MM/YYYY') as datalimite,
                        to_char(entrega.dt_entrega, 'DD/MM/YYYY') as entreguedia,
                        ordem.nr_prazo_ordem,
                        case
                           when
                              entrega.sit_entrega = '1' 
                           then
                              'Entrega Parcial' 
                           when
                              entrega.sit_entrega = '2' 
                           then
                              'Entrega Total' 
                        end
                        situacao, 
                        (
                           select
                              sum(itens.qt_itens_entrega * itens.vl_itens_entrega) 
                           from
                              fin_entrega_itens as itens 
                           where
                              itens.id_entrega_confirmacao = entrega.id_entrega_confirmacao 
                        )
                        as vl_total_entrega 	/*VALOR TOTAL DA ENTREGA*/
                     ,
                        docEnt.vl_entrega_saldo 	/*VALOR UTILIZADO DA ENTREGA*/
                     ,
                        docEnt.vl_entrega_documento 
                     from
                        fin_entrega_confirmacao as entrega,
                        fin_protocolo as protocolo,
                        fin_ordem as ordem,
                        fin_entrega_documento as docEnt 
                     where
                        entrega.id_protocolo = protocolo.id_protocolo 
                        and entrega.id_ordem = ordem.id_ordem 
                        and entrega.id_entrega_confirmacao = docEnt.id_entrega_confirmacao 
                        and docEnt.id_documento_fiscal = :documento 
                     order by
                        docEnt.id_entrega_confirmacao";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":documento", $this->getIdDocumentoFiscal(), PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "Não foi possível Localizar o Contrato";
                $this->sucesso = false;
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function retornaEntregaVinculadoAoDocumentoFiscalEdicao(PDO $pdo) {
        try {
            $sql = "select
                        entrega.id_entrega_confirmacao,
                        entrega.nr_entrega_confirmacao,
                        ordem.id_ordem,
                        docEnt.id_entrega_documento,
                        (
                           ordem.nr_ordem || '/' || ordem.aa_ordem
                        )
                        as ordem,
                        to_char(protocolo.dh_recebimento, 'DD/MM/YYYY') as dataaviso,
                        to_char(protocolo.dt_entrega, 'DD/MM/YYYY') as datalimite,
                        to_char(entrega.dt_entrega, 'DD/MM/YYYY') as entreguedia,
                        ordem.nr_prazo_ordem,
                        case
                           when
                              entrega.sit_entrega = '1' 
                           then
                              'Entrega Parcial' 
                           when
                              entrega.sit_entrega = '2' 
                           then
                              'Entrega Total' 
                        end
                        situacao, 
                        entrega.sit_entrega,
                        (
                           select
                              sum(itens.qt_itens_entrega * itens.vl_itens_entrega) 
                           from
                              fin_entrega_itens as itens 
                           where
                              itens.id_entrega_confirmacao = entrega.id_entrega_confirmacao 
                        )
                        as vl_total_entrega 	/*VALOR TOTAL DA ENTREGA*/
                     ,
                        (
                           select
                              coalesce(sum(vl_entrega_documento), 0) 
                           from
                              fin_entrega_documento as entDoc,
                              fin_documento_fiscal as docFis 
                           where
                              entDoc.id_documento_fiscal = docFis.id_documento_fiscal 
                              and 
                              (
                                 docFis.id_documento_situacao <> 7 				/*DIFERENTE DE CANCELADO*/
                                 or docFis.id_documento_situacao is null 				/*VERIFICAR OS SEM TRAMITAÇÃO, ESTES POSSUEM NULL NO CAMPO 'id_documento_situacao'*/
                              )
                              and entDoc.id_entrega_confirmacao = entrega.id_entrega_confirmacao 
                        )
                        as vl_utilizado_entrega 	/*VALOR UTILIZADO DA ENTREGA*/,
                        docEnt.vl_entrega_documento
                     from
                        fin_entrega_confirmacao as entrega,
                        fin_protocolo as protocolo,
                        fin_ordem as ordem,
                        fin_entrega_documento as docEnt 
                     where
                        entrega.id_protocolo = protocolo.id_protocolo 
                        and entrega.id_ordem = ordem.id_ordem 
                        and entrega.id_entrega_confirmacao = docEnt.id_entrega_confirmacao 
                        and docEnt.id_documento_fiscal = :documento order by docEnt.id_entrega_confirmacao";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":documento", $this->getIdDocumentoFiscal(), PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "Não foi possível Localizar o Contrato";
                $this->sucesso = false;
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function retornaTrDocumentosFiscais(PDO $pdo, string $filtroSql = "") {
        try {
            $sql = "select
                        doc.id_documento_fiscal,
                        doc.nr_documento_fiscal,
                        to_char(doc.dt_emissao,'dd/mm/yyyy') as dt_emissao, 
                        pedido.nr_pedido,
                        contrato.nr_contrato,
                        emp.nr_empenho,
                        tpDoc.nm_tipo_documento,
                        (
                           trim(to_char(doc.mm_competencia, '09')) || '/' || trim(to_char(doc.aa_competencia, '9999'))
                        )
                        as competencia,
                        doc.vl_documento,
                        situacao.nm_situacao, p.nm_pessoa,
                        tpTramitacao.nm_tipo_tramitacao,
                        case
                            when 
                                pf.nr_cpf is null
                            then 
                                substring(pj.nr_cnpj, 1, 2) || '.' || substring(pj.nr_cnpj, 3, 3) || '.' || substring(pj.nr_cnpj, 6, 3) || '/' || substring(pj.nr_cnpj, 9, 4) || '-' || substring(pj.nr_cnpj, 13) || ' - ' || p.nm_pessoa
                            else 
                                substring(pf.nr_cpf, 1,3) || '.' || substring(pf.nr_cpf, 4,3) || '.' || substring(pf.nr_cpf, 7,3) || '-' || substring(pf.nr_cpf,10) || ' - ' || p.nm_pessoa
                        end as cpf_cnpj_fornecedor,
                        case
                           when
                              tramitacao.id_tipo_tramitacao = '3' 
                           then
                              concat(concat(docTipoLotacaoDestino.nm_doc_tipo_lotacao, ' / '), lotacaoDestino.nm_lotacao) 
                           else
                              concat(concat(docTipoLotacaoOrigem.nm_doc_tipo_lotacao, ' / '), lotacaoOrigem.nm_lotacao) 
                        end
                        as nm_lotacao 
                     from
                        fin_documento_fiscal as doc 
                        inner join
                           fin_tipo_documento as tpDoc 
                           on tpDoc.id_tipo_documento = doc.id_tipo_documento 
                        inner join
                           (
                              SELECT DISTINCT
                                 ON (id_documento_fiscal) * 
                              FROM
                                 fin_entrega_documento 
                           )
                           AS entDoc 
                           on entDoc.id_documento_fiscal = doc.id_documento_fiscal 
                        inner join
                           fin_entrega_confirmacao as entrega 
                           on entrega.id_entrega_confirmacao = entDoc.id_entrega_confirmacao 
                        inner join
                           fin_ordem as ordem 
                           on ordem.id_ordem = entrega.id_ordem 
                        inner join
                           fin_empenho as emp 
                           on emp.id_pedido = ordem.id_pedido 
                        inner join
                           fin_pedido as pedido 
                           on ordem.id_pedido = pedido.id_pedido 
                        inner join
                           pla_tipo_gasto as tipoGasto 
                           on tipoGasto.id_tipo_gasto = pedido.id_tipo_gasto 
                        inner join
                           fin_tipo_empenho as tpEmp 
                           on tpEmp.id_tipo_empenho = emp.id_tipo_empenho 
                        inner join
                           fin_fornecedor as fornecedor 
                           on fornecedor.id_fornecedor = pedido.id_fornecedor 
                        inner join 
                          ses_pessoa as p
                           on p.id_pessoa = fornecedor.id_pessoa 
                        left join 
                          ses_pessoa_fisica as pf
                           on pf.id_pessoa = p.id_pessoa
                        left join 
                          ses_pessoa_juridica as pj
                           on pj.id_pessoa = p.id_pessoa
                        inner join fin_contrato as contrato 
                           on contrato.id_contrato = fornecedor.id_contrato 
                        inner join
                           (
                              select DISTINCT
                                 ON (t.id_documento_fiscal) 'asd',
                                 TA.id_documento_fiscal,
                                 TA.id_doc_tramitacao,
                                 TA.id_documento_situacao,
                                 TA.id_tipo_tramitacao,
                                 TA.id_doc_origem,
                                 TA.id_doc_destino,
                                 TA.fl_pesquisa 
                              from
                                 fin_doc_tramitacao t 
                                 INNER JOIN
                                    fin_doc_tramitacao TA 
                                    on TA.id_documento_fiscal = t.id_documento_fiscal 
                              where
                                 ta.fl_pesquisa = '1' 
                              order by
                                 t.id_documento_fiscal,
                                 TA.dh_doc_tramitacao DESC
                           )
                           AS tramitacao 
                           on tramitacao.id_documento_fiscal = doc.id_documento_fiscal 
                        inner join
                           fin_documento_situacao as situacao 
                           on situacao.id_documento_situacao = tramitacao.id_documento_situacao 
                        inner join
                           fin_tipo_tramitacao as tpTramitacao 
                           on tpTramitacao.id_tipo_tramitacao = tramitacao.id_tipo_tramitacao 
                        left join
                           fin_doc_lotacao as docLotacaoOrigem 
                           on docLotacaoOrigem.id_doc_lotacao = tramitacao.id_doc_origem 
                        left join
                           fin_doc_tipo_lotacao as docTipoLotacaoOrigem 
                           on docTipoLotacaoOrigem.id_doc_tipo_lotacao = docLotacaoOrigem.id_doc_tipo_lotacao 
                        left join
                           ses_lotacao as lotacaoOrigem 
                           on lotacaoOrigem.id_lotacao = docLotacaoOrigem.id_lotacao 
                        left join
                           fin_doc_lotacao as docLotacaoDestino 
                           on docLotacaoDestino.id_doc_lotacao = tramitacao.id_doc_destino 
                        left join
                           fin_doc_tipo_lotacao as docTipoLotacaoDestino 
                           on docTipoLotacaoDestino.id_doc_tipo_lotacao = docLotacaoDestino.id_doc_tipo_lotacao 
                        left join
                           ses_lotacao as lotacaoDestino 
                           on lotacaoDestino.id_lotacao = docLotacaoDestino.id_lotacao 
                     where
                        tramitacao.fl_pesquisa = '1' " . $filtroSql ." order by doc.nr_documento_fiscal desc";

            $stmt = $pdo->prepare($sql);

            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "Nenhum Documento Fiscal Encontrado";
                $this->sucesso = false;
            }
        } catch (PDOException $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function retornaDadosDocumento(PDO $pdo) {
        try {
            $sql = "select * from fin_documento_fiscal where id_documento_fiscal = :documento";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":documento", $this->getIdDocumentoFiscal(), PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "Não foi possível Localizar o Contrato";
                $this->sucesso = false;
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function retornaDocumentoFiscaisEncaminha(PDO $pdo, string $filtroSql = "", int $idPessoa = 0) {
        try {
            $sql = "select doc.id_documento_fiscal, doc.nr_documento_fiscal,to_char(doc.dt_emissao,'dd/mm/yyyy') as dt_emissao, pedido.nr_pedido, contrato.nr_contrato, emp.nr_empenho, protoc.id_protocolo, tpDoc.nm_tipo_documento,
                    (trim(to_char(doc.mm_competencia, '09')) || '/' || trim(to_char(doc.aa_competencia, '9999'))) as competencia, to_char(doc.vl_documento,'999G999G990D0000') as vl_documento, 
                    situacao.nm_situacao, tpTramitacao.nm_tipo_tramitacao, tramitacao.id_documento_situacao,
                    
                    case
                        when 
                            pf.nr_cpf is null
                        then 
                            substring(pj.nr_cnpj, 1, 2) || '.' || substring(pj.nr_cnpj, 3, 3) || '.' || substring(pj.nr_cnpj, 6, 3) || '/' || substring(pj.nr_cnpj, 9, 4) || '-' || substring(pj.nr_cnpj, 13) || ' - ' || p.nm_pessoa
                        else 
                            substring(pf.nr_cpf, 1,3) || '.' || substring(pf.nr_cpf, 4,3) || '.' || substring(pf.nr_cpf, 7,3) || '-' || substring(pf.nr_cpf,10) || ' - ' || p.nm_pessoa
                    end as cpf_cnpj_fornecedor,
                        
                    case 
                    when lotacaoDestino.nm_lotacao is not null then concat(concat(docTipoLotacaoDestino.nm_doc_tipo_lotacao, ' / '),lotacaoDestino.nm_lotacao)
                    when lotacaoDestino.nm_lotacao is null then concat(concat(docTipoLotacaoOrigem.nm_doc_tipo_lotacao, ' / '),lotacaoOrigem.nm_lotacao) 
                    end as nm_lotacao, encaminhamento.*  
                    from fin_documento_fiscal as doc 

                    inner join fin_tipo_documento as tpDoc 
                    on tpDoc.id_tipo_documento = doc.id_tipo_documento 

                    inner join (SELECT DISTINCT ON (id_documento_fiscal) *
			FROM fin_entrega_documento
		    ) AS entDoc on entDoc.id_documento_fiscal = doc.id_documento_fiscal

                    inner join fin_entrega_confirmacao as entrega 
                    on entrega.id_entrega_confirmacao = entDoc.id_entrega_confirmacao 

                    inner join  fin_ordem as ordem 
                    on ordem.id_ordem = entrega.id_ordem 

                    inner join fin_empenho as emp 
                    on emp.id_pedido = ordem.id_pedido 

                    inner join fin_protocolo as protoc 
                    on protoc.id_ordem = ordem.id_ordem 

                    inner join fin_pedido as pedido 
                    on ordem.id_pedido = pedido.id_pedido 

                    inner join pla_tipo_gasto as tipoGasto 
                    on tipoGasto.id_tipo_gasto = pedido.id_tipo_gasto 

                    inner join fin_tipo_empenho as tpEmp 
                    on tpEmp.id_tipo_empenho = emp.id_tipo_empenho 

                    inner join fin_fornecedor as fornecedor 
                    on fornecedor.id_fornecedor = pedido.id_fornecedor 
                    
                    inner join ses_pessoa as p
                    on p.id_pessoa = fornecedor.id_pessoa 
                        
                    left join ses_pessoa_fisica as pf
                    on pf.id_pessoa = p.id_pessoa
                        
                    left join ses_pessoa_juridica as pj
                    on pj.id_pessoa = p.id_pessoa
                    
                    inner join fin_contrato as contrato 
                    on contrato.id_contrato = fornecedor.id_contrato 
                 
                    inner join (select DISTINCT ON (t.id_documento_fiscal) *
                                from fin_doc_tramitacao t				
                                order by t.id_documento_fiscal
                                , t.dh_doc_tramitacao desc, t.fl_pesquisa asc) AS tramitacao 
					on tramitacao.id_documento_fiscal = doc.id_documento_fiscal
                                        
                    inner join fin_documento_situacao as situacao
                    on situacao.id_documento_situacao =  tramitacao.id_documento_situacao

                    inner join fin_tipo_tramitacao as tpTramitacao
                    on tpTramitacao.id_tipo_tramitacao = tramitacao.id_tipo_tramitacao

                    left join fin_doc_lotacao as docLotacaoOrigem
                    on docLotacaoOrigem.id_doc_lotacao = tramitacao.id_doc_origem

                    left join fin_doc_tipo_lotacao as docTipoLotacaoOrigem
                    on docTipoLotacaoOrigem.id_doc_tipo_lotacao = docLotacaoOrigem.id_doc_tipo_lotacao

                    left join ses_lotacao as lotacaoOrigem
                    on lotacaoOrigem.id_lotacao =  docLotacaoOrigem.id_lotacao 

                    left join fin_doc_lotacao as docLotacaoDestino
                    on docLotacaoDestino.id_doc_lotacao = tramitacao.id_doc_destino

                    left join fin_doc_tipo_lotacao as docTipoLotacaoDestino
                    on docTipoLotacaoDestino.id_doc_tipo_lotacao = docLotacaoDestino.id_doc_tipo_lotacao

                    left join ses_lotacao as lotacaoDestino
                    on lotacaoDestino.id_lotacao =  docLotacaoDestino.id_lotacao

                    left join fin_doc_vinc_encaminhamento as encaminhamento
                    on encaminhamento.id_doc_lotacao = docLotacaoOrigem.id_doc_lotacao 
                    where tramitacao.fl_pesquisa = '0' and encaminhamento.id_pessoa = :pessoa and tpTramitacao.id_tipo_tramitacao = 2  and encaminhamento.id_doc_lotacao is not null  " . $filtroSql;
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":pessoa", $idPessoa, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "Nenhum Documento Fiscal Encontrado";
                $this->sucesso = false;
            }
        } catch (PDOException $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
    
    public function retornaDocumentoFiscaisRecebe(PDO $pdo, string $filtroSql = "", int $idPessoa = 0) {
        try {
            $sql = "select doc.id_documento_fiscal, doc.nr_documento_fiscal,to_char(doc.dt_emissao,'dd/mm/yyyy') as dt_emissao, pedido.nr_pedido, contrato.nr_contrato, emp.nr_empenho, protoc.id_protocolo, tpDoc.nm_tipo_documento,
                    (trim(to_char(doc.mm_competencia, '09')) || '/' || trim(to_char(doc.aa_competencia, '9999'))) as competencia, doc.vl_documento, 
                    situacao.nm_situacao, tpTramitacao.nm_tipo_tramitacao,
                    
                    case
                        when 
                            pf.nr_cpf is null
                        then 
                            substring(pj.nr_cnpj, 1, 2) || '.' || substring(pj.nr_cnpj, 3, 3) || '.' || substring(pj.nr_cnpj, 6, 3) || '/' || substring(pj.nr_cnpj, 9, 4) || '-' || substring(pj.nr_cnpj, 13) || ' - ' || p.nm_pessoa
                        else 
                            substring(pf.nr_cpf, 1,3) || '.' || substring(pf.nr_cpf, 4,3) || '.' || substring(pf.nr_cpf, 7,3) || '-' || substring(pf.nr_cpf,10) || ' - ' || p.nm_pessoa
                    end as cpf_cnpj_fornecedor,
                    
                    case 
                    when lotacaoDestino.nm_lotacao is not null then concat(concat(docTipoLotacaoDestino.nm_doc_tipo_lotacao, ' / '),lotacaoDestino.nm_lotacao)
                    when lotacaoDestino.nm_lotacao is null then concat(concat(docTipoLotacaoOrigem.nm_doc_tipo_lotacao, ' / '),lotacaoOrigem.nm_lotacao) 
                    end as nm_lotacao, recebimento.*  
                    from fin_documento_fiscal as doc 

                    inner join fin_tipo_documento as tpDoc 
                    on tpDoc.id_tipo_documento = doc.id_tipo_documento 

                    inner join (SELECT DISTINCT ON (id_documento_fiscal) *
			FROM fin_entrega_documento
		    ) AS entDoc on entDoc.id_documento_fiscal = doc.id_documento_fiscal

                    inner join fin_entrega_confirmacao as entrega 
                    on entrega.id_entrega_confirmacao = entDoc.id_entrega_confirmacao 

                    inner join  fin_ordem as ordem 
                    on ordem.id_ordem = entrega.id_ordem 

                    inner join fin_empenho as emp 
                    on emp.id_pedido = ordem.id_pedido 

                    inner join fin_protocolo as protoc 
                    on protoc.id_ordem = ordem.id_ordem 

                    inner join fin_pedido as pedido 
                    on ordem.id_pedido = pedido.id_pedido 

                    inner join pla_tipo_gasto as tipoGasto 
                    on tipoGasto.id_tipo_gasto = pedido.id_tipo_gasto 

                    inner join fin_tipo_empenho as tpEmp 
                    on tpEmp.id_tipo_empenho = emp.id_tipo_empenho 

                    inner join fin_fornecedor as fornecedor 
                    on fornecedor.id_fornecedor = pedido.id_fornecedor 
                    
                    inner join ses_pessoa as p
                    on p.id_pessoa = fornecedor.id_pessoa 
                    
                    left join ses_pessoa_fisica as pf
                    on pf.id_pessoa = p.id_pessoa
                    
                    left join ses_pessoa_juridica as pj
                    on pj.id_pessoa = p.id_pessoa
                    
                    inner join fin_contrato as contrato 
                    on contrato.id_contrato = fornecedor.id_contrato 

                    inner join (select DISTINCT ON (t.id_documento_fiscal) *
                                from fin_doc_tramitacao t				
                                order by t.id_documento_fiscal
                                , t.dh_doc_tramitacao desc, t.fl_pesquisa asc) AS tramitacao 
                                on tramitacao.id_documento_fiscal = doc.id_documento_fiscal

                    inner join fin_documento_situacao as situacao
                    on situacao.id_documento_situacao =  tramitacao.id_documento_situacao

                    inner join fin_tipo_tramitacao as tpTramitacao
                    on tpTramitacao.id_tipo_tramitacao = tramitacao.id_tipo_tramitacao

                    left join fin_doc_lotacao as docLotacaoOrigem
                    on docLotacaoOrigem.id_doc_lotacao = tramitacao.id_doc_origem

                    left join fin_doc_tipo_lotacao as docTipoLotacaoOrigem
                    on docTipoLotacaoOrigem.id_doc_tipo_lotacao = docLotacaoOrigem.id_doc_tipo_lotacao

                    left join ses_lotacao as lotacaoOrigem
                    on lotacaoOrigem.id_lotacao =  docLotacaoOrigem.id_lotacao 

                    left join fin_doc_lotacao as docLotacaoDestino
                    on docLotacaoDestino.id_doc_lotacao = tramitacao.id_doc_destino

                    left join fin_doc_tipo_lotacao as docTipoLotacaoDestino
                    on docTipoLotacaoDestino.id_doc_tipo_lotacao = docLotacaoDestino.id_doc_tipo_lotacao

                    left join ses_lotacao as lotacaoDestino
                    on lotacaoDestino.id_lotacao =  docLotacaoDestino.id_lotacao

                    left join fin_doc_vinc_recebimento as recebimento
                    on recebimento.id_doc_lotacao = docLotacaoOrigem.id_doc_lotacao 
                    where tramitacao.fl_pesquisa = '0' and tpTramitacao.id_tipo_tramitacao = 4 and recebimento.id_pessoa = :pessoa and recebimento.id_doc_lotacao is not null  " . $filtroSql;
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":pessoa", $idPessoa, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "Nenhum Documento Fiscal Encontrado";
                $this->sucesso = false;
            }
        } catch (PDOException $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }
    

    /**
     * Esse metodo nao e para ser criado aqui mais por falta de tempo foi espero quem veja corrija 
     * @param PDO $pdo
     */
    public function retornaTipoLotacaoParaEncaminhamento(PDO $pdo, int $idPessoa = 0) {
        try {
//            $sql = "select tipoLotacaoDestinario.id_doc_tipo_lotacao, tipoLotacaoDestinario.nm_doc_tipo_lotacao
//                    from fin_doc_vinc_encaminhamento as encaminhamento
//
//                    inner join fin_doc_lotacao as lotacaoTipo
//                    on lotacaoTipo.id_doc_lotacao = encaminhamento.id_doc_lotacao
//
//                    inner join fin_doc_tipo_lotacao as tipoLotacao
//                    on tipoLotacao.id_doc_tipo_lotacao = lotacaoTipo.id_doc_tipo_lotacao
//
//                    inner join fin_doc_parm_tramitacao as parametro
//                    on parametro.id_doc_tipo_remetente  =  tipoLotacao.id_doc_tipo_lotacao
//
//                    inner join fin_doc_tipo_lotacao as tipoLotacaoDestinario
//                    on tipoLotacaoDestinario.id_doc_tipo_lotacao = parametro.id_doc_tipo_destinatario
//
//                    where encaminhamento.id_pessoa = :pessoa
//                    group by tipoLotacaoDestinario.id_doc_tipo_lotacao, tipoLotacaoDestinario.nm_doc_tipo_lotacao";
            $sql = "select distinct docTpDest.id_doc_tipo_lotacao, docTpDest.nm_doc_tipo_lotacao
                    from fin_doc_vinc_encaminhamento as enc
                    inner join fin_doc_lotacao as docLot
                    on docLot.id_doc_lotacao = enc.id_doc_lotacao
                    inner join  fin_doc_tipo_lotacao as docTpLot
                    on docTpLot.id_doc_tipo_lotacao = docLot.id_doc_tipo_lotacao
                    inner join fin_doc_parm_tramitacao as param
                    on param.id_doc_tipo_remetente = docTpLot.id_doc_tipo_lotacao
                    inner join fin_doc_tipo_lotacao as docTpDest
                    on docTpDest.id_doc_tipo_lotacao = param.id_doc_tipo_destinatario
                    inner join ses_pessoa as pessoa
                    on pessoa.id_pessoa = enc.id_pessoa
                    where param.tp_doc_parm_tramitacao = '1' --Encaminhar
                    and enc.id_pessoa = :pessoa
                    order by docTpDest.nm_doc_tipo_lotacao";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":pessoa", $idPessoa, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "Nenhum Documento Fiscal Encontrado";
                $this->sucesso = false;
            }
        } catch (PDOException $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
//    public function retornaTipoLotacaoParaRecebimento(PDO $pdo, int $idPessoa = 0){
//        try {
//            $sql = "select tipoLotacaoRemetente.id_doc_tipo_lotacao, tipoLotacaoRemetente.nm_doc_tipo_lotacao
//                    from fin_doc_vinc_recebimento as recebimento
//
//                    inner join fin_doc_lotacao as lotacaoTipo
//                    on lotacaoTipo.id_doc_lotacao = recebimento.id_doc_lotacao
//
//                    inner join fin_doc_tipo_lotacao as tipoLotacao
//                    on tipoLotacao.id_doc_tipo_lotacao = lotacaoTipo.id_doc_tipo_lotacao
//
//                    inner join fin_doc_parm_tramitacao as parametro
//                    on parametro.id_doc_tipo_remetente  =  tipoLotacao.id_doc_tipo_lotacao
//
//                    inner join fin_doc_tipo_lotacao as tipoLotacaoRemetente
//                    on tipoLotacaoRemetente.id_doc_tipo_lotacao = parametro.id_doc_tipo_remetente
//
//                    where recebimento.id_pessoa = :pessoa
//                    group by tipoLotacaoRemetente.id_doc_tipo_lotacao, tipoLotacaoRemetente.nm_doc_tipo_lotacao";
//            $stmt = $pdo->prepare($sql);
//            $stmt->bindValue(":pessoa", $idPessoa, PDO::PARAM_INT);
//            $stmt->execute();
//            if ($stmt->rowCount() > 0) {
//                $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
//                $this->sucesso = true;
//            } else {
//                $this->msgRetorno = "Nenhum Documento Fiscal Encontrado";
//                $this->sucesso = false;
//            }
//        } catch (PDOException $ex) {
//            $this->sucesso = false;
//            $this->msgRetorno = $ex->getMessage();
//        }
//    }
    

    public function retornaDestinatarioPorTipo(PDO $pdo, $tipo) {
        try {
            $sql = "select lotacao.id_lotacao, lotacao.nm_lotacao, docLotacao.id_doc_lotacao 
                    from fin_doc_lotacao as docLotacao
                    inner join ses_lotacao as lotacao
                    on lotacao.id_lotacao = docLotacao.id_lotacao
                    where docLotacao.id_doc_tipo_lotacao = :tipo";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":tipo", $tipo, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "Nenhum Documento Fiscal Encontrado";
                $this->sucesso = false;
            }
        } catch (PDOException $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
    public function retornaRemetentePorTipo(PDO $pdo , $tipo){
        try {
             $sql = "select lotacao.id_lotacao, lotacao.nm_lotacao, docLotacao.id_doc_lotacao 
                    from fin_doc_lotacao as docLotacao
                    inner join ses_lotacao as lotacao
                    on lotacao.id_lotacao = docLotacao.id_lotacao
                    where docLotacao.id_doc_tipo_lotacao = :tipo";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":tipo", $tipo, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "Nenhum Documento Fiscal Encontrado";
                $this->sucesso = false;
            }
        } catch (PDOException $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function retornaUltimoTipoRemetenteTramitacao(PDO $pdo) {
        try {
            $sql = "select id_doc_origem,id_doc_tipo_lotacao as tipo_remetente
                    from fin_doc_tramitacao
                    inner join fin_doc_lotacao tipoLot
                    on tipoLot.id_doc_lotacao = id_doc_origem 
                    where id_documento_fiscal = :documento
                    order by id_doc_tramitacao desc 
                    limit 1";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":documento", $this->getIdDocumentoFiscal(), PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "Não foi possível encontrar o remetente da última tramitação.";
                $this->sucesso = false;
            }
        } catch (PDOException $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
    public function retornaPrimeiroTipoRemetenteTramitacao(PDO $pdo) {
        try {
            $sql = "select * from fin_doc_tramitacao 
                where id_documento_fiscal = :idDocumentoFiscal 
                order by dh_doc_tramitacao desc limit 1";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":idDocumentoFiscal", $this->getIdDocumentoFiscal(), PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "Não foi possível encontrar o remetente da última tramitação.";
                $this->sucesso = false;
            }
        } catch (PDOException $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
    
    //select * from fin_doc_tramitacao where id_documento_fiscal = 3 order by dh_doc_tramitacao desc limit 1
    
    public function verificaPermissaoEncaminhar(PDO $pdo, int $idPessoa = 0, int $tipoRemetente = 0){
        try {
            $sql = "select count(*) from fin_doc_vinc_encaminhamento as encaminhar
                    inner join fin_doc_lotacao as tipoLotacao
                    on encaminhar.id_doc_lotacao = tipoLotacao.id_doc_lotacao
                    where tipoLotacao.id_doc_tipo_lotacao = :tipo_remetente
                    and encaminhar.id_pessoa = :pessoa";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":pessoa", $idPessoa, PDO::PARAM_INT);
            $stmt->bindValue(':tipo_remetente', $tipoRemetente, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "Sem permissão para encaminhar.";
                $this->sucesso = false;
            }
        } catch (PDOException $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
    public function retornaOrigemDestinoUltimaTramitacao(PDO $pdo){
        try {
            $sql = "select id_doc_origem,tipoOrigem.id_doc_tipo_lotacao as tipo_remetente ,id_doc_destino, tipoDestino.id_doc_tipo_lotacao as tipo_destinatario  from fin_doc_tramitacao as tramitacao
                    inner join fin_doc_lotacao as tipoOrigem
                    on tipoOrigem.id_doc_lotacao = tramitacao.id_doc_origem
                    inner join fin_doc_lotacao as tipoDestino
                    on tipoDestino.id_doc_lotacao = tramitacao.id_doc_destino
                    where id_documento_fiscal = :documento
                    and id_doc_origem is not null
                    and id_doc_destino is not null
                    order by id_doc_tramitacao desc
                    limit 1";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":documento", $this->getIdDocumentoFiscal(), PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "Sem permissão para encaminhar.";
                $this->sucesso = false;
            }
        } catch (PDOException $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
    public function retornaUltimaOrigemDocumento(PDO $pdo) {
        try {
            $sql = "select id_doc_origem from fin_doc_tramitacao 
                    where id_documento_fiscal = :documento
                    order by id_doc_tramitacao desc 
                    limit 1";
//            $sql = "select id_doc_origem,tipoLotOrigem.id_doc_tipo_lotacao as tipo_remetente,id_doc_destino, tipoLotDestino.id_doc_tipo_lotacao as tipo_destinatario
//                    from fin_doc_tramitacao as tramitacao
//                    left join fin_doc_lotacao as tipoLotOrigem
//                    on tipoLotOrigem.id_doc_lotacao = tramitacao.id_doc_origem
//                    left join fin_doc_lotacao as tipoLotDestino
//                    on tipoLotDestino.id_doc_lotacao = tramitacao.id_doc_destino
//                    where id_documento_fiscal = :documento
//                    and tramitacao.id_doc_destino is not null
//                    order by id_doc_tramitacao desc 
//                    limit 1";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":documento", $this->getIdDocumentoFiscal(), PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "Nenhum Documento Fiscal Encontrado";
                $this->sucesso = false;
            }
        } catch (PDOException $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
    public function retornaSituacaoDoParametro(PDO $pdo, int $lotacaoOrigem=0, int $tipo=0){
        try {
            $sql = "select parmametro.id_documento_situacao
                    from fin_doc_lotacao as docLotacao

                    inner join fin_doc_tipo_lotacao as tpLotacao
                    on tpLotacao.id_doc_tipo_lotacao = docLotacao.id_doc_tipo_lotacao

                    inner join fin_doc_parm_tramitacao as parmametro
                    on parmametro.id_doc_tipo_remetente = tpLotacao.id_doc_tipo_lotacao

                    where docLotacao.id_doc_lotacao = :lotacaoOrigem
                    and parmametro.id_doc_tipo_destinatario = :tipo
                    limit 1";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":lotacaoOrigem", $lotacaoOrigem, PDO::PARAM_INT);
            $stmt->bindValue(":tipo", $tipo, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "Nenhum Documento Fiscal Encontrado";
                $this->sucesso = false;
            }
        } catch (PDOException $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
    public function retornaSituacaoDocumentoParametro(PDO $pdo,int $tipo_remetente=0,int $tipo_destinatario =0, string $encaminhar_receber=""){
        try {
            $sql = "select id_documento_situacao from fin_doc_parm_tramitacao
                    where id_doc_tipo_remetente = :tipo_remetente
                    and id_doc_tipo_destinatario = :tipo_destinatario
                    and tp_doc_parm_tramitacao = :encaminhar_receber";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":tipo_remetente", $tipo_remetente, PDO::PARAM_INT);
            $stmt->bindValue(":tipo_destinatario", $tipo_destinatario, PDO::PARAM_INT);
            $stmt->bindValue(":encaminhar_receber", $encaminhar_receber, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "Nenhum Documento Fiscal Encontrado";
                $this->sucesso = false;
            }
        } catch (PDOException $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
    
    public function verificaPermissaoPessoaSituacaoAtual(int $idPessoa, int $idSituacao, PDO $pdo) {
        try {
            $sql = "select doc.id_documento_fiscal, doc.nr_documento_fiscal
                    , situacao.nm_situacao, situacao.id_documento_situacao
                    , tpTramitacao.nm_tipo_tramitacao, tpTramitacao.id_tipo_tramitacao
                    , case 
                    when lotacaoDestino.nm_lotacao is not null then concat(concat(docTipoLotacaoDestino.nm_doc_tipo_lotacao, ' / '),lotacaoDestino.nm_lotacao)
                    when lotacaoDestino.nm_lotacao is null then concat(concat(docTipoLotacaoOrigem.nm_doc_tipo_lotacao, ' / '),lotacaoOrigem.nm_lotacao) 
                    end as nm_lotacao, encaminhamento.id_doc_lotacao
                    from fin_documento_fiscal as doc 
                    inner join (select DISTINCT ON (t.id_documento_fiscal) *
                                from fin_doc_tramitacao t				
                                order by t.id_documento_fiscal
                                , t.dh_doc_tramitacao desc, t.fl_pesquisa asc) AS tramitacao 
                    on tramitacao.id_documento_fiscal = doc.id_documento_fiscal

                    inner join fin_documento_situacao as situacao
                    on situacao.id_documento_situacao =  tramitacao.id_documento_situacao

                    inner join fin_tipo_tramitacao as tpTramitacao
                    on tpTramitacao.id_tipo_tramitacao = tramitacao.id_tipo_tramitacao

                    left join fin_doc_lotacao as docLotacaoOrigem
                    on docLotacaoOrigem.id_doc_lotacao = tramitacao.id_doc_origem

                    left join fin_doc_tipo_lotacao as docTipoLotacaoOrigem
                    on docTipoLotacaoOrigem.id_doc_tipo_lotacao = docLotacaoOrigem.id_doc_tipo_lotacao

                    left join ses_lotacao as lotacaoOrigem
                    on lotacaoOrigem.id_lotacao =  docLotacaoOrigem.id_lotacao 

                    left join fin_doc_lotacao as docLotacaoDestino
                    on docLotacaoDestino.id_doc_lotacao = tramitacao.id_doc_destino

                    left join fin_doc_tipo_lotacao as docTipoLotacaoDestino
                    on docTipoLotacaoDestino.id_doc_tipo_lotacao = docLotacaoDestino.id_doc_tipo_lotacao

                    left join ses_lotacao as lotacaoDestino
                    on lotacaoDestino.id_lotacao =  docLotacaoDestino.id_lotacao

                    left join fin_doc_vinc_encaminhamento as encaminhamento
                    on encaminhamento.id_doc_lotacao = docLotacaoOrigem.id_doc_lotacao 

                    where tramitacao.fl_pesquisa = '0'                     
                    and encaminhamento.id_doc_lotacao is not null                        
                    and encaminhamento.id_pessoa = :idPessoa 
                    and doc.id_documento_fiscal = :idDocFiscal
                    and situacao.id_documento_situacao = :idDocumentoSituacao";
                                        
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":idPessoa", $idPessoa, PDO::PARAM_INT);
            $stmt->bindValue(":idDocFiscal", $this->getIdDocumentoFiscal(), PDO::PARAM_INT);
            $stmt->bindValue(":idDocumentoSituacao", $idSituacao, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "Nenhum Documento Fiscal Encontrado";
                $this->sucesso = false;
            }
        } catch (PDOException $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
    
    public function retornaTramitacaoDocumentoFiscal(PDO $pdo){
        try {
            $sql = "select
                        (to_char(dh_doc_tramitacao, 'dd/mm/yyyy hh24:mi:ss') || ' - ' || nm_pessoa || ': ' || nm_tipo_tramitacao || 
                        case
                           when
                              tpTramitacao.id_tipo_tramitacao = 3 
                           then
                     ( ' para o(a) ' || coalesce(docTpLotDestino.nm_doc_tipo_lotacao, '') || '/' || coalesce(lotacaoDestino.nm_lotacao, '')) 
                           else
                     ( ' pelo(a) ' || docTpLotOrigem.nm_doc_tipo_lotacao || '/' || lotacaoOrigem.nm_lotacao) 
                        end) as historico, tramitacao.ds_doc_tramitacao as obs
                     from
                        fin_doc_tramitacao as tramitacao 
                        inner join
                           ses_pessoa as pessoa 
                           on pessoa.id_pessoa = tramitacao.id_pessoa 
                        inner join
                           fin_tipo_tramitacao tpTramitacao 
                           on tpTramitacao.id_tipo_tramitacao = tramitacao.id_tipo_tramitacao 
                        inner join
                           fin_documento_situacao as docSit 
                           on docSit.id_documento_situacao = tramitacao.id_documento_situacao 
                        left join
                           fin_doc_lotacao as tpLotOrigem 
                           on tpLotOrigem.id_doc_lotacao = tramitacao.id_doc_origem 
                        left join
                           fin_doc_tipo_lotacao as docTpLotOrigem 
                           on tpLotOrigem.id_doc_tipo_lotacao = docTpLotOrigem.id_doc_tipo_lotacao 
                        left join
                           ses_lotacao as lotacaoOrigem 
                           on lotacaoOrigem.id_lotacao = tpLotOrigem.id_lotacao 
                        left join
                           fin_doc_lotacao as tpLotDestino 
                           on tpLotDestino.id_doc_lotacao = tramitacao.id_doc_destino 
                        left join
                           fin_doc_tipo_lotacao as docTpLotDestino 
                           on tpLotDestino.id_doc_tipo_lotacao = docTpLotDestino.id_doc_tipo_lotacao 
                        left join
                           ses_lotacao as lotacaoDestino 
                           on lotacaoDestino.id_lotacao = tpLotDestino.id_lotacao 
                     where
                        id_documento_fiscal = :documento 
                     order by
                        dh_doc_tramitacao desc, fl_pesquisa asc";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":documento", $this->getIdDocumentoFiscal(), PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "Nenhum Documento Fiscal Encontrado";
                $this->sucesso = false;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    

}
