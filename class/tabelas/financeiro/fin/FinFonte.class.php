<?php

class FinFonte{

    private $id_fonte = null;
    private $nr_fonte = null;
    private $st_fonte = null;


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
     * Get the value of Nr Fonte
     *
     * @return mixed
     */
    public function getNrFonte()
    {
        return $this->nr_fonte;
    }

    /**
     * Set the value of Nr Fonte
     *
     * @param mixed nr_fonte
     *
     * @return self
     */
    public function setNrFonte($nr_fonte)
    {
        $this->nr_fonte = $nr_fonte;

        return $this;
    }

    /**
     * Get the value of St Fonte
     *
     * @return mixed
     */
    public function getStFonte()
    {
        return $this->st_fonte;
    }

    /**
     * Set the value of St Fonte
     *
     * @param mixed st_fonte
     *
     * @return self
     */
    public function setStFonte($st_fonte)
    {
        $this->st_fonte = $st_fonte;

        return $this;
    }

}
