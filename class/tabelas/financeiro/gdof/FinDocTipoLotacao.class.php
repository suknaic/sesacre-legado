<?php

class FinDocTipoLotacao {

    private $idDocTipoLotacao = null;
    private $nmDocTipoLotacao = null;
    private $stAtivo = '1';
    
    function getIdDocTipoLotacao() {
        return $this->idDocTipoLotacao;
    }

    function getNmDocTipoLotacao() {
        return $this->nmDocTipoLotacao;
    }

    function getStAtivo() {
        return $this->stAtivo;
    }

    function setIdDocTipoLotacao($idDocTipoLotacao) {
        $this->idDocTipoLotacao = $idDocTipoLotacao;
        return $this;
    }

    function setNmDocTipoLotacao($nmDocTipoLotacao) {
        $this->nmDocTipoLotacao = $nmDocTipoLotacao;
        return $this;
    }

    function setStAtivo($stAtivo) {
        $this->stAtivo = $stAtivo;
        return $this;
    }


}

