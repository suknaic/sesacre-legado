<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/gdof/FinEntregaDocumentoTb.class.php";

class DaoFinEntregaDocumento extends FinEntregaDocumentoTb {

    private $sucesso = false;
    private $msgRetorno = null;

    function sucesso() {
        return $this->sucesso;
    }

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    public function insertEntregaDocumento(PDO $pdo) {
        try {
            if (empty($pdo)) {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
                return false;
            }

            $sql = "insert into fin_entrega_documento (id_documento_fiscal, id_entrega_confirmacao, vl_entrega_documento, vl_entrega_saldo) values (:documento, :entrega, :vlEntrega, :vlSaldo)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":documento", $this->getIdDocumentoFiscal(), PDO::PARAM_INT);
            $stmt->bindValue(":entrega", $this->getIdEntregaConfirmacao(), PDO::PARAM_INT);
            $stmt->bindValue(":vlEntrega", $this->getVlEntregaDocumento(), PDO::PARAM_STR);
            $stmt->bindValue(":vlSaldo", $this->getVlEntregaSaldo(), PDO::PARAM_STR);
            $stmt->execute();
            $this->sucesso = true;
        } catch (PDOException $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
    public function atualiza(PDO $pdo){
        try {
            if (empty($pdo)) {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
                return false;
            }
            $sql = "update fin_entrega_documento set vl_entrega_documento = :vl_entrega_documento, vl_entrega_saldo = :vl_entrega_saldo where id_entrega_documento = :id_entrega_documento ";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":vl_entrega_documento", $this->getVlEntregaDocumento(), PDO::PARAM_STR);
            $stmt->bindValue(":vl_entrega_saldo", $this->getVlEntregaSaldo(), PDO::PARAM_STR);
            $stmt->bindValue(":id_entrega_documento", $this->getIdEntregaDocumento(), PDO::PARAM_INT);
            $stmt->execute();
            $this->sucesso = true;
        } catch (PDOException $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function remove(PDO $pdo) {
        try {
            if (empty($pdo)) {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
                return false;
            }
            $sql = "DELETE FROM fin_entrega_documento WHERE id_entrega_documento = :idEntregaDocumento";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":idEntregaDocumento", $this->getIdEntregaDocumento(), PDO::PARAM_INT);
            $stmt->execute();
            $this->sucesso = true;
        } catch (PDOException $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    /**
     * Retorna todas as Entregas por um Documento Fiscal
     * @param PDO $pdo
     */
    public function retornaPorDocumentoFiscal(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "SELECT id_entrega_documento, id_documento_fiscal, id_entrega_confirmacao, vl_entrega_documento, vl_entrega_saldo"
                        . " FROM fin_entrega_documento"
                        . " WHERE id_documento_fiscal = :idDocumentoFiscal";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idDocumentoFiscal", $this->getIdDocumentoFiscal(), PDO::PARAM_INT);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                    $this->msgRetorno = "Sem Resultado";
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Sem conexão ao banco";
            }
        } catch (PDOException $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function retorna(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "SELECT *"
                        . " FROM fin_entrega_documento"
                        . " WHERE id_entrega_documento = :idEntregaDocumento";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idEntregaDocumento", $this->getIdEntregaDocumento(), PDO::PARAM_INT);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                    $this->msgRetorno = "Sem Resultado";
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Sem conexão ao banco";
            }
        } catch (PDOException $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function retornaSaldoEntregas(PDO $pdo, string $documentoFiltro = "") {
        try {
            if (!empty($pdo)) {
                $sql = "select 
                        sum(item.vl_itens_entrega * item.qt_itens_entrega)  
                        -
                        (select COALESCE(sum(entDocumento.vl_entrega_documento),'0.0000')  
                        from fin_entrega_documento as entDocumento 
                        inner join fin_documento_fiscal as documento
                        on documento.id_documento_fiscal = entDocumento.id_documento_fiscal
                        where entDocumento.id_entrega_confirmacao = :confirmacao
                        and documento.id_documento_situacao <> '7' ".$documentoFiltro.")
                         as saldo
                        from fin_entrega_itens as item
                        where item.id_entrega_confirmacao = :confirmacao";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":confirmacao", $this->getIdEntregaConfirmacao(), PDO::PARAM_INT);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                    $this->msgRetorno = "Sem Resultado";
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Sem conexão ao banco";
            }
        } catch (PDOException $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
    public function retornaSaldoEntregaAtualizacao(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select
                            sum(item.vl_itens_entrega * item.qt_itens_entrega) - (
                            select
                               COALESCE(sum(entDocumento.vl_entrega_documento), '0.0000') 
                            from
                               fin_entrega_documento as entDocumento 
                               inner join
                                  fin_documento_fiscal as documento 
                                  on documento.id_documento_fiscal = entDocumento.id_documento_fiscal 
                            where
                               entDocumento.id_entrega_confirmacao = :confirmacao 
                               and  documento.id_documento_situacao <> '7'
                               and documento.id_documento_fiscal <> :documento ) as saldo 
                            from
                               fin_entrega_itens as item 
                            where
                               item.id_entrega_confirmacao = :confirmacao";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":confirmacao", $this->getIdEntregaConfirmacao(), PDO::PARAM_INT);
                $stmt->bindValue(":documento", $this->getIdDocumentoFiscal(), PDO::PARAM_INT);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                    $this->msgRetorno = "Sem Resultado";
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Sem conexão ao banco";
            }
        } catch (PDOException $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    
    public function retornaEntregaGdofEdicao(PDO $pdo) {
        try {
            $sql = "SELECT
                        confirmacao.id_entrega_confirmacao,
                        confirmacao.nr_entrega_confirmacao,
                        concat(concat(ordem.nr_ordem, '/'), ordem.aa_ordem) as ordem,
                        to_char(protocolo.dh_recebimento, 'DD/MM/YYYY') as dataaviso,
                        to_char(protocolo.dt_entrega, 'DD/MM/YYYY') as datalimite,
                        ordem.nr_prazo_ordem,
                        to_char(confirmacao.dt_entrega, 'DD/MM/YYYY') as entreguedia,
                        sum(item.vl_itens_entrega * item.qt_itens_entrega) as valor,
                        ordem.id_ordem,
                        (
                           sum(item.vl_itens_entrega * item.qt_itens_entrega) - ( 
                           select
                              COALESCE(sum(entDocumento.vl_entrega_documento), '0.0000') 
                           from
                              fin_entrega_documento as entDocumento 
                              inner join
                                 fin_documento_fiscal as documento 
                                 on documento.id_documento_fiscal = entDocumento.id_documento_fiscal 
                           where
                              entDocumento.id_entrega_confirmacao = confirmacao.id_entrega_confirmacao 
                              and  documento.id_documento_situacao <> '7' 
                              
                     ) 
                        )
                        as saldo,
                        (
                           select
                              coalesce(id_entrega_documento, 0) 
                           from
                              fin_entrega_documento as entDoc 
                           where
                              entDoc.id_entrega_confirmacao = confirmacao.id_entrega_confirmacao 
                              and entDoc.id_documento_fiscal = :documento 
                        )
                        as id_entrega_documento,
                        (
                           select
                              coalesce(vl_entrega_documento, 0) 
                           from
                              fin_entrega_documento as entDoc 
                           where
                              entDoc.id_entrega_confirmacao = confirmacao.id_entrega_confirmacao 
                              and entDoc.id_documento_fiscal = :documento 
                        )
                        as vl_entrega_documento,
                        case
                           when
                              confirmacao.sit_entrega = '1' 
                           then
                              'Entrega Parcial' 
                           when
                              confirmacao.sit_entrega = '2' 
                           then
                              'Entrega Total' 
                        end
                        situacao, confirmacao.sit_entrega 
                     from
                        fin_protocolo as protocolo 
                        inner join
                           fin_entrega_confirmacao as confirmacao 
                           on protocolo.id_protocolo = confirmacao.id_protocolo 
                        inner join
                           fin_ordem as ordem 
                           on confirmacao.id_ordem = ordem.id_ordem 
                        inner join
                           fin_entrega_itens as item 
                           on item.id_entrega_confirmacao = confirmacao.id_entrega_confirmacao 
                     where
                        confirmacao.id_entrega_confirmacao = :entrega 
                     group by
                        confirmacao.id_entrega_confirmacao, protocolo.id_protocolo, ordem.id_ordem 
                     order by
                        concat(concat(ordem.nr_ordem, '/'), ordem.aa_ordem), confirmacao.nr_entrega_confirmacao";
            
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":entrega", $this->getIdEntregaConfirmacao(), PDO::PARAM_INT);
            $stmt->bindValue(":documento", $this->getIdDocumentoFiscal(), PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->sucesso = true;
                $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;
            }
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }
}
