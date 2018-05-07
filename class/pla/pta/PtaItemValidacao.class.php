<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/pla/DaoPlaPtaItemValidacao.class.php";

class PtaItemValidacao{    
    
    
    private $idPas = null;
    private $idTipoGastoCategoria = null;
    private $idPessoa = null;
    private $dsPtaItemValidacao = null;    
    private $sucesso = null;
    private $msgRetorno = null;        
       
    function getIdPas() {
        return $this->idPas;
    }

    function getIdTipoGastoCategoria() {
        return $this->idTipoGastoCategoria;
    }

    function getIdPessoa() {
        return $this->idPessoa;
    }

    function getDsPtaItemValidacao() {
        return $this->dsPtaItemValidacao;
    }

    function setIdPas($idPas) {
        $this->idPas = $idPas;
        return $this;
    }

    function setIdTipoGastoCategoria($idTipoGastoCategoria) {
        $this->idTipoGastoCategoria = $idTipoGastoCategoria;
        return $this;
    }

    function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
        return $this;
    }

    function setDsPtaItemValidacao($dsPtaItemValidacao) {
        $this->dsPtaItemValidacao = $dsPtaItemValidacao;
        return $this;
    }
        
    function getMsgRetorno() {
        return $this->msgRetorno;
    }   
 
    function Sucesso(){
        return $this->sucesso;
    }
                 
                              
    /**
     * 
     * @param type $quem 1 - Unidade/Departamento/Setor; 2 - Central;
     * @param type $acao 1 - Envio; 2 - Retorno;
     * @param type $perfil 0 - Valida Permissão; 1 - Não valida nada
     * @return type
     */
    public function salvar($quem, $acao, $perfil){
        try {         
            
            if($this->idPas == 0 || $this->idTipoGastoCategoria == 0
                    || $this->idPessoa == 0) {
                $this->sucesso = false;
                $this->msgRetorno = STR_PREENCHER_CAMPOS;
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            /* @var $pdo PDO */
            $pdo = $conexao->connect();            
            $pdo->beginTransaction();                     
                        
                       
            //Seta os Cammpos
            $dao = new DaoPlaPtaItemValidacao();
            $dao->setIdPas($this->idPas);
            $dao->setIdTipoGastoCategoria($this->idTipoGastoCategoria);
            $dao->setIdPessoa($this->idPessoa);
            $dao->setDsPtaItemValidacao($this->dsPtaItemValidacao);     
            
            $tipo = new TipoGastoCategoria();            
            $tipo->setIdTipoGastoCategoria($this->idTipoGastoCategoria);
            $tipo->carregaTipoGastoCategoria($pdo);            
            if(!$tipo->Sucesso()){                    
                return Metodos::retornoAjax("Erro", "alert", "Não foi possível localizar o Tipo de Gasto Categoria." .STR_ERROR); 
            }
            
            
            $p = new Pas();
            $p->setIdPas($this->idPas);            
            $p->carregaDados($p->getIdPas(),$pdo);                                                        
            //Verifica se o usuario logado não é perfil 1
            //Verifica se tem permissão para fazer essa ação
            //Aqui quem está usando a Unidade/Setor que deseja Enviar os Itens Para Validação
            //Por isso precisa se ter certeza se quem está enviando tem acesso para esse PAS;
            if($perfil == 0 && $quem == 1){                              
                if(!$p->verificaPermissaoPas($p->getIdLotacao(), $pdo)){
                    return Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                }         
            //Aqui Verificamos se quem está enviando possui permissão para com essa Central de Demanda.
            }else if($perfil == 0 && $quem == 2){
                
                $central = new CentralPessoa();
                $central->setIdLotacao($tipo->getIdLotacao());
                $central->setIdPessoa($this->idPessoa);
                $central->verificaPermissao($pdo);                
                if(!$central->Sucesso()){                 
                    return Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                }
            }
            
            //Mudar o status dos Itens do PTA que estão para se validados, somente os 2 status
            $item = new PtaItem();            
            
            //Unidade Enviar para Central os Itens que estao na Unidade
            if($quem == 1 && $acao == 1){
                $statusQueFicara = $item->stItemEnviadoValidacaoCentral();
                $statusQueEstao = $item->stItemNaUnidade();
                $dao->setStPtaItemValidacao($statusQueFicara);      
            //Central Validar os Itens
            }else if($quem == 2 && $acao == 1){
                $statusQueFicara = $item->stItemValidado();
                $statusQueEstao = $item->stItemEnviadoValidacaoCentral();                
                $dao->setStPtaItemValidacao($statusQueFicara);
            //Central Retorna os Itens para a Unidade
            }else if($quem == 2 && $acao == 2){
                $statusQueFicara = $item->stItemRetornoCentral();
                $statusQueEstao = $item->stItemEnviadoValidacaoCentral();
                $dao->setStPtaItemValidacao($statusQueFicara);
            }
            
            if(!is_array($statusQueEstao)){
                $statusQueEstao = array($statusQueEstao);
            }
            
            //Primeiro, Iremos buscar os Ids dos Itens que terão seus Status Alterados
            //Então alteramos o Status desses Itens            
            //Posterior, caso seja a Central Validando os Itens, iremos atualizar na tabela de validação dos Itens
            //Para saber qual central e quem foi que validou os Itens
            
            $status = Metodos::implodeComAspas($statusQueEstao); 
            $item->setIdTipoGastoCategoria($this->idTipoGastoCategoria);            
            $item->retornaItensPorPasTGCStatus($this->idPas, $status, $pdo);
            
            //Caso não ache nenhum Item, irá somente a Mensagem.
            if(!$item->Sucesso()){
                //$pdo->rollBack();
                //return Metodos::retornoAjax("Erro", "alert", "Não foi possível localizar nenhum item para ser Utilizado.");
            }else{
                $arrayItens = $item->getMsgRetorno();
                if(count($arrayItens) > 0){
                    //Alterar o Status de Todos os Itens
                    $item->alterarStatusItensPorPASTipoGastoCategoria($arrayItens, $statusQueFicara, $pdo);
                    if(!$item->Sucesso()){
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "console", $item->getMsgRetorno()); 
                    }
                    
                    //Registrar a Informações da Alteração dos Itens de quem foi e qual central
                    //Isso somente se a Central Validar.
                    if($quem == 2 && $acao == 1){
                        $ptaItemValidacaoItem = new PtaItemValidacaoItem();
                        $ptaItemValidacaoItem->setIdLotacao($tipo->getIdLotacao());
                        $ptaItemValidacaoItem->setIdPessoa($this->idPessoa);
                        $ptaItemValidacaoItem->salvarPtasItens($arrayItens, $pdo);
                        if(!$ptaItemValidacaoItem->Sucesso()){
                            $this->sucesso = false;
                            $this->msgRetorno = $ptaItemValidacaoItem->getMsgRetorno();
                            return Metodos::retornoAjax("Erro", "console", $ptaItemValidacaoItem->getMsgRetorno());
                        }                        
                    }                                        
                }                
            }
                                                                                                                                                                                                        
                    
            //Salvar a Mensagem de Envio                                  
            $dao->insert($pdo);
            if(!$dao->Sucesso()){
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());                
            }else{
                $dao->setIdPtaItemValidacao($pdo->lastInsertId('pla_pta_item_validacao_id_pta_item_validacao_seq'));
                if (Log::SalvaLogI('pla_pta_item_validacao', $dao->getIdPtaItemValidacao(), $pdo)) {
                    $sucesso = true;
                }else{
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());                          
                }
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
        
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());                        
        }  
    }
               
    
    
    public function retornaMensagensPorPASINTipoGastoCategoria($idsTipoGastoCategoria, PDO $pdo = null){
        $this->sucesso = false;           
        try{
            if($pdo == null){
                $conexao = new Conexao();            
                /* @var $pdo PDO */
                $pdo = $conexao->connect();            
            }            
            
            $dao = new DaoPlaPtaItemValidacao();
            $dao->setIdPas($this->idPas);            
                        
            $dao->retornaMensagensPorPasINTipo($idsTipoGastoCategoria, $pdo);                       
            
            if(!$dao->Sucesso()){    
                $this->sucesso = false;
                $this->msgRetorno = $dao->getMsgRetorno();
                return;
            }else{
                $this->sucesso = true;
                $this->msgRetorno = $dao->getMsgRetorno();
                return;
                               
            }                                    
                                                                     
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
            return;
        }                               
    }
    
    
                                       
}

?>
