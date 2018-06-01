<?php

/**
 * Description of SesLotacao
 *
 * @author elivelton
 */
class SesLotacaoDetalhe {
    
    private $id_lotacao_detalhe = null;
    private $id_pai = null;
    private $id_lotacao_categoria = null;
    private $nm_lotacao_detalhe = null;
    private $nr_cnpj = null;
    private $id_cidade = null;
    private $ds_logradouro = null;
    private $ds_bairro = null;
    private $nr_cep = null;
    private $nm_email = null;
    private $nr_telefone = null;
    private $mp_latitude = null;
    private $mp_longitute = null;
    private $st_ativo = null;
    private $nmPessoa = null;
    private $nmCidade = null;
    private $id_pessoa = null;
    private $id_pessoa_juridica = null;
    private $st_principal = null;
    private $id_telefone = null;
    
    function getId_lotacao_detalhe() {
        return $this->id_lotacao_detalhe;
    }

    function getId_pai() {
        return $this->id_pai;
    }

    function getId_lotacao_categoria() {
        return $this->id_lotacao_categoria;
    }

    function getNm_lotacao_detalhe() {
        return $this->nm_lotacao_detalhe;
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

    function getMp_longitute() {
        return $this->mp_longitute;
    }

    function getSt_ativo() {
        return $this->st_ativo;
    }

    function getNmPessoa() {
        return $this->nmPessoa;
    }

    function getNmCidade() {
        return $this->nmCidade;
    }

    function getId_pessoa() {
        return $this->id_pessoa;
    }

    function getId_pessoa_juridica() {
        return $this->id_pessoa_juridica;
    }

    function getSt_principal() {
        return $this->st_principal;
    }

    function getId_telefone() {
        return $this->id_telefone;
    }

    function setId_lotacao_detalhe($id_lotacao_detalhe) {
        $this->id_lotacao_detalhe = $id_lotacao_detalhe;
    }

    function setId_pai($id_pai) {
        $this->id_pai = $id_pai;
    }

    function setId_lotacao_categoria($id_lotacao_categoria) {
        $this->id_lotacao_categoria = $id_lotacao_categoria;
    }

    function setNm_lotacao_detalhe($nm_lotacao_detalhe) {
        $this->nm_lotacao_detalhe = $nm_lotacao_detalhe;
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

    function setMp_longitute($mp_longitute) {
        $this->mp_longitute = $mp_longitute;
    }

    function setSt_ativo($st_ativo) {
        $this->st_ativo = $st_ativo;
    }

    function setNmPessoa($nmPessoa) {
        $this->nmPessoa = $nmPessoa;
    }

    function setNmCidade($nmCidade) {
        $this->nmCidade = $nmCidade;
    }

    function setId_pessoa($id_pessoa) {
        $this->id_pessoa = $id_pessoa;
    }

    function setId_pessoa_juridica($id_pessoa_juridica) {
        $this->id_pessoa_juridica = $id_pessoa_juridica;
    }

    function setSt_principal($st_principal) {
        $this->st_principal = $st_principal;
    }

    function setId_telefone($id_telefone) {
        $this->id_telefone = $id_telefone;
    }

}
