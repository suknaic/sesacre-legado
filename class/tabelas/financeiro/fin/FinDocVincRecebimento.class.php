<?php

class FinDocVincRecebimento {

    private $idDocVincRecebimento = null;
    private $idDocTipoLotacao = null;
    private $idLotacao = null;
    private $idPessoa = null;

    function getIdDocVincRecebimento() {
        return $this->idDocVincRecebimento;
    }

    function setIdDocVincRecebimento($idDocVincRecebimento) {
        $this->idDocVincRecebimento = $idDocVincRecebimento;
        return $this;
    }

    function getIdDocTipoLotacao() {
        return $this->idDocTipoLotacao;
    }

    function getIdLotacao() {
        return $this->idLotacao;
    }
    
    function getIdPessoa(){
        return $this->idPessoa;
    }

    function setIdDocTipoLotacao($idDocTipoLotacao) {
        $this->idDocTipoLotacao = $idDocTipoLotacao;
        return $this;
    }

    function setIdLotacao($idLotacao) {
        $this->idLotacao = $idLotacao;
        return $this;
    }
    
    function setIdPessoa($idPessoa){
        $this->idPessoa = $idPessoa;
        return $this;
    }


}