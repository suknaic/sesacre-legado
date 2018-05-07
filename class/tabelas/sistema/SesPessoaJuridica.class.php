<?php
class SesPessoaJuridica{
    private $id_pessoa_juridica = null;
    private $id_pessoa = null;
    private $nr_cnae = null;
    private $nr_cnpj = null;
    private $ds_insc_estadual = null;
    private $ds_insc_municipal = null;
    private $dt_fundacao = null;
    private $id_natureza = null;
    private $nm_fantasia = null;
    private $nr_safira = null;
    //***********************************
    function getId_natureza() {
        return $this->id_natureza;
    }

    function getNm_fantasia() {
        return $this->nm_fantasia;
    }

    function getNr_safira() {
        return $this->nr_safira;
    }

    function setId_natureza($id_natureza) {
        $this->id_natureza = $id_natureza;
    }

    function setNm_fantasia($nm_fantasia) {
        $this->nm_fantasia = $nm_fantasia;
    }

    function setNr_safira($nr_safira) {
        $this->nr_safira = $nr_safira;
    }

        function getId_pessoa_juridica() {
        return $this->id_pessoa_juridica;
    }

    function getId_pessoa() {
        return $this->id_pessoa;
    }

    function getNr_cnae() {
        return $this->nr_cnae;
    }

    function getNr_cnpj() {
        return $this->nr_cnpj;
    }

    function getDs_insc_estadual() {
        return $this->ds_insc_estadual;
    }

    function getDs_insc_municipal() {
        return $this->ds_insc_municipal;
    }

    function getDt_fundacao() {
        return $this->dt_fundacao;
    }

    function setId_pessoa_juridica($id_pessoa_juridica) {
        $this->id_pessoa_juridica = $id_pessoa_juridica;
    }

    function setId_pessoa($id_pessoa) {
        $this->id_pessoa = $id_pessoa;
    }

    function setNr_cnae($nr_cnae) {
        $this->nr_cnae = $nr_cnae;
    }

    function setNr_cnpj($nr_cnpj) {
        $this->nr_cnpj = $nr_cnpj;
    }

    function setDs_insc_estadual($ds_insc_estadual) {
        $this->ds_insc_estadual = $ds_insc_estadual;
    }

    function setDs_insc_municipal($ds_insc_municipal) {
        $this->ds_insc_municipal = $ds_insc_municipal;
    }

    function setDt_fundacao($dt_fundacao) {
        $this->dt_fundacao = $dt_fundacao;
    }

    
}
