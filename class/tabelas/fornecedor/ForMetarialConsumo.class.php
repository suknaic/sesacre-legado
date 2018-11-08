<?php
/**
 * Created by PhpStorm.
 * User: elivelton
 * Date: 07/11/18
 * Time: 17:08
 */

class ForMetarialConsumo {
    private $idMaterialConsumo = null;
    private $nmMaterialConsumo = null;

    /**
     * @return null
     */
    public function getIdMaterialConsumo()
    {
        return $this->idMaterialConsumo;
    }

    /**
     * @param null $idMaterialConsumo
     */
    public function setIdMaterialConsumo($idMaterialConsumo)
    {
        $this->idMaterialConsumo = $idMaterialConsumo;
    }

    /**
     * @return null
     */
    public function getNmMaterialConsumo()
    {
        return $this->nmMaterialConsumo;
    }

    /**
     * @param null $nmMaterialConsumo
     */
    public function setNmMaterialConsumo($nmMaterialConsumo)
    {
        $this->nmMaterialConsumo = $nmMaterialConsumo;
    }
}