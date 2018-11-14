<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/recurso/Recurso.class.php";

class RecursoUtil{
    
    
    private $idPessoa = null;
    private $flCadastrar = null;
    private $flEditar = null;
    private $flExcluir = null;
    private $lkRecurso = null;
    private $arquivo = null;
    private $acao = null;
    
    
    public function getIdPessoa() {
        return $this->idPessoa;
    }

    private function getFlCadastrar() {
        return $this->flCadastrar;
    }

    private function getFlEditar() {
        return $this->flEditar;
    }

    private function getFlExcluir() {
        return $this->flExcluir;
    }

    private function getLkRecurso() {
        return $this->lkRecurso;
    }

    public function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
        return $this;
    }

    private function setFlCadastrar($flCadastrar) {
        $this->flCadastrar = $flCadastrar;
        return $this;
    }

    private function setFlEditar($flEditar) {
        $this->flEditar = $flEditar;
        return $this;
    }

    private function setFlExcluir($flExcluir) {
        $this->flExcluir = $flExcluir;
        return $this;
    }

    private function setLkRecurso($lkRecurso) {
        $this->lkRecurso = $lkRecurso;
        return $this;
    }
    
    private function getArquivo() {
        return $this->arquivo;
    }

    private function setArquivo($arquivo) {
        $this->arquivo = $arquivo;
        return $this;
    }    
    private function getAcao() {
        return $this->acao;
    }

    private function setAcao($acao) {
        $this->acao = $acao;
        return $this;
    }
    
    public function getAcoesLivres() {
        return array("pesquisar", "visualizar");
    }

    
        
    /**
     * Irá procurar e setar os Campos necessários para a utilização do Recurso
     * Caminho da url para ser buscado no Banco de Dados
     * Nome da "ação" pesquisar, visualizar, cadastrar, editar, excluir ....
     * Nome do Arquivo
     */
    private function setaCamposPrincipais(){
        try{
            
            /*
            * Url completa de onde está ocorrendo a chamado principal do arquivo
            */
            $url = filter_input(INPUT_SERVER, 'PHP_SELF', FILTER_SANITIZE_URL);        
            /*
            * Nome do Arquivo
            */
            $this->setArquivo(substr(strrchr($url, "/"), 1));
            
            /*
            * Link Sem o Anexo
            */
            $link = substr($url, 0, ( (strlen($url)- strlen(strrchr($url, "/"))+0)));       
            
            /*
            * Caminho que será validado com o Sistema Para a busca do Recurso
            */
            $partes = explode('/', $link);
            $ultimo = array_pop($partes);
            $partes = array(implode('/', $partes), $ultimo);
            $this->setLkRecurso($partes[0]);
            $this->setAcao($partes[1]);       
            
        } catch (Exception $ex) {
            print_r($ex->getMessage());
        }                        
    }
    
    /**
     * Verifica se a Acao é de alguma das permitidas
     * @return boolean
     */
    private function acaoValida(){
        if(!empty($this->getAcao())){
            $acoesValidas = array("cadastrar", "editar", "pesquisar", "excluir", "visualizar");            
            if(array_search($this->getAcao(), $acoesValidas) === FALSE){
                return false;
            }else{
                return true;
            }
        }else{
            return false;
        }
    }
    
    /*
     * Verifica se a Ação é livre para acesso
     */
    private function acaoLivre(){
        if(!empty($this->getAcao())){                     
            if(array_search($this->getAcao(), $this->getAcoesLivres()) === FALSE){
                return false;
            }else{
                return true;
            }
        }else{
            return false;
        }
    }
        
    
    public function validaRecursoUsuario(PDO $pdo = null){
        try{
            
            $this->setaCamposPrincipais();  
            
            if(!$this->acaoValida()){
                return false;
            }      
                        
            $recurso = new Recurso();
            $recurso->setIdPessoa($this->idPessoa);
            $recurso->setLkRecurso($this->getLkRecurso());
            
            $recurso->retornaRecursoPessoa($pdo);
            if(!$recurso->sucesso()){
                return false;
            }
            
            $permissoes = $recurso->getMsgRetorno();
            
//            echo "<pre>";
//            print_r($permissoes);
//            echo "</pre>";
            
            
            
        } catch (Exception $ex) {
            print_r($ex->getMessage());
        }                
    }
    
    
    
}

