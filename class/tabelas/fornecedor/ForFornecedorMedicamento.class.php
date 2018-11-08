<?php
/**
 * Created by PhpStorm.
 * User: elivelton
 * Date: 07/11/18
 * Time: 09:20
 */

class ForFornecedorMedicamento{
    private $idFornecedorMedicamento = null;
    private $idFornecedor = null;
    private $idMedicamento = null;

    /**
     * @return null
     */
    public function getIdFornecedorMedicamento()
    {
        return $this->idFornecedorMedicamento;
    }

    /**
     * @param null $idFornecedorMedicamento
     */
    public function setIdFornecedorMedicamento($idFornecedorMedicamento)
    {
        $this->idFornecedorMedicamento = $idFornecedorMedicamento;
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

}