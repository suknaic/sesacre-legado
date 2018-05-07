<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/sistema/DaoSesPerfilPessoa.class.php";

class PerfilPessoa {

    private $idPerfilPessoa = null;
    private $idPerfil = null;
    private $idPessoa = null;
    private $sucesso = null;
    private $msgRetorno = null;    
    
    function getIdPerfilPessoa() {
        return $this->idPerfilPessoa;
    }

    function getIdPerfil() {
        return $this->idPerfil;
    }

    function getIdPessoa() {
        return $this->idPessoa;
    }

    function setIdPerfilPessoa($idPerfilPessoa) {
        $this->idPerfilPessoa = $idPerfilPessoa;
        return $this;
    }

    function setIdPerfil($idPerfil) {
        $this->idPerfil = $idPerfil;
        return $this;
    }

    function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
        return $this;
    }
    
    function getMsgRetorno() {
        return $this->msgRetorno;
    }   
 
    function Sucesso(){
        return $this->sucesso;
    }


    /**
     * Função que recebe um Perfil e uma Pessoa para incluir na tabela de Perfil Pessoa, 
     * e retorna um True ou False
     * Função que deverá ser utilizada em alguns módulos do sistema que será incluindo o Perfil Para a Pessoa
     * Ex: Caso o Chefe do RH deseja dar permissão de RH para algum subordinado no módulo de gerencimanto do RH
     * então o próprio responsável pelo RH poderá fazer isso, sem que ele tenha acesso ao módulo dos Perfil de todo o sistema
     * CASO o Perfil já existe cadastrado naquela Pessoa, então irá retornar TRUE, pois já está cadastrado
     * @param PDO $pdo
     * @return boolean
     */
    public function incluirPessoaPerfil(PDO $pdo){
        $retorno = FALSE;
        try {            
            
            if($this->idPerfil == "" || $this->idPessoa == "" ){
                return $retorno;
            }                                   
            
            //Seta os Campos
            $dao = new DaoSesPerfilPessoa();
            $dao->setIdPerfil($this->idPerfil);
            $dao->setIdPessoa($this->idPessoa);      
            
            
            $result = $dao->verificaPerfilPessoaExiste($pdo);
            if($result){
                return TRUE;
            }
                                
            $result = $dao->insert($pdo);
            if ($result != "Sucesso") {                                
                return $retorno;
            }
                                                                                                                                 
            $dao->setIdPerfilPessoa($pdo->lastInsertId('ses_perfil_pessoa_id_perfil_pessoa_seq'));            
            
            if (Log::SalvaLogI('ses_perfil_pessoa', $dao->getIdPerfilPessoa(), $pdo)) {
                return TRUE;
            }else{                                
                return $retorno;
            }
            
            return $retorno;
        
        } catch (Exception $exc) {            
            return $retorno;
        }  
    }
    
    /**
     * Função que recebe um Perfil e uma Pessoa para remover na tabela de Perfil Pessoa, 
     * e retorna um True ou False
     * Função que deverá ser utilizada em alguns módulos do sistema que será removido o Perfil Para a Pessoa
     * Ex: Caso o Chefe do RH deseja tirar permissão de RH para algum subordinado no módulo de gerencimanto do RH
     * então o próprio responsável pelo RH poderá fazer isso, sem que ele tenha acesso ao módulo dos Perfil de todo o sistema
     * CASO o Perfil não exista cadastrado para aquela Pessoa, então irá retornar TRUE, pois já está foi removido
     * @param PDO $pdo
     * @return boolean
     */
    public function removerPerfilPessoa(PDO $pdo){
        $retorno = FALSE;
        try {
                                    
            if($this->idPerfil == "" || $this->idPessoa == "" ){
                return $retorno;
            } 
           
            //Seta os Campos
            $dao = new DaoSesPerfilPessoa();
            $dao->setIdPerfil($this->idPerfil);
            $dao->setIdPessoa($this->idPessoa);            
            
            $busca = $dao->retornaPerfilPessoa($pdo);
                           
            if ($busca){
                $dao->setIdPerfilPessoa($busca['id_perfil_pessoa']);
          
                if (!Log::SalvaLogD('ses_perfil_pessoa', $dao->getIdPerfilPessoa(), $pdo)) {                      
                    return $retorno;
                }                
            } else {               
               return TRUE;
            }
            
            $resultDao = $dao->deletePerfilPessoa($pdo);            
            if ($resultDao != "Sucesso"){               
                return $retorno;
            }
                                                                            
            return TRUE;
        
        } catch (Exception $exc) {   
            echo $exc->getMessage();
            return FALSE;
        }
    }
    
    public function retornaPessoasPorINPerfil(string $perfis, PDO $pdo){
        $this->sucesso = FALSE;
        try {
                                    
            //Seta os Campos
            $dao = new DaoSesPerfilPessoa();
            $dao->setIdPerfil($perfis);                                
            $dao->retornaPessoaINPerfis($pdo);
            
            if($dao->Sucesso()){
                $this->sucesso = TRUE;           
            }else{
                $this->sucesso = FALSE;
            }
            $this->msgRetorno = $dao->getMsgRetorno();
        
        } catch (Exception $exc) {   
            $this->msgRetorno = $dao->getMsgRetorno();
            $this->sucesso = FALSE;
        }
    }
    
    public function verificaPessoaPerfilExiste(PDO $pdo){
        $this->sucesso = FALSE;
        try {
                                    
            //Seta os Campos
            $dao = new DaoSesPerfilPessoa();
            $dao->setIdPerfil($this->idPerfil);     
            $dao->setIdPessoa($this->idPessoa);
            $dao->verificaPerfilPessoaExiste($pdo);
            
            if($dao->Sucesso()){
                $this->sucesso = TRUE;           
            }else{
                $this->sucesso = FALSE;
            }
            $this->msgRetorno = $dao->getMsgRetorno();
        
        } catch (Exception $exc) {   
            $this->msgRetorno = $dao->getMsgRetorno();
            $this->sucesso = FALSE;
        }
    }
    
    
    
    
    
    

}

