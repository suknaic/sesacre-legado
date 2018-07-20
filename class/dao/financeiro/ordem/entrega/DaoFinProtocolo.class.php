<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/ordem/FinProtocoloTb.class.php";

class DaoFinProtocolo extends FinProtocoloTb {

    private $sucesso = false;
    private $msgRetorno = null;

    function __construct() {
        
    }

    /**
     * @return mixed
     */
    public function getMsgRetorno() {
        return $this->msgRetorno;
    }

    /**
     * [sucesso e responsavel ]
     * @return [type]
     */
    public function sucesso() {
        return $this->sucesso;
    }

    public function retornaInforLoadProtocolo(PDO $pdo) {
        try {
            if ($pdo != null) {

                $sql = "select ordem.id_ordem, ordem.nr_ordem, p.nr_pedido, centalLotacao.nm_lotacao, pFornecedor.nm_pessoa, 
                        modalidade.nm_modalidade, processo.cd_pregao as licitacao,emp.nr_empenho, tpEmpenho.nm_tipo_empenho, 
                        emp.id_tipo_empenho, tpGasto.nm_tipo_gasto, cont.nr_contrato, cont.tp_contrato, font.nr_fonte,
                        cont.dt_ini_vigencia_contrato, cont.dt_fim_vigencia_contrato, pt.cd_programa_trabalho, p.ds_pedido,
                        pt.ds_programa_trabalho, desp.cd_despesa, desp.ds_despesa_elemento, p.vl_pedido, ordem.sit_ordem
                        from fin_ordem as ordem
                        inner join fin_pedido as p
                        on p.id_pedido = ordem.id_pedido
                        inner join pla_tipo_gasto as tpGasto
                        on tpGasto.id_tipo_gasto  = p.id_tipo_gasto
                        inner join fin_empenho as emp
                        on emp.id_pedido = p.id_pedido
                        inner join fin_tipo_empenho as tpEmpenho
                        on tpEmpenho.id_tipo_empenho = emp.id_tipo_empenho
                        inner join fin_fonte as font
                        on font.id_fonte = p.id_fonte
                        inner join view_programa_trabalho as pt
                        on pt.id_programa_trabalho = p.id_programa_trabalho
                        inner join view_despesa as desp
                        on desp.id_despesa = p.id_despesa
                        inner join ses_lotacao as centalLotacao
                        on centalLotacao.id_lotacao = p.id_lotacao
                        inner join fin_fornecedor as f
                        on f.id_fornecedor = p.id_fornecedor
                        inner join ses_pessoa as pFornecedor
                        on pFornecedor.id_pessoa  = f.id_pessoa
                        inner join fin_contrato as cont
                        on cont.id_contrato = f.id_contrato
                        inner join gco_processo as processo
                        on processo.id_processo = cont.id_processo
                        inner join gco_modalidade as modalidade
                        on modalidade.id_modalidade = processo.id_modalidade
                        where p.st_pedido > '0' 
                        and ordem.sit_ordem > '0'
                        and ordem.id_ordem  = :idOrdem";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idOrdem", $this->getIdOrdem(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->msgRetorno = "Sem conexao";
                $this->sucesso = false;
            }
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

    public function salvaProcotolo(PDO $pdo) {
        try {
            if ($pdo != null) {

                $sql = "insert into fin_protocolo (nm_representante, nr_rg_cpf, nm_email_representante, 
                        dh_recebimento_sistema, ds_protocolo, id_ordem, id_pessoa, qt_entrega, dt_entrega) 
                        values (:nmRepresentante, :rgCpf, :email, :recebimento, :dsProtocolo, :ordem, 
                        :pessoa, :qtEntrega, :dtEntrega)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":nmRepresentante", $this->getNmRepresentante(), PDO::PARAM_STR);
                $stmt->bindValue(":rgCpf", $this->getNrRgCpf(), PDO::PARAM_INT);
                $stmt->bindValue(":email", $this->getNmEmailRepresentante(), PDO::PARAM_STR);
                $stmt->bindValue(":recebimento", $this->getDhRecebimentoSistema(), PDO::PARAM_STR);
                $stmt->bindValue(":dsProtocolo", $this->getDsProtocolo(), PDO::PARAM_STR);
                $stmt->bindValue(":ordem", $this->getIdOrdem(), PDO::PARAM_INT);
                $stmt->bindValue(":pessoa", $this->getIdPessoa(), PDO::PARAM_INT);
                $stmt->bindValue(":qtEntrega", $this->getQtEntrega(), PDO::PARAM_INT);
                $stmt->bindValue(":dtEntrega", $this->getDtEntrega(), PDO::PARAM_STR);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "Sem conexao";
                $this->sucesso = false;
            }
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

    public function retornaPrazoDeentrega(PDO $pdo) {
        try {
            if ($pdo != null) {
                $sql = "select nr_prazo_ordem from fin_ordem where id_ordem  = :idOrdem";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idOrdem", $this->getIdOrdem(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->msgRetorno = "Sem conexao";
                $this->sucesso = false;
            }
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

    public function updateStatusOrdem(PDO $pdo) {
        try {
            if ($pdo != null) {
                $sql = "update fin_ordem set sit_ordem = 2 where id_ordem = :idOrdem";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idOrdem", $this->getIdOrdem(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "Sem conexao";
                $this->sucesso = false;
            }
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

    public function retornaEntregaConfirmacao(PDO $pdo) {
        try {
            if ($pdo != null) {
                $sql = "select protocolo.id_protocolo, protocolo.id_ordem, to_char(protocolo.dh_recebimento_sistema, 'DD/MM/YYYY') as dh_recebimento_sistema,
                        protocolo.qt_entrega, ordem.nr_prazo_ordem, to_char(protocolo.dt_entrega, 'DD/MM/YYYY') as dt_entrega, 
                        to_char(protocolo.dt_confirmacao, 'DD/MM/YYYY') as dt_confirmacao, protocolo.st_protocolo as status,
                        CASE  
                                WHEN protocolo.dt_confirmacao is null	  THEN  (protocolo.dt_entrega -  (SELECT CURRENT_DATE )) 
                            WHEN protocolo.dt_confirmacao is not null  THEN  (protocolo.dt_entrega - protocolo.dt_confirmacao)
                        END as diasAtrazo,
                        CASE 
                            WHEN protocolo.st_protocolo = '0' THEN 'Nehuma entrega informada'
                                WHEN protocolo.st_protocolo = '1' THEN 'Entrega Parcial'
                            WHEN protocolo.st_protocolo = '2' THEN 'Entrega Total'
                        END situacao
                        from fin_protocolo as protocolo
                        inner join fin_ordem as ordem
                        on ordem.id_ordem = protocolo.id_ordem
                        where ordem.id_ordem = :idOrdem";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idOrdem", $this->getIdOrdem(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->msgRetorno = "Sem conexao";
                $this->sucesso = false;
            }
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

    public function retornaProtocoloPorOrdem(PDO $pdo) {
        try {
            if ($pdo != null) {
                $sql = "select id_protocolo from fin_protocolo where id_ordem = :idOrdem";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idOrdem", $this->getIdOrdem(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->msgRetorno = "Sem conexao";
                $this->sucesso = false;
            }
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

    public function updateSituacaoProtocolo(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "update fin_protocolo set st_protocolo = :situacao where id_protocolo = :protocolo";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":situacao", $this->getStProtocolo(), PDO::PARAM_INT);
                $stmt->bindValue(":protocolo", $this->getIdProtocolo(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "Sem conexao";
                $this->sucesso = false;
            }
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

    public function retornaEntregueDiaProtocolo(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select dt_confirmacao from fin_protocolo where id_protocolo = :protocolo";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":protocolo", $this->getIdProtocolo(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->msgRetorno = "Sem conexao";
                $this->sucesso = false;
            }
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

    public function updateDtConfirmacao(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "update fin_protocolo set dt_confirmacao = :data where id_protocolo = :protocolo";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":data", $this->getDtConfirmacao(), PDO::PARAM_STR);
                $stmt->bindValue(":protocolo", $this->getIdProtocolo(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "Sem conexao";
                $this->sucesso = false;
            }
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

    public function verificaEntregaParcial(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select * from fin_protocolo where st_protocolo = '1' and id_protocolo = :protocolo";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":protocolo", $this->getIdProtocolo(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->msgRetorno = "Sem conexao";
                $this->sucesso = false;
            }
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

    public function retornaSituacao(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select st_protocolo from fin_protocolo where id_protocolo = :protocolo";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":protocolo", $this->getIdProtocolo(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->sucesso = true;
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->msgRetorno = "Sem conexao";
                $this->sucesso = false;
            }
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

    public function updateQtEntrega(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "update set qt_entrega = :qtEntrega from fin_protocolo where id_protocolo = :protocolo";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":qtEntrega", $this->getQtEntrega(), PDO::PARAM_INT);
                $stmt->bindValue(":protocolo", $this->getIdProtocolo(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "Sem conexao";
                $this->sucesso = false;
            }
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

}
