<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/contabil/liquidacao/ConLiquidacaoAnotacao.class.php";

class DaoConLiquidacaoAnotacao extends ConLiquidacaoAnotacao {

    private $sucesso = null;
    private $msgRetorno = null;    
    
    function getMsgRetorno() {
        return $this->msgRetorno;
    }   
 
    function Sucesso(){
        return $this->sucesso;
    }

    function insert($pdo) {
        $this->sucesso = false;
        $sql = "INSERT INTO con_liquidacao_anotacao (id_pessoa, id_liquidacao, ds_liquidacao_anotacao)"                    
                    . " VALUES (:id_pessoa, :id_liquidacao, :ds_liquidacao_anotacao);";
        try {                      
            $result = $pdo->prepare($sql);                                        
            $result->bindValue(":id_pessoa", $this->getIdPessoa(), PDO::PARAM_INT);            
            $result->bindValue(":id_liquidacao", $this->getIdLiquidacao(), PDO::PARAM_INT);            
            $result->bindValue(":ds_liquidacao_anotacao", $this->getDsLiquidacaoAnotacao(), PDO::PARAM_STR);            
            $result->execute();
            $this->sucesso = true;            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage();            
        }
    }

    function retornaPorLiquidacao($pdo){
        $this->sucesso = false;
        $sql = "SELECT * FROM con_liquidacao_anotacao where id_liquidacao = :id_liquidacao";
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":id_liquidacao", $this->getIdLiquidacao(), PDO::PARAM_INT);
            $result->execute();
            if ($result->rowCount() >= 1){
                $this->sucesso = true; 
                $this->msgRetorno = $result->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;                
                $this->msgRetorno = "Não encontrou Registros";                
            }    
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    public function lista(PDO $pdo) {
        $this->sucesso = false;
        $sql = "select pessoa.nm_pessoa, to_char(anotacao.dh_liquidacao_anotacao,'dd/mm/yyyy HH24:MI:SS') as dh_liquidacao_anotacao, 
                    anotacao.ds_liquidacao_anotacao
                    from con_liquidacao_anotacao as anotacao
                    inner join ses_pessoa as pessoa
                    on pessoa.id_pessoa = anotacao.id_pessoa
                    where anotacao.id_liquidacao = :id_liquidacao";
        try {
            if (empty($pdo)) {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
                return false;
            }
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":id_liquidacao", $this->getIdLiquidacao(), PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
            }
        } catch (PDOException $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }
}
