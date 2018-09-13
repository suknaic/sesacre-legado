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

            $sql = "insert into fin_entrega_documento (id_documento_fiscal, id_entrega_confirmacao, vl_entrega_documento) values (:documento, :entrega, :vlEntrega)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":documento", $this->getIdDocumentoFiscal(), PDO::PARAM_INT);
            $stmt->bindValue(":entrega", $this->getIdEntregaConfirmacao(), PDO::PARAM_INT);
            $stmt->bindValue(":vlEntrega", $this->getVlEntregaDocumento(), PDO::PARAM_STR);
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
                $sql = "SELECT id_entrega_documento, id_documento_fiscal, id_entrega_confirmacao"
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

    public function retornaSaldoEntregas(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select 
                        sum(item.vl_itens_entrega * item.qt_itens_entrega)  
                        -
			(select COALESCE(sum(entDocumento.vl_entrega_documento),'0.0000') 
			 from fin_entrega_documento as entDocumento
			 where entDocumento.id_entrega_confirmacao = :confirmacao
			)
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

}
