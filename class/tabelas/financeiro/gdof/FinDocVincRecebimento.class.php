<?php

class FinDocVincRecebimento {

    private $idDocVincRecebimento = null;
    private $idDocLotacao = null;
    private $idPessoa = null;

    function getIdDocVincRecebimento() {
        return $this->idDocVincRecebimento;
    }

    function setIdDocVincRecebimento($idDocVincRecebimento) {
        $this->idDocVincRecebimento = $idDocVincRecebimento;
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