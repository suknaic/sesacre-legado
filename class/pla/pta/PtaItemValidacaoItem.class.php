<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/pla/DaoPlaPtaItemValidacaoItem.class.php";

class PtaItemValidacaoItem{    
    
    
    private $idPtaItem = null;
    private $idLotacao = null;
    private $idPessoa = null;     
    private $sucesso = null;
    private $msgRetorno = null;     
    
    
    function getIdPtaItem() {
        return $this->idPtaItem;
    }

    function getIdLotacao() {
        return $this->idLotacao;
    }

    function getIdPessoa() {
        return $this->idPessoa;
    }

    function getSucesso() {
        return $this->sucesso;
    }

    function setIdPtaItem($idPtaItem) {
        $this->idPtaItem = $idPtaItem;
        return $this;
    }

    function setIdLotacao($idLotacao) {
        $this->idLotacao = $idLotacao;
        return $this;
    }

    function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
        return $this;
    }

    function setSucesso($sucesso) {
        $this->sucesso = $sucesso;
        return $this;
    }     
        
    function getMsgRetorno() {
        return $this->msgRetorno;
    }   
 
    function Sucesso(){
        return $this->sucesso;
    }
                 
     
    public function salvarPtasItens(array $arrayItens, PDO $pdo){
        try {                                 
                                                                            
            //Seta os Cammpos
            $dao = new DaoPlaPtaItemValidacaoItem();
            $dao->setIdLotacao($this->idLotacao);
            $dao->setIdPessoa($this->idPessoa);                        
                                                                                                                                                                                                   
            foreach ($arrayItens as $value) {
                $dao->setIdPtaItem($value['id_pta_item']);
                $dao->insert($pdo);
                if(!$dao->Sucesso()){
                    $this->sucesso = false;
                    $this->msgRetorno = $dao->getMsgRetorno();
                    $pdo->rollBack();
                    return;                    
                }else{
                    $dao->setIdPtaItemValidacaoItem($pdo->lastInsertId('pla_pta_item_validacao_item_id_pta_item_validacao_item_seq'));
                    if (!Log::SalvaLogI('pla_pta_item_validacao_item', $dao->getIdPtaItemValidacaoItem(), $pdo)) {
                        $this->sucesso = false;
                        $this->msgRetorno = $dao->getMsgRetorno();
                        $pdo->rollBack();
                        return;    
                    }
                }                                 
            }
            
            $this->sucesso = true;
            return;                                                                                                                                                                                               
        
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
            $pdo->rollBack();
            return;                
        }  
    }
               
    
    
                                       
}

?>
