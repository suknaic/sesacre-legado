<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/fin/DaoFinConta.class.php";


class Conta{
    
    private $idConta = null;
    private $idContaFinanceira = null;
    private $idFonteTipo = null;
    private $idFonte = null;
    private $idPortariaDs = null;
    private $idConvenio = null;

    function getIdConta() {
        return $this->idConta;
    }

    function getIdContaFinanceira() {
        return $this->idContaFinanceira;
    }

    function getIdFonteTipo() {
        return $this->idFonteTipo;
    }

    function getIdFonte() {
        return $this->idFonte;
    }

    function getIdPortariaDs() {
        return $this->idPortariaDs;
    }

    function getIdConvenio() {
        return $this->idConvenio;
    }

    function setIdConta($idConta) {
        $this->idConta = $idConta;
    }

    function setIdContaFinanceira($idContaFinanceira) {
        $this->idContaFinanceira = $idContaFinanceira;
    }

    function setIdFonteTipo($idFonteTipo) {
        $this->idFonteTipo = $idFonteTipo;
    }

    function setIdFonte($idFonte) {
        $this->idFonte = $idFonte;
    }

    function setIdPortariaDs($idPortariaDs) {
        $this->idPortariaDs = $idPortariaDs;
    }

    function setIdConvenio($idConvenio) {
        $this->idConvenio = $idConvenio;
    }

                     
    
      
                             
}

?>
