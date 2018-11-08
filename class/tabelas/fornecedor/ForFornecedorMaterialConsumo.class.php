<?php
/**
 * Created by PhpStorm.
 * User: elivelton
 * Date: 07/11/18
 * Time: 11:24
 */

class ForFornecedorMaterialConsumo{
    private $idFornecedorMaterialConsumo = null;
    private $idFornecedor = null;
    private $idMaterialConsumo = null;

    /**
     * @return null
     */
    public function getIdFornecedorMaterialConsumo()
    {
        return $this->idFornecedorMaterialConsumo;
    }

    /**
     * @param null $idFornecedorMaterialConsumo
     */
    public function setIdFornecedorMaterialConsumo($idFornecedorMaterialConsumo)
    {
        $this->idFornecedorMaterialConsumo = $idFornecedorMaterialConsumo;
    }

    /**
     * @return null
     */
    public function getIdFornecedor()
    {
        return $this->idFornecedor;
    }

    /**
     * @param null $idFornecedor
     */
    public function setIdFornecedor($idFornecedor)
    {
        $this->idFornecedor = $idFornecedor;
    }

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

}