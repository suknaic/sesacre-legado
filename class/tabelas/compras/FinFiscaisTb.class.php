<?php
class FinFiscaisModelTb {

    private $idFiscal = null;
    private $idAta = null;
    private $idContrato = null;
    private $idPessoa = null;
    private $tpFiscal = null;
    private $dtIniFiscal = null;
    private $dtFimFiscal = null;
    private $sitAtivo = null;

    /**
     * @return mixed
     */
    public function getIdFiscal() {
        return $this->idFiscal;
    }

    /**
     * @param mixed $idFiscal
     *
     * @return self
     */
    public function setIdFiscal($idFiscal) {
        $this->idFiscal = $idFiscal;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdAta() {
        return $this->idAta;
    }

    /**
     * @param mixed $idAta
     *
     * @return self
     */
    public function setIdAta($idAta) {
        $this->idAta = $idAta;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdContrato() {
        return $this->idContrato;
    }

    /**
     * @param mixed $idContrato
     *
     * @return self
     */
    public function setIdContrato($idContrato) {
        $this->idContrato = $idContrato;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdPessoa() {
        return $this->idPessoa;
    }

    /**
     * @param mixed $idPessoa
     *
     * @return self
     */
    public function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTpFiscal() {
        return $this->tpFiscal;
    }

    /**
     * @param mixed $tpFiscal
     *
     * @return self
     */
    public function setTpFiscal($tpFiscal) {
        $this->tpFiscal = $tpFiscal;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtIniFiscal() {
        return $this->dtIniFiscal;
    }

    /**
     * @param mixed $dtIniFiscal
     *
     * @return self
     */
    public function setDtIniFiscal($dtIniFiscal) {
        $this->dtIniFiscal = $dtIniFiscal;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtFimFiscal() {
        return $this->dtFimFiscal;
    }

    /**
     * @param mixed $dtFimFiscal
     *
     * @return self
     */
    public function setDtFimFiscal($dtFimFiscal) {
        $this->dtFimFiscal = $dtFimFiscal;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSitAtivo() {
        return $this->sitAtivo;
    }

    /**
     * @param mixed $sitAtivo
     *
     * @return self
     */
    public function setSitAtivo($sitAtivo) {
        $this->sitAtivo = $sitAtivo;

        return $this;
    }
}
