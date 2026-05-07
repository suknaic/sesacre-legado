<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/pla/DaoPlaPtaAcaoDet.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pas_resp/PasPesLot.class.php";
//require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/acao/Acao.class.php";


class PtaAcaoDet{
    
    private $idPtaAcaoDet = null;
    private $idPta = null;    
    private $idAcao = null;
    private $nmPtaAcaoDet = null;    
    private $idPtaTitulo = null;
    
    function getIdPtaTitulo() {
        return $this->idPtaTitulo;
    }

    function setIdPtaTitulo($idPtaTitulo) {
        $this->idPtaTitulo = $idPtaTitulo;
        return $this;
    }
        
    function getIdPtaAcaoDet() {
        return $this->idPtaAcaoDet;
    }

    function getIdPta() {
        return $this->idPta;
    }

    function getIdAcao() {
        return $this->idAcao;
    }

    function getNmPtaAcaoDet() {
        return $this->nmPtaAcaoDet;
    }

    function setIdPtaAcaoDet($idPtaAcaoDet) {
        $this->idPtaAcaoDet = $idPtaAcaoDet;
        return $this;
    }

    function setIdPta($idPta) {
        $this->idPta = $idPta;
        return $this;
    }

    function setIdAcao($idAcao) {
        $this->idAcao = $idAcao;
        return $this;
    }

    function setNmPtaAcaoDet($nmPtaAcaoDet) {
        $this->nmPtaAcaoDet = $nmPtaAcaoDet;
        return $this;
    }

    
    /**
     * Cadastra Um registro Referente a essa classe
     * @param int $perfil Perfil do usuario para cadastro
     * @return string
     */                                    
    public function cadastrar($perfil){
        try {
            
            //Verifica se os campos foram preenchidos
            if($this->idPtaTitulo == 0 || $this->nmPtaAcaoDet == ""
                    || $this->idAcao == 0){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            //startar conexao com o banco e salva instancia para utilizar durante o processo.
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $p = new PtaTitulo();
            $p->setIdPtaTitulo($this->idPtaTitulo);            
            $p->carregaDados($pdo);
                                                
            
            //Verifica se o usuario logado não é perfil 1
            //Verifica se tem permissão para fazer essa ação
            if($perfil != 1){
                //Verifica se o usuario possui a permissão para acessar esse Detalhamento da Ação
                //Precisa esperar a parte do Matheus pois é nela que irei trazer o PAS da Ação do PTA
                if(!$p->verificaPermissaoPas($p->getIdPas(), $pdo)){
                    return Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                }                                      
            }
            
            //Seta os Campos
            $pad = new DaoPlaPtaAcaoDet();
                        
            $pad->setIdPta($p->getIdPta());
            $pad->setNmPtaAcaoDet($this->nmPtaAcaoDet);
            $pad->setIdAcao($this->idAcao);
            
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
            if($this->idPtaAcaoDet == 0 || $this->nmPtaAcaoDet == ""
                    || $this->idAcao == 0 || $this->idPtaTitulo == 0){
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
            $pad->setIdAcao($this->idAcao);
            
            //Retorna o Estagio atual do Registro a ser Editado, para ser utilizado no LOG
            $busca = $pad->retorna($pdo);
            
            if (!$busca){
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }   
            
            
                                    
            $p = new PtaTitulo();
            $p->setIdPtaTitulo($this->idPtaTitulo);
            $p->carregaDados($pdo);                                                
            
            //Verifica se o usuario logado não é perfil 1
            //Verifica se tem permissão para fazer essa ação
            if($perfil != 1){
                //Verifica se o usuario possui a permissão para acessar esse Detalhamento da Ação
                //Precisa esperar a parte do Matheus pois é nela que irei trazer o PAS da Ação do PTA
                if(!$p->verificaPermissaoPas($p->getIdPas(), $pdo)){
                    return Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                }                                      
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
            $busca = $pad->retorna($pdo);
            
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
                        
            $this->setIdPta($busca['id_pta']);
            
            $p = new Pta();
            $p->setIdPta($this->idPta);
            $p->carregaDados($p->getIdPta());                                                
            
            //Verifica se o usuario logado não é perfil 1
            //Verifica se tem permissão para fazer essa ação
            if($perfil != 1){
                //Verifica se o usuario possui a permissão para acessar esse Detalhamento da Ação
                //Precisa esperar a parte do Matheus pois é nela que irei trazer o PAS da Ação do PTA
                if(!$p->verificaPermissaoPta($p->getIdPas(), $pdo)){
                    return Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                }                                      
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
     * Retorna as Trs para a Tabela do Detalhemento da Ação, contendo todos os Detalhementos de uma Ação Especifica do PTA          
     * @return string
     */
    public function retornaTrPorPta(){
        $retorno = "";                
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pad = new DaoPlaPtaAcaoDet();
            
            $pad->setIdPta($this->idPta);
            
            $ptaTitulo = new PtaTitulo();
            $ptaTitulo->setIdPtaTitulo($this->idPtaTitulo);
            $ptaTitulo->carregaDados($pdo);
            if(empty($ptaTitulo->getIdPtaTitulo())){
                return $retorno;
            }                        
            
            
                                    
            $result = $pad->retornaTodosPorPtaTituloPasPta((int)$ptaTitulo->getIdPtaTitulo(), (int)$ptaTitulo->getIdPas(), $pdo);
                                                                        
            
            if (!$result) {
                return $retorno;
            } else {
                //Armazena as informações na variável $retorno com os dados.
                foreach ($result as $v) {
                    $id = $v['id_pta_acao_det'];  
                    $idAcao = $v['id_acao'];
                    $retorno .= "<tr>";
                    $retorno .= "<td>".$v['nm_pta_acao_det']."</td>"
                            . "<td>".$v['nm_acao']."</td>"                                                                                                               
                            . '<td style="text-align: center;">'                          
                           
                            . '<button type="button" class="btn btn-default btn-edit btn-xs"'
                                . ' title="Editar" nome="'.$v['nm_pta_acao_det'].'" acao="'.$idAcao.'" '
                                . 'value=' . $id . ' >
                                <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>
                              </button> '
                            . '<button type="button" class="btn btn-default btn-remover btn-xs"'
                                . ' title="Remover" nome="'.$v['nm_pta_acao_det'].'" '
                                . 'value=' . $id . ' >
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
               
    
    public function carregaDados(int $idPtaAcaoDet){
        
        try{
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pad = new DaoPlaPtaAcaoDet();            
            $pad->setIdPtaAcaoDet($idPtaAcaoDet);                          
            $result = $pad->retornaPtaAcaoDet($pdo);  
            
            if (!$result) {
                
            } else {                                
                
                $this->idPtaAcaoDet = $result['id_pta_acao_det'];
                $this->idPtaAcao = $result['id_pta_acao'];
                $this->nmPtaAcaoDet = $result['nm_pta_acao_det'];
                                
            }
                                                          
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
            $result = $pad->retornaTodosDadosPorPtaAcaoDet($pdo);
            
            if (!$result) {
                return $retorno;
            } else {                                         
                                                
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
                    $retorno .= "<div class='col-sm-9'>".$result['nm_acao']."</div>";                    
                $retorno .= "</div>";
                
                $retorno .= "<div class='row'>";
                    $retorno .= "<div class='col-sm-2'><b>Indicador:</b></div>";
                    $retorno .= "<div class='col-sm-9'>".$result['ds_indicador']."</div>";                    
                $retorno .= "</div>";
                
                $retorno .= "<div class='row'>";
                    $retorno .= "<div class='col-sm-2'><b>Meta:</b></div>";
                    $retorno .= "<div class='col-sm-9'>".$result['ds_meta_plano']."</div>";                    
                $retorno .= "</div>";
                
                if($result['tipo'] != ""){
                    $retorno .= "<div class='row'>";
                        $retorno .= "<div class='col-sm-2'><b>Unidade Responsável:</b></div>";
                        $retorno .= "<div class='col-sm-9'>".$result['tipo']."</div>";                    
                    $retorno .= "</div>";
                }
                                                                                                                                                 
            }
            
            return $retorno;
                                                          
        } catch (Exception $ex) {            
            return $ex->getMessage();
        }                               
    }
    
    
    /**
     * Retorna os options de uma unico PTA e PPA Projeto/Atividade
     * @param int $idPta
     * @param int $idPpaProjAti
     * @param pdo $pdo
     * @return string
     */
    public function retornaOPPorPtaPpaProjAti(int $idPta, int $idPpaProjAti, PDO $pdo = null){
        $retorno = "";                
        try{
            if($pdo == null){
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $pad = new DaoPlaPtaAcaoDet();                        
            
            $result = $pad->retornaTodosDetAcaoPorPTAPPaProjAti($idPta, $idPpaProjAti, $pdo);
                                                                                    
            if (!$result) {
                return $retorno;
            } else {
                //Armazena as informações na variável $retorno com os dados.
                foreach ($result as $v) {                    
                    $retorno .= "<option value='".$v['id_pta_acao_det']."'>".$v['nm_pta_acao_det']."</option>";                    
                }
            }
            return $retorno;                                                
        } catch (Exception $ex) {
            $retorno = "";
        }                               
    }
    
    
    public function apagarEssaFuncao(){
        $retorno = "";                
        try{
           
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pad = new DaoPlaPtaAcaoDet();        
            $result = $pad->apagarDepois($pdo);
                                                 
            if (!$result) {
                return $retorno;
            } else {
                //Armazena as informações na variável $retorno com os dados.
                foreach ($result as $v) {                    
                    $retorno .= "<option value='".$v['id_pta_acao_det']."'>".$v['nm_pta_acao_det']."</option>";                    
                }
            }
            return $retorno;                                                
        } catch (Exception $ex) {
            $retorno = "";
        }                               
    }
                             
}

?>
