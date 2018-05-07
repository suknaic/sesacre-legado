<?php

class ChaFormTelefonia {
    
    private $id_form_telefonia = null;
    private $id_chamado = null;
    private $nr_ramal = null;
    private $ds_tipo = null;
    private $ds_destino = null;
    private $nr_patrimonio = null;
    private $ds_marca = null;
    private $ds_modelo = null;
    private $ds_localizacao = null;
    
    /**
     *nr_ramal: O número do ramal que está com problema
     * ds_tipo: Se o telefone é com fio, sem fio, de mesa, fax, etc...
     * ds_destino: Para onde o ramal vai quando solicitam troca de ramal
     * nr_patrimonio: Número do patrimônio do telefone
     * ds_marca: Marca do telefone
     * ds_modelo: Modelo do telefone
     * ds_localizacao: Onde o telefone está localizado. 
     */
    
    function getId_form_telefonia() {
        return $this->id_form_telefonia;
    }

    function getId_chamado() {
        return $this->id_chamado;
    }

    function getNr_ramal() {
        return $this->nr_ramal;
    }

    function getDs_tipo() {
        return $this->ds_tipo;
    }

    function getDs_destino() {
        return $this->ds_destino;
    }

    function getNr_patrimonio() {
        return $this->nr_patrimonio;
    }

    function getDs_marca() {
        return $this->ds_marca;
    }

    function getDs_modelo() {
        return $this->ds_modelo;
    }

    function getDs_localizacao() {
        return $this->ds_localizacao;
    }

    function setId_form_telefonia($id_form_telefonia) {
        $this->id_form_telefonia = $id_form_telefonia;
    }

    function setId_chamado($id_chamado) {
        $this->id_chamado = $id_chamado;
    }

    function setNr_ramal($nr_ramal) {
        $this->nr_ramal = $nr_ramal;
    }

    function setDs_tipo($ds_tipo) {
        $this->ds_tipo = $ds_tipo;
    }

    function setDs_destino($ds_destino) {
        $this->ds_destino = $ds_destino;
    }

    function setNr_patrimonio($nr_patrimonio) {
        $this->nr_patrimonio = $nr_patrimonio;
    }

    function setDs_marca($ds_marca) {
        $this->ds_marca = $ds_marca;
    }

    function setDs_modelo($ds_modelo) {
        $this->ds_modelo = $ds_modelo;
    }

    function setDs_localizacao($ds_localizacao) {
        $this->ds_localizacao = $ds_localizacao;
    }


}