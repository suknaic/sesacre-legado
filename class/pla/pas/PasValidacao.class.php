<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/pla/DaoPlaPasValidacao.class.php";

class PasValidacao{    
    
    private $idPas = null;
    private $idPessoa = null;
    private $dhPasValidacao = null;
    private $dsPasValidacao = null;
    private $stPasValidacao = null;
    private $sucesso = null;
    private $msgRetorno = null; 
    
    function getMsgRetorno(){
        return $this->msgRetorno;
    }   
 
    function Sucesso(){
        return $this->sucesso;
    }
    
    function getIdPas() {
        return $this->idPas;
    }

    function getIdPessoa() {
        return $this->idPessoa;
    }

    function getDhPasValidacao() {
        return $this->dhPasValidacao;
    }

    function getDsPasValidacao() {
        return $this->dsPasValidacao;
    }

    function getStPasValidacao() {
        return $this->stPasValidacao;
    }

    function setIdPas($idPas) {
        $this->idPas = $idPas;
        return $this;
    }

    function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
        return $this;
    }

    function setDhPasValidacao($dhPasValidacao) {
        $this->dhPasValidacao = $dhPasValidacao;
        return $this;
    }

    function setDsPasValidacao($dsPasValidacao) {
        $this->dsPasValidacao = $dsPasValidacao;
        return $this;
    }

    function setStPasValidacao($stPasValidacao) {
        $this->stPasValidacao = $stPasValidacao;
        return $this;
    }

        
    
     
    public function salvar($pdo){
        
        try {                                            
            
            //Seta os Cammpos
            $dao = new DaoPlaPasValidacao();
            $dao->setIdPas($this->idPas);
            $dao->setIdPessoa($this->idPessoa);                        
            $dao->setDsPasValidacao($this->dsPasValidacao);
            $dao->setStPasValidacao($this->stPasValidacao);                        
            
            
                                                                                                                                                                                                                                         
            $dao->insert($pdo);
            if(!$dao->Sucesso()){               
                $this->sucesso = false;
                $this->msgRetorno = $dao->getMsgRetorno();
                $pdo->rollBack();
                return;                    
            }else{                    
                $dao->setIdPasValidacao($pdo->lastInsertId('pla_pas_validacao_id_pas_validacao_seq'));
                if (!Log::SalvaLogI('pla_pas_validacao', $dao->getIdPasValidacao(), $pdo)) {
                    $this->sucesso = false;
                    $this->msgRetorno = $dao->getMsgRetorno();
                    $pdo->rollBack();
                    return;    
                }
            }                                 
           
            
            $this->sucesso = true;
            return;                                                                                                                                                                                               
        
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
            $pdo->rollBack();
            return;                
        }  
    }
    
    
    
    function retornaTextos(PDO $pdo = null){
        try {                                            
            
            if($pdo == null){
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            //Seta os Cammpos
            $dao = new DaoPlaPasValidacao();
            $dao->setIdPas($this->idPas);            
            
            $dao->retornaMensagensPorPas($pdo);
                                                                                                                                                                                                                                                     
            if(!$dao->Sucesso()){               
                $this->sucesso = false;
                $this->msgRetorno = $dao->getMsgRetorno();                                         
            }else{                    
                $this->sucesso = true;
                $this->msgRetorno = $dao->getMsgRetorno();
            }                                                                                                                                                                                                                                  
        
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();                         
        }  
    }
               
    
    
                                       
}

?>
