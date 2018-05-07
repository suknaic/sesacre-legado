<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdminPlaTipoGasto
 *
 * @author elivelton
 */
class AdminPlaTipoGasto {
    private $idTipoGasto = null;
    private $nmTipoGasto = null;
    
    function getIdTipoGasto() {
        return $this->idTipoGasto;
    }

    function getNmTipoGasto() {
        return $this->nmTipoGasto;
    }

    function setIdTipoGasto($idTipoGasto) {
        $this->idTipoGasto = $idTipoGasto;
    }

    function setNmTipoGasto($nmTipoGasto) {
        $this->nmTipoGasto = $nmTipoGasto;
    }
}
