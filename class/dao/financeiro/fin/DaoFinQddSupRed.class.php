<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/fin/FinQddSupRed.class.php";

class DaoFinQddSupRed extends FinQddSupRed {
    
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
            $result = $pdo->prepare("INSERT INTO fin_qdd_sup_red (id_qdd, id_pessoa, ds_qdd_sup_red, tp_qdd_sup_red) "
                    . " VALUES (:idQdd, :idPessoa, :dsQddSupRed, :tpQddSupRed)");                                        
            $result->bindValue(":idQdd", $this->getIdQdd(), PDO::PARAM_INT);
            $result->bindValue(":idPessoa", $this->getIdPessoa(), PDO::PARAM_INT);
            $result->bindValue(":dsQddSupRed", $this->getDsQddSupRed(), PDO::PARAM_STR);
            $result->bindValue(":tpQddSupRed", $this->getTpQddSupRed(), PDO::PARAM_STR);            
            $result->execute();
            $this->sucesso = true;            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage();            
        }
    }   
    
    function updateValidacao($pdo) {
            try {            

                $result = $pdo->prepare("UPDATE fin_qdd_sup_red SET st_qdd_sup_red = :stQddSupRed"
                        . " , id_pessoa_st = :idPessoaSt"
                        . " WHERE id_qdd_sup_red = :idQddSupRed ");
                $result->bindValue(":idQddSupRed", $this->getIdQddSupRed(), PDO::PARAM_INT);
                $result->bindValue(":idPessoaSt", $this->getIdPessoaSt(), PDO::PARAM_INT);
                $result->bindValue(":stQddSupRed", $this->getStQddSupRed(), PDO::PARAM_STR);
                $result->execute();
                $this->sucesso = true; 
            } catch (PDOException $e) {
                $this->sucesso = false;            
                $this->msgRetorno = $e->getMessage(); 
            }
        }
    
    public function retorna($pdo){
        try{
            $sql = $pdo->prepare("SELECT *"
                    . " FROM fin_qdd_sup_red"
                    . " WHERE id_qdd_sup_red = :idQddSupRed");
            $sql->bindValue(":idQddSupRed", $this->getIdQddSupRed(), PDO::PARAM_INT);
            $sql->execute();
            if ($sql->rowCount() > 0){
                $this->sucesso = TRUE;
                $this->msgRetorno = $sql->fetch(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }
    
    
    public function retornaSupRedETrans($pdo){
        try{
            $sql = $pdo->prepare("SELECT SR.id_qdd_sup_red, SR.id_qdd"
                    . " , to_char(SR.dh_qdd_sup_red, 'DD/MM/YYYY HH24:MI:SS') AS dh_qdd_sup_red "
                    . " , SR.ds_qdd_sup_red, SR.tp_qdd_sup_red, SR.st_qdd_sup_red"
                    . " , P.id_pessoa, P.nm_pessoa"
                    . " , SRT.vl_qdd_sup_red_trans, SRT.tp_qdd_sup_red_trans"
                    . " , PT.programa_trabalho, PT.cd_programa_trabalho, PT.ds_programa_trabalho"
                    . " , F.nr_fonte"
                    . " , DE.cd_despesa_elemento"
                    . " , PST.nm_pessoa AS nm_pessoa_st"
                    . " FROM fin_qdd_sup_red SR"
                    . " INNER JOIN ses_pessoa P ON P.id_pessoa = SR.id_pessoa"
                    . " INNER JOIN fin_qdd_sup_red_trans SRT ON SRT.id_qdd_sup_red = SR.id_qdd_sup_red"
                    . " INNER JOIN fin_qdd_valor QV ON QV.id_qdd_valor = SRT.id_qdd_valor"
                    . " INNER JOIN fin_fonte F ON F.id_fonte = QV.id_fonte"
                    . " INNER JOIN view_programa_trabalho PT ON PT.id_programa_trabalho = QV.id_programa_trabalho"
                    . " INNER JOIN view_despesa_elemento DE ON DE.id_despesa_elemento = QV.id_despesa_elemento"
                    . " LEFT JOIN ses_pessoa PST ON PST.id_pessoa = SR.id_pessoa_st"
                    . " WHERE SR.id_qdd = :idQdd"
                    . " ORDER BY SR.dh_qdd_sup_red DESC"
                        . ", PT.cd_programa_trabalho, F.nr_fonte, DE.cd_despesa_elemento");
            $sql->bindValue(":idQdd", $this->getIdQdd(), PDO::PARAM_INT);
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
    
    
    public function retornaSupRedParaValidar($pdo){
        try{
            $sql = $pdo->prepare("SELECT SR.id_qdd_sup_red, SR.id_qdd"
                    . " , to_char(SR.dh_qdd_sup_red, 'DD/MM/YYYY HH24:MI:SS') AS dh_qdd_sup_red "
                    . " , SR.ds_qdd_sup_red, SR.tp_qdd_sup_red, SR.st_qdd_sup_red"
                    . " , P.id_pessoa, P.nm_pessoa"
                    . " , SRT.vl_qdd_sup_red_trans, SRT.tp_qdd_sup_red_trans"
                    . " , PT.programa_trabalho, PT.cd_programa_trabalho, PT.ds_programa_trabalho"
                    . " , F.nr_fonte"
                    . " , DE.cd_despesa_elemento"                    
                    . " FROM fin_qdd_sup_red SR"
                    . " INNER JOIN ses_pessoa P ON P.id_pessoa = SR.id_pessoa"
                    . " INNER JOIN fin_qdd_sup_red_trans SRT ON SRT.id_qdd_sup_red = SR.id_qdd_sup_red"
                    . " INNER JOIN fin_qdd_valor QV ON QV.id_qdd_valor = SRT.id_qdd_valor"
                    . " INNER JOIN fin_fonte F ON F.id_fonte = QV.id_fonte"
                    . " INNER JOIN view_programa_trabalho PT ON PT.id_programa_trabalho = QV.id_programa_trabalho"
                    . " INNER JOIN view_despesa_elemento DE ON DE.id_despesa_elemento = QV.id_despesa_elemento"                    
                    . " WHERE SR.id_qdd = :idQdd AND SR.st_qdd_sup_red IS NULL"
                    . " ORDER BY SR.dh_qdd_sup_red DESC"
                        . ", PT.cd_programa_trabalho, F.nr_fonte, DE.cd_despesa_elemento");
            $sql->bindValue(":idQdd", $this->getIdQdd(), PDO::PARAM_INT);
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