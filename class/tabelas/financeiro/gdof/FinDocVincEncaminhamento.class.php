<?php

class FinDocVincEncaminhamento {

    private $idDocVincEncaminhamento = null;
    private $idDocLotacao = null;
    private $idPessoa = null;

    function getIdDocVincEncaminhamento() {
        return $this->idDocVincEncaminhamento;
    }

    function setIdDocVincEncaminhamento($idDocVincEncaminhamento) {
        $this->idDocVincEncaminhamento = $idDocVincEncaminhamento;
        return $this;
    }

    function getIdDocLotacao() {
        return $this->idDocLotacao;
    }
    
    function getIdPessoa(){
        return $this->idPessoa;
    }

    function setIdDocLotacao($idDocLotacao) {
        $this->idDocLotacao = $idDocLotacao;
        return $this;
    }
    
    function setIdPessoa($idPessoa){
        $this->idPessoa = $idPessoa;
        return $this;
    }


}

