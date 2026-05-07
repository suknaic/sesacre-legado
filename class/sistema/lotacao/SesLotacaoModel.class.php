<?php
class SesLotacaoModel{
    private $id_lotacao = null;
    private $id_pai = null;
    private $id_lotacao_categoria = null;
    private $nm_lotacao = null;
    private $nr_cnpj = null;
    private $id_cidade = null;
    private $ds_logradouro = null; 
    private $ds_bairro  = null;
    private $nr_cep = null;
    private $nm_email = null;
    private $nr_telefone = null;
    private $mp_latitude = null;
    private $mp_longitude = null;
    private $st_ativo = null;
    
    function getId_lotacao() {
        return $this->id_lotacao;
    }

    function getId_pai() {
        return $this->id_pai;
    }

    function getId_lotacao_categoria() {
        return $this->id_lotacao_categoria;
    }

    function getNm_lotacao() {
        return $this->nm_lotacao;
    }

    function getNr_cnpj() {
        return $this->nr_cnpj;
    }

    function getId_cidade() {
        return $this->id_cidade;
    }

    function getDs_logradouro() {
        return $this->ds_logradouro;
    }

    function getDs_bairro() {
        return $this->ds_bairro;
    }

    function getNr_cep() {
        return $this->nr_cep;
    }

    function getNm_email() {
        return $this->nm_email;
    }

    function getNr_telefone() {
        return $this->nr_telefone;
    }

    function getMp_latitude() {
        return $this->mp_latitude;
    }

    function getMp_longitude() {
        return $this->mp_longitude;
    }

    function getSt_ativo() {
        return $this->st_ativo;
    }

    function setId_lotacao($id_lotacao) {
        $this->id_lotacao = $id_lotacao;
    }

    function setId_pai($id_pai) {
        $this->id_pai = $id_pai;
    }

    function setId_lotacao_categoria($id_lotacao_categoria) {
        $this->id_lotacao_categoria = $id_lotacao_categoria;
    }

    function setNm_lotacao($nm_lotacao) {
        $this->nm_lotacao = $nm_lotacao;
    }

    function setNr_cnpj($nr_cnpj) {
        $this->nr_cnpj = $nr_cnpj;
    }

    function setId_cidade($id_cidade) {
        $this->id_cidade = $id_cidade;
    }

    function setDs_logradouro($ds_logradouro) {
        $this->ds_logradouro = $ds_logradouro;
    }

    function setDs_bairro($ds_bairro) {
        $this->ds_bairro = $ds_bairro;
    }

    function setNr_cep($nr_cep) {
        $this->nr_cep = $nr_cep;
    }

    function setNm_email($nm_email) {
        $this->nm_email = $nm_email;
    }

    function setNr_telefone($nr_telefone) {
        $this->nr_telefone = $nr_telefone;
    }

    function setMp_latitude($mp_latitude) {
        $this->mp_latitude = $mp_latitude;
    }

    function setMp_longitude($mp_longitude) {
        $this->mp_longitude = $mp_longitude;
    }

    function setSt_ativo($st_ativo) {
        $this->st_ativo = $st_ativo;
    }
    /**Retorna lotacao do usuario**/
    
}

