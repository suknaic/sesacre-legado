<?php

class PlaPtaItemRecebido {

    private $id_pta_item_recebido = null;
    private $id_ordem_destino = null;
    private $id_pta_acao_det = null;
    private $dh_recebido = null;
    private $ds_pta_item_recebido = null;
    private $qt_pta_item_recebido = null;
    private $id_tipo_gasto = null;
    private $id_tipo_gasto_categoria = null;
    private $dh_pta_item_recebido = null;
    private $st_ativo = null;

    /**
     * Get the value of Id Pta Item Recebido
     *
     * @return mixed
     */
    public function getIdPtaItemRecebido()
    {
        return $this->id_pta_item_recebido;
    }

    /**
     * Set the value of Id Pta Item Recebido
     *
     * @param mixed id_pta_item_recebido
     *
     * @return self
     */
    public function setIdPtaItemRecebido($id_pta_item_recebido)
    {
        $this->id_pta_item_recebido = $id_pta_item_recebido;

        return $this;
    }

    /**
     * Get the value of Id Ordem Destino
     *
     * @return mixed
     */
    public function getIdOrdemDestino()
    {
        return $this->id_ordem_destino;
    }

    /**
     * Set the value of Id Ordem Destino
     *
     * @param mixed id_ordem_destino
     *
     * @return self
     */
    public function setIdOrdemDestino($id_ordem_destino)
    {
        $this->id_ordem_destino = $id_ordem_destino;

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
     * Get the value of Dh Recebido
     *
     * @return mixed
     */
    public function getDhRecebido()
    {
        return $this->dh_recebido;
    }

    /**
     * Set the value of Dh Recebido
     *
     * @param mixed dh_recebido
     *
     * @return self
     */
    public function setDhRecebido($dh_recebido)
    {
        $this->dh_recebido = $dh_recebido;

        return $this;
    }

    /**
     * Get the value of Ds Pta Item Recebido
     *
     * @return mixed
     */
    public function getDsPtaItemRecebido()
    {
        return $this->ds_pta_item_recebido;
    }

    /**
     * Set the value of Ds Pta Item Recebido
     *
     * @param mixed ds_pta_item_recebido
     *
     * @return self
     */
    public function setDsPtaItemRecebido($ds_pta_item_recebido)
    {
        $this->ds_pta_item_recebido = $ds_pta_item_recebido;

        return $this;
    }

    /**
     * Get the value of Qt Pta Item Recebido
     *
     * @return mixed
     */
    public function getQtPtaItemRecebido()
    {
        return $this->qt_pta_item_recebido;
    }

    /**
     * Set the value of Qt Pta Item Recebido
     *
     * @param mixed qt_pta_item_recebido
     *
     * @return self
     */
    public function setQtPtaItemRecebido($qt_pta_item_recebido)
    {
        $this->qt_pta_item_recebido = $qt_pta_item_recebido;

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
     * Get the value of Dh Pta Item Recebido
     *
     * @return mixed
     */
    public function getDhPtaItemRecebido()
    {
        return $this->dh_pta_item_recebido;
    }

    /**
     * Set the value of Dh Pta Item Recebido
     *
     * @param mixed dh_pta_item_recebido
     *
     * @return self
     */
    public function setDhPtaItemRecebido($dh_pta_item_recebido)
    {
        $this->dh_pta_item_recebido = $dh_pta_item_recebido;

        return $this;
    }

    /**
     * Get the value of St Ativo
     *
     * @return mixed
     */
    public function getStAtivo()
    {
        return $this->st_ativo;
    }

    /**
     * Set the value of St Ativo
     *
     * @param mixed st_ativo
     *
     * @return self
     */
    public function setStAtivo($st_ativo)
    {
        $this->st_ativo = $st_ativo;

        return $this;
    }

}
