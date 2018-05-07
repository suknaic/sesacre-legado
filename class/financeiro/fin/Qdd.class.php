<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/fin/DaoFinQdd.class.php";

class Qdd {
    
    private $idQdd = null;
    private $aaQdd = null;
    
    function getIdQdd() {
        return $this->idQdd;
    }

    function getAaQdd() {
        return $this->aaQdd;
    }

    function setIdQdd($idQdd) {
        $this->idQdd = $idQdd;
        return $this;
    }

    function setAaQdd($aaQdd) {
        $this->aaQdd = $aaQdd;
        return $this;
    }
    
    
    /**
     * Cria o QDD
     * @return type
     */
    public function criar(){
        try {  
                                   
            if(empty($this->aaQdd) || strlen($this->aaQdd) != 4){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            /* @var $pdo PDO */
            $pdo = $conexao->connect();
            
            $pdo->beginTransaction();
            //Seta os Campos
            $dao = new DaoFinQdd();
           
            $dao->setAaQdd($this->aaQdd);
                       
            //Verifica se Já existe algum Qdd Cadastrado no Sistema para esse Ano
            $this->verificaExisteCarregaDados($pdo);
            
            if(!empty($this->getIdQdd())){
                $retorno = Metodos::retornoAjax("Erro", "alert", "Já existe um QDD Cadastrado Para Este Ano.");                        
                $pdo->rollBack();
                return $retorno;
            }
            
            //Salva o Registro do QDD
            $dao->insert($pdo);
            
            if(!$dao->Sucesso()){
                $retorno = Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
                $pdo->rollBack();
                return $retorno;
            }
            
            $dao->setIdQdd($pdo->lastInsertId('fin_qdd_id_qdd_seq'));            

            if (!Log::SalvaLogI('fin_qdd', $dao->getIdQdd(), $pdo)) {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }                        
                                                          
            $retorno = Metodos::retornoAjax("ok", "html", "QDD Criado com Sucesso.");
            $pdo->commit();
            return $retorno;
                                                                               
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
    
    public function remover(){
        try {
                                    
            if(empty($this->aaQdd) || strlen($this->aaQdd) != 4){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            /* @var $pdo PDO */
            $pdo = $conexao->connect();
            
            $pdo->beginTransaction();
            //Seta os Campos
            $dao = new DaoFinQdd();
           
            $dao->setAaQdd($this->aaQdd);      
            
            //Verifica se Já existe algum Qdd Cadastrado no Sistema para esse Ano
            $dao->verificaExistePorAno($pdo);
            if(!$dao->Sucesso()){
                $retorno = Metodos::retornoAjax("Erro", "alert", "Não foi Possível Localizar o Ano.");                        
                $pdo->rollBack();
                return $retorno; 
            }
            $busca = $dao->getMsgRetorno();
            $dao->setIdQdd($busca['id_qdd']);                                    
            
            if (!Log::SalvaLogD('fin_qdd', $dao->getIdQdd(), $pdo)) {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }   
                        
            $dao->delete($pdo);
            if(!$dao->Sucesso()){            
                $retorno = Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
                $pdo->rollBack();
                return $retorno;
            }
            $retorno = Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
            $pdo->commit();
            return $retorno;                       
                    
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
    
    

    public function verificaExisteCarregaDados(PDO $pdo = null){        
        try{
            if(empty($pdo)){
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $dao = new DaoFinQdd();                       
            $dao->setAaQdd($this->aaQdd);
            $dao->verificaExistePorAno($pdo);  
            
            if(!$dao->Sucesso()){
                
            }else{
               $result = $dao->getMsgRetorno();
               $this->idQdd = $result['id_qdd'];
               $this->aaQdd = $result['aa_qdd'];               
            }                        
                                                          
        } catch (Exception $ex) {
            $retorno = "";
        }                               
    }
        
   
	
}