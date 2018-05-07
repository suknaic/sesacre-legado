<?php

class ChaFormMaterial {
    
    private $id_form_material = null;
    private $id_condicao = null;
    private $nm_form_material = null;
    private $ds_marca = null;
    private $ds_modelo = null;
    private $nr_patrimonio = null;
    private $ds_localizacao = null;
    private $nm_serie = null;
    private $tp_estado = null;
    private $id_unidade_medida = null;
    private $ds_destino = null;
    
    /**
     * ChaFormMaterial: Formulário que o usuário preenche quando está abrindo o chamado.
     * id_condicao: Se o material é comprado ou alugado
     * nm_material: o Nome do material
     * ds_marca: Marca do Material
     * ds_modelo: Modelo do material
     * nr_patrimonio: Número de patrimonio do material
     * ds_localizacao: Onde o equipamento está localizado - Em cima do armário verde na segunda ilha...
     * nm_serie: Nome de série do material
     * tp_estado: Se o equipamento é novo ou velho
     * id_unidade_medida: se o material é dado por caixa, metros, TB, GB, unidade, ect
     * ds_destino: Para onde o equipamento vai ser remanejado
     */
    
    function getId_form_material() {
        return $this->id_form_material;
    }

    function getId_condicao() {
        return $this->id_condicao;
    }

    function getNm_form_material() {
        return $this->nm_form_material;
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

    function getDs_localizacao() {
        return $this->ds_localizacao;
    }

    function getNm_serie() {
        return $this->nm_serie;
    }

    function getTp_estado() {
        return $this->tp_estado;
    }

    function getId_unidade_medida() {
        return $this->id_unidade_medida;
    }

    function getDs_destino() {
        return $this->ds_destino;
    }

    function setId_form_material($id_form_material) {
        $this->id_form_material = $id_form_material;
    }

    function setId_condicao($id_condicao) {
        $this->id_condicao = $id_condicao;
    }

    function setNm_form_material($nm_form_material) {
        $this->nm_form_material = $nm_form_material;
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

    function setDs_localizacao($ds_localizacao) {
        $this->ds_localizacao = $ds_localizacao;
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

    function setDs_destino($ds_destino) {
        $this->ds_destino = $ds_destino;
    }

}
