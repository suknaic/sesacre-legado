<?php
/**
 * Created by PhpStorm.
 * User: elivelton
 * Date: 07/11/18
 * Time: 16:29
 */

class ForMedicamento {
    private $idMedicamento = null;
    private $nmMedicamento = null;

    /**
     * @return null
     */
    public function getIdMedicamento()
    {
        return $this->idMedicamento;
    }

    /**
     * @param null $idMedicamento
     */
    public function setIdMedicamento($idMedicamento)
    {
        $this->idMedicamento = $idMedicamento;
    }

    /**
     * @return null
     */
    public function getNmMedicamento()
    {
        return $this->nmMedicamento;
    }

    /**
     * @param null $nmMedicamento
     */
    public function setNmMedicamento($nmMedicamento)
    {
        $this->nmMedicamento = $nmMedicamento;
    }
}