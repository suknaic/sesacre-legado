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
    
    public function selectPorId(PDO $pdo = null){
        try {
            if(!empty($pdo)){
                $sql = "select id_pedido_anotacao, ds_pedido_anotacao,dh_pedido_anotacao,id_pessoa,id_pedido from fin_pedido_anotacao where id_pedido_anotacao = :id_pedido_anotacao";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_pedido_anotacao",$this->getIdPedidoAnotacao(), PDO::PARAM_INT);
                
                $stmt->execute();
                if ($stmt->rowCount() > 0) { 
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->msgRetorno = 'Nenhuma anotação encontrada.';
                    $this->sucesso = false;
                }
            }  else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    public function selectPorPedido(PDO $pdo = null){
        try {
            if(!empty($pdo)){
                $sql = "SELECT
                            id_pedido_anotacao,
                            to_char(dh_pedido_anotacao, 'DD/MM/YYYY HH24:MI:SS') AS dh_pedido_anotacao,
                            ds_pedido_anotacao,
                            fpa.id_pessoa,
                            sp.nm_pessoa,
                            id_pedido
                          FROM fin_pedido_anotacao fpa,
                               ses_pessoa sp
                          WHERE id_pedido = :id_pedido
                          AND fpa.id_pessoa = sp.id_pessoa
                          ORDER BY id_pedido_anotacao desc";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_pedido",$this->getIdPedido(), PDO::PARAM_INT);
                
                $stmt->execute();
                if ($stmt->rowCount() > 0) { 
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->msgRetorno = 'Nenhuma anotação encontrada.';
                    $this->sucesso = false;
                }
            }  else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    

}

