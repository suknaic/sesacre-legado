<?php

class FinQddSupRedTrans{

    private $id_qdd_sup_red_trans = null;
    private $id_qdd_sup_red = null;
    private $id_qdd_valor = null;
    private $vl_qdd_sup_red_trans = null;
    private $tp_qdd_sup_red_trans = null;
        
    /**
     * Get the value of Id Qdd Sup Red Trans
     *
     * @return mixed
     */
    public function getIdQddSupRedTrans()
    {
        return $this->id_qdd_sup_red_trans;
    }

    /**
     * Set the value of Id Qdd Sup Red Trans
     *
     * @param mixed id_qdd_sup_red_trans
     *
     * @return self
     */
    public function setIdQddSupRedTrans($id_qdd_sup_red_trans)
    {
        $this->id_qdd_sup_red_trans = $id_qdd_sup_red_trans;

        return $this;
    }

    /**
     * Get the value of Id Qdd Sup Red
     *
     * @return mixed
     */
    public function getIdQddSupRed()
    {
        return $this->id_qdd_sup_red;
    }

    /**
     * Set the value of Id Qdd Sup Red
     *
     * @param mixed id_qdd_sup_red
     *
     * @return self
     */
    public function setIdQddSupRed($id_qdd_sup_red)
    {
        $this->id_qdd_sup_red = $id_qdd_sup_red;

        return $this;
    }

    /**
     * Get the value of Id Qdd Valor
     *
     * @return mixed
     */
    public function getIdQddValor()
    {
        return $this->id_qdd_valor;
    }

    /**
     * Set the value of Id Qdd Valor
     *
     * @param mixed id_qdd_valor
     *
     * @return self
     */
    public function setIdQddValor($id_qdd_valor)
    {
        $this->id_qdd_valor = $id_qdd_valor;

        return $this;
    }

    /**
     * Get the value of Vl Qdd Sup Red Trans
     *
     * @return mixed
     */
    public function getVlQddSupRedTrans()
    {
        return $this->vl_qdd_sup_red_trans;
    }

    /**
     * Set the value of Vl Qdd Sup Red Trans
     *
     * @param mixed vl_qdd_sup_red_trans
     *
     * @return self
     */
    public function setVlQddSupRedTrans($vl_qdd_sup_red_trans)
    {
        $this->vl_qdd_sup_red_trans = $vl_qdd_sup_red_trans;

        return $this;
    }

    /**
     * Get the value of Tp Qdd Sup Red Trans
     *
     * @return mixed
     */
    public function getTpQddSupRedTrans()
    {
        return $this->tp_qdd_sup_red_trans;
    }

    /**
     * Set the value of Tp Qdd Sup Red Trans
     *
     * @param mixed tp_qdd_sup_red_trans
     *
     * @return self
     */
    public function setTpQddSupRedTrans($tp_qdd_sup_red_trans)
    {
        $this->tp_qdd_sup_red_trans = $tp_qdd_sup_red_trans;

        return $this;
    }

}
