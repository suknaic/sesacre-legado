<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/pedido/FinPedidoAnotacao.class.php";

class DaoFinPedidoAnotacao extends FinPedidoAnotacao {

    private $sucesso = false;
    private $msgRetorno = null;

    function getMsgRetorno() {
        return $this->msgRetorno;
    }
    
    function getSucesso() {
        return $this->sucesso;
    }

    public function insert(PDO $pdo = null) {
        try {
            if(!empty($pdo)){
                $sql = "insert into fin_pedido_anotacao (id_pessoa,id_pedido,ds_pedido_anotacao) values (:id_pessoa, :id_pedido, :ds_pedido_anotacao)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_pessoa", $this->getIdPessoa(), PDO::PARAM_INT);
                $stmt->bindValue(":id_pedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->bindValue(":ds_pedido_anotacao", $this->getDsPedidoAnotacao(), PDO::PARAM_STR);
                
                $stmt->execute();
                $this->sucesso = true;
            }  else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    public function update(PDO $pdo = null) {
        try {
            if(!empty($pdo)){
            }  else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    public function delete(PDO $pdo = null) {
        try {
            if(!empty($pdo)){
            }  else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    public function select(PDO $pdo = null){
        try {
            if(!empty($pdo)){
            }  else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

}

