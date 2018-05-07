<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/pla/PlaPasAcaoIndicador.class.php";

class DaoPlaPasAcaoIndicador extends PlaPasAcaoIndicador{
    
    private $sucesso = null;
    private $msgRetorno = null;     
   
    function getMsgRetorno(){
        return $this->msgRetorno;
    }   
 
    function Sucesso(){
        return $this->sucesso;
    }
        
    function insert($pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO pla_pas_acao_indicador (id_pas, "
                    . " id_acao, id_indicador_saude) "
                    . " VALUES (:idPas, :idAcao, :idIndicadorSaude)");            
            $result->bindValue(":idPas", $this->getIdPas(), PDO::PARAM_INT);
            $result->bindValue(":idAcao", $this->getIdAcao(), PDO::PARAM_INT);
            $result->bindValue(":idIndicadorSaude", $this->getIdIndicadorSaude(), PDO::PARAM_INT);            
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            if($e->getCode() == "23505"){
                return "Duplicado";
            }            
            return $e->getMessage();            
        }
    }
   
    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM pla_pas_acao_indicador WHERE id_pas_acao_indicador = :idPasAcaoIndicador");
            $result->bindValue(":idPasAcaoIndicador", $this->getIdPasAcaoIndicador(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }          
        
    
    /**
     * Retorna as informações de um Pas Acao Indicador de Saúde Especifico
     * @param type $pdo
     * @return boolean
     */
    function retorna($pdo){
        
        $retorno = FALSE;                    
        
        $sql = " SELECT *"                                        
                . " FROM pla_pas_acao_indicador"
                . " WHERE id_pas_acao_indicador = :idPasAcaoIndicador";                
        try {
            $sth = $pdo->prepare($sql);            
            $sth->bindValue(":idPasAcaoIndicador", $this->getIdPasAcaoIndicador(), PDO::PARAM_INT);                
            $sth->execute();                      
            if ($sth->rowCount() >= 1) {          
                return $sth->fetch(PDO::FETCH_ASSOC);                             
            }else{                
                return $retorno;
            }      
            return $retorno;
        } catch (PDOException $e) {            
            echo $e->getMessage();
            return $retorno;
        }  
    } 
    
    
    /**
     * Retorna todas as Informações de Todas as Ações e quais seus Indicadores Agrupados
     * @param type $pdo
     * @return boolean
     */
    function retornaTodasAcoesIndicadoresPorPas($pdo){
        
        $retorno = FALSE;
        
        $sql = "SELECT A.id_acao, A.nm_acao"
            . " , STRING_AGG(CONCAT(I.cd_nota, ' - ', I.nm_indicador_saude), '<br/> ') AS nm_indicador_saude"
            . " FROM pla_pas_acao_indicador PI"
            . " INNER JOIN pla_indicador_saude I ON I.id_indicador_saude = PI.id_indicador_saude"
            . " INNER JOIN pla_acao A ON A.id_acao = PI.id_acao"
            . " WHERE PI.id_pas = :idPas"
            . " GROUP BY A.id_acao, A.nm_acao"
            . " ORDER BY A.id_acao, A.nm_acao, nm_indicador_saude";
        try {
            $sth = $pdo->prepare($sql);       
            $sth->bindValue(":idPas", $this->getIdPas(), PDO::PARAM_INT);                
            $sth->execute();                      
            if ($sth->rowCount() >= 1) {      
                return $sth->fetchAll(PDO::FETCH_ASSOC);                             
            }else{              
                return $retorno;
            }      
            return $retorno;
        } catch (PDOException $e) {           
            echo $e->getMessage();
            return $retorno;
        }  
    }
    
    
    
    
    /**
     * Retorna os dados para a edição da Tela do Pas Acao Indicador de Saúde
     * @param type $pdo
     * @return boolean
     */
    function retornaDadosParaEdicao($pdo){
        
        $retorno = FALSE;                     
        
        $sql = "SELECT A.id_acao"           
            . " , COALESCE(json_object_agg(I.id_indicador_saude, CONCAT(I.cd_nota, ' - ', I.nm_indicador_saude)) FILTER (WHERE I.id_indicador_saude IS NOT NULL), '[]') AS \"indicadores\" "
            . " FROM pla_pas_acao_indicador PI"
            . " INNER JOIN pla_indicador_saude I ON I.id_indicador_saude = PI.id_indicador_saude"
            . " INNER JOIN pla_acao A ON A.id_acao = PI.id_acao"
            . " WHERE PI.id_acao = :idAcao AND PI.id_pas = :idPas"
            . " GROUP BY A.id_acao";            
        
        try {
            $sth = $pdo->prepare($sql);  
            $sth->bindValue(":idAcao", $this->getIdAcao(), PDO::PARAM_INT);       
            $sth->bindValue(":idPas", $this->getIdPas(), PDO::PARAM_INT); 
            $sth->execute();           
            if ($sth->rowCount() >= 1) {
                return $sth->fetch(PDO::FETCH_ASSOC);
            }else{
                return $retorno;
            }
            return $retorno;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return $retorno;
        }
    }
    
    /**
     * Retorna todos os Ids Pas Acao Indicador, através de um conjunto de Ids de Indicador de Saúde
     * @param string $idIndicadorSaude
     * @param type $pdo
     * @return boolean
     */
    function retornaTodosPorPasAcaoINIndicador(string $idIndicadorSaude, $pdo){
        
        $retorno = FALSE;
        
        $sql = " SELECT id_pas_acao_indicador"               
                . " FROM pla_pas_acao_indicador"                
                . " WHERE id_indicador_saude IN (".$idIndicadorSaude.") "
                . " AND id_acao = :idAcao AND id_pas = :idPas";
        
        try {
            $sth = $pdo->prepare($sql);     
            $sth->bindValue(":idPas", $this->getIdPas(), PDO::PARAM_INT);       
            $sth->bindValue(":idAcao", $this->getIdAcao(), PDO::PARAM_INT);                   
            $sth->execute();           
            if ($sth->rowCount() >= 1) {
                return $sth->fetchAll(PDO::FETCH_ASSOC);
            }else{
                return $retorno;
            }
            return $retorno;
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return $retorno;
        }
    }
    
    /**
     * Retorna Todos os Pas Acao Indicador por uma Ação e Pas
     * @param type $pdo
     * @return boolean
     */
    function retornaTodosPorPasAcao($pdo){
        
        $retorno = FALSE;                     
        
        $sql = "SELECT id_pas_acao_indicador"                       
            . " FROM pla_pas_acao_indicador"            
            . " WHERE id_acao = :idAcao AND id_pas = :idPas";             
        
        try {
            $sth = $pdo->prepare($sql);  
            $sth->bindValue(":idAcao", $this->getIdAcao(), PDO::PARAM_INT);       
            $sth->bindValue(":idPas", $this->getIdPas(), PDO::PARAM_INT);  
            $sth->execute();           
            if ($sth->rowCount() >= 1) {
                return $sth->fetchAll(PDO::FETCH_ASSOC);
            }else{
                return $retorno;
            }
            return $retorno;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return $retorno;
        }
    }
    
    
    function verificaAoMenosUmIndicadorExisteNaPas(PDO $pdo){
        
        $this->sucesso = false;                
        
        $sql = "SELECT id_pas_acao_indicador"                       
            . " FROM pla_pas_acao_indicador"            
            . " WHERE id_pas = :idPas LIMIT 1";             
        
        try {
            $sth = $pdo->prepare($sql);                  
            $sth->bindValue(":idPas", $this->getIdPas(), PDO::PARAM_INT);  
            $sth->execute();           
            if ($sth->rowCount() >= 1) {
                $this->sucesso = true;                
            }else{
                $this->sucesso = false;                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();            
        }
    }
    
    
}

