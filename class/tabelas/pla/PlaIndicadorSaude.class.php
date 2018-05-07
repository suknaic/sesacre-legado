<?php

class PlaIndicadorSaude{

    private $id_indicador_saude = null;
    private $nm_indicador_saude = null;
    private $aa_indicador_saude = null;
    private $cd_nota = null;
    private $tp_indicador_saude = null;
    private $ds_meta = null;
    private $ds_unidade = null;

    /**
     * Get the value of Id Indicador Saude
     *
     * @return mixed
     */
    public function getIdIndicadorSaude()
    {
        return $this->id_indicador_saude;
    }

    /**
     * Set the value of Id Indicador Saude
     *
     * @param mixed id_indicador_saude
     *
     * @return self
     */
    public function setIdIndicadorSaude($id_indicador_saude)
    {
        $this->id_indicador_saude = $id_indicador_saude;

        return $this;
    }

    /**
     * Get the value of Nm Indicador Saude
     *
     * @return mixed
     */
    public function getNmIndicadorSaude()
    {
        return $this->nm_indicador_saude;
    }

    /**
     * Set the value of Nm Indicador Saude
     *
     * @param mixed nm_indicador_saude
     *
     * @return self
     */
    public function setNmIndicadorSaude($nm_indicador_saude)
    {
        $this->nm_indicador_saude = $nm_indicador_saude;

        return $this;
    }

    /**
     * Get the value of Aa Indicador Saude
     *
     * @return mixed
     */
    public function getAaIndicadorSaude()
    {
        return $this->aa_indicador_saude;
    }

    /**
     * Set the value of Aa Indicador Saude
     *
     * @param mixed aa_indicador_saude
     *
     * @return self
     */
    public function setAaIndicadorSaude($aa_indicador_saude)
    {
        $this->aa_indicador_saude = $aa_indicador_saude;

        return $this;
    }

    /**
     * Get the value of Cd Nota
     *
     * @return mixed
     */
    public function getCdNota()
    {
        return $this->cd_nota;
    }

    /**
     * Set the value of Cd Nota
     *
     * @param mixed cd_nota
     *
     * @return self
     */
    public function setCdNota($cd_nota)
    {
        $this->cd_nota = $cd_nota;

        return $this;
    }

    /**
     * Get the value of Tp Indicador Saude
     *
     * @return mixed
     */
    public function getTpIndicadorSaude()
    {
        return $this->tp_indicador_saude;
    }

    /**
     * Set the value of Tp Indicador Saude
     *
     * @param mixed tp_indicador_saude
     *
     * @return self
     */
    public function setTpIndicadorSaude($tp_indicador_saude)
    {
        $this->tp_indicador_saude = $tp_indicador_saude;

        return $this;
    }

    /**
     * Get the value of Ds Meta
     *
     * @return mixed
     */
    public function getDsMeta()
    {
        return $this->ds_meta;
    }

    /**
     * Set the value of Ds Meta
     *
     * @param mixed ds_meta
     *
     * @return self
     */
    public function setDsMeta($ds_meta)
    {
        $this->ds_meta = $ds_meta;

        return $this;
    }

    /**
     * Get the value of Ds Unidade
     *
     * @return mixed
     */
    public function getDsUnidade()
    {
        return $this->ds_unidade;
    }

    /**
     * Set the value of Ds Unidade
     *
     * @param mixed ds_unidade
     *
     * @return self
     */
    public function setDsUnidade($ds_unidade)
    {
        $this->ds_unidade = $ds_unidade;

        return $this;
    }

}
