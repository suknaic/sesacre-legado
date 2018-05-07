<?php

class ChaAnexo {

    private $id_anexo = null;
    private $id_chamado = null;
    private $lk_anexo = null;
    private $ds_anexo = null;

    function getId_anexo() {
        return $this->id_anexo;
    }

    function getId_chamado() {
        return $this->id_chamado;
    }

    function getLk_anexo() {
        return $this->lk_anexo;
    }

    function getDs_anexo() {
        return $this->ds_anexo;
    }

    function setId_anexo($id_anexo) {
        $this->id_anexo = $id_anexo;
    }

    function setId_chamado($id_chamado) {
        $this->id_chamado = $id_chamado;
    }

    function setLk_anexo($lk_anexo) {
        $this->lk_anexo = $lk_anexo;
    }

    function setDs_anexo($ds_anexo) {
        $this->ds_anexo = $ds_anexo;
    }

}
