<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/rh/DaoSesPessoa.class.php";

class Login{
    
    private $idPessoa = null;
    private $usuario = null;
    private $senha = null;
    private $senhaNova = null;
    
    
    function getIdPessoa() {
        return $this->idPessoa;
    }

    function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
    }
        
    function getSenhaNova() {
        return $this->senhaNova;
    }

    function setSenhaNova($senhaNova) {
        $this->senhaNova = $senhaNova;
    }
    
    function getUsuario() {
        return $this->usuario;
    }

    function getSenha() {
        return $this->senha;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }
            
    public function Logar(){
        
        try {
                    
            $usuario = $this->usuario;
            $senha = $this->senha;

            if($usuario == "" || $senha == ""){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            //Verificar se o E-mail Informado Não é Valido
            //Caso não Seja Valido, ele irá acrescentar a parte do e-mail do estado
            if (!filter_var($usuario, FILTER_VALIDATE_EMAIL)){            
                $usuario .= "@ac.gov.br";            
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $pessoa = new DaoSesPessoa();
            
            $pessoa->setNmEmail($usuario);
            $pessoa->setNmSenha($senha);
            $pessoa->setDhLogin(date("Y-m-d H:i:s"));
                        
            $result = $pessoa->logar($pdo);

            if (!$result) {
                return Metodos::retornoAjax("Erro", "alert", STR_USUARIO_OU_SENHA_ERRADO);
            } else {
                if (password_verify($pessoa->getNmSenha(), $result['nm_senha'])){
                    if($result['st_ativo'] == 1){
                        if($pessoa->getNmSenha() == "123456"){
                            return Metodos::retornoAjax("novaSenha", null, STR_ALTERACAO_SENHA);  
                        }                        
                        
                        $pessoa->setIdPessoa($result['id_pessoa']);
                        $pessoa->setNmPessoa($result['nm_pessoa']);
                        $reg = $pessoa->salvaHorarioLogin($pdo);                          
                        if($reg != "Sucesso"){
                            $retorno = Metodos::retornoAjax("Erro", "console", $reg);
                            $pdo->rollBack();
                            return $retorno;
                        }
                        
                        
                        session_start();
                        $_SESSION['idUser'] = $pessoa->getIdPessoa();
                        $_SESSION['nmPessoa'] = $pessoa->getNmPessoa();                        
                        $_SESSION['data'] = $pessoa->getDhLogin();
                        //Salvar no Log que houve Login
                        if (!Log::SalvaLogLogin($pdo)) {
                            $retorno = Metodos::retornoAjax("Erro", "console", STR_ERROR);
                            session_unset();
                            session_destroy();
                            $pdo->rollBack();
                            return $retorno;
                        }
                        $pdo->commit();
                        return Metodos::retornoAjax("ok", null, null);  
                    }else{
                        return Metodos::retornoAjax("Erro", "alert", STR_USUARIO_DESATIVADO);  
                    }                    
                } else {
                    return Metodos::retornoAjax("Erro", "alert", STR_USUARIO_OU_SENHA_ERRADO);                    
                }
                
                                                
            }

            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }        
    }
    
    
    public function mudarSenhaLogar(){
        try {
                    
            $usuario = $this->usuario;
            $senha = $this->senha;            

            if($usuario == "" || $senha == ""){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            //Verificar se o E-mail Informado Não é Valido
            //Caso não Seja Valido, ele irá acrescentar a parte do e-mail do estado
            if (!filter_var($usuario, FILTER_VALIDATE_EMAIL)){            
                $usuario .= "@ac.gov.br";            
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $pessoa = new DaoSesPessoa();
            
            $pessoa->setNmEmail($usuario);
            $pessoa->setNmSenha($senha);    
            $pessoa->setDhLogin(date("Y-m-d H:i:s"));
            $result = $pessoa->logar($pdo);                

            if (!$result) {
                return Metodos::retornoAjax("Erro", "alert", STR_USUARIO_OU_SENHA_ERRADO);
            } else {
                if (password_verify($pessoa->getNmSenha(), $result['nm_senha'])) {
                    if($result['st_ativo'] == 1){
                        if($this->senhaNova == "123456"){
                            return Metodos::retornoAjax("Erro", "alert", STR_NOVA_SENHA_DIFERENTE);  
                        }
                        //Mudar a Senha Atual para a Nova Senha
                        $senhaNova = Metodos::retornaPasswordHash($this->senhaNova);                                
                        $pessoa->setIdPessoa($result['id_pessoa']);
                        $pessoa->setNmPessoa($result['nm_pessoa']);
                        $pessoa->setNmSenha($senhaNova);
                        
                        
                        $reg = $pessoa->retornaPessoa($pdo);                                   
                        if(!$reg){
                            $retorno = Metodos::retornoAjax("Erro", "console", $reg);
                            $pdo->rollBack();
                            return $retorno;
                        }
                      
                        $resultDao = $pessoa->mudarSenha($pdo);            
                        if($resultDao != "Sucesso"){
                          $retorno = Metodos::retornoAjax("Erro", "console", $resultDao);
                          $pdo->rollBack();
                          return $retorno;
                        }
                        
                        $horario = $pessoa->salvaHorarioLogin($pdo);                        
                        if($horario != "Sucesso"){
                            $retorno = Metodos::retornoAjax("Erro", "console", $horario);
                            $pdo->rollBack();
                            return $retorno;
                        }
                        
                        session_start();
                        $_SESSION['idUser'] = $pessoa->getIdPessoa();
                        $_SESSION['nmPessoa'] = $pessoa->getNmPessoa();
                        $_SESSION['data'] = $pessoa->getDhLogin();
                        if (!Log::SalvaLogLogin($pdo)) {
                            $retorno = Metodos::retornoAjax("Erro", "console", STR_ERROR);
                            session_unset();
                            session_destroy();
                            $pdo->rollBack();
                            return $retorno;
                        }
                        
                        if (!Log::SalvaLogU('ses_pessoa', $pessoa->getIdPessoa(), $reg, $pdo)){
                            $retorno = Metodos::retornoAjax("Erro", "console", $reg);
                            session_unset();
                            session_destroy();
                            $pdo->rollBack();
                            return $retorno;
                        }
                        
                        $pdo->commit();
                        return Metodos::retornoAjax("ok", null, null);
                    }else{
                        return Metodos::retornoAjax("Erro", "alert", STR_USUARIO_DESATIVADO);  
                    }                    
                } else {
                    return Metodos::retornoAjax("Erro", "alert", STR_USUARIO_OU_SENHA_ERRADO);                    
                }
                
                                                
            }

            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
    
    
    //Função Utilizada para a Tela que o próprio usuário irá mudar sua Senha
    public function alterarSenha(){
        try {                                                            

            if($this->idPessoa == "" || $this->senha == "" || $this->senhaNova == ""){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            
            if($this->idPessoa != $_SESSION['idUser']){
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }
            
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $pessoa = new DaoSesPessoa();
            
            $pessoa->setIdPessoa($this->idPessoa);
            $pessoa->setNmSenha($this->senha);            
            $result = $pessoa->retornaPessoa($pdo);           

            if (!$result) {
                return Metodos::retornoAjax("Erro", "alert", STR_USUARIO_OU_SENHA_ERRADO);
            } else {
                if (password_verify($pessoa->getNmSenha(), $result['nm_senha'])) {
                    if($result['st_ativo'] == 1){
                        if($this->senhaNova == "123456"){
                            return Metodos::retornoAjax("Erro", "alert", STR_NOVA_SENHA_DIFERENTE);  
                        }
                        //Mudar a Senha Atual para a Nova Senha
                        $senhaNova = Metodos::retornaPasswordHash($this->senhaNova);
                        $pessoa->setNmSenha($senhaNova);
                        
                        
                        //Atribuindo o Valor do result para o reg, para ser utilizado no LOG,
                        //Caso a senha seja modificada
                        $reg = $result;
                      
                        $resultDao = $pessoa->mudarSenha($pdo);            
                        if($resultDao != "Sucesso"){
                          $retorno = Metodos::retornoAjax("Erro", "console", $resultDao);
                          $pdo->rollBack();
                          return $retorno;
                        }                                                                        
                        
                        if (!Log::SalvaLogU('ses_pessoa', $pessoa->getIdPessoa(), $reg, $pdo)) {
                            $retorno = Metodos::retornoAjax("Erro", "console", $reg);                            
                            $pdo->rollBack();
                            return $retorno;
                        }
                        
                        $pdo->commit();
                        return Metodos::retornoAjax("ok", null, null);
                    }else{
                        return Metodos::retornoAjax("Erro", "alert", STR_USUARIO_DESATIVADO);  
                    }                    
                } else {
                    return Metodos::retornoAjax("Erro", "alert", STR_USUARIO_OU_SENHA_ERRADO);                    
                }                                                                
            }
            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
    
    
}

?>
