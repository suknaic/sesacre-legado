<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/contabil/empenho/anulacao/ConEmpenhoAnulacaoAnotacao.class.php";

class DaoConEmpenhoAnulacaoAnotacao extends ConEmpenhoAnulacaoAnotacao {

    private $sucesso = null;
    private $msgRetorno = null;    
    
    function getMsgRetorno() {
        return $this->msgRetorno;
    }   
 
    function getSucesso(){
        return $this->sucesso;
    }

    function insert(PDO $pdo) {
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = "INSERT INTO con_empenho_anulacao_anotacao (id_pessoa, id_empenho_anulacao, ds_empenho_anulacao_anotacao)"                    
                    . " VALUES (:id_pessoa, :id_empenho_anulacao, :ds_empenho_anulacao_anotacao);";
        try {
            if (!empty($pdo)) {                    
                $stmt = $pdo->prepare($sql);                                        
                $stmt->bindValue(":id_pessoa", $this->getIdPessoa(), PDO::PARAM_INT);            
                $stmt->bindValue(":id_empenho_anulacao", $this->getIdEmpenhoAnulacao(), PDO::PARAM_INT);            
                $stmt->bindValue(":ds_empenho_anulacao_anotacao", $this->getDsEmpenhoAnulacaoAnotacao(), PDO::PARAM_STR);            
                $stmt->execute();
                $this->sucesso = true; 
            } else {
                $this->msgRetorno = "Sem conexão com o banco de dados";
            }           
        } catch (PDOException $e) {          
            $this->msgRetorno = $e->getMessage();            
        }
    }

    function retornaAnotacaoPorAnulacao(PDO $pdo){
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = "SELECT * FROM con_empenho_anulacao_anotacao where id_empenho_anulacao = :id_empenho_anulacao";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":id_empenho_anulacao", $this->getIdEmpenhoAnulacao(), PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() >= 1){
                $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "Não encontrou Registros";                
            }    
        } catch (PDOException $e) {       
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    public function lista(PDO $pdo) {
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = "select (pessoa.nm_pessoa || ' - ' || to_char(anotacao.dh_empenho_anulacao_anotacao,'dd/mm/yyyy HH24:MI:SS') || ': ' || anotacao.ds_empenho_anulacao_anotacao) as anotacao
                    from con_empenho_anulacao_anotacao as anotacao
                    inner join ses_pessoa as pessoa
                    on pessoa.id_pessoa = anotacao.id_pessoa
                    where anotacao.id_empenho_anulacao = :id_empenho_anulacao";
        try {
            if (!empty($pdo)) {
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_empenho_anulacao", $this->getIdEmpenhoAnulacao(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (PDOException $ex) {
            $this->msgRetorno = $ex->getMessage();
        }
    }
}
