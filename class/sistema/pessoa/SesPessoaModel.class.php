<?php

class SesPessoaJuridicaModel {

    private $id_pessoa = null;
    private $nm_pessoa = null;
    private $id_naturalidade = null;
    private $ds_logradouro = null;
    private $ds_bairro = null;
    private $ds_complemento = null;
    private $nr_cep = null;
    private $id_cidade = null;
    private $nr_elefone_residencial = null;
    private $nr_telefone_celular = null;
    private $nm_email = null;
    private $nm_senha = null;
    private $ds_observacao = null;
    private $dh_cadastro = null;
    private $st_ativo = null;
    private $st_login = null;

    function getId_pessoa() {
        return $this->id_pessoa;
    }

    function getNm_pessoa() {
        return $this->nm_pessoa;
    }

    function getId_naturalidade() {
        return $this->id_naturalidade;
    }

    function getDs_logradouro() {
        return $this->ds_logradouro;
    }

    function getDs_bairro() {
        return $this->ds_bairro;
    }

    function getDs_complemento() {
        return $this->ds_complemento;
    }

    function getNr_cep() {
        return $this->nr_cep;
    }

    function getId_cidade() {
        return $this->id_cidade;
    }

    function getNr_elefone_residencial() {
        return $this->nr_elefone_residencial;
    }

    function getNr_telefone_celular() {
        return $this->nr_telefone_celular;
    }

    function getNm_email() {
        return $this->nm_email;
    }

    function getNm_senha() {
        return $this->nm_senha;
    }

    function getDs_observacao() {
        return $this->ds_observacao;
    }

    function getDh_cadastro() {
        return $this->dh_cadastro;
    }

    function getSt_ativo() {
        return $this->st_ativo;
    }

    function getSt_login() {
        return $this->st_login;
    }

    function setId_pessoa($id_pessoa) {
        $this->id_pessoa = $id_pessoa;
    }

    function setNm_pessoa($nm_pessoa) {
        $this->nm_pessoa = $nm_pessoa;
    }

    function setId_naturalidade($id_naturalidade) {
        $this->id_naturalidade = $id_naturalidade;
    }

    function setDs_logradouro($ds_logradouro) {
        $this->ds_logradouro = $ds_logradouro;
    }

    function setDs_bairro($ds_bairro) {
        $this->ds_bairro = $ds_bairro;
    }

    function setDs_complemento($ds_complemento) {
        $this->ds_complemento = $ds_complemento;
    }

    function setNr_cep($nr_cep) {
        $this->nr_cep = $nr_cep;
    }

    function setId_cidade($id_cidade) {
        $this->id_cidade = $id_cidade;
    }

    function setNr_elefone_residencial($nr_elefone_residencial) {
        $this->nr_elefone_residencial = $nr_elefone_residencial;
    }

    function setNr_telefone_celular($nr_telefone_celular) {
        $this->nr_telefone_celular = $nr_telefone_celular;
    }

    function setNm_email($nm_email) {
        $this->nm_email = $nm_email;
    }

    function setNm_senha($nm_senha) {
        $this->nm_senha = $nm_senha;
    }

    function setDs_observacao($ds_observacao) {
        $this->ds_observacao = $ds_observacao;
    }

    function setDh_cadastro($dh_cadastro) {
        $this->dh_cadastro = $dh_cadastro;
    }

    function setSt_ativo($st_ativo) {
        $this->st_ativo = $st_ativo;
    }

    function setSt_login($st_login) {
        $this->st_login = $st_login;
    }
    
    

}
