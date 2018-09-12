<?php

class SesTramitacao {

    private $idTramitacao = null;
    private $nmTramitacao = null;
    private $stAtivo = null;
    
    function getIdTramitacao() {
        return $this->idTramitacao;
    }

    function getNmTramitacao() {
        return $this->nmTramitacao;
    }

    function getStAtivo() {
        return $this->stAtivo;
    }

    function setIdTramitacao($idTramitacao) {
        $this->idTramitacao = $idTramitacao;
        return $this;
    }

    function setNmTramitacao($nmTramitacao) {
        $this->nmTramitacao = $nmTramitacao;
        return $this;
    }

    function setStAtivo($stAtivo) {
        $this->stAtivo = $stAtivo;
        return $this;
    }



}

