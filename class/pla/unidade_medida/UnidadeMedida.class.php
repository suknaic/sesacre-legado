<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/pla/DaoPlaUnidadeMedida.class.php";


class UnidadeMedida{
    
    private $idUnidadeMedida = null;
    private $nmUnidadeMedida = null;    

    function getIdUnidadeMedida() {
        return $this->idUnidadeMedida;
    }

    function getNmUnidadeMedida() {
        return $this->nmUnidadeMedida;
    }

    function setIdUnidadeMedida($idUnidadeMedida) {
        $this->idUnidadeMedida = $idUnidadeMedida;
    }

    function setNmUnidadeMedida($nmUnidadeMedida) {
        $this->nmUnidadeMedida = $nmUnidadeMedida;
    }             
        

    /**
     * Cadastra Um registro Referente a essa classe
     * @param int $perfil Perfil do usuario para cadastro
     * @return string
     */                                    
    public function cadastrar($perfil){
        try {
            
            //Verifica se os campos foram preenchidos
            if($this->idPtaAcao == "" || $this->nmPtaAcaoDet == ""){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            //startar conexao com o banco e salva instancia para utilizar durante o processo.
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
                                    
            
            //Verifica se o usuario logado não é perfil 1
            //Verifica se tem permissão para fazer essa ação
            if($perfil != 1){
                //Verifica se o usuario possui a permissão para acessar esse Detalhamento da Ação
                //Precisa esperar a parte do Matheus pois é nela que irei trazer o PAS da Ação do PTA
                if(!$this->verificaPermissaoPtaAcaoDet($this->idPtaAcao, $pdo)){
                    return Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                }                                      
            }
            
            //Seta os Campos
            $pad = new DaoPlaPtaAcaoDet();
                        
            $pad->setIdPtaAcao($this->idPtaAcao);
            $pad->setNmPtaAcaoDet($this->nmPtaAcaoDet);                                    
            
            //Insere o Registro no banco
            $result = $pad->insert($pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }
            //Pega o ID Inserido                                                                                         
            $pad->setIdPtaAcaoDet($pdo->lastInsertId('pla_pta_acao_det_id_pta_acao_det_seq'));            
            //Salva no Log
            $sucesso = false;
            if (Log::SalvaLogI('pla_pta_acao_det', $pad->getIdPtaAcaoDet(), $pdo)) {
                $sucesso = true;
            }else{
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
            //Se tudo deu certo da commit e enviar uma mensagem de sucesso.
            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", "Cadastro do Detalhemento da Ação Realizado com Sucesso.");
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }                                                                                       
            //Caso de algo errado ele retorna erro
            $pdo->rollBack();
            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
    
    /**
     * Edita Um registro Referente a essa classe
     * @return string
     */
    public function editar($perfil){
        try {
            
            //Verifica se os campos foram preenchidos
            if($this->nmPtaAcaoDet == "" || $this->idPtaAcaoDet == ""){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            //startar conexao com o banco e salva instancia para utilizar durante o processo.
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            //Seta os Campos
            $pad = new DaoPlaPtaAcaoDet();
                        
            $pad->setIdPtaAcaoDet($this->idPtaAcaoDet);            
            $pad->setNmPtaAcaoDet($this->nmPtaAcaoDet);                                    
            
            //Retorna o Estagio atual do Registro a ser Editado, para ser utilizado no LOG
            $busca = $pad->retornaPtaAcaoDet($pdo);
            
            $this->setIdPtaAcao($busca['id_pta_acao']);
                        
            //Verifica se o usuario logado não é perfil 1
            //Verifica se tem permissão para fazer essa ação
            if($perfil != 1){
                //Verifica se o usuario possui a permissão para acessar esse Detalhamento da Ação
                //Precisa esperar a parte do Matheus pois é nela que irei trazer o PAS da Ação do PTA
                if(!$this->verificaPermissaoPtaAcaoDet($this->idPtaAcao, $pdo)){
                    return Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                }                                      
            }            
            
            if (!$busca){
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }                                  
                                                
            //Edita o Registro no banco
            $result = $pad->update($pdo);
            if ($result != "Sucesso") {
                $retorno = Metodos::retornoAjax("Erro", "console", $result);
                $pdo->rollBack();
                return $retorno;
            }
            //Salva no Log
            $sucesso = false;
            if (!Log::SalvaLogU('pla_pta_acao_det', $pad->getIdPtaAcaoDet(), $busca, $pdo)){
                $retorno = retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }else{
                $sucesso = true;
            }
                                                                                                                                 
            //Se tudo deu certo da commit e enviar uma mensagem de sucesso.                              
            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", "Edição Realizada com Sucesso.");
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }    
            
            //Caso de algo errado ele retorna erro
            $pdo->rollBack();
            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
    
    /**
     * Remove Um registro Referente a essa classe
     * @return string
     */
    public function remover($perfil){
        try {
            
            //Verifica se enviou o campo.                   
            if($this->idPtaAcaoDet == ""){
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }
            //startar conexao com o banco e salva instancia para utilizar durante o processo.
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();                 
                        
            //Seta os Campos
            $pad = new DaoPlaPtaAcaoDet();
            
            $pad->setIdPtaAcaoDet($this->idPtaAcaoDet);    
            
            //Retorna o Estagio atual do Registro a ser Removido, para ser utilizado no LOG
            $busca = $pad->retornaPtaAcaoDet($pdo);
            
            
            $this->setIdPtaAcao($busca['id_pta_acao']);
            
            //Verifica se o usuario logado não é perfil 1
            //Verifica se tem permissão para fazer essa ação
            if($perfil != 1){
                //Verifica se o usuario possui a permissão para acessar esse Detalhamento da Ação
                //Precisa esperar a parte do Matheus pois é nela que irei trazer o PAS da Ação do PTA
                if(!$this->verificaPermissaoPtaAcaoDet($this->idPtaAcao, $pdo)){
                    return Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                }                                      
            }  
                        
            
            //Salva no Log            
            if ($busca){
                if (!Log::SalvaLogD('pla_pta_acao_det', $pad->getIdPtaAcaoDet(), $pdo)) {
                    $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                }                
            } else {
               $retorno = retornoAjax("Erro", "alert", "Não foi possível localizar o Detalhamento da Ação.");
               $pdo->rollBack();
               return $retorno;
            }
                                                
            //Remove o Registro no banco
            $resultDao = $pad->delete($pdo);
            if ($resultDao != "Sucesso"){
                $retorno = Metodos::retornoAjax("Erro", "console", $resultDao);
                $pdo->rollBack();
                return $retorno;
            }

            $sucesso = true;
            //Se tudo deu certo da commit e enviar uma mensagem de sucesso.                                                                                                                                                              
            if ($sucesso){
                $retorno = Metodos::retornoAjax("ok", "html", "Detalhemento da Ação removido com Sucesso.");
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }        
            
            //Caso de algo errado ele retorna erro
            $pdo->rollBack();
            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
                 
    
    /**
     * Verifica se o usuário possui permissão em um Pas especifico
     * @param int $idPas
     * @param type $pdo
     * @return boolean
     */
    public function verificaPermissaoPtaAcaoDet($idPasAcao, $pdo){
        
        return TRUE;
        
        try {                    
            $retorno = FALSE;
            $pasPes = new PasPesLot();        
            $result = $pasPes->verificaPermissaoPas($_SESSION['idUser'], $idPas, $pdo);
            if(!$result){
                return $retorno;
            }else{
                return TRUE;
            }                                        
            return $retorno;
        } catch (Exception $exc) {
            $retorno = FALSE;
            echo $exc->getMessage();
        }
                             
    }
    
    
       
    
    /**
     * Retorna os options de Todas Unidades de Medida     
     * @return string
     */
    public function retornaOptionSelect(){
        $retorno = "";                
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $unid = new DaoPlaUnidadeMedida();                        
            
            $result = $unid->retornaTodosPlaUnidadeMedida($pdo);
                                                                        
            
            if (!$result) {
                return $retorno;
            } else {
                //Armazena as informações na variável $retorno com os dados.
                foreach ($result as $v) {
                    if ($this->idUnidadeMedida == $v['id_unidade_medida']){
                        $retorno .= "<option value='".$v['id_unidade_medida']."' selected>".$v['nm_unidade_medida']."</option>";
                    } else {
                        $retorno .= "<option value='".$v['id_unidade_medida']."'>".$v['nm_unidade_medida']."</option>";
                    }
                }
            }
            return $retorno;                                                
        } catch (Exception $ex) {
            $retorno = "";
        }                               
    }
    
    public function retornaInfoPorDetAcao(){
        $retorno = "";
        
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pad = new DaoPlaPtaAcaoDet();
            $pad->setIdPtaAcaoDet($this->idPtaAcaoDet);                     
            $result = $pad->retornaTodosDadosDoPEsPorPtaAcaoDet($pdo);
            
            if (!$result) {
                return $retorno;
            } else {          
                
                $acao = new Acao();
                $cadastro = $acao->pegaCadastro($result['tp_cadastro']);   
                
                $retorno .= "<div class='row'>";
                    $retorno .= "<div class='col-sm-2'><b>Projeto do PPA:</b></div>";
                    $retorno .= "<div class='col-sm-9'>".$result['nm_proj_ppa']."</div>";                       
                $retorno .= "</div>";
                
                $retorno .= "<div class='row'>";
                    $retorno .= "<div class='col-sm-2'><b>Eixo:</b></div>";
                    $retorno .= "<div class='col-sm-9'>".$result['nm_eixo']."</div>";                    
                $retorno .= "</div>";                                
                
                $retorno .= "<div class='row'>";
                    $retorno .= "<div class='col-sm-2'><b>Diretriz:</b></div>";
                    $retorno .= "<div class='col-sm-9'>".$result['nm_diretriz']."</div>";                    
                $retorno .= "</div>";                                
                
                $retorno .= "<div class='row'>";
                    $retorno .= "<div class='col-sm-2'><b>Objeto:</b></div>";
                    $retorno .= "<div class='col-sm-9'>".$result['nm_objetivo']."</div>";                    
                $retorno .= "</div>";
                
                $retorno .= "<div class='row'>";
                    $retorno .= "<div class='col-sm-2'><b>Ação:</b></div>";
                    $retorno .= "<div class='col-sm-9'>".$result['nm_acao']." | ".$cadastro."</div>";                    
                $retorno .= "</div>";
                                                                                                                                                 
            }
            
            return $retorno;
                                                          
        } catch (Exception $ex) {            
            return $ex->getMessage();
        }                               
    }
                             
}

?>
