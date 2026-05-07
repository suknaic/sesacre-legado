<?php

class FinAtaTb {

    private $idAta = null;
    private $idProcesso = null;
    private $idPessoaJuridica = null;
    private $flCarona = null;
    private $nrAta = null;
    private $dsObjeto = null;
    private $dtIniVigenciaAta = null;
    private $dtFimVigenciaAta = null;
    private $dtAssinatura = null;
    private $dtPublicacao = null;
    private $dsObsAta = null;
    private $stAta = null;
    private $orgaoGerenciador = null;
    //atritubos do qdd
    private $idProgramaTrabalho = null;
    private $idFonte = null;

    function __construct() {
        
    }

    function getIdAta() {
        return $this->idAta;
    }

    function getIdProcesso() {
        return $this->idProcesso;
    }

    function getIdPessoaJuridica() {
        return $this->idPessoaJuridica;
    }

    function getFlCarona() {
        return $this->flCarona;
    }

    function getNrAta() {
        return $this->nrAta;
    }

    function getDsObjeto() {
        return $this->dsObjeto;
    }

    function getDtIniVigenciaAta() {
        return $this->dtIniVigenciaAta;
    }

    function getDtFimVigenciaAta() {
        return $this->dtFimVigenciaAta;
    }

    function getDtAssinatura() {
        return $this->dtAssinatura;
    }

    function getDtPublicacao() {
        return $this->dtPublicacao;
    }

    function getDsObsAta() {
        return $this->dsObsAta;
    }

    function getStAta() {
        return $this->stAta;
    }

    function getOrgaoGerenciador() {
        return $this->orgaoGerenciador;
    }

    function setIdAta($idAta) {
        $this->idAta = $idAta;
    }

    function setIdProcesso($idProcesso) {
        $this->idProcesso = $idProcesso;
    }

    function setIdPessoaJuridica($idPessoaJuridica) {
        $this->idPessoaJuridica = $idPessoaJuridica;
    }

    function setFlCarona($flCarona) {
        $this->flCarona = $flCarona;
    }

    function setNrAta($nrAta) {
        $this->nrAta = $nrAta;
    }

    function setDsObjeto($dsObjeto) {
        $this->dsObjeto = $dsObjeto;
    }

    function setDtIniVigenciaAta($dtIniVigenciaAta) {
        $this->dtIniVigenciaAta = $dtIniVigenciaAta;
    }

    function setDtFimVigenciaAta($dtFimVigenciaAta) {
        $this->dtFimVigenciaAta = $dtFimVigenciaAta;
    }

    function setDtAssinatura($dtAssinatura) {
        $this->dtAssinatura = $dtAssinatura;
    }

    function setDtPublicacao($dtPublicacao) {
        $this->dtPublicacao = $dtPublicacao;
    }

    function setDsObsAta($dsObsAta) {
        $this->dsObsAta = $dsObsAta;
    }

    function setStAta($stAta) {
        $this->stAta = $stAta;
    }

    function setOrgaoGerenciador($orgaoGerenciador) {
        $this->orgaoGerenciador = $orgaoGerenciador;
    }

    function getIdProgramaTrabalho() {
        return $this->idProgramaTrabalho;
    }

    function getIdFonte() {
        return $this->idFonte;
    }

    function setIdProgramaTrabalho($idProgramaTrabalho) {
        $this->idProgramaTrabalho = $idProgramaTrabalho;
    }

    function setIdFonte($idFonte) {
        $this->idFonte = $idFonte;
    }

}
