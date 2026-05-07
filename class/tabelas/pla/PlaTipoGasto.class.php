<?php

class PlaTipoGasto{

    private $id_tipo_gasto = null;
    private $nm_tipo_gasto = null;
    private $st_ativo = null;

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
     * Get the value of Nm Tipo Gasto
     *
     * @return mixed
     */
    public function getNmTipoGasto()
    {
        return $this->nm_tipo_gasto;
    }

    /**
     * Set the value of Nm Tipo Gasto
     *
     * @param mixed nm_tipo_gasto
     *
     * @return self
     */
    public function setNmTipoGasto($nm_tipo_gasto)
    {
        $this->nm_tipo_gasto = $nm_tipo_gasto;

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
