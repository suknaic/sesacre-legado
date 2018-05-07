<?php
class FinGestorTb {
    private $idGestor = null;
    private $idPessoa = null;
    private $idContrato = null;
    private $idAta = null;
    private $tpGestor = null;
    private $dtIniGestor = null;
    private $dtFimGestor = null;
    private $sitAtivo = null;

    /**
     * @return mixed
     */
    public function getIdGestor() {
        return $this->idGestor;
    }

    /**
     * @param mixed $idGestor
     *
     * @return self
     */
    public function setIdGestor($idGestor) {
        $this->idGestor = $idGestor;

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
    public function getTpGestor() {
        return $this->tpGestor;
    }

    /**
     * @param mixed $tpGestor
     *
     * @return self
     */
    public function setTpGestor($tpGestor) {
        $this->tpGestor = $tpGestor;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtIniGestor() {
        return $this->dtIniGestor;
    }

    /**
     * @param mixed $dtIniGestor
     *
     * @return self
     */
    public function setDtIniGestor($dtIniGestor) {
        $this->dtIniGestor = $dtIniGestor;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtFimGestor() {
        return $this->dtFimGestor;
    }

    /**
     * @param mixed $dtFimGestor
     *
     * @return self
     */
    public function setDtFimGestor($dtFimGestor) {
        $this->dtFimGestor = $dtFimGestor;

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

