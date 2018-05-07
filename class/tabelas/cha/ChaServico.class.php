<?php

class ChaServico {
    
    private $id_servico = null;
    private $id_chamado = null;
    private $id_categoria_secundaria = null;
    private $hr_trabalhadas = null;
    private $ds_ordem_servico = null;
    private $vl_ordem_servico = null;
    private $qt_ordem_servico = null;
    private $vl_total_servico = null;
    private $vl_despesa = null;
    private $ds_despesa = null;
    
    /**
     * hr_trabalhadas: Quantas horas o técnico trabalhou para a realização daquele servico.
     * ds_ordem_servico: Qual categoria secundária será realizada no chamado]
     * vl_ordem_servico: Qual o valor do de cada categoria secundária
     * qt_ordem_servico: Quantas categorias secundárias foram realizadas
     * vl_total_servico: Soma do valor da categoria secundária vezes a quantidade de vezes que ela foi realizada
     * vl_despesa: Valor total de quanto foi gasto com despesas para a realização do chamado.  Ex: R$ 500,00
     * ds_despesa: Descriminação das despesas informando com o que foi gasto. Ex: diárias, passagens, gasolina, etc.
     */
    
    function getId_servico() {
        return $this->id_servico;
    }

    function getId_chamado() {
        return $this->id_chamado;
    }

    function getId_categoria_secundaria() {
        return $this->id_categoria_secundaria;
    }

    function getHr_trabalhadas() {
        return $this->hr_trabalhadas;
    }

    function getDs_ordem_servico() {
        return $this->ds_ordem_servico;
    }

    function getVl_ordem_servico() {
        return $this->vl_ordem_servico;
    }

    function getQt_ordem_servico() {
        return $this->qt_ordem_servico;
    }

    function getVl_total_servico() {
        return $this->vl_total_servico;
    }

    function getVl_despesa() {
        return $this->vl_despesa;
    }

    function getDs_despesa() {
        return $this->ds_despesa;
    }

    function setId_servico($id_servico) {
        $this->id_servico = $id_servico;
    }

    function setId_chamado($id_chamado) {
        $this->id_chamado = $id_chamado;
    }

    function setId_categoria_secundaria($id_categoria_secundaria) {
        $this->id_categoria_secundaria = $id_categoria_secundaria;
    }

    function setHr_trabalhadas($hr_trabalhadas) {
        $this->hr_trabalhadas = $hr_trabalhadas;
    }

    function setDs_ordem_servico($ds_ordem_servico) {
        $this->ds_ordem_servico = $ds_ordem_servico;
    }

    function setVl_ordem_servico($vl_ordem_servico) {
        $this->vl_ordem_servico = $vl_ordem_servico;
    }

    function setQt_ordem_servico($qt_ordem_servico) {
        $this->qt_ordem_servico = $qt_ordem_servico;
    }

    function setVl_total_servico($vl_total_servico) {
        $this->vl_total_servico = $vl_total_servico;
    }

    function setVl_despesa($vl_despesa) {
        $this->vl_despesa = $vl_despesa;
    }

    function setDs_despesa($ds_despesa) {
        $this->ds_despesa = $ds_despesa;
    }

}
