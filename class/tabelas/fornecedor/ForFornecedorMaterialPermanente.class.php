<?php
/**
 * Created by PhpStorm.
 * User: elivelton
 * Date: 07/11/18
 * Time: 11:55
 */

class ForFornecedorMaterialPermanente {

    private $idFornecedorMaterialPermanente = null;
    private $idFornecedor = null;
    private $idMaterialPermanente = null;

    /**
     * @return null
     */
    public function getIdFornecedorMaterialPermanente()
    {
        return $this->idFornecedorMaterialPermanente;
    }

    /**
     * @param null $idFornecedorMaterialPermanente
     */
    public function setIdFornecedorMaterialPermanente($idFornecedorMaterialPermanente)
    {
        $this->idFornecedorMaterialPermanente = $idFornecedorMaterialPermanente;
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

}