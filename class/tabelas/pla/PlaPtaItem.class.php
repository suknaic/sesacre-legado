<?php

class PlaPtaItem{

    private $id_pta_item = null;
    private $id_pta_titulo = null;
    private $id_material = null;
    private $ds_pta_item = null;
    private $id_pta_acao_det = null;
    private $id_tipo_gasto = null;
    private $id_tipo_gasto_categoria = null;
    private $id_unidade_medida = null;
    private $id_fonte = null;
    private $tp_fonte = null;
    private $id_portaria = null;
    private $id_convenio = null;
    private $qt_pta_item = null;
    private $vl_pta_item = null;
    private $st_pta_item = null;


    /**
     * Get the value of Id Pta Item
     *
     * @return mixed
     */
    public function getIdPtaItem()
    {
        return $this->id_pta_item;
    }

    /**
     * Set the value of Id Pta Item
     *
     * @param mixed id_pta_item
     *
     * @return self
     */
    public function setIdPtaItem($id_pta_item)
    {
        $this->id_pta_item = $id_pta_item;

        return $this;
    }

    /**
     * Get the value of Id Pta Titulo
     *
     * @return mixed
     */
    public function getIdPtaTitulo()
    {
        return $this->id_pta_titulo;
    }

    /**
     * Set the value of Id Pta Titulo
     *
     * @param mixed id_pta_titulo
     *
     * @return self
     */
    public function setIdPtaTitulo($id_pta_titulo)
    {
        $this->id_pta_titulo = $id_pta_titulo;

        return $this;
    }

    /**
     * Get the value of Id Material
     *
     * @return mixed
     */
    public function getIdMaterial()
    {
        return $this->id_material;
    }

    /**
     * Set the value of Id Material
     *
     * @param mixed id_material
     *
     * @return self
     */
    public function setIdMaterial($id_material)
    {
        $this->id_material = $id_material;

        return $this;
    }

    /**
     * Get the value of Ds Pta Item
     *
     * @return mixed
     */
    public function getDsPtaItem()
    {
        return $this->ds_pta_item;
    }

    /**
     * Set the value of Ds Pta Item
     *
     * @param mixed ds_pta_item
     *
     * @return self
     */
    public function setDsPtaItem($ds_pta_item)
    {
        $this->ds_pta_item = $ds_pta_item;

        return $this;
    }

    /**
     * Get the value of Id Pta Acao Det
     *
     * @return mixed
     */
    public function getIdPtaAcaoDet()
    {
        return $this->id_pta_acao_det;
    }

    /**
     * Set the value of Id Pta Acao Det
     *
     * @param mixed id_pta_acao_det
     *
     * @return self
     */
    public function setIdPtaAcaoDet($id_pta_acao_det)
    {
        $this->id_pta_acao_det = $id_pta_acao_det;

        return $this;
    }

    /**
     * Get the value of Id Tipo Gasto
     *
     * @return mixed
     */
    public function getIdTipoGasto()
    {
        return $this->id_tipo_gasto;
    }

    /**
     * Set the value of Id Tipo Gasto
     *
     * @param mixed id_tipo_gasto
     *
     * @return self
     */
    public function setIdTipoGasto($id_tipo_gasto)
    {
        $this->id_tipo_gasto = $id_tipo_gasto;

        return $this;
    }

    /**
     * Get the value of Id Tipo Gasto Categoria
     *
     * @return mixed
     */
    public function getIdTipoGastoCategoria()
    {
        return $this->id_tipo_gasto_categoria;
    }

    /**
     * Set the value of Id Tipo Gasto Categoria
     *
     * @param mixed id_tipo_gasto_categoria
     *
     * @return self
     */
    public function setIdTipoGastoCategoria($id_tipo_gasto_categoria)
    {
        $this->id_tipo_gasto_categoria = $id_tipo_gasto_categoria;

        return $this;
    }

    /**
     * Get the value of Id Unidade Medida
     *
     * @return mixed
     */
    public function getIdUnidadeMedida()
    {
        return $this->id_unidade_medida;
    }

    /**
     * Set the value of Id Unidade Medida
     *
     * @param mixed id_unidade_medida
     *
     * @return self
     */
    public function setIdUnidadeMedida($id_unidade_medida)
    {
        $this->id_unidade_medida = $id_unidade_medida;

        return $this;
    }

    /**
     * Get the value of Id Fonte
     *
     * @return mixed
     */
    public function getIdFonte()
    {
        return $this->id_fonte;
    }

    /**
     * Set the value of Id Fonte
     *
     * @param mixed id_fonte
     *
     * @return self
     */
    public function setIdFonte($id_fonte)
    {
        $this->id_fonte = $id_fonte;

        return $this;
    }

    /**
     * Get the value of Tp Fonte
     *
     * @return mixed
     */
    public function getTpFonte()
    {
        return $this->tp_fonte;
    }

    /**
     * Set the value of Tp Fonte
     *
     * @param mixed tp_fonte
     *
     * @return self
     */
    public function setTpFonte($tp_fonte)
    {
        $this->tp_fonte = $tp_fonte;

        return $this;
    }

    /**
     * Get the value of Id Portaria
     *
     * @return mixed
     */
    public function getIdPortaria()
    {
        return $this->id_portaria;
    }

    /**
     * Set the value of Id Portaria
     *
     * @param mixed id_portaria
     *
     * @return self
     */
    public function setIdPortaria($id_portaria)
    {
        $this->id_portaria = $id_portaria;

        return $this;
    }

    /**
     * Get the value of Id Convenio
     *
     * @return mixed
     */
    public function getIdConvenio()
    {
        return $this->id_convenio;
    }

    /**
     * Set the value of Id Convenio
     *
     * @param mixed id_convenio
     *
     * @return self
     */
    public function setIdConvenio($id_convenio)
    {
        $this->id_convenio = $id_convenio;

        return $this;
    }

    /**
     * Get the value of Qt Pta Item
     *
     * @return mixed
     */
    public function getQtPtaItem()
    {
        return $this->qt_pta_item;
    }

    /**
     * Set the value of Qt Pta Item
     *
     * @param mixed qt_pta_item
     *
     * @return self
     */
    public function setQtPtaItem($qt_pta_item)
    {
        $this->qt_pta_item = $qt_pta_item;

        return $this;
    }

    /**
     * Get the value of Vl Pta Item
     *
     * @return mixed
     */
    public function getVlPtaItem()
    {
        return $this->vl_pta_item;
    }

    /**
     * Set the value of Vl Pta Item
     *
     * @param mixed vl_pta_item
     *
     * @return self
     */
    public function setVlPtaItem($vl_pta_item)
    {
        $this->vl_pta_item = $vl_pta_item;

        return $this;
    }

    /**
     * Get the value of St Pta Item
     *
     * @return mixed
     */
    public function getStPtaItem()
    {
        return $this->st_pta_item;
    }

    /**
     * Set the value of St Pta Item
     *
     * @param mixed st_pta_item
     *
     * @return self
     */
    public function setStPtaItem($st_pta_item)
    {
        $this->st_pta_item = $st_pta_item;

        return $this;
    }

}
