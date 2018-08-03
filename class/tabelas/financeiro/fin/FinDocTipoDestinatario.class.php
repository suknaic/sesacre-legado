<?php

class FinDocTipoDestinatario {

    private $idDocTipoDestinatario = null;
    private $nmDocTipoDestinatario = null;
    private $stAtivo = '1';
    
    function getIdDocTipoDestinatario() {
        return $this->idDocTipoDestinatario;
    }

    function getNmDocTipoDestinatario() {
        return $this->nmDocTipoDestinatario;
    }

    function getStAtivo() {
        return $this->stAtivo;
    }

    function setIdDocTipoDestinatario($idDocTipoDestinatario) {
        $this->idDocTipoDestinatario = $idDocTipoDestinatario;
        return $this;
    }

    function setNmDocTipoDestinatario($nmDocTipoDestinatario) {
        $this->nmDocTipoDestinatario = $nmDocTipoDestinatario;
        return $this;
    }

    function setStAtivo($stAtivo) {
        $this->stAtivo = $stAtivo;
        return $this;
    }



}

