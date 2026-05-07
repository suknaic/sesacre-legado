<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/fin/DaoFinConvenio.class.php";


class Convenio{
    
    private $idConvenio = null;
    private $idFonte = null;
    private $nmConvenio = null;
    private $vlTotal = null;
    private $sucesso = null;
    private $msgRetorno = null;    
    
    function getMsgRetorno() {
        return $this->msgRetorno;
    }   
 
    function Sucesso(){
        return $this->sucesso;
    }

    function getIdConvenio() {
        return $this->idConvenio;
    }

    function getIdFonte() {
        return $this->idFonte;
    }

    function getNmConvenio() {
        return $this->nmConvenio;
    }

    function getVlTotal() {
        return $this->vlTotal;
    }

    function setIdConvenio($idConvenio) {
        $this->idConvenio = $idConvenio;
        return $this;
    }

    function setIdFonte($idFonte) {
        $this->idFonte = $idFonte;
        return $this;
    }

    function setNmConvenio($nmConvenio) {
        $this->nmConvenio = $nmConvenio;
        return $this;
    }

    function setVlTotal($vlTotal) {
        $this->vlTotal = $vlTotal;
        return $this;
    }

    
                         
    
    /**    
     * @return Object
     */
    public function retornaConvenioPorFonte(PDO $pdo){
        $this->sucesso = false;             
        try{            
            if($pdo == null){
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            
            $dao = new DaoFinConvenio();
            $dao->setIdFonte($this->idFonte);

            $dao->retornaTodosPorFonte($pdo);
            if(!$dao->Sucesso()){
                $this->sucesso = false;
                $this->msgRetorno = $dao->getMsgRetorno();
            }else{
                $this->sucesso = true;
                $this->msgRetorno = $dao->getMsgRetorno();
            }                                                                       
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();            
        }                               
    }        
                             
}

?>
