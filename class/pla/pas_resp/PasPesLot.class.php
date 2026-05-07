<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/pla/DaoPlaPasPessoaLotacao.class.php";

class PasPesLot{
    
    private $idPasPessoaLotacao = null;
    private $idPessoa = null;
    private $idLotacao = null;    

    function getIdPasPessoaLotacao() {
        return $this->idPasPessoaLotacao;
    }

    function getIdPessoa() {
        return $this->idPessoa;
    }

    function getIdLotacao() {
        return $this->idLotacao;
    }

    function setIdPasPessoaLotacao($idPasPessoaLotacao) {
        $this->idPasPessoaLotacao = $idPasPessoaLotacao;
    }

    function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
    }

    function setIdLotacao($idLotacao) {
        $this->idLotacao = $idLotacao;
    }
       
    
                              
    public function cadastrar(){
        try {            
            if($this->idLotacao == "" || $this->idPessoa == ""){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
           
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $dao = new DaoPlaPasPessoaLotacao();
            
            $dao->setIdLotacao($this->idLotacao);
            $dao->setIdPessoa($this->idPessoa);       
            
            //Verifica se já está cadastrado, para não duplicar
            $result = $dao->retornaPermissaoPessoaLotacao($pdo);            
            if($result){
                $retorno = Metodos::retornoAjax("Erro", "alert", "Usuário já possui Permissão para esta Unidade");
                $pdo->rollback();
                return $retorno;
            }                        
                                            
            $result = $dao->insert($pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }
                                                                                                                                 
            $dao->setIdPasPessoaLotacao($pdo->lastInsertId('pla_pas_pessoa_lotacao_id_pas_pessoa_lotacao_seq'));            
            
            if (Log::SalvaLogI('pla_pas_pessoa_lotacao', $dao->getIdPasPessoaLotacao(), $pdo)) {
                $sucesso = true;
            }else{
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
            
            //Cadastra o Perfil necessário do Planejamento, para o usuário
            $perfilPessoa = new PerfilPessoa();
            $perfilPessoa->setIdPerfil(PERFIL_PLANEJAMENTO_USUARIO);
            $perfilPessoa->setIdPessoa($dao->getIdPessoa());
            
            $result = $perfilPessoa->incluirPessoaPerfil($pdo);
            if(!$result){
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }           
            
            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }                                                                                       

            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
    
        
    
    public function remover(){
        try {
                                    
            if($this->idPasPessoaLotacao == ""){
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }
           
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //Seta os Campos
            $dao = new DaoPlaPasPessoaLotacao();
            
            $dao->setIdPasPessoaLotacao($this->idPasPessoaLotacao);       
            
            $busca = $dao->retornaPasPessoaLotacao($pdo);
            
            if ($busca){
                if (!Log::SalvaLogD('pla_pas_pessoa_lotacao', $dao->getIdPasPessoaLotacao(), $pdo)) {
                    $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                }                
            } else {
               $retorno = retornoAjax("Erro", "alert", "Não foi possível localizar o Registro.");
               $pdo->rollBack();
               return $retorno;
            }
           
            $resultDao = $dao->delete($pdo);
            if ($resultDao != "Sucesso"){
                $retorno = Metodos::retornoAjax("Erro", "console", $resultDao);
                $pdo->rollBack();
                return $retorno;
            }
            
            //Verifica se é a última unidade da Pessoa, caso seja irá remover o Perfil dele. 
            $dao->setIdPessoa($busca['id_pessoa']);
            $resultDao = $dao->retornaLotacaoAutorizadas($pdo);
            if(!$resultDao){
                $perfilPessoa = new PerfilPessoa();
                $perfilPessoa->setIdPerfil(PERFIL_PLANEJAMENTO_USUARIO);
                $perfilPessoa->setIdPessoa($dao->getIdPessoa());
                $result = $perfilPessoa->removerPerfilPessoa($pdo);
                if(!$result){
                    $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                }                   
            }            

            $sucesso = true;
                                                                                                                                                                             
            if ($sucesso){
                $retorno = Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }                                                                                       

            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
    
    
    public function retornaTrTodos(){
        $retorno = "";                
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $dao = new DaoPlaPasPessoaLotacao();                        
            
            $result = $dao->retornaTodos($pdo);
            
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $id = $v['id_pas_pessoa_lotacao'];
                    $nome = $v['nm_pessoa']." - ".$v['nm_lotacao'];
                    $retorno .= "<tr>";
                    $retorno .= "<td>".$v['nm_pessoa']."</td>"
                            . "<td>" . $v['nm_lotacao'].  "</td>"                            
                            . '<td style="text-align: center;">'                                                                                
                            . '<button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value=' . $id . ' >
                                <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                              </button>'
                            . '</td>'
                            . "</tr>";                                                                              
                    $retorno .= "</tr>";
                }
            }
            return $retorno;                                                
        } catch (Exception $ex) {
            $retorno = "";
        }                               
    }
    
    /**
     * Retorna option contendo as Lotações, caso tenha setado idPessoa ele irá ser somente na qual essa pessoa tenha liberação
     * @param type $idPessoa
     * @return string
     */
    public function retornaSelectLotacoes($idPessoa = ""){
        $retorno = "";                
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $dao = new DaoPlaPasPessoaLotacao();                        
            $dao->setIdPessoa($idPessoa);
            
            $result = $dao->retornaLotacaoAutorizadas($pdo);
            
            if (!$result) {
                return $retorno;
            } else {
                foreach ($result as $v) {
                    $retorno .= "<option value=".$v['id_lotacao'].">".$v['nm_lotacao']."</option>";                    
                }
            }
            return $retorno;                                                
        } catch (Exception $ex) {
            $retorno = "";
        }
    }

    
    /**
     * Verifica se o usuário possui permissão em uma Lotação especifica
     * @param int $idPessoa
     * @param int $idLotacao
     * @param type $pdo
     * @return boolean
     */
    public function verificaPermissao($idPessoa, $idLotacao, $pdo){
        $retorno = FALSE;        
        $pasPesLot = new DaoPlaPasPessoaLotacao();
        $pasPesLot->setIdPessoa($idPessoa);
        $pasPesLot->setIdLotacao($idLotacao);
        $result = $pasPesLot->retornaPermissaoPessoaLotacao($pdo);
        if(!$result){
            return $retorno;
        }else{
            return TRUE;
        }                                        
        return $retorno;                
    }
    
    /**
     * Verifica se o usuário possui permissão em Pas Especifico
     * @param int $idPessoa
     * @param int $idPas
     * @param type $pdo
     * @return boolean
     */
    public function verificaPermissaoPas($idPessoa, $idPas, $pdo){
        $retorno = FALSE;   
        $pasPesLot = new DaoPlaPasPessoaLotacao();        
        $result = $pasPesLot->retornaPermissaoPessoaPas($idPessoa, $idPas,$pdo);
        if(!$result){
            return $retorno;
        }else{
            return TRUE;
        }                                        
        return $retorno;                
    }

                      
    
    
    
           
}

?>
