<?php

class ObjetoExtd {
    
    private $idObjeto = null;
    private $objeto = null;
   
    function getIdObjeto() {
        return $this->idObjeto;
    }

    function getObjeto() {
        return $this->objeto;
    }

    function setIdObjeto($idObjeto) {
        $this->idObjeto = $idObjeto;
    }

    function setObjeto($objeto) {
        $this->objeto = $objeto;
    }

}