<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/contabil/empenho/anulacao/ConEmpenhoAnulacao.class.php";

class DaoConEmpenhoAnulacao extends ConEmpenhoAnulacao {

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
        $sql = "insert into con_empenho_anulacao "
                . "(id_pedido,nr_empenho_anulacao,dt_empenho_anulacao,vl_empenho_anulacao,vl_empenho_antigo,"
                . "id_empenho_anulacao_situacao,id_empenho_anulacao_status,id_pessoa) "
                . "values"
                . " (:id_pedido,:nr_empenho_anulacao,:dt_empenho_anulacao,:vl_empenho_anulacao,:vl_empenho_antigo,"
                . ":id_empenho_anulacao_situacao,:id_empenho_anulacao_status,:id_pessoa)";
        try {
            if(!empty($pdo)){
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_pedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->bindValue(":nr_empenho_anulacao", $this->getNrEmpenhoAnulacao(), PDO::PARAM_STR);
                $stmt->bindValue(":dt_empenho_anulacao", $this->getDtEmpenhoAnulacao(), PDO::PARAM_STR);
                $stmt->bindValue(":vl_empenho_anulacao", $this->getVlEmpenhoAnulacao(), PDO::PARAM_STR);
                $stmt->bindValue(":vl_empenho_antigo", $this->getVlEmpenhoAntigo(), PDO::PARAM_STR);
                $stmt->bindValue(":id_empenho_anulacao_situacao", $this->getIdEmpenhoAnulacaoSituacao(), PDO::PARAM_INT);
                $stmt->bindValue(":id_empenho_anulacao_status", $this->getIdEmpenhoAnulacaoStatus(), PDO::PARAM_INT);
                $stmt->bindValue(":id_pessoa", $this->getIdPessoa(), PDO::PARAM_INT);
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
        $sql = "select * from con_empenho_anulacao where id_empenho_anulacao = :id_empenho_anulacao";
        try {
            if(!empty($pdo)){
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_empenho_anulacao", $this->getIdEmpenhoAnulacao(), PDO::PARAM_INT);
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