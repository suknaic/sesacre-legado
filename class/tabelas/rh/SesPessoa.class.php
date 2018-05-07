<?php

class SesPessoa{
    
    private $id_pessoa = null;
    private $nm_pessoa = null;
    private $id_naturalidade = null;
    private $ds_logradouro = null;
    private $ds_bairro = null;
    private $ds_complemento = null;
    private $nr_cep = null;
    private $id_cidade = null;
    private $nr_telefone_residencial = null;
    private $nr_telefone_celular = null;
    private $nm_email = null;
    private $nm_senha = null;
    private $ds_observacao = null;
    private $dh_login = null;
    private $st_ativo = null;
    
    function getIdPessoa() {
        return $this->id_pessoa;
    }

    function getNmPessoa() {
        return $this->nm_pessoa;
    }

    function getIdNaturalidade() {
        return $this->id_naturalidade;
    }

    function getDsLogradouro() {
        return $this->ds_logradouro;
    }

    function getDsBairro() {
        return $this->ds_bairro;
    }

    function getDsComplemento() {
        return $this->ds_complemento;
    }

    function getNrCep() {
        return $this->nr_cep;
    }

    function getIdCidade() {
        return $this->id_cidade;
    }

    function getNrTelefoneResidencial() {
        return $this->nr_telefone_residencial;
    }

    function getNrTelefoneCelular() {
        return $this->nr_telefone_celular;
    }

    function getNmEmail() {
        return $this->nm_email;
    }

    function getNmSenha() {
        return $this->nm_senha;
    }

    function getDsObservacao() {
        return $this->ds_observacao;
    }

    function getDhLogin() {
        return $this->dh_login;
    }

    function getStAtivo() {
        return $this->st_ativo;
    }

    function setIdPessoa($id_pessoa) {
        $this->id_pessoa = $id_pessoa;
    }

    function setNmPessoa($nm_pessoa) {
        $this->nm_pessoa = $nm_pessoa;
    }

    function setIdNaturalidade($id_naturalidade) {
        $this->id_naturalidade = $id_naturalidade;
    }

    function setDsLogradouro($ds_logradouro) {
        $this->ds_logradouro = $ds_logradouro;
    }

    function setDsBairro($ds_bairro) {
        $this->ds_bairro = $ds_bairro;
    }

    function setDsComplemento($ds_complemento) {
        $this->ds_complemento = $ds_complemento;
    }

    function setNrCep($nr_cep) {
        $this->nr_cep = $nr_cep;
    }

    function setIdCidade($id_cidade) {
        $this->id_cidade = $id_cidade;
    }

    function setNrTelefoneResidencial($nr_telefone_residencial) {
        $this->nr_telefone_residencial = $nr_telefone_residencial;
    }

    function setNrTelefoneCelular($nr_telefone_celular) {
        $this->nr_telefone_celular = $nr_telefone_celular;
    }

    function setNmEmail($nm_email) {
        $this->nm_email = $nm_email;
    }

    function setNmSenha($nm_senha) {
        $this->nm_senha = $nm_senha;
    }

    function setDsObservacao($ds_observacao) {
        $this->ds_observacao = $ds_observacao;
    }

    function setDhLogin($dh_login) {
        $this->dh_login = $dh_login;
    }

    function setStAtivo($st_ativo) {
        $this->st_ativo = $st_ativo;
    }                                  
    
}


