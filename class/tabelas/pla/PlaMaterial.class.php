<?php

class PlaMaterial {

    private $id_material = null;
    private $cd_material = null;
    private $nm_material = null;
    private $cd_desc_material = null;
    private $nm_desc_material = null;
    private $cd_grupo = null;
    private $nm_grupo = null;
    private $cd_sub_grupo = null;
    private $nm_sub_grupo = null;
    private $tp_material = null;
    private $cd_elemento_despesa = null;
    private $id_despesa = null;

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
     * Get the value of Cd Material
     *
     * @return mixed
     */
    public function getCdMaterial()
    {
        return $this->cd_material;
    }

    /**
     * Set the value of Cd Material
     *
     * @param mixed cd_material
     *
     * @return self
     */
    public function setCdMaterial($cd_material)
    {
        $this->cd_material = $cd_material;

        return $this;
    }

    /**
     * Get the value of Nm Material
     *
     * @return mixed
     */
    public function getNmMaterial()
    {
        return $this->nm_material;
    }

    /**
     * Set the value of Nm Material
     *
     * @param mixed nm_material
     *
     * @return self
     */
    public function setNmMaterial($nm_material)
    {
        $this->nm_material = $nm_material;

        return $this;
    }

    /**
     * Get the value of Cd Desc Material
     *
     * @return mixed
     */
    public function getCdDescMaterial()
    {
        return $this->cd_desc_material;
    }

    /**
     * Set the value of Cd Desc Material
     *
     * @param mixed cd_desc_material
     *
     * @return self
     */
    public function setCdDescMaterial($cd_desc_material)
    {
        $this->cd_desc_material = $cd_desc_material;

        return $this;
    }

    /**
     * Get the value of Nm Desc Material
     *
     * @return mixed
     */
    public function getNmDescMaterial()
    {
        return $this->nm_desc_material;
    }

    /**
     * Set the value of Nm Desc Material
     *
     * @param mixed nm_desc_material
     *
     * @return self
     */
    public function setNmDescMaterial($nm_desc_material)
    {
        $this->nm_desc_material = $nm_desc_material;

        return $this;
    }

    /**
     * Get the value of Cd Grupo
     *
     * @return mixed
     */
    public function getCdGrupo()
    {
        return $this->cd_grupo;
    }

    /**
     * Set the value of Cd Grupo
     *
     * @param mixed cd_grupo
     *
     * @return self
     */
    public function setCdGrupo($cd_grupo)
    {
        $this->cd_grupo = $cd_grupo;

        return $this;
    }

    /**
     * Get the value of Nm Grupo
     *
     * @return mixed
     */
    public function getNmGrupo()
    {
        return $this->nm_grupo;
    }

    /**
     * Set the value of Nm Grupo
     *
     * @param mixed nm_grupo
     *
     * @return self
     */
    public function setNmGrupo($nm_grupo)
    {
        $this->nm_grupo = $nm_grupo;

        return $this;
    }

    /**
     * Get the value of Cd Sub Grupo
     *
     * @return mixed
     */
    public function getCdSubGrupo()
    {
        return $this->cd_sub_grupo;
    }

    /**
     * Set the value of Cd Sub Grupo
     *
     * @param mixed cd_sub_grupo
     *
     * @return self
     */
    public function setCdSubGrupo($cd_sub_grupo)
    {
        $this->cd_sub_grupo = $cd_sub_grupo;

        return $this;
    }

    /**
     * Get the value of Nm Sub Grupo
     *
     * @return mixed
     */
    public function getNmSubGrupo()
    {
        return $this->nm_sub_grupo;
    }

    /**
     * Set the value of Nm Sub Grupo
     *
     * @param mixed nm_sub_grupo
     *
     * @return self
     */
    public function setNmSubGrupo($nm_sub_grupo)
    {
        $this->nm_sub_grupo = $nm_sub_grupo;

        return $this;
    }

    /**
     * Get the value of Tp Material
     *
     * @return mixed
     */
    public function getTpMaterial()
    {
        return $this->tp_material;
    }

    /**
     * Set the value of Tp Material
     *
     * @param mixed tp_material
     *
     * @return self
     */
    public function setTpMaterial($tp_material)
    {
        $this->tp_material = $tp_material;

        return $this;
    }

    /**
     * Get the value of Cd Elemento Despesa
     *
     * @return mixed
     */
    public function getCdElementoDespesa()
    {
        return $this->cd_elemento_despesa;
    }

    /**
     * Set the value of Cd Elemento Despesa
     *
     * @param mixed cd_elemento_despesa
     *
     * @return self
     */
    public function setCdElementoDespesa($cd_elemento_despesa)
    {
        $this->cd_elemento_despesa = $cd_elemento_despesa;

        return $this;
    }

    /**
     * Get the value of Id Despesa
     *
     * @return mixed
     */
    public function getIdDespesa()
    {
        return $this->id_despesa;
    }

    /**
     * Set the value of Id Despesa
     *
     * @param mixed id_despesa
     *
     * @return self
     */
    public function setIdDespesa($id_despesa)
    {
        $this->id_despesa = $id_despesa;

        return $this;
    }

}
