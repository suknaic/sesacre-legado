<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/pla/DaoPlaLiberacaoFonte.class.php";

class LiberacaoFonte {
    
    private $idLiberacaoFonte = null;
    private $idFonte = null;
    private $aaLiberacaoFonte = null;
    private $vlLiberacaoFonte = null;
    private $sucesso = null;
    private $msgRetorno = null;
    private $nrFonte = null;    
    
    function getNrFonte() {
        return $this->nrFonte;
    }

    function setNrFonte($nrFonte) {
        $this->nrFonte = $nrFonte;
        return $this;
    }

        
    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function Sucesso() {

        return $this->sucesso;
    }
    
    function getIdLiberacaoFonte() {
        return $this->idLiberacaoFonte;
    }

    function getIdFonte() {
        return $this->idFonte;
    }

    function getAaLiberacaoFonte() {
        return $this->aaLiberacaoFonte;
    }

    function getVlLiberacaoFonte() {
        return $this->vlLiberacaoFonte;
    }

    function setIdLiberacaoFonte($idLiberacaoFonte) {
        $this->idLiberacaoFonte = $idLiberacaoFonte;
        return $this;
    }

    function setIdFonte($idFonte) {
        $this->idFonte = $idFonte;
        return $this;
    }

    function setAaLiberacaoFonte($aaLiberacaoFonte) {
        $this->aaLiberacaoFonte = $aaLiberacaoFonte;
        return $this;
    }

    function setVlLiberacaoFonte($vlLiberacaoFonte) {
        $this->vlLiberacaoFonte = $vlLiberacaoFonte;
        return $this;
    }

        
    /**
     * 
     * @return type
     */
    public function inserir(){
        try {  
                                   
            if(empty($this->idFonte) || strlen($this->aaLiberacaoFonte) != 4
                    || empty($this->vlLiberacaoFonte)){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            /* @var $pdo PDO */
            $pdo = $conexao->connect();
            
            $pdo->beginTransaction();
            //Seta os Campos
            $dao = new DaoPlaLiberacaoFonte();
           
            $dao->setIdFonte($this->idFonte);
            $dao->setAaLiberacaoFonte($this->aaLiberacaoFonte);
            $dao->setVlLiberacaoFonte(Metodos::ConverteValorIng($this->vlLiberacaoFonte));
                       
            $dao->existeDuplicidade($pdo);
            if($dao->Sucesso()){
                $retorno = Metodos::retornoAjax("Erro", "alert", "Já existe uma Fonte Para Esse Ano Cadastrado.");                        
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
            
            $dao->setIdLiberacaoFonte($pdo->lastInsertId('pla_liberacao_fonte_id_liberacao_fonte_seq'));            

            if (!Log::SalvaLogI('pla_liberacao_fonte', $dao->getIdLiberacaoFonte(), $pdo)) {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }                        
                                                          
            $retorno = Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
            $pdo->commit();
            return $retorno;
                                                                               
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
    
    
    public function editar(){
        try {  
                                   
            if(empty($this->idFonte) || strlen($this->aaLiberacaoFonte) != 4
                    || empty($this->vlLiberacaoFonte) || empty($this->idLiberacaoFonte)){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            /* @var $pdo PDO */
            $pdo = $conexao->connect();
            
            $pdo->beginTransaction();
            //Seta os Campos
            $dao = new DaoPlaLiberacaoFonte();
           
            $dao->setIdLiberacaoFonte($this->idLiberacaoFonte);
            $dao->setIdFonte($this->idFonte);
            $dao->setAaLiberacaoFonte($this->aaLiberacaoFonte);
            $dao->setVlLiberacaoFonte(Metodos::ConverteValorIng($this->vlLiberacaoFonte));
            
            $dao->retorna($pdo);
            if(!$dao->Sucesso()){
                $retorno = Metodos::retornoAjax("Erro", "alert", "Não foi Possível Localizar o Registro.");                        
                $pdo->rollBack();
                return $retorno;
            }
            
            $busca = $dao->getMsgRetorno();
            
            $dao->existeDuplicidade($pdo);
            if($dao->Sucesso()){
                if($this->idLiberacaoFonte != $dao->getMsgRetorno()['id_liberacao_fonte']){
                   $retorno = Metodos::retornoAjax("Erro", "alert", "Já existe uma Fonte Para Esse Ano Cadastrado.");                                
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

            if (!Log::SalvaLogU('pla_liberacao_fonte', $dao->getIdLiberacaoFonte(), $busca, $pdo)) {
                $retorno = retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }  

            $retorno = Metodos::retornoAjax("ok", "html", STR_EDICAO_SUCESSO);
            $pdo->commit();
            return $retorno;                        
                                                
                                                                               
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }  
    }
    
    
    public function remover(){
        try {
                                    
            if(empty($this->idLiberacaoFonte)){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            /* @var $pdo PDO */
            $pdo = $conexao->connect();
            
            $pdo->beginTransaction();
            //Seta os Campos
            $dao = new DaoPlaLiberacaoFonte();
           
            $dao->setIdLiberacaoFonte($this->idLiberacaoFonte);      
            
            //Verifica se Já existe algum Qdd Cadastrado no Sistema para esse Ano
            $dao->retorna($pdo);
            if(!$dao->Sucesso()){
                $retorno = Metodos::retornoAjax("Erro", "alert", "Não foi Possível Localizar o Registro.");                        
                $pdo->rollBack();
                return $retorno; 
            }
            
            $busca = $dao->getMsgRetorno();
            $dao->setIdLiberacaoFonte($busca['id_liberacao_fonte']);                                    
            
            if (!Log::SalvaLogD('pla_liberacao_fonte', $dao->getIdLiberacaoFonte(), $pdo)) {
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
    
    
    public function retornaTr(PDO $pdo = null){
        $retorno = "";     
        $foot = "";
        try{
            if(empty($pdo)){
                $conexao = new Conexao();            
                $pdo = $conexao->connect();
            }
            /* @var $pdo PDO */
            $dao = new DaoPlaLiberacaoFonte();
            
            
            
            $dao->retornaTodos($pdo);
            if(!$dao->Sucesso()){
                return $retorno;
            } else {
                
                $result = $dao->getMsgRetorno();
                $soma = 0;
                foreach ($result as $v) {    
                    $soma += $v['vl_liberacao_fonte'];
                    $id = $v['id_liberacao_fonte'];
                    $retorno .= "<tr>";
                    $retorno .= "<td>" . $v['nr_fonte'] . "</td>"
                            . "<td>" . $v['aa_liberacao_fonte'] . "</td>"                            
                            . "<td style='text-align: right;'> R$ " . Metodos::ConverteValorBr($v['vl_liberacao_fonte'], 2) .  "</td>"                           
                            . '<td style="text-align: center;">'
                            . '<a href="liber_fonte.php?token='.$id.'" class="btn btn-default btn-entrar btn-xs" title="Liberação do Recurso Para Unidades"> 
                                <i class="fa fa-search-plus fa-lg text-info" aria-hidden="true"></i>
                            </a> '                                                  
                            .'<button type="button" class="btn btn-default btn-edit btn-xs"'                               
                                . ' title="Editar" nome="'.$v['nr_fonte'].'" '
                                . ' ano="'.$v['aa_liberacao_fonte'].'" '
                                . ' fonte="'.$v['id_fonte'].'" '                                                                                          
                                . ' valor="'.Metodos::ConverteValorBr($v['vl_liberacao_fonte'], 2).'" '
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
                $foot = "<tr><td colspan=2>Total</td><td style='text-align: right;'>R$ ".Metodos::ConverteValorBr($soma, 2)."</td><td></td></tr>";
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
            $dao = new DaoPlaLiberacaoFonte();
            $dao->setIdLiberacaoFonte($this->idLiberacaoFonte);
            $dao->retornaDadosCompleto($pdo);                                      
            
            if(!$dao->Sucesso()){            
                $this->sucesso = FALSE;
                $this->msgRetorno = $dao->getMsgRetorno();
            } else {
                $result = $dao->getMsgRetorno();
                $this->sucesso = TRUE;
                $this->idLiberacaoFonte = $result['id_liberacao_fonte'];
                $this->idFonte = $result['id_fonte'];                                                             
                $this->aaLiberacaoFonte = $result['aa_liberacao_fonte'];
                $this->vlLiberacaoFonte = Metodos::ConverteValorBr($result['vl_liberacao_fonte'], 2);
                $this->nrFonte = $result['nr_fonte'];
            }
                                                          
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
            $retorno = "";
        }                               
    }
                  
	
}