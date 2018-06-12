<?php

/**
 * Description of GconAnexoExt
 *
 * @author elivelton
 */
class GconAnexoExt {
    
    private $idProcesso = null;
    private $idAnexo = null;
    private $nomeAnexo = null;
    private $binAnexo = null;
    private $tipoAnexo = null;
    
    function getIdProcesso() {
        return $this->idProcesso;
    }

    function getIdAnexo() {
        return $this->idAnexo;
    }

    function getNomeAnexo() {
        return $this->nomeAnexo;
    }

    function getBinAnexo() {
        return $this->binAnexo;
    }

    function getTipoAnexo() {
        return $this->tipoAnexo;
    }

    function setIdProcesso($idProcesso) {
        $this->idProcesso = $idProcesso;
    }

    function setIdAnexo($idAnexo) {
        $this->idAnexo = $idAnexo;
    }

    function setNomeAnexo($nomeAnexo) {
        $this->nomeAnexo = $nomeAnexo;
    }

    function setBinAnexo($binAnexo) {
        $this->binAnexo = $binAnexo;
    }

    function setTipoAnexo($tipoAnexo) {
        $this->tipoAnexo = $tipoAnexo;
    }

}
