<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/pla/DaoPlaPasAlteracao.class.php";

class PasAlteracao{    
    
    
    private $idPas = null;    
    private $idPessoa = null;    
    private $dsTela = null;
    private $dsPasAlteracao = null;
    private $tpPasAlteracao = null;
    private $idPta = null;
    private $idPtaTitulo = null;
    private $idPtaItem = null;
    
    private $sucesso = null;
    private $msgRetorno = null;    

    function getIdPtaItem() {
        return $this->idPtaItem;
    }

    function setIdPtaItem($idPtaItem) {
        $this->idPtaItem = $idPtaItem;
        return $this;
    }  
    
    function getIdPta() {
        return $this->idPta;
    }

    function getIdPtaTitulo() {
        return $this->idPtaTitulo;
    }

    function setIdPta($idPta) {
        $this->idPta = $idPta;
        return $this;
    }

    function setIdPtaTitulo($idPtaTitulo) {
        $this->idPtaTitulo = $idPtaTitulo;
        return $this;
    }
           
    
    function getIdPas() {
        return $this->idPas;
    }

    function getIdPessoa() {
        return $this->idPessoa;
    }

    function getDsTela() {
        return $this->dsTela;
    }

    function getDsPasAlteracao() {
        return $this->dsPasAlteracao;
    }

    function getTpPasAlteracao() {
        return $this->tpPasAlteracao;
    }

    function setIdPas($idPas) {
        $this->idPas = $idPas;
        return $this;
    }

    function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
        return $this;
    }

    function setDsTela($dsTela) {
        $this->dsTela = $dsTela;
        return $this;
    }

    function setDsPasAlteracao($dsPasAlteracao) {
        $this->dsPasAlteracao = $dsPasAlteracao;
        return $this;
    }

    function setTpPasAlteracao($tpPasAlteracao) {
        $this->tpPasAlteracao = $tpPasAlteracao;
        return $this;
    }

                
    function getMsgRetorno() {
        return $this->msgRetorno;
    }   
 
    function Sucesso(){
        return $this->sucesso;
    }
                 
                              
   
    public function salvar(PDO $pdo = null){
        $this->sucesso = FALSE;
        try {         
            if(empty($pdo)){
                $conexao = new Conexao();
                /* @var $pdo PDO */
                $pdo = $conexao->connect(); 
            }
            
            if($this->idPas == 0 || $this->idPessoa == 0) {
                $this->sucesso = false;
                $this->msgRetorno = STR_PREENCHER_CAMPOS;                
            }                   
                                             
            
            //Seta os Cammpos
            $dao = new DaoPlaPasAlteracao();            
            $dao->setIdPas($this->idPas);            
            $dao->setIdPessoa($this->idPessoa);
            $dao->setDsTela($this->dsTela);
            $dao->setDsPasAlteracao($this->dsPasAlteracao);
            $dao->setTpPasAlteracao($this->tpPasAlteracao);
            $dao->setIdPta($this->idPta);
            $dao->setIdPtaTitulo($this->idPtaTitulo);       
            $dao->setIdPtaItem($this->idPtaItem);
                    
            //Salvar a Mensagem de Envio                                  
            $dao->insert($pdo);
            if(!$dao->Sucesso()){
                $this->sucesso = FALSE;
                $this->msgRetorno = $dao->getMsgRetorno();
                $pdo->rollBack();                         
            }else{
                $dao->setIdPasAlteracao($pdo->lastInsertId('pla_pas_alteracao_id_pas_alteracao_seq'));
                if (!Log::SalvaLogI('pla_pas_alteracao', $dao->getIdPasAlteracao(), $pdo)) {
                    $this->msgRetorno = "LOG";
                    $this->sucesso = FALSE;
                    $pdo->rollBack();
                }
            }                                                                                                                                                                    
           
            $this->sucesso = TRUE;
        
        } catch (Exception $exc) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $exc->getMessage();            
        }  
    }
               
    
    
    
    
                                       
}

?>
