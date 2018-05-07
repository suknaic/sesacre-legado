<?php

class SituacaoExtd {
    
    private $idSituacao = null;
    private $Nova_Situacao = null;
    private $Pesq_Situacao = null;
    
    function getIdSituacao() {
        return $this->idSituacao;
    }

    function getNova_Situacao() {
        return $this->Nova_Situacao;
    }

    function getPesq_Situacao() {
        return $this->Pesq_Situacao;
    }

    function setIdSituacao($idSituacao) {
        $this->idSituacao = $idSituacao;
    }

    function setNova_Situacao($Nova_Situacao) {
        $this->Nova_Situacao = $Nova_Situacao;
    }

    function setPesq_Situacao($Pesq_Situacao) {
        $this->Pesq_Situacao = $Pesq_Situacao;
    }

}
?>
