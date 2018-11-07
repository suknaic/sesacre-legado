<?php
/**
 * Created by PhpStorm.
 * User: elivelton
 * Date: 07/11/18
 * Time: 16:57
 */

class ForServico {
    private $idServio = null;
    private $nmServico = null;

    /**
     * @return null
     */
    public function getIdServio()
    {
        return $this->idServio;
    }

    /**
     * @param null $idServio
     */
    public function setIdServio($idServio)
    {
        $this->idServio = $idServio;
    }

    /**
     * @return null
     */
    public function getNmServico()
    {
        return $this->nmServico;
    }

    /**
     * @param null $nmServico
     */
    public function setNmServico($nmServico)
    {
        $this->nmServico = $nmServico;
    }
}