<?php

class ChaChamado {

    private $idChamado = null;
    private $idCategoriaSecundaria = null;
    private $idPessoaSolicitante = null;
    private $idPessoaServico = null;
    private $dhAbertura = null;
    private $dsChamado = null;
    private $nrTelefoneSolicitante = null;
    private $dsFinalizado = null;
    private $dhFinalizado = null;
    private $nrAvaliacao = null;
    private $dhAvaliacao = null;
    private $dsAvaliacao = null;
    private $vlChamado = null;
    private $idStatus = null;
    private $dhAgendamento = null;
    private $idPrioridade = null;
    private $dhCancelamento = null;
    private $dsCancelamento = null;
    private $dtPrazo = null;
    private $sucesso = null;
    private $mensagem = null;

    /**
     * id_pessoa_servico: Pessoa que receberá o serviço.
     * dh_abertura: Data e Hora da Abertura do Chamado;
     * ds_chamado: O campo em que o usuário poderá esṕecificar melhor o problema
     * nr_telefone_solicitante: Telefone particular da pessoa que está abrindo o chamado.
     * ds_finalizado: O técnico deverá colocar na descricao do chamado os serviços que foram realizados. Ex: passagem de cabos...
     * dh_finalizado: Data e Hora da Finalização do Chamado.
     * nr_avaliação: De 1 a 5 estrelas
     * dh_avaliação: Data e Hora da Avaliação
     * ds_avaliação: Quando o chamado receber ate 3 estrelas, o usuário deve informar qual problema ocorreu e justificar aquela nota.
     * vl_chamado: A soma de todos os serviços, despesas e peças e que foram utilizadas para a realização do mesmo.
     * id_status: O técnico deverá sempre atualizar o status do chamado em caso de alguma mudança. Ex: Pausado - Motivo: Aguardando Garantia.
     * dh-agendamento: Quando o chamado for, por exemplo, de treinamento, o técnico deverá agendar a hora e a data para dar o treinamento para os usuários.
     * id_prioridade: Qual o nível de prioridade do chamado.
     * dh_cancelamento: Data e hora do cancelamento do chamado
     * ds_cancelamento: Descrição Obrigatória de porque o chamado está sendo cancelado.
     * dt_prazo: O Chafe da equipe pode estipular uma data limite para o técnico resolver um chamado. Se passar do prazo vai ser emitido um alerta para o chefe.
     */
    function getIdChamado() {
        return $this->idChamado;
    }

    function getIdCategoriaSecundaria() {
        return $this->idCategoriaSecundaria;
    }

    function getIdPessoaSolicitante() {
        return $this->idPessoaSolicitante;
    }

    function getIdPessoaServico() {
        return $this->idPessoaServico;
    }

    function getDhAbertura() {
        return $this->dhAbertura;
    }

    function getDsChamado() {
        return $this->dsChamado;
    }

    function getNrTelefoneSolicitante() {
        return $this->nrTelefoneSolicitante;
    }

    function getDsFinalizado() {
        return $this->dsFinalizado;
    }

    function getDhFinalizado() {
        return $this->dhFinalizado;
    }

    function getNrAvaliacao() {
        return $this->nrAvaliacao;
    }

    function getDhAvaliacao() {
        return $this->dhAvaliacao;
    }

    function getDsAvaliacao() {
        return $this->dsAvaliacao;
    }

    function getVlChamado() {
        return $this->vlChamado;
    }

    function getIdStatus() {
        return $this->idStatus;
    }

    function getDhAgendamento() {
        return $this->dhAgendamento;
    }

    function getIdPrioridade() {
        return $this->idPrioridade;
    }

    function getDhCancelamento() {
        return $this->dhCancelamento;
    }

    function getDsCancelamento() {
        return $this->dsCancelamento;
    }

    function getDtPrazo() {
        return $this->dtPrazo;
    }

    function setIdChamado($idChamado) {
        $this->idChamado = $idChamado;
    }

    function setIdCategoriaSecundaria($idCategoriaSecundaria) {
        $this->idCategoriaSecundaria = $idCategoriaSecundaria;
    }

    function setIdPessoaSolicitante($idPessoaSolicitante) {
        $this->idPessoaSolicitante = $idPessoaSolicitante;
    }

    function setIdPessoaServico($idPessoaServico) {
        $this->idPessoaServico = $idPessoaServico;
    }

    function setDhAbertura($dhAbertura) {
        $this->dhAbertura = $dhAbertura;
    }

    function setDsChamado($dsChamado) {
        $this->dsChamado = $dsChamado;
    }

    function setNrTelefoneSolicitante($nrTelefoneSolicitante) {
        $this->nrTelefoneSolicitante = $nrTelefoneSolicitante;
    }

    function setDsFinalizado($dsFinalizado) {
        $this->dsFinalizado = $dsFinalizado;
    }

    function setDhFinalizado($dhFinalizado) {
        $this->dhFinalizado = $dhFinalizado;
    }

    function setNrAvaliacao($nrAvaliacao) {
        $this->nrAvaliacao = $nrAvaliacao;
    }

    function setDhAvaliacao($dhAvaliacao) {
        $this->dhAvaliacao = $dhAvaliacao;
    }

    function setDsAvaliacao($dsAvaliacao) {
        $this->dsAvaliacao = $dsAvaliacao;
    }

    function setVlChamado($vlChamado) {
        $this->vlChamado = $vlChamado;
    }

    function setIdStatus($idStatus) {
        $this->idStatus = $idStatus;
    }

    function setDhAgendamento($dhAgendamento) {
        $this->dhAgendamento = $dhAgendamento;
    }

    function setIdPrioridade($idPrioridade) {
        $this->idPrioridade = $idPrioridade;
    }

    function setDhCancelamento($dhCancelamento) {
        $this->dhCancelamento = $dhCancelamento;
    }

    function setDsCancelamento($dsCancelamento) {
        $this->dsCancelamento = $dsCancelamento;
    }

    function setDtPrazo($dtPrazo) {
        $this->dtPrazo = $dtPrazo;
    }
    function getSucesso() {
        return $this->sucesso;
    }

    function setSucesso($sucesso) {
        $this->sucesso = $sucesso;
    }
    function getMensagem() {
        return $this->mensagem;
    }

    function setMensagem($mensagem) {
        $this->mensagem = $mensagem;
    }



}
