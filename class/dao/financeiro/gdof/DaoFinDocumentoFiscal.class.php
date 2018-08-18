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
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
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
                    p.vl_pedido
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
            $sql = "select ordem.id_ordem, concat(concat(ordem.nr_ordem, '/'),ordem.aa_ordem) as ordem,
                    case 
                            when ordem.tp_ordem = '1' then 'Entrega'
                            when ordem.tp_ordem = '2' then 'Serviço/Execução'
                    end tipo,
                    sum(ordemItens.qt_itens_ordem * ordemItens.vl_itens_ordem) as valor
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

    public function retornaEntregaVinculadoAoDocumentoFiscal(PDO $pdo) {
        try {
            $sql = "select confirmacao.id_entrega_confirmacao, confirmacao.nr_entrega_confirmacao,
                    concat(concat(ordem.nr_ordem,'/'),ordem.aa_ordem) as ordem, 
                    to_char(protocolo.dh_recebimento, 'DD/MM/YYYY') as dataaviso,
                    to_char(protocolo.dt_entrega, 'DD/MM/YYYY') as datalimite, ordem.nr_prazo_ordem,
                    to_char(confirmacao.dt_entrega, 'DD/MM/YYYY') as entreguedia,
                    sum(item.vl_itens_entrega * item.qt_itens_entrega) as valor, ordem.id_ordem,  
                    case 
                     when confirmacao.sit_entrega = '1' then 'Entrega Parcial'
                     when confirmacao.sit_entrega = '2' then 'Entrega Total'
                    end situacao
                    from fin_documento_fiscal as doc
                    inner join fin_entrega_documento as entDoc
                    on entDoc.id_documento_fiscal =  doc.id_documento_fiscal
                    inner join fin_entrega_confirmacao as confirmacao
                    on confirmacao.id_entrega_confirmacao  =  entDoc.id_entrega_confirmacao
                    inner join fin_protocolo as protocolo
                    on protocolo.id_protocolo = confirmacao.id_protocolo
                    inner join fin_ordem as ordem
                    on confirmacao.id_ordem = ordem.id_ordem
                    inner join fin_entrega_itens as item
                    on item.id_entrega_confirmacao = confirmacao.id_entrega_confirmacao
                    where doc.id_documento_fiscal = :documento
                    group by confirmacao.id_entrega_confirmacao, protocolo.id_protocolo, ordem.id_ordem
                    order by concat(concat(ordem.nr_ordem,'/'),ordem.aa_ordem), confirmacao.nr_entrega_confirmacao";
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
            $sql = "select doc.nr_documento_fiscal, pedido.nr_pedido, contrato.nr_contrato, emp.nr_empenho, protoc.id_protocolo, tpDoc.nm_tipo_documento,
                    (trim(to_char(doc.mm_competencia, '09')) || '/' || trim(to_char(doc.aa_competencia, '9999'))) as competencia, doc.vl_documento, 
                    situacao.nm_situacao, tpTramitacao.nm_tipo_tramitacao, lotacao.nm_lotacao  
                    from fin_documento_fiscal as doc 
                    inner join fin_tipo_documento as tpDoc 
                    on tpDoc.id_tipo_documento = doc.id_tipo_documento 
                    inner join fin_entrega_documento as entDoc 
                    on entDoc.id_documento_fiscal = doc.id_documento_fiscal 
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
                    inner join fin_contrato as contrato 
                    on contrato.id_contrato = fornecedor.id_contrato 
                    inner join fin_doc_tramitacao as tramitacao
                    on tramitacao.id_doc_tramitacao = doc.id_doc_tramitacao
                    inner join fin_documento_situacao as situacao
                    on situacao.id_documento_situacao =  tramitacao.id_documento_situacao
                    inner join fin_tipo_tramitacao as tpTramitacao
                    on tpTramitacao.id_tipo_tramitacao = tramitacao.id_tipo_tramitacao
                    left join fin_doc_lotacao as docLotacao
                    on docLotacao.id_doc_lotacao = tramitacao.id_doc_destino
                    left join ses_lotacao as lotacao
                    on lotacao.id_lotacao =  docLotacao.id_lotacao " . $filtroSql;
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
    


}    