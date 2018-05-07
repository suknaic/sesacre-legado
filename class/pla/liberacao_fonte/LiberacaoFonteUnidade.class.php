<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/pla/DaoPlaLiberacaoFonteUnidade.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/pla/DaoPlaLiberacaoFonteUnidadeTrans.class.php";

class LiberacaoFonteUnidade {
        
    private $idLiberacaoFonteUnidade = null;
    private $idLiberacaoFonte = null;
    private $idLotacao = null;
    private $idProgramaTrabalho = null;
    private $idDespesaElemento = null;
    private $vlInicial = null;
    private $vlSuplementado = null;
    private $vlReduzido = null;
    private $idPessoa = null;
    private $idLiberacaoFonteUnidadeTrans = null;
    private $vlLiberacaoFonteUnidadeTrans = null;
    private $tpLiberacaoFonteUnidadeTrans = null;
    
    function getIdLiberacaoFonteUnidade() {
        return $this->idLiberacaoFonteUnidade;
    }

    function getIdLiberacaoFonte() {
        return $this->idLiberacaoFonte;
    }

    function getIdLotacao() {
        return $this->idLotacao;
    }

    function getIdProgramaTrabalho() {
        return $this->idProgramaTrabalho;
    }

    function getIdDespesaElemento() {
        return $this->idDespesaElemento;
    }

    function getVlInicial() {
        return $this->vlInicial;
    }

    function getVlSuplementado() {
        return $this->vlSuplementado;
    }

    function getVlReduzido() {
        return $this->vlReduzido;
    }

    function getIdPessoa() {
        return $this->idPessoa;
    }

    function getIdLiberacaoFonteUnidadeTrans() {
        return $this->idLiberacaoFonteUnidadeTrans;
    }

    function getVlLiberacaoFonteUnidadeTrans() {
        return $this->vlLiberacaoFonteUnidadeTrans;
    }

    function getTpLiberacaoFonteUnidadeTrans() {
        return $this->tpLiberacaoFonteUnidadeTrans;
    }

    function setIdLiberacaoFonteUnidade($idLiberacaoFonteUnidade) {
        $this->idLiberacaoFonteUnidade = $idLiberacaoFonteUnidade;
        return $this;
    }

    function setIdLiberacaoFonte($idLiberacaoFonte) {
        $this->idLiberacaoFonte = $idLiberacaoFonte;
        return $this;
    }

    function setIdLotacao($idLotacao) {
        $this->idLotacao = $idLotacao;
        return $this;
    }

    function setIdProgramaTrabalho($idProgramaTrabalho) {
        $this->idProgramaTrabalho = $idProgramaTrabalho;
        return $this;
    }

    function setIdDespesaElemento($idDespesaElemento) {
        $this->idDespesaElemento = $idDespesaElemento;
        return $this;
    }

    function setVlInicial($vlInicial) {
        $this->vlInicial = $vlInicial;
        return $this;
    }

    function setVlSuplementado($vlSuplementado) {
        $this->vlSuplementado = $vlSuplementado;
        return $this;
    }

    function setVlReduzido($vlReduzido) {
        $this->vlReduzido = $vlReduzido;
        return $this;
    }

    function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
        return $this;
    }

    function setIdLiberacaoFonteUnidadeTrans($idLiberacaoFonteUnidadeTrans) {
        $this->idLiberacaoFonteUnidadeTrans = $idLiberacaoFonteUnidadeTrans;
        return $this;
    }

    function setVlLiberacaoFonteUnidadeTrans($vlLiberacaoFonteUnidadeTrans) {
        $this->vlLiberacaoFonteUnidadeTrans = $vlLiberacaoFonteUnidadeTrans;
        return $this;
    }

    function setTpLiberacaoFonteUnidadeTrans($tpLiberacaoFonteUnidadeTrans) {
        $this->tpLiberacaoFonteUnidadeTrans = $tpLiberacaoFonteUnidadeTrans;
        return $this;
    }
            
    private $sucesso = null;
    private $msgRetorno = null;        
           
    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function Sucesso() {

        return $this->sucesso;
    }
  
        
    /**
     * 
     * @return type
     */
    public function salvarInicial(){
        try {  
                                   
            if(empty($this->idLiberacaoFonte) || empty($this->idLotacao)
                    || empty($this->idProgramaTrabalho) || empty($this->idDespesaElemento)){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            /* @var $pdo PDO */
            $pdo = $conexao->connect();
            
            $pdo->beginTransaction();
            //Seta os Campos
            $dao = new DaoPlaLiberacaoFonteUnidade();
           
            $dao->setIdLiberacaoFonte($this->idLiberacaoFonte);
            $dao->setIdLotacao($this->idLotacao);
            $dao->setIdProgramaTrabalho($this->idProgramaTrabalho);
            $dao->setIdDespesaElemento($this->idDespesaElemento);
            $dao->setVlInicial(Metodos::ConverteValorIng($this->vlInicial));
            
            $inserir = TRUE;
            if(!empty($this->idLiberacaoFonteUnidade)){                
                $dao->setIdLiberacaoFonteUnidade($this->idLiberacaoFonteUnidade);
                $inserir = FALSE;
            }
            
            if($inserir){
                $dao->existeDuplicidade($pdo);
                
                if($dao->Sucesso()){
                    $retorno = Metodos::retornoAjax("Erro", "alert", "Já existe um Valor Inicial Cadastrado Para esse Registro.");                        
                    $pdo->rollBack();
                    return $retorno;
                }
            }
                   
            if($inserir){                           
                $dao->insert($pdo);
                
                if(!$dao->Sucesso()){
                    $retorno = Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
                    $pdo->rollBack();
                    return $retorno;
                }
                
                $dao->setIdLiberacaoFonteUnidade($pdo->lastInsertId('pla_liberacao_fonte_unidade_id_liberacao_fonte_unidade_seq'));            
                
                if (!Log::SalvaLogI('pla_liberacao_fonte_unidade', $dao->getIdLiberacaoFonteUnidade(), $pdo)) {
                    $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                }   
                
                $retorno = Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
            }else{
                
                $dao->retorna($pdo);
                if(!$dao->Sucesso()){
                    $retorno = Metodos::retornoAjax("Erro", "alert", "Não foi Possível Localizar o Registro.");                        
                    $pdo->rollBack();
                    return $retorno;
                }

                $busca = $dao->getMsgRetorno();

                $dao->existeDuplicidade($pdo);
                if($dao->Sucesso()){
                    if($this->idLiberacaoFonteUnidade != $dao->getMsgRetorno()['id_liberacao_fonte_unidade']){
                       $retorno = Metodos::retornoAjax("Erro", "alert", "Registro Duplicado. Já Existe.");                                
                        $pdo->rollBack();
                        return $retorno; 
                    }
                }

                $dao->update($pdo);               
                if(!$dao->Sucesso()){                
                    $retorno = Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
                    $pdo->rollBack();
                    return $retorno;
                }

                if (!Log::SalvaLogU('pla_liberacao_fonte_unidade', $dao->getIdLiberacaoFonteUnidade(), $busca, $pdo)) {
                    $retorno = retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                }
                $retorno = Metodos::retornoAjax("ok", "html", STR_EDICAO_SUCESSO);
                
            }                                                                                  
            $pdo->commit();
            return $retorno;
                                                                               
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
               
    
    public function removerInicial(){
        try {
                                    
            if(empty($this->idLiberacaoFonteUnidade)){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            /* @var $pdo PDO */
            $pdo = $conexao->connect();
            
            $pdo->beginTransaction();
            //Seta os Campos
            $dao = new DaoPlaLiberacaoFonteUnidade();
           
            $dao->setIdLiberacaoFonteUnidade($this->idLiberacaoFonteUnidade);      
            
            $dao->retorna($pdo);
            if(!$dao->Sucesso()){
                $retorno = Metodos::retornoAjax("Erro", "alert", "Não foi Possível Localizar o Registro.");                        
                $pdo->rollBack();
                return $retorno; 
            }
            
            $busca = $dao->getMsgRetorno();
            $dao->setIdLiberacaoFonteUnidade($busca['id_liberacao_fonte_unidade']);                                    
            
            if (!Log::SalvaLogD('pla_liberacao_fonte_unidade', $dao->getIdLiberacaoFonteUnidade(), $pdo)) {
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
    
    
    public function retornaTrPorLiberacaoFonte(PDO $pdo = null){
        $retorno = "";       
        $foot = "";
        try{
            if(empty($pdo)){
                $conexao = new Conexao();            
                $pdo = $conexao->connect();
            }
            /* @var $pdo PDO */
            $dao = new DaoPlaLiberacaoFonteUnidade();
            $dao->setIdLiberacaoFonte($this->idLiberacaoFonte);
            
            $dao->retornaDadosLiberacaoFonte($pdo);
            if(!$dao->Sucesso()){
                return $retorno;
            } else {
                
                $result = $dao->getMsgRetorno();                                
                $soma = 0;
                foreach ($result as $v) {         
                    $soma += $v['vl_total'];
                    $id = $v['id_liberacao_fonte_unidade'];
                    $retorno .= "<tr>";
                    $retorno .= "<td>" . $v['nm_lotacao'] . "</td>"                                                 
                            . "<td>" . $v['programa_trabalho'] . "</td>"
                            . "<td>" . $v['cd_despesa_elemento'] . "</td>"
                            . "<td style='text-align: right;'> R$ " . Metodos::ConverteValorBr($v['vl_inicial'], 2) .  "</td>"
                            . "<td style='text-align: right;'> R$ " . Metodos::ConverteValorBr($v['vl_suplementado'], 2) .  "</td>"
                            . "<td style='text-align: right;'> R$ " . Metodos::ConverteValorBr($v['vl_reduzido'], 2) .  "</td>"
                            . "<td style='text-align: right;'> R$ " . Metodos::ConverteValorBr($v['vl_total'], 2) .  "</td>"
                            . '<td style="text-align: center;">'
                            . '<button type="button" class="btn btn-default btn-suple btn-xs" title="Adicionar Recurso" value=' . $id . ' >
                                <i class="fa fa-arrow-circle-up fa-lg text-success" aria-hidden="true"></i>
                              </button> ' 
                            . '<button type="button" class="btn btn-default btn-reduz btn-xs" title="Reduzir Recurso" value=' . $id . ' >
                                <i class="fa fa-arrow-circle-down fa-lg text-danger" aria-hidden="true"></i>
                              </button> '
                            .'<button type="button" class="btn btn-default btn-edit btn-xs"'
                                . ' title="Editar" nome="'.$v['nm_lotacao'].'" '
                                . ' lotacao="'.$v['id_lotacao'].'" '
                                . ' programa="'.$v['id_programa_trabalho'].'" '
                                . ' despesa="'.$v['id_despesa_elemento'].'" '
                                . ' valor="'.Metodos::ConverteValorBr($v['vl_inicial'], 2).'" '
                                . ' value=' . $id . ' >
                                <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>                                
                              </button> '
                            . '<button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value=' . $id . ' >
                                <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                              </button>'
                            . '</td>'
                            . "</tr>";                                                                              
                    $retorno .= "</tr>";
                }
                $foot = "<tr><td colspan=6>Total</td><td style='text-align: right;'>R$ ".Metodos::ConverteValorBr($soma, 2)."</td><td></td></tr>";
            }
            $dados = array($retorno, $foot);
            $retorno = Metodos::retornoAjax("ok", "html", $dados);
            return $retorno;                                                
        } catch (Exception $ex) {
            $retorno = "";
        }                               
    }
    
    
    public function carregaDados(PDO $pdo = null){
        $this->sucesso = FALSE;
        try{
            if(empty($pdo)){
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }            
            $dao = new DaoPlaLiberacaoFonteUnidade();
            $dao->setIdLiberacaoFonteUnidade($this->idLiberacaoFonteUnidade);
            $dao->retorna($pdo);                                      
            
            if(!$dao->Sucesso()){            
                $this->sucesso = FALSE;
                $this->msgRetorno = $dao->getMsgRetorno();
            } else {
                $result = $dao->getMsgRetorno();
                $this->sucesso = TRUE;
                $this->idLiberacaoFonteUnidade = $result['id_liberacao_fonte_unidade'];
                $this->idLiberacaoFonte = $result['id_liberacao_fonte'];                                                             
                $this->idLotacao = $result['id_lotacao'];
                $this->idProgramaTrabalho = $result['id_programa_trabalho'];
                $this->idDespesaElemento = $result['id_despesa_elemento'];
                $this->vlInicial = $result['vl_inicial'];
                $this->vlSuplementado = $result['vl_suplementado'];
                $this->vlReduzido = $result['vl_reduzido'];
            }
                                                          
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
            $retorno = "";
        }                               
    }
    
    
    /**
     * 
     * @param type $valor
     * @param string $tipo
     * @return type
     */
    public function salvarSuplementadoReduzido($valor, string $tipo){
        try {  
                      
            if($tipo != "suplementar" && $tipo != "reduzir"){
                return Metodos::retornoAjax("Erro", "alert", "Não foi possível identificar o tipo da ação.");
            }
            
            $suplementar = TRUE;           
            if($tipo == "reduzir"){
                $suplementar = FALSE;
            }
                        
            
            if(empty($this->idLiberacaoFonteUnidade) || empty($valor)){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            
            $valor = Metodos::ConverteValorIng($valor);

            $conexao = new Conexao();
            /* @var $pdo PDO */
            $pdo = $conexao->connect();
            
            $pdo->beginTransaction();
            //Seta os Campos
            $dao = new DaoPlaLiberacaoFonteUnidade();
           
            $dao->setIdLiberacaoFonteUnidade($this->idLiberacaoFonteUnidade);
            
            
            $this->carregaDados($pdo);
            if(!$this->Sucesso()){
                return Metodos::retornoAjax("Erro", "alert", "Não foi possível carregar o registro.");
            }
            
            //Irá somente suplementar, basta atualizar
            if($suplementar){
                
                
                //Atualiza os dados do suplementado
                $dao->retorna($pdo);
                if(!$dao->Sucesso()){
                    $retorno = Metodos::retornoAjax("Erro", "alert", "Não foi Possível Localizar o Registro.");                        
                    $pdo->rollBack();
                    return $retorno;
                }

                $busca = $dao->getMsgRetorno();
                
                $dao->setVlSuplementado($this->vlSuplementado+$valor);
                $dao->updateSuplementado($pdo);                
                if(!$dao->Sucesso()){                
                    $retorno = Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
                    $pdo->rollBack();
                    return $retorno;
                }

                if (!Log::SalvaLogU('pla_liberacao_fonte_unidade', $dao->getIdLiberacaoFonteUnidade(), $busca, $pdo)) {
                    $retorno = retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                }
                                                                                                                                                
                
            //Irá reduzir, precisa verifica se irá ficar negativo antes de atualizar;
            }else{
                
                
                //Verifica se o inicial + suplementado - reduzido irá ficar menor que 0 
                if( ($this->vlInicial+$this->vlSuplementado-$this->vlReduzido-$valor) < 0 ){
                    $retorno = Metodos::retornoAjax("Erro", "alert", "O total irá ficar menor que 0. Saldo não pode ficar negativo.");                        
                    $pdo->rollBack();
                    return $retorno;
                }
                
                //Atualiza os dados do suplementado
                $dao->retorna($pdo);
                if(!$dao->Sucesso()){
                    $retorno = Metodos::retornoAjax("Erro", "alert", "Não foi Possível Localizar o Registro.");                        
                    $pdo->rollBack();
                    return $retorno;
                }

                $busca = $dao->getMsgRetorno();
                
                $dao->setVlReduzido($this->vlReduzido+$valor);
                $dao->updateReduzido($pdo);                
                if(!$dao->Sucesso()){                
                    $retorno = Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
                    $pdo->rollBack();
                    return $retorno;
                }

                if (!Log::SalvaLogU('pla_liberacao_fonte_unidade', $dao->getIdLiberacaoFonteUnidade(), $busca, $pdo)) {
                    $retorno = retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                }
                                
            }            
            
            $daoTrans = new DaoPlaLiberacaoFonteUnidadeTrans();
            $daoTrans->setIdPessoa($this->idPessoa);
            $daoTrans->setIdLiberacaoFonteUnidade($this->idLiberacaoFonteUnidade);
            $daoTrans->setVlLiberacaoFonteUnidadeTrans($valor);
            $tpLiberacaoFonteUnidadeTrans = "S";
            if(!$suplementar){
                $tpLiberacaoFonteUnidadeTrans = "R";
            }
            $daoTrans->setTpLiberacaoFonteUnidadeTrans($tpLiberacaoFonteUnidadeTrans);
            
            $daoTrans->insert($pdo);
                
            if(!$daoTrans->Sucesso()){
                $retorno = Metodos::retornoAjax("Erro", "console", $daoTrans->getMsgRetorno());
                $pdo->rollBack();
                return $retorno;
            }

            $daoTrans->setIdLiberacaoFonteUnidadeTrans($pdo->lastInsertId('pla_liberacao_fonte_unidade_t_id_liberacao_fonte_unidade_tr_seq'));            

            if (!Log::SalvaLogI('pla_liberacao_fonte_unidade_trans', $daoTrans->getIdLiberacaoFonteUnidadeTrans(), $pdo)) {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
            
            
            $retorno = Metodos::retornoAjax("ok", "html", "Ação Realizada com Sucesso");                                                                            
            $pdo->commit();
            return $retorno;
                                                                               
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
    
    /**
     * 
     * @param int $ano
     * @param PDO $pdo
     * @return string
     */
    public function retornaOptionAnoLotacaoProgTrab(int $ano, PDO $pdo = null){
        $retorno = "";       
        $foot = "";
        try{
            if(empty($pdo)){
                $conexao = new Conexao();            
                $pdo = $conexao->connect();
            }
            /* @var $pdo PDO */
            $dao = new DaoPlaLiberacaoFonteUnidade();
            $dao->setIdLotacao($this->idLotacao);
            $dao->setIdProgramaTrabalho($this->idProgramaTrabalho);
            
            $dao->retornaFontePorLotacaoAnoProgTrab($ano, $pdo);
            
            
            if(!$dao->Sucesso()){
                return $retorno;
            } else {
                
                $result = $dao->getMsgRetorno();                                
                
                foreach ($result as $v) {         
                    $retorno .= "<option value=".$v['id_fonte'].">". $v['nr_fonte'] ."</option>";
                }
                
            }            
            return $retorno;                                                
        } catch (Exception $ex) {
            $retorno = "";
        }                               
    }
    
    public function retornaValoresAnoLotacaoProgTrab(int $ano, PDO $pdo = null){
        $this->sucesso = FALSE;
        try{
            if(empty($pdo)){
                $conexao = new Conexao();            
                $pdo = $conexao->connect();
            }
            /* @var $pdo PDO */
            $dao = new DaoPlaLiberacaoFonteUnidade();
            $dao->setIdLotacao($this->idLotacao);
            $dao->setIdProgramaTrabalho($this->idProgramaTrabalho);
            
            $dao->retornaPorLotacaoAnoProgTrab($ano, $pdo);
                        
            if(!$dao->Sucesso()){
                $this->sucesso = FALSE;
                $this->msgRetorno = $dao->getMsgRetorno();                
            } else {
                $this->sucesso = TRUE;
                $this->msgRetorno = $dao->getMsgRetorno();                     
            }                                                  
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();            
        }                               
    }
    
    
    /**
     * Programa de Trabalho, Lotação, Ano, Fonte, Despesa
     * @param int $idProgramaTrabalho
     * @param int $idLotacao
     * @param int $ano
     * @param int $idFonte
     * @param type $idDespesa
     * @param PDO $pdo
     */
    public function verificaExisteLiberacaoParaPTA(int $idProgramaTrabalho, int $idLotacao
            , int $ano, int $idFonte, int $idDespesa, PDO $pdo = null){
        $this->sucesso = FALSE;
        try{
            if(empty($pdo)){
                $conexao = new Conexao();            
                $pdo = $conexao->connect();
            }
            /* @var $pdo PDO */
            $dao = new DaoPlaLiberacaoFonteUnidade();
            
            
            $dao->existeLiberacaoParaItemDoPTA($idProgramaTrabalho, $idLotacao, $ano, $idFonte, $idDespesa, $pdo);
            
                        
            if(!$dao->Sucesso()){
                $this->sucesso = FALSE;
                $this->msgRetorno = $dao->getMsgRetorno();                
            } else {
                $this->sucesso = TRUE;
                $this->msgRetorno = $dao->getMsgRetorno();                     
            }                                                  
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();            
        }                               
    }
    
    
    public function retornaValoresAnoLotacao(int $ano, PDO $pdo = null){
        $this->sucesso = FALSE;
        try{
            if(empty($pdo)){
                $conexao = new Conexao();            
                $pdo = $conexao->connect();
            }
            /* @var $pdo PDO */
            $dao = new DaoPlaLiberacaoFonteUnidade();
            $dao->setIdLotacao($this->idLotacao);            
            
            $dao->retornaPorLotacaoAno($ano, $pdo);
                        
            if(!$dao->Sucesso()){
                $this->sucesso = FALSE;
                $this->msgRetorno = $dao->getMsgRetorno();                
            } else {
                $this->sucesso = TRUE;
                $this->msgRetorno = $dao->getMsgRetorno();                     
            }                                                   
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();            
        }                               
    }
    
    
    
    public function retornaTabelaSituacao(int $ano, int $idFonte, PDO $pdo = null){
        $retorno = "";        
        try{
            if(empty($pdo)){
                $conexao = new Conexao();            
                $pdo = $conexao->connect();
            }
            /* @var $pdo PDO */
            $dao = new DaoPlaLiberacaoFonteUnidade();            
            
            $dao->retornaValorAtuaPtaQdd($ano, $idFonte, $pdo);
            if(!$dao->Sucesso()){              
                return $retorno;
            } else {
                
                $result = $dao->getMsgRetorno();                                
               
                $retorno .= '<div class="panel panel-default" style="margin-top: 5px;">'
                            . '<div class="panel-body" style="margin-bottom: 5px;">'
                                . '<span class="text-main text-semibold">
                                    Os Valores são somente dos Liberados. Se não foi Liberado um Projeto/Atividade e Despesa. Não irá aparecer na Lista Abaixo.
                                    <br><br>
                                    O "Atualizado Liberado" compõe a Liberação que é feita para as Unidades/Departamentos formular seus PAS/PTA.<br>
                                    O "PTAs" compõe os valores dos itens dos PTAS, não leva em consideração se esses PTAs foram aprovados ou não.<br>
                                    A "Dot Atual QDD" é a Dotação Inicial + Suplementado - Reduzido Do QDD.<br>
                                    O "Saldo Atual QDD" é (Dotação Inicial + Suplementado - Reduzido) + Empenhado - Bloqueado Do QDD.<br>
                                    <br>
                                    Quando o "Atualizado Liberado" for Maior que a "Dot Atual QDD", o mesmo irá ficar em vermelho.<br>
                                    Quando o "PTAs" for Maior que a "Atualizado Liberado", o mesmo irá ficar em vermelho.<br>
                                </span>'
                            . '</div>';                    

                $retorno .= '<table class="table table-striped table-bordered" cellspacing="0" width="100%" id="tabela_situacao">'
                        . '<thead>'
                            . '<tr>'
                                . '<th>Projeto/Atividade</th>'                                
                                . '<th class="text-center">Despesa</th>'
                                . '<th class="text-right">Atualizado Liberado</th>'
                                . '<th class="text-right">PTAs</th>'
                                . '<th class="text-right">Dot Atual QDD</th>'
                                . '<th class="text-right">Saldo Atual QDD</th>'
                            . '</tr>'
                        . '</thead>'
                        . '<tbody>';
                $valorTotalAtualizado = 0;
                $valorTotalPTA = 0;
                $valorTotalQDD = 0;
                $valotTotalQDDSaldo = 0;
                $classPTA = "";
                $classAtualizado = "";
                foreach ($result as $v) {    
                    $valorTotalAtualizado += $v['vl_atualizado'];
                    $valorTotalPTA += $v['vl_pta'];
                    $valorTotalQDD += $v['vl_qdd_atual'];
                    $valotTotalQDDSaldo += $v['vl_qdd_saldo'];
                    if($v['vl_pta'] > $v['vl_atualizado']){
                        $classPTA = "danger";
                    }
                    if($v['vl_atualizado'] > $v['vl_qdd_atual']){
                        $classAtualizado = "danger";
                    }
                    $retorno .= "<tr>"
                                . "<td>".$v['programa_trabalho']."</td>"                                
                                . "<td class='text-center'>".$v['cd_despesa_elemento']."</td>"
                                . "<td class='text-right ".$classAtualizado."'>R$ ". Metodos::ConverteValorBr((float)$v['vl_atualizado'], 4)."</td>"
                                . "<td class='text-right ".$classPTA."'>R$ ". Metodos::ConverteValorBr((float)$v['vl_pta'], 4)."</td>"
                                . "<td class='text-right'>R$ ". Metodos::ConverteValorBr((float)$v['vl_qdd_atual'], 4)."</td>"
                                . "<td class='text-right'>R$ ". Metodos::ConverteValorBr((float)$v['vl_qdd_saldo'], 4)."</td>"
                            . "</tr>";                                                                                                
                    $classPTA = "";
                }

                $retorno .= "</tbody>";
                $retorno .= "<tfoot>"
                            . "<tr>"
                                . "<th colspan='2'>Total</th>"
                                . "<th class='text-right'>R$ ".Metodos::ConverteValorBr($valorTotalAtualizado, 4)."</th>"
                                . "<th class='text-right'>R$ ".Metodos::ConverteValorBr($valorTotalPTA, 4)."</th>"
                                . "<th class='text-right'>R$ ".Metodos::ConverteValorBr($valorTotalQDD, 4)."</th>"
                                . "<th class='text-right'>R$ ".Metodos::ConverteValorBr($valotTotalQDDSaldo, 4)."</th>"
                                . "<th></th>"
                            . "</tr>"
                        . "</tfoot>";
                $retorno .= "</table>";

                $retorno .= "</div>";
            }
            return $retorno;                                                
        } catch (Exception $ex) {
            $retorno = "";
        }                               
    }
                  
	
}