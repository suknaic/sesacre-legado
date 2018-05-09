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
    private $endereco = null;
    
    function getIdProcesso() {
        return $this->idProcesso;
    }

    function getNomeAnexo() {
        return $this->nomeAnexo;
    }

    function getEndereco() {
        return $this->endereco;
    }
    function getIdAnexo() {
        return $this->idAnexo;
    }

    function setIdAnexo($idAnexo) {
        $this->idAnexo = $idAnexo;
    }

    function setIdProcesso($idProcesso) {
        $this->idProcesso = $idProcesso;
    }

    function setNomeAnexo($nomeAnexo) {
        $this->nomeAnexo = $nomeAnexo;
    }

    function setEndereco($endereco) {
        $this->endereco = $endereco;
    }


}
