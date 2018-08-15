<?php

class FinDocVincEncaminhamento {

    private $idDocVincEncaminhamento = null;
    private $idDocTipoLotacao = null;
    private $idLotacao = null;
    private $idPessoa = null;

    function getIdDocVincEncaminhamento() {
        return $this->idDocVincEncaminhamento;
    }

    function setIdDocVincEncaminhamento($idDocVincEncaminhamento) {
        $this->idDocVincEncaminhamento = $idDocVincEncaminhamento;
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

