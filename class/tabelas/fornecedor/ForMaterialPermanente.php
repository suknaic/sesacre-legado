<?php
/**
 * Created by PhpStorm.
 * User: elivelton
 * Date: 07/11/18
 * Time: 17:22
 */

class ForMaterialPermanente {
    private $idMaterialPermanente = null;
    private $nmMaterialPermanente = null;

    /**
     * @return null
     */
    public function getIdMaterialPermanente()
    {
        return $this->idMaterialPermanente;
    }

    /**
     * @param null $idMaterialPermanente
     */
    public function setIdMaterialPermanente($idMaterialPermanente)
    {
        $this->idMaterialPermanente = $idMaterialPermanente;
    }

    /**
     * @return null
     */
    public function getNmMaterialPermanente()
    {
        return $this->nmMaterialPermanente;
    }

    /**
     * @param null $nmMaterialPermanente
     */
    public function setNmMaterialPermanente($nmMaterialPermanente)
    {
        $this->nmMaterialPermanente = $nmMaterialPermanente;
    }

}