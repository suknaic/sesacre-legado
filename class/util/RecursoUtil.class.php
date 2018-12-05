<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/recurso/Recurso.class.php";

class RecursoUtil{
        
    private $idPessoa = null;
    private $flAcessar = false;
    private $flCadastrar = false;    
    private $flEditar = false;
    private $flExcluir = false;
    private $lkRecurso = null;
    private $arquivo = null;
    private $acao = null;
                    
    private function getIdPessoa() {
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

    public function setLkRecurso($lkRecurso) {
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
    
    private function getAcoesLivres() {
        return array("pesquisar", "visualizar");
    }
    
    public function recursoPodeAcessar() : bool{
        return $this->flAcessar;
    }
    
    public function recursoPodeCadastrar() : bool{
        return $this->flCadastrar;
    }
    
    public function recursoPodeEditar() : bool{
        return $this->flEditar;
    }
    
    public function recursoPodeExcluir() : bool{
        return $this->flExcluir;
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
    
    private function validaUsodaAcao(array $permissoes, string $acao){
        return $permissoes[$acao];        
    }
        
    
    public function validaRecursoUsuario(PDO $pdo = null){
        try{
                         
            
            /*
             * Irá fazer a Busca da URL e organizar para ser utilizada 
             * durante a execução do código
             */
            $this->setaCamposPrincipais();
            
            /*
             * Verifica se a Ação é alguma das Ações validas no sistema
             * Em Geral é o nome da pasta
             */
            if(!$this->acaoValida()){
                return false;
            }
                        
            $recurso = new Recurso();
            $recurso->setIdPessoa($this->idPessoa);
            $recurso->setLkRecurso($this->getLkRecurso());
            
            /*
             * Verifica se o usuário possui permissão para esse recurso e também retorna 
             * as permissoes que ele possui para esse recurso
             */
            $recurso->retornaRecursoPessoa($pdo);
            
            /*
             * Se for false, então significa que o usuário não possui permissão para tal recurso
             */
            if(!$recurso->sucesso()){                    
                return false;
            }
            
            $permissoes = $recurso->getMsgRetorno();
            if(!is_array($permissoes)){
                return false;
            }
            /*
             * Seta as Permissões do Recurso que o usuário possui
             */
            $this->flCadastrar = $permissoes['cadastrar'];
            $this->flEditar = $permissoes['editar'];
            $this->flExcluir = $permissoes['excluir'];    
            
            /*
             * Se a Ação que está sendo utilizado não é livre para acesso exclusivamente do recurso
             * Ou seja, é necessário que o usuário tenha acesso a alguma permissão especifica
             * Então é preciso fazer essa validação
             */
            if(!$this->acaoLivre()){
                /*
                 * Se o usuário não possui permissão para essa ação
                 * então ele não deve ter acesso a essa página
                 */
                if(!$this->validaUsodaAcao($permissoes, $this->getAcao())){                    
                    return false;
                }                                
            }                        
                                    
            return true;            
        } catch (Exception $ex) {            
            return false;
        }                
    }
    
    /**
     * É Necessário Setar o Id da Pessoa e o Link do Recurso
     * @param PDO $pdo
     * @return boolean
     */
    public function carregaRecursoUsuario(PDO $pdo = null){
        try{
            
            
            if(empty($pdo)){
                $conexao = new Conexao();
                $pdo = $conexao->connect();                
            } 
                                   
            $recurso = new Recurso();
            $recurso->setIdPessoa($this->idPessoa);
            $recurso->setLkRecurso($this->getLkRecurso());
            
            /*
             * Verifica se o usuário possui permissão para esse recurso e também retorna 
             * as permissoes que ele possui para esse recurso
             */
            $recurso->retornaRecursoPessoa($pdo);
            
            /*
             * Se for false, então significa que o usuário não possui permissão para tal recurso
             */
            if(!$recurso->sucesso()){                    
                $this->flAcessar = false;
                return false;
            }
            $this->flAcessar = true;
            
            $permissoes = $recurso->getMsgRetorno();
            if(!is_array($permissoes)){
                return false;
            }
            
            /*
             * Seta as Permissões do Recurso que o usuário possui
             */
            $this->flCadastrar = $permissoes['cadastrar'];
            $this->flEditar = $permissoes['editar'];
            $this->flExcluir = $permissoes['excluir'];                                              
                                    
            return true;            
        } catch (Exception $ex) {            
            return false;
        }                
    }
    
    
    
}

