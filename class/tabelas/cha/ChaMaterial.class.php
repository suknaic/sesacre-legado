<?php

class ChaMaterial {
    
    private $id_material = null;
    private $nm_material = null;
    private $dt_aquisicao = null;
    private $ds_marca = null;
    private $ds_modelo = null;
    private $nr_patrimonio = null;
    private $vl_preco = null;
    private $qt_meses_garantia = null;
    private $nm_serie = null;
    private $tp_estado = null;
    private $id_unidade_medida = null;
    private $qt_memoria_ram = null;
    private $ds_processador = null;
    private $qt_hd = null;
    private $qt_fonte = null;
    private $fl_wireless = null;
    
    /**
     * ChaMaterial: Formulário que o técnico preenche quando vai cadastrar um computador
     * nm_material: nome do equipamento, peça ou suprimento
     * dt_aquisicao: Data em que o item foi comprado
     * ds_marca: A marca do material
     * ds_modelo: O Modelo do material
     * nr_patrimonio: O numero do patrimonio do material, caso ele seja comprado
     * vl_preco: Valor do material
     * qt_meses_garantia: Meses de Garantia de um material
     * nm_serie: Número de Série do material
     * tp_estado: Se o material é novo ou velho/usado
     * id_unidade_medida: Se o material é por caixa, metros, TB, GB ou Unidade...
     * qt_memoria_ram: Quantidade de memória ram do computador
     * ds_processador: Descrição do processador
     * qt_hd: Quanto de memório o HD possui
     * qt_fonte: Quantos wats a fonte possui
     * fl_wireless: Se o computador tem palca wifi ou nao 
     */
    
    function getId_material() {
        return $this->id_material;
    }

    function getNm_material() {
        return $this->nm_material;
    }

    function getDt_aquisicao() {
        return $this->dt_aquisicao;
    }

    function getDs_marca() {
        return $this->ds_marca;
    }

    function getDs_modelo() {
        return $this->ds_modelo;
    }

    function getNr_patrimonio() {
        return $this->nr_patrimonio;
    }

    function getVl_preco() {
        return $this->vl_preco;
    }

    function getQt_meses_garantia() {
        return $this->qt_meses_garantia;
    }

    function getTp_estado() {
        return $this->tp_estado;
    }

    function getId_unidade_medida() {
        return $this->id_unidade_medida;
    }

    function getQt_memoria_ram() {
        return $this->qt_memoria_ram;
    }

    function getDs_processador() {
        return $this->ds_processador;
    }

    function getQt_hd() {
        return $this->qt_hd;
    }

    function getQt_fonte() {
        return $this->qt_fonte;
    }

    function getFl_wireless() {
        return $this->fl_wireless;
    }

    function setId_material($id_material) {
        $this->id_material = $id_material;
    }

    function setNm_material($nm_material) {
        $this->nm_material = $nm_material;
    }

    function setDt_aquisicao($dt_aquisicao) {
        $this->dt_aquisicao = $dt_aquisicao;
    }

    function setDs_marca($ds_marca) {
        $this->ds_marca = $ds_marca;
    }

    function setDs_modelo($ds_modelo) {
        $this->ds_modelo = $ds_modelo;
    }

    function setNr_patrimonio($nr_patrimonio) {
        $this->nr_patrimonio = $nr_patrimonio;
    }

    function setVl_preco($vl_preco) {
        $this->vl_preco = $vl_preco;
    }

    function setQt_meses_garantia($qt_meses_garantia) {
        $this->qt_meses_garantia = $qt_meses_garantia;
    }

    function setNm_serie($nm_serie) {
        $this->nm_serie = $nm_serie;
    }

    function setTp_estado($tp_estado) {
        $this->tp_estado = $tp_estado;
    }

    function setId_unidade_medida($id_unidade_medida) {
        $this->id_unidade_medida = $id_unidade_medida;
    }

    function setQt_memoria_ram($qt_memoria_ram) {
        $this->qt_memoria_ram = $qt_memoria_ram;
    }

    function setDs_processador($ds_processador) {
        $this->ds_processador = $ds_processador;
    }

    function setQt_hd($qt_hd) {
        $this->qt_hd = $qt_hd;
    }

    function setQt_fonte($qt_fonte) {
        $this->qt_fonte = $qt_fonte;
    }

    function setFl_wireless($fl_wireless) {
        $this->fl_wireless = $fl_wireless;
    }
    
    function getNm_serie() {
        return $this->nm_serie;
    }
}

