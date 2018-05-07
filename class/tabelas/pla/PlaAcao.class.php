<?php

class PlaAcao {

    private $id_acao = null;
    private $id_objetivo = null;
    private $nm_acao = null;
    private $ds_indicador = null;
    private $ds_meta_plano = null;
    private $tp_cadastro = null;
    private $st_ativo = null;
    private $id_lotacao = null;

    function getIdLotacao() {
        return $this->id_lotacao;
    }

    function setIdLotacao($id_lotacao) {
        $this->id_lotacao = $id_lotacao;
        return $this;
    }
    
    function getIdAcao() {
        return $this->id_acao;
    }

    function getIdObjetivo() {
        return $this->id_objetivo;
    }

    function getNmAcao() {
        return $this->nm_acao;
    }

    function getDsIndicador() {
        return $this->ds_indicador;
    }

    function getTpCadastro() {
        return $this->tp_cadastro;
    }

    function getStAtivo() {
        return $this->st_ativo;
    }

    function setIdAcao($id_acao) {
        $this->id_acao = $id_acao;
    }

    function setIdObjetivo($id_objetivo) {
        $this->id_objetivo = $id_objetivo;
    }

    function setNmAcao($nm_acao) {
        $this->nm_acao = $nm_acao;
    }

    function setDsIndicador($ds_indicador) {
        $this->ds_indicador = $ds_indicador;
    }  

    function setTpCadastro($tp_cadastro) {
        $this->tp_cadastro = $tp_cadastro;
    }

    function setStAtivo($st_ativo) {
        $this->st_ativo = $st_ativo;
    }
    
    function getDsMetaPlano() {
        return $this->ds_meta_plano;
    }

    function setDsMetaPlano($ds_meta_plano) {
        $this->ds_meta_plano = $ds_meta_plano;
        return $this;
    }



}
