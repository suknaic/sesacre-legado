<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/contabil/empenho/anulacao/ConEmpenhoAnulacaoItem.class.php";

class DaoConEmpenhoAnulacaoItem extends ConEmpenhoAnulacaoItem {

    private $sucesso = null;
    private $msgRetorno = null;
    
    function getSucesso() {
        return $this->sucesso;
    }

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function insert(PDO $pdo){
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = "insert into con_empenho_anulacao_item "
                . "(id_empenho_anulacao, id_pre_ordem, qt_item,vl_item,qt_anulado,vl_anulado,vl_saldo) "
                . "values "
                . "(:id_empenho_anulacao, :id_pre_ordem, :qt_item,:vl_item,:qt_anulado,:vl_anulado, :vl_saldo)";
        try {
            if(!empty($pdo)){
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_empenho_anulacao", $this->getIdEmpenhoAnulacao(), PDO::PARAM_INT);
                $stmt->bindValue(":id_pre_ordem", $this->getIdPreOrdem(), PDO::PARAM_INT);
                $stmt->bindValue(":qt_item", $this->getQtItem(), PDO::PARAM_STR);
                $stmt->bindValue(":vl_item", $this->getVlItem(), PDO::PARAM_STR);
                $stmt->bindValue(":qt_anulado", $this->getQtAnulacao(), PDO::PARAM_STR);
                $stmt->bindValue(":vl_anulado", $this->getVlAnulado(), PDO::PARAM_STR);
                $stmt->bindValue(":vl_saldo", $this->getVlSaldo(), PDO::PARAM_STR);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados.';
            }
        } catch (PDOException $e) {
            $this->msgRetorno = $e->getMessage();
        }
    }
    
    function retorna(PDO $pdo){
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = "select * from con_empenho_anulacao_item where id_empenho_anulacao_item = :id_empenho_anulacao_item";
        try {
            if(!empty($pdo)){
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_empenho_anulacao_item", $this->getIdEmpenhoAnulacaoItem(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() >= 1) {
                    $this->sucesso = true;
                    $this->msgRetorno = $result->fetch(PDO::FETCH_ASSOC);
                } else {
                    $this->msgRetorno = "Não encontrou Registros";
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados.';
            }
        } catch (PDOException $e) {
            $this->msgRetorno = $e->getMessage();
        }
    }

}
