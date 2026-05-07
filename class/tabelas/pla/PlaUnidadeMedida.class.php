<?php

class PlaUnidadeMedida{

    private $id_unidade_medida = null;
    private $nm_unidade_medida = null;
    private $st_ativo = null;

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
     * Get the value of Nm Unidade Medida
     *
     * @return mixed
     */
    public function getNmUnidadeMedida()
    {
        return $this->nm_unidade_medida;
    }

    /**
     * Set the value of Nm Unidade Medida
     *
     * @param mixed nm_unidade_medida
     *
     * @return self
     */
    public function setNmUnidadeMedida($nm_unidade_medida)
    {
        $this->nm_unidade_medida = $nm_unidade_medida;

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
