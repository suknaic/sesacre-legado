<?php
/**
 * Created by PhpStorm.
 * User: elivelton
 * Date: 07/11/18
 * Time: 10:48
 */

class ForFornecedorServico{
    private $idFornecedorServico = null;
    private $idFornecedor = null;
    private $idServico = null;

    /**
     * @return null
     */
    public function getIdFornecedorServico()
    {
        return $this->idFornecedorServico;
    }

    /**
     * @param null $idFornecedorServico
     */
    public function setIdFornecedorServico($idFornecedorServico)
    {
        $this->idFornecedorServico = $idFornecedorServico;
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
    public function getIdServico()
    {
        return $this->idServico;
    }

    /**
     * @param null $idServico
     */
    public function setIdServico($idServico)
    {
        $this->idServico = $idServico;
    }

}