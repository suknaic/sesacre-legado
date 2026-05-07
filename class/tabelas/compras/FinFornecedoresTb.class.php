<?php
class FinFornecedoresTb {
    private $id_fornecedor = null;
    private $id_contrato = null;
    private $id_ata = null;
    private $id_pessoa = null;
    private $sit_fornecedor = null;

    /**
     * @return mixed
     */
    public function getIdFornecedor() {
        return $this->id_fornecedor;
    }

    /**
     * @param mixed $id_fornecedor
     *
     * @return self
     */
    public function setIdFornecedor($id_fornecedor) {
        $this->id_fornecedor = $id_fornecedor;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdContrato() {
        return $this->id_contrato;
    }

    /**
     * @param mixed $id_contrato
     *
     * @return self
     */
    public function setIdContrato($id_contrato) {
        $this->id_contrato = $id_contrato;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdAta() {
        return $this->id_ata;
    }

    /**
     * @param mixed $id_ata
     *
     * @return self
     */
    public function setIdAta($id_ata) {
        $this->id_ata = $id_ata;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdPessoa() {
        return $this->id_pessoa;
    }

    /**
     * @param mixed $id_pessoa
     *
     * @return self
     */
    public function setIdPessoa($id_pessoa) {
        $this->id_pessoa = $id_pessoa;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSitFornecedor() {
        return $this->sit_fornecedor;
    }

    /**
     * @param mixed $sit_fornecedor
     *
     * @return self
     */
    public function setSitFornecedor($sit_fornecedor) {
        $this->sit_fornecedor = $sit_fornecedor;

        return $this;
    }
}