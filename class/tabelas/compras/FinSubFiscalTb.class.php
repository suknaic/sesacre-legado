<?php
class FinSubFiscalTb{
    private $idSubFiscal = null;
    private $idAta = null;
    private $idContrato = null;
    private $idPessoa = null;
    private $tpSubFiscal = null;
    private $dtIniSubFiscal = null;
    private $dtFimSubFiscal = null;
    private $sitAtivo = null;
    function getIdSubFiscal() {
        return $this->idSubFiscal;
    }

    function getIdAta() {
        return $this->idAta;
    }

    function getIdContrato() {
        return $this->idContrato;
    }

    function getIdPessoa() {
        return $this->idPessoa;
    }

    function getTpSubFiscal() {
        return $this->tpSubFiscal;
    }

    function getDtIniSubFiscal() {
        return $this->dtIniSubFiscal;
    }

    function getDtFimSubFiscal() {
        return $this->dtFimSubFiscal;
    }

    function getSitAtivo() {
        return $this->sitAtivo;
    }

    function setIdSubFiscal($idSubFiscal) {
        $this->idSubFiscal = $idSubFiscal;
    }

    function setIdAta($idAta) {
        $this->idAta = $idAta;
    }

    function setIdContrato($idContrato) {
        $this->idContrato = $idContrato;
    }

    function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
    }

    function setTpSubFiscal($tpSubFiscal) {
        $this->tpSubFiscal = $tpSubFiscal;
    }

    function setDtIniSubFiscal($dtIniSubFiscal) {
        $this->dtIniSubFiscal = $dtIniSubFiscal;
    }

    function setDtFimSubFiscal($dtFimSubFiscal) {
        $this->dtFimSubFiscal = $dtFimSubFiscal;
    }

    function setSitAtivo($sitAtivo) {
        $this->sitAtivo = $sitAtivo;
    }
}