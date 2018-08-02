<?php

class FinDocDestinatario {

    private $idDocDestinatario = null;
    private $idDocTipoDestinatario = null;
    private $idLotacao = null;

    function getIdDocDestinatario() {
        return $this->idDocDestinatario;
    }

    function getIdDocTipoDestinatario() {
        return $this->idDocTipoDestinatario;
    }

    function getIdLotacao() {
        return $this->idLotacao;
    }

    function setIdDocDestinatario($idDocDestinatario) {
        $this->idDocDestinatario = $idDocDestinatario;
        return $this;
    }

    function setIdDocTipoDestinatario($idDocTipoDestinatario) {
        $this->idDocTipoDestinatario = $idDocTipoDestinatario;
        return $this;
    }

    function setIdLotacao($idLotacao) {
        $this->idLotacao = $idLotacao;
        return $this;
    }


}

