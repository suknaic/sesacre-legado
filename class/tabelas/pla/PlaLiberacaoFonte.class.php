<?php

class PlaLiberacaoFonte {

    private $id_liberacao_fonte = null;
    private $id_fonte = null;
    private $aa_liberacao_fonte = null;
    private $vl_liberacao_fonte = null;

                          
    /**
     * Get the value of Id Liberacao Fonte
     *
     * @return mixed
     */
    public function getIdLiberacaoFonte()
    {
        return $this->id_liberacao_fonte;
    }

    /**
     * Set the value of Id Liberacao Fonte
     *
     * @param mixed id_liberacao_fonte
     *
     * @return self
     */
    public function setIdLiberacaoFonte($id_liberacao_fonte)
    {
        $this->id_liberacao_fonte = $id_liberacao_fonte;

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
     * Get the value of Aa Liberacao Fonte
     *
     * @return mixed
     */
    public function getAaLiberacaoFonte()
    {
        return $this->aa_liberacao_fonte;
    }

    /**
     * Set the value of Aa Liberacao Fonte
     *
     * @param mixed aa_liberacao_fonte
     *
     * @return self
     */
    public function setAaLiberacaoFonte($aa_liberacao_fonte)
    {
        $this->aa_liberacao_fonte = $aa_liberacao_fonte;

        return $this;
    }

    /**
     * Get the value of Vl Liberacao Fonte
     *
     * @return mixed
     */
    public function getVlLiberacaoFonte()
    {
        return $this->vl_liberacao_fonte;
    }

    /**
     * Set the value of Vl Liberacao Fonte
     *
     * @param mixed vl_liberacao_fonte
     *
     * @return self
     */
    public function setVlLiberacaoFonte($vl_liberacao_fonte)
    {
        $this->vl_liberacao_fonte = $vl_liberacao_fonte;

        return $this;
    }

}
