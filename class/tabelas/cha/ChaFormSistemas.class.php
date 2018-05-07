<?php

class ChaFormSistemas {

    private $idFormSistemas = null;
    private $idChamado = null;
    private $nmPessoa = null;
    private $dsEmail = null;
    private $nrTelefone = null;
    private $nrCartaoSus = null;
    private $nrCpf = null;
    private $nrRg = null;
    private $nrTelefoneSetor = null;
    private $nrMatricula = null;
    private $nmModulo = null;
    private $nrPortaria = null;
    private $nmSetor = null;
    private $cdSetor = null;
    private $nmResponsavel = null;
    private $nrParticipantes = null;
    private $dsSenhaDesejada = null;
    private $nmExame = null;
    private $dsExameParametro = null;
    private $nmPermissao = null;
    private $nmConselho = null;
    private $nrConselho = null;
    private $dtInicial = null;
    private $dtFim = null;
    private $dtNascimento = null;
    private $idCargo = null;
    private $idFuncao = null;
    private $idLotacao = null;
    private $idVinculo = null;
    private $idPessoaSolicitante = null;

    /**
     * nm_pessoa: Nome da pessoa
     * ds_email: email funcional
     * nr_cartao_sus: Número do cartão do sus para Criar usuário no Cadweb
     * nr_cpf: Número do CPF do usuário
     * nr_rg: Número do RG do usuário
     * nr_telefone_setor: Número do telefone do setor
     * nr_matricula: Número da matrícula do funcionario
     * nm_modulo: Módulo do GRP e Hospub q deseja liberação
     * nr_portaria: Número da portaria em que foi publicado o novo setor
     * nm_setor: Nome do Setor
     * cd_setor: Código do Setor no SIAG
     * nm_responsavel: Nome do responsável pelo setor
     * nr_participantes: Número de participantes de um treinamento
     * ds_senha_desejada: A senha que o usuário deseja para o HOSPUB
     * nm_exame: Nome do exame a ser inserido no HOSPUB
     * ds_exame_parametro: Parametro do exame a ser inserido no HOSPUB
     * nm_permissao: Qual tipo de permissão o usuário deseja para o GRP e HOSPUB
     * nm_conselho: Nome do conselho de classe 
     * nr_conselho: Número do conselho de classe
     * dt_inicial: Data Inicial do relatórios de atendimento do HOSPUB
     * dt_fim: Data Final do relatório de atendimento do HOSPUB 
     * dt_nascimento: Data de Nascimento do Usuário
     * id_cargo: Cargo do Usuário
     * id_funcao: Função do Usuário
     * id_lotacao: Lotação do Usuário
     * id_vinculo: Vínculo do Usuário
     */
    function getIdFormSistemas() {
        return $this->idFormSistemas;
    }

    function getIdChamado() {
        return $this->idChamado;
    }

    function getNmPessoa() {
        return $this->nmPessoa;
    }

    function getDsEmail() {
        return $this->dsEmail;
    }

    function getNrTelefone() {
        return $this->nrTelefone;
    }

    function getNrCartaoSus() {
        return $this->nrCartaoSus;
    }

    function getNrCpf() {
        return $this->nrCpf;
    }

    function getNrRg() {
        return $this->nrRg;
    }

    function getNrTelefoneSetor() {
        return $this->nrTelefoneSetor;
    }

    function getNrMatricula() {
        return $this->nrMatricula;
    }

    function getNmModulo() {
        return $this->nmModulo;
    }

    function getNrPortaria() {
        return $this->nrPortaria;
    }

    function getNmSetor() {
        return $this->nmSetor;
    }

    function getCdSetor() {
        return $this->cdSetor;
    }

    function getNmResponsavel() {
        return $this->nmResponsavel;
    }

    function getNrParticipantes() {
        return $this->nrParticipantes;
    }

    function getDsSenhaDesejada() {
        return $this->dsSenhaDesejada;
    }

    function getNmExame() {
        return $this->nmExame;
    }

    function getDsExameParametro() {
        return $this->dsExameParametro;
    }

    function getNmPermissao() {
        return $this->nmPermissao;
    }

    function getNmConselho() {
        return $this->nmConselho;
    }

    function getNrConselho() {
        return $this->nrConselho;
    }

    function getDtInicial() {
        return $this->dtInicial;
    }

    function getDtFim() {
        return $this->dtFim;
    }

    function getDtNascimento() {
        return $this->dtNascimento;
    }

    function getIdCargo() {
        return $this->idCargo;
    }

    function getIdFuncao() {
        return $this->idFuncao;
    }

    function getIdLotacao() {
        return $this->idLotacao;
    }

    function getIdVinculo() {
        return $this->idVinculo;
    }

    function setIdFormSistemas($idFormSistemas) {
        $this->idFormSistemas = $idFormSistemas;
    }

    function setIdChamado($idChamado) {
        $this->idChamado = $idChamado;
    }

    function setNmPessoa($nmPessoa) {
        $this->nmPessoa = $nmPessoa;
    }

    function setDsEmail($dsEmail) {
        $this->dsEmail = $dsEmail;
    }

    function setNrTelefone($nrTelefone) {
        $this->nrTelefone = $nrTelefone;
    }

    function setNrCartaoSus($nrCartaoSus) {
        $this->nrCartaoSus = $nrCartaoSus;
    }

    function setNrCpf($nrCpf) {
        $this->nrCpf = $nrCpf;
    }

    function setNrRg($nrRg) {
        $this->nrRg = $nrRg;
    }

    function setNrTelefoneSetor($nrTelefoneSetor) {
        $this->nrTelefoneSetor = $nrTelefoneSetor;
    }

    function setNrMatricula($nrMatricula) {
        $this->nrMatricula = $nrMatricula;
    }

    function setNmModulo($nmModulo) {
        $this->nmModulo = $nmModulo;
    }

    function setNrPortaria($nrPortaria) {
        $this->nrPortaria = $nrPortaria;
    }

    function setNmSetor($nmSetor) {
        $this->nmSetor = $nmSetor;
    }

    function setCdSetor($cdSetor) {
        $this->cdSetor = $cdSetor;
    }

    function setNmResponsavel($nmResponsavel) {
        $this->nmResponsavel = $nmResponsavel;
    }

    function setNrParticipantes($nrParticipantes) {
        $this->nrParticipantes = $nrParticipantes;
    }

    function setDsSenhaDesejada($dsSenhaDesejada) {
        $this->dsSenhaDesejada = $dsSenhaDesejada;
    }

    function setNmExame($nmExame) {
        $this->nmExame = $nmExame;
    }

    function setDsExameParametro($dsExameParametro) {
        $this->dsExameParametro = $dsExameParametro;
    }

    function setNmPermissao($nmPermissao) {
        $this->nmPermissao = $nmPermissao;
    }

    function setNmConselho($nmConselho) {
        $this->nmConselho = $nmConselho;
    }

    function setNrConselho($nrConselho) {
        $this->nrConselho = $nrConselho;
    }

    function setDtInicial($dtInicial) {
        $this->dtInicial = $dtInicial;
    }

    function setDtFim($dtFim) {
        $this->dtFim = $dtFim;
    }

    function setDtNascimento($dtNascimento) {
        $this->dtNascimento = $dtNascimento;
    }

    function setIdCargo($idCargo) {
        $this->idCargo = $idCargo;
    }

    function setIdFuncao($idFuncao) {
        $this->idFuncao = $idFuncao;
    }

    function setIdLotacao($idLotacao) {
        $this->idLotacao = $idLotacao;
    }

    function setIdVinculo($idVinculo) {
        $this->idVinculo = $idVinculo;
    }

    function getIdPessoaSolicitante() {
        return $this->idPessoaSolicitante;
    }

    function setIdPessoaSolicitante($idPessoaSolicitante) {
        $this->idPessoaSolicitante = $idPessoaSolicitante;
    }

}
