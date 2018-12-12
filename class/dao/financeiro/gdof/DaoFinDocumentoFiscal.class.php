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
                    vl_documento, fl_encontro_contas, fl_grp, nr_grp_numero, id_lotacao, id_tipo_documento, id_documento_situacao, id_pedido, vl_documento_saldo, dt_vencimento) values(:processo, :nrDocumento, 
                    :mmCompetencia, :aaCompetencia, :dtEmissao, :dtAtesto, :vlDocumento, :flContas, :flGrp, :nrGrp, :idLotacao, :idTipoDocumento, :idDocumentoSituacao, :idPedido, :vlDocumentoSaldo, :dtVencimento)";
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
            $stmt->bindValue(":idDocumentoSituacao", $this->getIdDocumentoSituacao(), PDO::PARAM_INT);
            $stmt->bindValue(":idPedido", $this->getIdPedido(), PDO::PARAM_INT);
            $stmt->bindValue(":vlDocumentoSaldo", $this->getVlDocumentoSaldo(), PDO::PARAM_STR);
            $stmt->bindValue(":dtVencimento", $this->getDtVencimento(), PDO::PARAM_STR);
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
                        . " , vl_documento_saldo = :vlDocumentoSaldo"
                        . " , dt_vencimento = :dtVencimento"
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
                $stmt->bindValue(":vlDocumentoSaldo", $this->getVlDocumentoSaldo(), PDO::PARAM_STR); 
                $stmt->bindValue(":dtVencimento", $this->getDtVencimento(), PDO::PARAM_STR);
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
            $sql = "select DISTINCT (p.nr_pedido), to_char(p.dt_pedido,'YYYY') as ano_pedido,p.id_pedido, (p.nr_pedido || '/' || to_char(p.dt_pedido,'YYYY')) as nr_pedido, p.id_lotacao, p.ds_pedido, f.nr_fonte,
                    programa.cd_programa_trabalho, programa.ds_programa_trabalho,
                    despesa.cd_despesa_elemento, despesa.ds_despesa_elemento,
                    p.vl_pedido, desp.cd_despesa, desp.ds_despesa, p.id_tipo_solicitacao, doc.id_pedido
                    from fin_documento_fiscal as doc
                    left join fin_entrega_documento as entDocumento
                    on entDocumento.id_documento_fiscal  = doc.id_documento_fiscal
                    left join fin_entrega_confirmacao as confirmacao
                    on confirmacao.id_entrega_confirmacao = entDocumento.id_entrega_confirmacao
                    left join fin_ordem as ordem
                    on ordem.id_ordem = confirmacao.id_ordem
                    inner join fin_pedido as p
                    on p.id_pedido = doc.id_pedido
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
    public function retornaIfEmpenhoPorIdDocumento(PDO $pdo, $ignorarDoc) {
        try {
            
            $sqlIgnoraDoc = "";
            if(!$ignorarDoc){
                $sqlIgnoraDoc = " AND docFis.id_documento_fiscal <> :documento ";
            }
            
            $sql = "select DISTINCT
                       (emp.nr_empenho),
                       --emp.nr_empenho,
                       concat(substr(emp.nr_empenho, 1, ((LENGTH(emp.nr_empenho)-4)) ), '/',  substring(emp.nr_empenho FROM '....$')) as nr_empenho,
                       to_char(emp.dt_empenho_safira, 'DD/MM/YYYY') as dataEmpenho,
                       tpEmp.nm_tipo_empenho,
                       doc.vl_documento_saldo,
                       emp.vl_empenho,
                       (
                          emp.vl_empenho - coalesce(( 
                          select
                             sum(vl_documento) 
                          from                     
                          	 fin_pedido p
                      	  inner join fin_documento_fiscal docFis on docFis.id_pedido = p.id_pedido                              
                          where
                             p.id_pedido = doc.id_pedido 
                             ".$sqlIgnoraDoc."
                             and docFis.id_documento_situacao <> 7 
                             ), 0)
                       )
                       as saldo_empenho_gdof 
                    from
                       fin_documento_fiscal as doc 
                       left join
                          fin_entrega_documento as entDoc 
                          on entDoc.id_documento_fiscal = doc.id_documento_fiscal 
                       left join
                          fin_entrega_confirmacao as entrega 
                          on entrega.id_entrega_confirmacao = entDoc.id_entrega_confirmacao 
                       left join
                          fin_ordem as ordem 
                          on ordem.id_ordem = entrega.id_ordem 
                       inner join
                          fin_empenho as emp 
                          on emp.id_pedido = doc.id_pedido 
                       inner join
                          fin_tipo_empenho as tpEmp 
                          on tpEmp.id_tipo_empenho = emp.id_tipo_empenho 
                    where
                       doc.id_documento_fiscal = :documento";
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

            $sql = "select ordem.id_ordem, concat(concat(ordem.nr_ordem, '/'),ordem.aa_ordem) as ordem,
                    case 
                        when ordem.tp_ordem = '1' then 'Entrega'
                        when ordem.tp_ordem = '2' then 'Serviço/Execução'
                    end tipo,
                    case
                        when ordem.sit_ordem = '0' then 'Cancelada'
                        when ordem.sit_ordem = '1' THEN 'Cadastrado'
                        when ordem.sit_ordem = '2' THEN 'Requisitado'
                        when ordem.sit_ordem = '3' THEN 'Finalizado'
                        when ordem.sit_ordem = '4' THEN 'Finalizado por Supresão do Ordenado'
                        when ordem.sit_ordem = '5' THEN 'Finalizado por Descumprimento da Contratada'
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
                             sum(round((itens.qt_itens_entrega * itens.vl_itens_entrega),2)) 
                           from
                              fin_entrega_itens as itens 
                           where
                              itens.id_entrega_confirmacao = entrega.id_entrega_confirmacao 
                        )
                        as vl_total_entrega 	/*VALOR TOTAL DA ENTREGA*/
                     ,
                        coalesce(docEnt.vl_entrega_saldo,0) as vl_entrega_saldo 	/*VALOR UTILIZADO DA ENTREGA*/
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
                              and docFis.id_documento_situacao <> 7 /*DIFERENTE DE CANCELADO*/
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
                        (doc.nr_documento_fiscal || '/' || to_char(doc.dt_emissao,'YYYY') ) as nr_documento_fiscal,
                        to_char(doc.dt_emissao,'dd/mm/yyyy') as dt_emissao, 
                        (pedido.nr_pedido || '/' || to_char(pedido.dt_pedido,'YYYY') ) as nr_pedido,
                        contrato.nr_contrato,
                        --emp.nr_empenho,
                        concat(substr(emp.nr_empenho, 1, ((LENGTH(emp.nr_empenho)-4)) ), '/',  substring(emp.nr_empenho FROM '....$')) as nr_empenho,
                        nr_empenho as empenho_sm,
                        tpDoc.nm_tipo_documento,
                        (
                           trim(to_char(doc.mm_competencia, '09')) || '/' || trim(to_char(doc.aa_competencia, '9999'))
                        )
                        as competencia,
                        (to_char(doc.vl_documento, '999G999G990D9999')) as vl_documento,
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
                        left join
                           (
                              SELECT DISTINCT
                                 ON (id_documento_fiscal) * 
                              FROM
                                 fin_entrega_documento 
                           )
                           AS entDoc 
                           on entDoc.id_documento_fiscal = doc.id_documento_fiscal 
                        left join
                           fin_entrega_confirmacao as entrega 
                           on entrega.id_entrega_confirmacao = entDoc.id_entrega_confirmacao 
                        left join
                           fin_ordem as ordem 
                           on ordem.id_ordem = entrega.id_ordem 
                        inner join
                           fin_empenho as emp 
                           on emp.id_pedido = doc.id_pedido 
                        inner join
                           fin_pedido as pedido 
                           on doc.id_pedido = pedido.id_pedido 
                        inner join
                           pla_tipo_gasto as tipoGasto 
                           on tipoGasto.id_tipo_gasto = pedido.id_tipo_gasto 
                        inner join
                           fin_tipo_empenho as tpEmp 
                           on tpEmp.id_tipo_empenho = emp.id_tipo_empenho 
                        left join
                           fin_fornecedor as fornecedor 
                           on fornecedor.id_fornecedor = pedido.id_fornecedor 
                        left join 
                          ses_pessoa as p
                           on p.id_pessoa = fornecedor.id_pessoa 
                        left join 
                          ses_pessoa_fisica as pf
                           on pf.id_pessoa = p.id_pessoa
                        left join 
                          ses_pessoa_juridica as pj
                           on pj.id_pessoa = p.id_pessoa
                        left join fin_contrato as contrato 
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
                           on situacao.id_documento_situacao = doc.id_documento_situacao 
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

    public function retornaDocumentoFiscaisEncaminha(PDO $pdo, array $condicoes = []) {
        try {
            $strQuery = "";
            if (!empty($condicoes)) {
                foreach ($condicoes as $condicao) {
                    $filtro[] = $condicao['sql'];
                }
                $strQuery = " where " . implode(" and ", $filtro);
            }
            $sql = "select distinct
                        DF.id_documento_fiscal,
                        DF.nr_documento_fiscal,
                        DF.id_documento_situacao,
                        concat(DF.nr_documento_fiscal, '/', to_char(DF.dt_emissao, 'YYYY')) as nr_documento_fiscal,
                        concat(P.nr_pedido, '/', to_char(P.dt_pedido, 'YYYY')) as nr_pedido,
                        concat(substr(E.nr_empenho, 1, 
                        (
                     (LENGTH(E.nr_empenho) - 4)
                        )
                     ), '/', substring(E.nr_empenho 
                     FROM
                        '....$')) as nr_empenho,
                        TDF.nm_tipo_documento,
                        concat(trim(to_char(DF.mm_competencia, '09')), '/', DF.aa_competencia) as competencia,
                        TPLOT.nm_doc_tipo_lotacao,
                        LOT.nm_lotacao,
                        to_char(DF.dt_emissao, 'DD/MM/YYYY') as dt_emissao,
                        DF.vl_documento,
                        TPTRM.nm_tipo_tramitacao,
                        coalesce(PF.nr_cpf,'') as nr_cpf,
                        coalesce(PF.nm_civil,'') as nm_civil,
                        coalesce(PJ.nr_cnpj,'') as nr_cnpj,
                        coalesce(PJ.nm_fantasia,'') as nm_fantasia,
                        SITDF.nm_situacao,
                        E.nr_empenho as empenho_sm 
                     from
                        fin_documento_fiscal DF 
                        inner join
                           fin_pedido P 
                           on P.id_pedido = DF.id_pedido 
                        inner join
                           fin_empenho E 
                           on E.id_pedido = P.id_pedido 
                        inner join
                           fin_tipo_documento TDF 
                           on DF.id_tipo_documento = TDF.id_tipo_documento 
                        inner join
                           fin_documento_situacao SITDF 
                           on SITDF.id_documento_situacao = DF.id_documento_situacao 
                        inner join
                           (
                              select
                                 id_documento_fiscal,
                                 max(id_doc_tramitacao) as id_doc_tramitacao 
                              from
                                 fin_doc_tramitacao 
                              group by
                                 id_documento_fiscal 
                           )
                           UT 
                           on UT.id_documento_fiscal = DF.id_documento_fiscal 
                        inner join
                           fin_doc_tramitacao TRM 
                           on TRM.id_documento_fiscal = UT.id_documento_fiscal 
                           and TRM.id_doc_tramitacao = UT.id_doc_tramitacao 
                        inner join
                           fin_tipo_tramitacao TPTRM 
                           on TPTRM.id_tipo_tramitacao = TRM.id_tipo_tramitacao 
                        inner join
                           fin_doc_vinc_encaminhamento ENC 
                           on ENC.id_doc_lotacao = TRM.id_doc_origem 
                        inner join
                           fin_doc_lotacao FDL 
                           on FDL.id_doc_lotacao = ENC.id_doc_lotacao 
                        inner join
                           fin_doc_tipo_lotacao TPLOT 
                           on TPLOT.id_doc_tipo_lotacao = FDL.id_doc_tipo_lotacao 
                        inner join
                           ses_lotacao LOT 
                           on LOT.id_lotacao = FDL.id_lotacao 
                        left join
                           fin_fornecedor F 
                           on F.id_fornecedor = P.id_fornecedor 
                        left join
                           fin_contrato C 
                           on C.id_contrato = F.id_contrato 
                        left join
                           ses_pessoa_fisica PF 
                           on PF.id_pessoa = F.id_pessoa 
                        left join
                           ses_pessoa_juridica PJ 
                           on pj.id_pessoa = F.id_pessoa " . $strQuery . " order by DF.nr_documento_fiscal";
            $stmt = $pdo->prepare($sql);
            
            if (!empty($condicoes)) {
                foreach ($condicoes as $condicao) {
                    $stmt->bindValue($condicao['bind'], $condicao['valor'], $condicao['pdo_param']);
                }
            }
            
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
            echo $ex->getMessage();
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
    
    public function retornaDocumentoFiscaisRecebe(PDO $pdo, array $condicoes = []) {
        try {
            $strQuery = "";
            if (!empty($condicoes)) {
                foreach ($condicoes as $condicao) {
                    $filtro[] = $condicao['sql'];
                }
                $strQuery = " where " . implode(" and ", $filtro);
            }
            $sql = "select distinct
                        DF.id_documento_fiscal,
                        DF.nr_documento_fiscal,
                        DF.id_documento_situacao,
                        concat(DF.nr_documento_fiscal, '/', to_char(DF.dt_emissao, 'YYYY')) as nr_documento_fiscal,
                        concat(P.nr_pedido, '/', to_char(P.dt_pedido, 'YYYY')) as nr_pedido,
                        concat(substr(E.nr_empenho, 1, 
                        (
                     (LENGTH(E.nr_empenho) - 4)
                        )
                     ), '/', substring(E.nr_empenho 
                     FROM
                        '....$')) as nr_empenho,
                        TDF.nm_tipo_documento,
                        concat(trim(to_char(DF.mm_competencia, '09')), '/', DF.aa_competencia) as competencia,
                        TPLOT.nm_doc_tipo_lotacao,
                        LOT.nm_lotacao,
                        to_char(DF.dt_emissao, 'DD/MM/YYYY') as dt_emissao,
                        DF.vl_documento,
                        TPTRM.nm_tipo_tramitacao,
                        coalesce(PF.nr_cpf,'') as nr_cpf,
                        coalesce(PF.nm_civil,'') as nm_civil,
                        coalesce(PJ.nr_cnpj,'') as nr_cnpj,
                        coalesce(PJ.nm_fantasia,'') as nm_fantasia,
                        SITDF.nm_situacao,
                        E.nr_empenho as empenho_sm 
                     from
                        fin_documento_fiscal DF 
                        inner join
                           fin_pedido P 
                           on P.id_pedido = DF.id_pedido 
                        inner join
                           fin_empenho E 
                           on E.id_pedido = P.id_pedido 
                        inner join
                           fin_tipo_documento TDF 
                           on DF.id_tipo_documento = TDF.id_tipo_documento 
                        inner join
                           fin_documento_situacao SITDF 
                           on SITDF.id_documento_situacao = DF.id_documento_situacao 
                        inner join
                           (
                              select
                                 id_documento_fiscal,
                                 max(id_doc_tramitacao) as id_doc_tramitacao 
                              from
                                 fin_doc_tramitacao 
                              group by
                                 id_documento_fiscal 
                           )
                           UT 
                           on UT.id_documento_fiscal = DF.id_documento_fiscal 
                        inner join
                           fin_doc_tramitacao TRM 
                           on TRM.id_documento_fiscal = UT.id_documento_fiscal 
                           and TRM.id_doc_tramitacao = UT.id_doc_tramitacao 
                        inner join
                           fin_tipo_tramitacao TPTRM 
                           on TPTRM.id_tipo_tramitacao = TRM.id_tipo_tramitacao 
                        inner join
                           fin_doc_vinc_recebimento REC 
                           on REC.id_doc_lotacao = TRM.id_doc_origem 
                        inner join
                           fin_doc_lotacao FDL 
                           on FDL.id_doc_lotacao = REC.id_doc_lotacao 
                        inner join
                           fin_doc_tipo_lotacao TPLOT 
                           on TPLOT.id_doc_tipo_lotacao = FDL.id_doc_tipo_lotacao 
                        inner join
                           ses_lotacao LOT 
                           on LOT.id_lotacao = FDL.id_lotacao 
                        left join
                           fin_fornecedor F 
                           on F.id_fornecedor = P.id_fornecedor 
                        left join
                           fin_contrato C 
                           on C.id_contrato = F.id_contrato 
                        left join
                           ses_pessoa_fisica PF 
                           on PF.id_pessoa = F.id_pessoa 
                        left join
                           ses_pessoa_juridica PJ 
                           on pj.id_pessoa = F.id_pessoa " . $strQuery . " order by DF.nr_documento_fiscal";
            $stmt = $pdo->prepare($sql);
            if (!empty($condicoes)) {
                foreach ($condicoes as $condicao) {
                    $stmt->bindValue($condicao['bind'], $condicao['valor'], $condicao['pdo_param']);
                }
            }
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
    
    public function retornaDestinatarioPorTipo(PDO $pdo, $tipo) {
        try {
            $sql = "select lotacao.id_lotacao, lotacao.nm_lotacao, docLotacao.id_doc_lotacao 
                    from fin_doc_lotacao as docLotacao
                    inner join ses_lotacao as lotacao
                    on lotacao.id_lotacao = docLotacao.id_lotacao
                    where docLotacao.id_doc_tipo_lotacao = :tipo and docLotacao.st_ativo = '1'";
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
            $sql = "select TRM.id_doc_origem,
                           TL.id_doc_tipo_lotacao as tipo_remetente, 
                           DF.id_documento_situacao as situacao_documento
                    from fin_doc_tramitacao TRM
                    inner join fin_doc_lotacao TL
                    on TL.id_doc_lotacao = TRM.id_doc_origem 
                    inner join fin_documento_fiscal DF
                    on DF.id_documento_fiscal = TRM.id_documento_fiscal
                    where TRM.id_documento_fiscal = :documento
                    order by TRM.id_doc_tramitacao desc 
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
    
    public function verificaPermissaoReceber(PDO $pdo, int $idPessoa, int $tipoDestinatario = 0){
        try {
            $sql = "select count(*) from fin_doc_vinc_recebimento as receber
                    inner join fin_doc_lotacao as tipoLotacao
                    on receber.id_doc_lotacao = tipoLotacao.id_doc_lotacao
                    Where tipoLotacao.id_doc_tipo_lotacao = :tipo_destinatario
                    and receber.id_pessoa = :pessoa";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":pessoa", $idPessoa, PDO::PARAM_INT);
            $stmt->bindValue(':tipo_destinatario', $tipoDestinatario, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "Sem permissão para Receber.";
                $this->sucesso = false;
            }
        } catch (PDOException $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
    public function retornaDadosTramitacaoEncaminhar(PDO $pdo, int $destino = 0){
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = "select
                    O.id_doc_lotacao as origem,
                    O.id_doc_tipo_lotacao as tipo_origem,
                    D.id_doc_lotacao as destino,
                    D.id_doc_tipo_lotacao as tipo_destino,
                    PARAM.id_documento_situacao as situacao_nova,
                    case when (L.id_documento_fiscal is null) then 'N' else 'S' end as liquidacao,
                    case when (P.id_documento_fiscal is null) then 'N' else 'S' end as pagamento
                 from
                    fin_documento_fiscal DF 
                    inner join
                       (
                         select id_documento_fiscal , 
                                max(id_doc_tramitacao) as id_doc_tramitacao 
                         from fin_doc_tramitacao 
                         where id_tipo_tramitacao = 2 
                         group by id_documento_fiscal 
                       ) UT on UT.id_documento_fiscal = DF.id_documento_fiscal
                    inner join
                       fin_doc_tramitacao TRM
                       on TRM.id_documento_fiscal = UT.id_documento_fiscal
                       and TRM.id_doc_tramitacao = UT.id_doc_tramitacao
                    inner join
                       fin_doc_lotacao O 
                       on O.id_doc_lotacao = TRM.id_doc_origem 
                    inner join
                       fin_doc_lotacao D 
                       on D.id_doc_lotacao = :destino
                    inner join
                       fin_doc_parm_tramitacao PARAM 
                       on PARAM.id_doc_tipo_remetente = O.id_doc_tipo_lotacao 
                       and PARAM.id_doc_tipo_destinatario = D.id_doc_tipo_lotacao 
                       and PARAM.tp_doc_parm_tramitacao = '1' 
                    left join
                       (
                          select distinct
                             LD.id_documento_fiscal 
                          from
                             con_liquidacao L,
                             con_liquidacao_doc LD 
                          where
                             L.id_liquidacao = LD.id_liquidacao 
                             and L.st_ativo = '1' 
                             and L.id_liquidacao_situacao <> 4 
                       )
                       L 
                       on L.id_documento_fiscal = DF.id_documento_fiscal 
                    left join
                       (
                          select distinct
                             PD.id_documento_fiscal 
                          from
                             con_pagamento P,
                             con_pagamento_doc PD 
                          where
                             P.id_pagamento = PD.id_pagamento 
                             and P.st_ativo = '1' 
                             and P.id_pagamento_situacao <> 2 
                       )
                       P 
                       on P.id_documento_fiscal = DF.id_documento_fiscal 
                 where
                    TRM.id_documento_fiscal = :documento";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":documento", $this->getIdDocumentoFiscal(), PDO::PARAM_INT);
            $stmt->bindValue(":destino", $destino, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "Sem permissão para encaminhar.";
            }
        } catch (PDOException $ex) {
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
    public function retornaDadosTramitacaoReceber(PDO $pdo){
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = "select
                    TRM.id_doc_destino as origem,
                    PARAM.id_doc_tipo_remetente as tipo_origem,
                    TRM.id_doc_origem as destino,
                    PARAM.id_doc_tipo_destinatario as tipo_destino,
                    PARAM.id_documento_situacao as situacao_documento 
                 from
                    fin_doc_tramitacao TRM 
                    inner join
                       fin_doc_lotacao O 
                       on O.id_doc_lotacao = TRM.id_doc_origem 
                    inner join
                       fin_doc_lotacao D 
                       on D.id_doc_lotacao = TRM.id_doc_destino 
                    inner join
                       fin_doc_parm_tramitacao PARAM 
                       on PARAM.id_doc_tipo_remetente = D.id_doc_tipo_lotacao 
                       and PARAM.id_doc_tipo_destinatario = O.id_doc_tipo_lotacao 
                       and PARAM.tp_doc_parm_tramitacao = '2'	
                 where
                    TRM.id_tipo_tramitacao = 3 
                    and TRM.id_documento_fiscal = :documento 
                 order by
                    TRM.id_doc_tramitacao desc limit 1";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":documento", $this->getIdDocumentoFiscal(), PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "Sem permissão para encaminhar.";
            }
        } catch (PDOException $ex) {
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
    
    
    public function retornaSaldoPedidoNecessidade(PDO $pdo){
        try {
            $sqlIgnoraDoc = "";
            if(!empty($this->getIdDocumentoFiscal())){
                $sqlIgnoraDoc = " AND DOC.id_documento_fiscal <> :idDocumentoFiscal ";
            }
            $sql = "SELECT coalesce(sum(DOC.vl_documento), 0.0000) AS executado, P.vl_pedido"
                    . " , (P.vl_pedido - coalesce(sum(DOC.vl_documento), 0.0000)) as saldo"
                    . " FROM fin_pedido P"
                    . " LEFT JOIN fin_documento_fiscal DOC ON DOC.id_pedido = P.id_pedido"
                    . " AND DOC.id_documento_situacao <> 7"
                    . $sqlIgnoraDoc
                    . " WHERE P.id_pedido = :idPedido"                    
                    . " GROUP BY P.id_pedido";                                                  
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":idPedido", $this->getIdPedido(), PDO::PARAM_INT);            
            if(!empty($this->getIdDocumentoFiscal())){
                $stmt->bindValue(":idDocumentoFiscal", $this->getIdDocumentoFiscal(), PDO::PARAM_INT);
            }
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
    

}
