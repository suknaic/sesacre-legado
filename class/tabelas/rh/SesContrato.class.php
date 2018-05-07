<?php

class SesContrato {

    private $id_contrato = null;
    private $nr_matricula = null;
    private $dt_admissao = null;
    private $nr_carga_horaria = null;
    private $dt_demissao = null;
    private $id_pessoa_fisica = null;
    private $id_vinculo = null;
    private $id_pessoa_juridica = null;
    private $id_cargo = null;
    private $st_ativo = null;
    //*********************************************
    private $id_contrato_lotacao = null;
    private $carga_horaria_lotacao = null;
    private $id_lotacao = null;
    private $id_funcao = null;
    private $dt_inicio = null;
    private $dt_fim = null;
    private $dt_historico = null;
    //**************************************************************************
    private $ds_observacao = null;
    private $id_contrato_situacao = null;
    private $id_contrato_historico = null;

    //**************************************************************************
    function getDt_historico() {
        return $this->dt_historico;
    }

    function setDt_historico($dt_historico) {
        $this->dt_historico = $dt_historico;
    }

        function getId_contrato_historico() {
        return $this->id_contrato_historico;
    }

    function setId_contrato_historico($id_contrato_historico) {
        $this->id_contrato_historico = $id_contrato_historico;
    }

    
    function getId_contrato_lotacao() {
        return $this->id_contrato_lotacao;
    }

    function getCarga_horaria_lotacao() {
        return $this->carga_horaria_lotacao;
    }

    function getId_lotacao() {
        return $this->id_lotacao;
    }

    function getId_funcao() {
        return $this->id_funcao;
    }

    function getDt_inicio() {
        return $this->dt_inicio;
    }

    function getDt_fim() {
        return $this->dt_fim;
    }

    function setId_contrato_lotacao($id_contrato_lotacao) {
        $this->id_contrato_lotacao = $id_contrato_lotacao;
    }

    function setCarga_horaria_lotacao($carga_horaria_lotacao) {
        $this->carga_horaria_lotacao = $carga_horaria_lotacao;
    }

    function setId_lotacao($id_lotacao) {
        $this->id_lotacao = $id_lotacao;
    }

    function setId_funcao($id_funcao) {
        $this->id_funcao = $id_funcao;
    }

    function setDt_inicio($dt_inicio) {
        $this->dt_inicio = $dt_inicio;
    }

    function setDt_fim($dt_fim) {
        $this->dt_fim = $dt_fim;
    }

    //**************************************************************************
    function getId_contrato() {
        return $this->id_contrato;
    }

    function getNr_matricula() {
        return $this->nr_matricula;
    }

    function getDt_admissao() {
        return $this->dt_admissao;
    }

    function getNr_carga_horaria() {
        return $this->nr_carga_horaria;
    }

    function getDt_demissao() {
        return $this->dt_demissao;
    }

    function getId_pessoa_fisica() {
        return $this->id_pessoa_fisica;
    }

    function getId_vinculo() {
        return $this->id_vinculo;
    }

    function getId_pessoa_juridica() {
        return $this->id_pessoa_juridica;
    }

    function getId_cargo() {
        return $this->id_cargo;
    }

    function getSt_ativo() {
        return $this->st_ativo;
    }

    function setId_contrato($id_contrato) {
        $this->id_contrato = $id_contrato;
    }

    function setNr_matricula($nr_matricula) {
        $this->nr_matricula = $nr_matricula;
    }

    function setDt_admissao($dt_admissao) {
        $this->dt_admissao = $dt_admissao;
    }

    function setNr_carga_horaria($nr_carga_horaria) {
        $this->nr_carga_horaria = $nr_carga_horaria;
    }

    function setDt_demissao($dt_demissao) {
        $this->dt_demissao = $dt_demissao;
    }

    function setId_pessoa_fisica($id_pessoa_fisica) {
        $this->id_pessoa_fisica = $id_pessoa_fisica;
    }

    function setId_vinculo($id_vinculo) {
        $this->id_vinculo = $id_vinculo;
    }

    function setId_pessoa_juridica($id_pessoa_juridica) {
        $this->id_pessoa_juridica = $id_pessoa_juridica;
    }

    function setId_cargo($id_cargo) {
        $this->id_cargo = $id_cargo;
    }

    function setSt_ativo($st_ativo) {
        $this->st_ativo = $st_ativo;
    }

//******************************************************************************
    function getDs_observacao() {
        return $this->ds_observacao;
    }

    function getId_contrato_situacao() {
        return $this->id_contrato_situacao;
    }

    function setDs_observacao($ds_observacao) {
        $this->ds_observacao = $ds_observacao;
    }

    function setId_contrato_situacao($id_contrato_situacao) {
        $this->id_contrato_situacao = $id_contrato_situacao;
    }

}
