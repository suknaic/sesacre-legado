<?php

class SesPessoaFisica{
   private $id_pessoa = null;
    //**************************************************************************
    private $id_pessoa_fisica = null;
    private $tp_sexo = null;
    private $nm_civil = null;
    private $nr_cpf = null;
    private $nr_rg = null;
    private $ds_orgao_expedidor = null;
    private $id_estado_expedidor = null;
    private $id_estado_civil = null;
    private $id_escolaridade_formacao = null;
    private $ds_habilidade = null;
    private $nm_pai = null;
    private $nm_mae = null;
    private $dt_nascimento = null;
    private $nr_cns = null;
    private $lk_foto = null;
    private $st_ativo = null;
    //**************************************************************************
    private $id_competencia = null;
    private $id_escolaridade_formacao_competencia = null;
    //**************************************************************************
    function getId_competencia() {
        return $this->id_competencia;
    }

    function setId_competencia($id_competencia) {
        $this->id_competencia = $id_competencia;
    }

    function getId_escolaridade_formacao_competencia() {
        return $this->id_escolaridade_formacao_competencia;
    }

    function setId_escolaridade_formacao_competencia($id_escolaridade_formacao_competencia) {
        $this->id_escolaridade_formacao_competencia = $id_escolaridade_formacao_competencia;
    }

        function getId_pessoa() {
        return $this->id_pessoa;
    }

    function getId_pessoa_fisica() {
        return $this->id_pessoa_fisica;
    }

    function getTp_sexo() {
        return $this->tp_sexo;
    }

    function getNm_civil() {
        return $this->nm_civil;
    }

    function getNr_cpf() {
        return $this->nr_cpf;
    }

    function getNr_rg() {
        return $this->nr_rg;
    }

    function getDs_orgao_expedidor() {
        return $this->ds_orgao_expedidor;
    }

    function getId_estado_expedidor() {
        return $this->id_estado_expedidor;
    }

    function getId_estado_civil() {
        return $this->id_estado_civil;
    }

    function getId_escolaridade_formacao() {
        return $this->id_escolaridade_formacao;
    }

    function getDs_habilidade() {
        return $this->ds_habilidade;
    }

    function getNm_pai() {
        return $this->nm_pai;
    }

    function getNm_mae() {
        return $this->nm_mae;
    }

    function getDt_nascimento() {
        return $this->dt_nascimento;
    }

    function getNr_cns() {
        return $this->nr_cns;
    }

    function getLk_foto() {
        return $this->lk_foto;
    }

    function getSt_ativo() {
        return $this->st_ativo;
    }

    function setId_pessoa($id_pessoa) {
        $this->id_pessoa = $id_pessoa;
    }

    function setId_pessoa_fisica($id_pessoa_fisica) {
        $this->id_pessoa_fisica = $id_pessoa_fisica;
    }

    function setTp_sexo($tp_sexo) {
        $this->tp_sexo = $tp_sexo;
    }

    function setNm_civil($nm_civil) {
        $this->nm_civil = $nm_civil;
    }

    function setNr_cpf($nr_cpf) {
        $this->nr_cpf = $nr_cpf;
    }

    function setNr_rg($nr_rg) {
        $this->nr_rg = $nr_rg;
    }

    function setDs_orgao_expedidor($ds_orgao_expedidor) {
        $this->ds_orgao_expedidor = $ds_orgao_expedidor;
    }

    function setId_estado_expedidor($id_estado_expedidor) {
        $this->id_estado_expedidor = $id_estado_expedidor;
    }

    function setId_estado_civil($id_estado_civil) {
        $this->id_estado_civil = $id_estado_civil;
    }

    function setId_escolaridade_formacao($id_escolaridade_formacao) {
        $this->id_escolaridade_formacao = $id_escolaridade_formacao;
    }

    function setDs_habilidade($ds_habilidade) {
        $this->ds_habilidade = $ds_habilidade;
    }

    function setNm_pai($nm_pai) {
        $this->nm_pai = $nm_pai;
    }

    function setNm_mae($nm_mae) {
        $this->nm_mae = $nm_mae;
    }

    function setDt_nascimento($dt_nascimento) {
        $this->dt_nascimento = $dt_nascimento;
    }

    function setNr_cns($nr_cns) {
        $this->nr_cns = $nr_cns;
    }

    function setLk_foto($lk_foto) {
        $this->lk_foto = $lk_foto;
    }

    function setSt_ativo($st_ativo) {
        $this->st_ativo = $st_ativo;
    }



}


