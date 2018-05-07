<?php

class ChaFormInfraestrutura {

    private $idFormInfraestrutura = null;
    private $idChamado = null;
    private $tpLiberacao = null;
    private $nmPessoa = null;
    private $idCargo = null;
    private $idFuncao = null;
    private $idLotacao = null;
    private $nmEmail = null;
    private $dsAndar = null;
    private $qtPontos = null;
    private $qtCabos = null;
    private $nmApp = null;
    private $qtPatchCord = null;
    private $dsJustificativa = null;
    private $nrVlan = null;
    private $qtKeystone = null;
    private $qtRj45 = null;
    private $qtRack = null;
    private $nmPasta = null;
    private $dsDestino = null;
    private $qtComputador = null;
    private $qtImpressora = null;
    private $qtTelefone = null;
    private $dsIpGateway = null;
    private $idPessoaSolicitante = null;
    private $nrTelefone = null;

    /**
     * tp_liberacao: Se o usuário deseja liberação para Tablet, Notebook, Celular, etc
     * nm_pessoa: Nome da Pessoa que deseja criar um usuário no domínio
     * id_cargo: Cargo da Pessoa
     * id_funcao: Função da Pessoa
     * id_lotação: Lotação da Pessoa
     * nm_email: Email funcional da Pessoa
     * ds_andar: O andar em que a pessoa trabalha
     * qtPontos: Quantidade de pontos de rede
     * qtCabos: Quantidade de cabos de rede
     * nmApp: Nome do aplicativo que será atualizado no servidor
     * qtPatchCord: Quantidade de patch cords
     * dsJustificativa: Justificativa do porque aquele chamado está sendo aberto
     * nrVlan: Número da vlan
     * qtKeystone: Quantidade de keystones
     * qtRj45: Quantidade de rj45
     * qrRack: Quantidade de racks
     * nmPasta: Qual pasta deve ser liberada
     * dsDestino: Destino do remajeamento do ponto de rede
     * qtComputador: quantidade de computadores para troca de layout
     * qtImpressora: quantidade de impressoras para troca de layout
     * qtTelefone: quantidade de telefones para troca de layout
     * dsIpGateway: Ip do gateway
     */
    function getIdFormInfraestrutura() {
        return $this->idFormInfraestrutura;
    }

    function getIdChamado() {
        return $this->idChamado;
    }

    function getTpLiberacao() {
        return $this->tpLiberacao;
    }

    function getNmPessoa() {
        return $this->nmPessoa;
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

    function getNmEmail() {
        return $this->nmEmail;
    }

    function getDsAndar() {
        return $this->dsAndar;
    }

    function getQtPontos() {
        return $this->qtPontos;
    }

    function getQtCabos() {
        return $this->qtCabos;
    }

    function getNmApp() {
        return $this->nmApp;
    }

    function getQtPatchCord() {
        return $this->qtPatchCord;
    }

    function getDsJustificativa() {
        return $this->dsJustificativa;
    }

    function getNrVlan() {
        return $this->nrVlan;
    }

    function getQtKeystone() {
        return $this->qtKeystone;
    }

    function getQtRj45() {
        return $this->qtRj45;
    }

    function getQtRack() {
        return $this->qtRack;
    }

    function getNmPasta() {
        return $this->nmPasta;
    }

    function getDsDestino() {
        return $this->dsDestino;
    }

    function getQtComputador() {
        return $this->qtComputador;
    }

    function getQtImpressora() {
        return $this->qtImpressora;
    }

    function getQtTelefone() {
        return $this->qtTelefone;
    }

    function getDsIpGateway() {
        return $this->dsIpGateway;
    }

    function getNrTelefone() {
        return $this->nrTelefone;
    }

    function setIdFormInfraestrutura($idFormInfraestrutura) {
        $this->idFormInfraestrutura = $idFormInfraestrutura;
    }

    function setIdChamado($idChamado) {
        $this->idChamado = $idChamado;
    }

    function setTpLiberacao($tpLiberacao) {
        $this->tpLiberacao = $tpLiberacao;
    }

    function setNmPessoa($nmPessoa) {
        $this->nmPessoa = $nmPessoa;
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

    function setNmEmail($nmEmail) {
        $this->nmEmail = $nmEmail;
    }

    function setDsAndar($dsAndar) {
        $this->dsAndar = $dsAndar;
    }

    function setQtPontos($qtPontos) {
        $this->qtPontos = $qtPontos;
    }

    function setQtCabos($qtCabos) {
        $this->qtCabos = $qtCabos;
    }

    function setNmApp($nmApp) {
        $this->nmApp = $nmApp;
    }

    function setQtPatchCord($qtPatchCord) {
        $this->qtPatchCord = $qtPatchCord;
    }

    function setDsJustificativa($dsJustificativa) {
        $this->dsJustificativa = $dsJustificativa;
    }

    function setNrVlan($nrVlan) {
        $this->nrVlan = $nrVlan;
    }

    function setQtKeystone($qtKeystone) {
        $this->qtKeystone = $qtKeystone;
    }

    function setQtRj45($qtRj45) {
        $this->qtRj45 = $qtRj45;
    }

    function setQtRack($qtRack) {
        $this->qtRack = $qtRack;
    }

    function setNmPasta($nmPasta) {
        $this->nmPasta = $nmPasta;
    }

    function setDsDestino($dsDestino) {
        $this->dsDestino = $dsDestino;
    }

    function setQtComputador($qtComputador) {
        $this->qtComputador = $qtComputador;
    }

    function setQtImpressora($qtImpressora) {
        $this->qtImpressora = $qtImpressora;
    }

    function setQtTelefone($qtTelefone) {
        $this->qtTelefone = $qtTelefone;
    }

    function setDsIpGateway($dsIpGateway) {
        $this->dsIpGateway = $dsIpGateway;
    }

    function getIdPessoaSolicitante() {
        return $this->idPessoaSolicitante;
    }

    function setIdPessoaSolicitante($idPessoaSolicitante) {
        $this->idPessoaSolicitante = $idPessoaSolicitante;
    }

    function setNrTelefone($nrTelefone) {
        $this->nrTelefone = $nrTelefone;
    }

}
