<?php
/**
 * Created by PhpStorm.
 * User: elivelton
 * Date: 06/11/18
 * Time: 17:38
 */

class ForFornecedor {
    private $idFornecedor = null;
    private $idPessoa = null;
    private $nmEmpresa = null;
    private $medicamento = null;
    private $servico = null;
    private $emailAdicional = null;
    private $materialConsumo = null;
    private $materialPermanente = null;
    private $flDistribuidora = null;
    private $flExclusiva = null;

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
    public function getIdPessoa()
    {
        return $this->idPessoa;
    }

    /**
     * @param null $idPessoa
     */
    public function setIdPessoa($idPessoa)
    {
        $this->idPessoa = $idPessoa;
    }

    /**
     * @return null
     */
    public function getNmEmpresa()
    {
        return $this->nmEmpresa;
    }

    /**
     * @param null $nmEmpresa
     */
    public function setNmEmpresa($nmEmpresa)
    {
        $this->nmEmpresa = $nmEmpresa;
    }

    /**
     * @return null
     */
    public function getMedicamento()
    {
        return $this->medicamento;
    }

    /**
     * @param null $medicamento
     */
    public function setMedicamento($medicamento)
    {
        $this->medicamento = $medicamento;
    }

    /**
     * @return null
     */
    public function getServico()
    {
        return $this->servico;
    }

    /**
     * @param null $servico
     */
    public function setServico($servico)
    {
        $this->servico = $servico;
    }

    /**
     * @return null
     */
    public function getMaterialConsumo()
    {
        return $this->materialConsumo;
    }

    /**
     * @param null $materialConsumo
     */
    public function setMaterialConsumo($materialConsumo)
    {
        $this->materialConsumo = $materialConsumo;
    }

    /**
     * @return null
     */
    public function getMaterialPermanente()
    {
        return $this->materialPermanente;
    }

    /**
     * @param null $materialPermanente
     */
    public function setMaterialPermanente($materialPermanente)
    {
        $this->materialPermanente = $materialPermanente;
    }

    /**
     * @return null
     */
    public function getFlDistribuidora()
    {
        return $this->flDistribuidora;
    }

    /**
     * @param null $flDistribuidora
     */
    public function setFlDistribuidora($flDistribuidora)
    {
        $this->flDistribuidora = $flDistribuidora;
    }

    /**
     * @return null
     */
    public function getFlExclusiva()
    {
        return $this->flExclusiva;
    }

    /**
     * @param null $flExclusiva
     */
    public function setFlExclusiva($flExclusiva)
    {
        $this->flExclusiva = $flExclusiva;
    }

    /**
     * @return null
     */
    public function getEmailAdicional()
    {
        return $this->emailAdicional;
    }

    /**
     * @param null $emailAdicional
     */
    public function setEmailAdicional($emailAdicional)
    {
        $this->emailAdicional = $emailAdicional;
    }


}