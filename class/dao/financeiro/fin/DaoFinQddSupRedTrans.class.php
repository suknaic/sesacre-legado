<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/fin/FinQddSupRedTrans.class.php";

class DaoFinQddSupRedTrans extends FinQddSupRedTrans {
    
    private $sucesso = null;
    private $msgRetorno = null;    
    
    function getMsgRetorno() {
        return $this->msgRetorno;
    }   
 
    function Sucesso(){
        return $this->sucesso;
    }

    function insert($pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO fin_qdd_sup_red_trans (id_qdd_sup_red, id_qdd_valor, vl_qdd_sup_red_trans, tp_qdd_sup_red_trans) "
                    . " VALUES (:idQddSupRed, :idQddValor, :vlQddSupRedTrans, :tpQddSupRedTrans)");                                        
            $result->bindValue(":idQddSupRed", $this->getIdQddSupRed(), PDO::PARAM_INT);
            $result->bindValue(":idQddValor", $this->getIdQddValor(), PDO::PARAM_INT);
            $result->bindValue(":vlQddSupRedTrans", $this->getVlQddSupRedTrans(), PDO::PARAM_STR);
            $result->bindValue(":tpQddSupRedTrans", $this->getTpQddSupRedTrans(), PDO::PARAM_STR);
            $result->execute();
            $this->sucesso = true;            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage();            
        }
    }       
    
    public function retornaPorSupRed($pdo){
        try{
            $sql = $pdo->prepare("SELECT SRT.id_qdd_sup_red_trans, SRT.id_qdd_valor"
                    . " , SRT.vl_qdd_sup_red_trans, SRT.tp_qdd_sup_red_trans"
                    . " , QV.vl_qdd_suplementado, QV.vl_qdd_reduzido, QV.vl_bloqueado, QV.vl_saldo"
                    . " FROM fin_qdd_sup_red_trans SRT"
                    . " INNER JOIN fin_qdd_valor QV ON QV.id_qdd_valor = SRT.id_qdd_valor"
                    . " WHERE SRT.id_qdd_sup_red = :idQddSupRed");
            $sql->bindValue(":idQddSupRed", $this->getIdQddSupRed(), PDO::PARAM_INT);
            $sql->execute();
            if ($sql->rowCount() > 0){
                $this->sucesso = TRUE;
                $this->msgRetorno = $sql->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }
}