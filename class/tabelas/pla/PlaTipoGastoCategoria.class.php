<?php

class PlaTipoGastoCategoria{

    private $id_tipo_gasto_categoria = null;
    private $nm_tipo_gasto_categoria = null;
    private $id_tipo_gasto = null;
    private $id_lotacao = null;
    private $st_ativo = null;

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
     * Get the value of Nm Tipo Gasto Categoria
     *
     * @return mixed
     */
    public function getNmTipoGastoCategoria()
    {
        return $this->nm_tipo_gasto_categoria;
    }

    /**
     * Set the value of Nm Tipo Gasto Categoria
     *
     * @param mixed nm_tipo_gasto_categoria
     *
     * @return self
     */
    public function setNmTipoGastoCategoria($nm_tipo_gasto_categoria)
    {
        $this->nm_tipo_gasto_categoria = $nm_tipo_gasto_categoria;

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
     * Get the value of Id Lotacao
     *
     * @return mixed
     */
    public function getIdLotacao()
    {
        return $this->id_lotacao;
    }

    /**
     * Set the value of Id Lotacao
     *
     * @param mixed id_lotacao
     *
     * @return self
     */
    public function setIdLotacao($id_lotacao)
    {
        $this->id_lotacao = $id_lotacao;

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
