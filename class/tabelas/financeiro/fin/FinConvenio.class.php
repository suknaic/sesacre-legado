<?php

class FinConvenio{

    private $id_convenio = null;
    private $id_fonte = null;
    private $nm_convenio = null;
    private $vl_total = null;
            
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
     * Get the value of Nm Convenio
     *
     * @return mixed
     */
    public function getNmConvenio()
    {
        return $this->nm_convenio;
    }

    /**
     * Set the value of Nm Convenio
     *
     * @param mixed nm_convenio
     *
     * @return self
     */
    public function setNmConvenio($nm_convenio)
    {
        $this->nm_convenio = $nm_convenio;

        return $this;
    }

    /**
     * Get the value of Vl Total
     *
     * @return mixed
     */
    public function getVlTotal()
    {
        return $this->vl_total;
    }

    /**
     * Set the value of Vl Total
     *
     * @param mixed vl_total
     *
     * @return self
     */
    public function setVlTotal($vl_total)
    {
        $this->vl_total = $vl_total;

        return $this;
    }

}
