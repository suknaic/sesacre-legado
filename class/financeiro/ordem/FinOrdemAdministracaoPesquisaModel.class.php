<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/ordem/DaoFinOrdemAdministracao.php";

class FinOrdemAdministracaoPesquisaModel {

    private $nr_ordem = null;
    private $aa_ordem = null;
    private $fornecedor = null;
    private $nr_contrato = null;
    private $nr_pedido = null;
    private $nr_empenho = null;
    private $central = null;
    private $id_tipo_gasto = null;
    private $situacao = null;

    public function getNrOrdem() {
        return $this->nr_ordem;
    }

    public function setNrOrdem($nr_ordem) {
        $this->nr_ordem = $nr_ordem;

        return $this;
    }

    public function getAaOrdem() {
        return $this->aa_ordem;
    }

    public function setAaOrdem($aa_ordem) {
        $this->aa_ordem = $aa_ordem;

        return $this;
    }

    public function getFornecedor() {
        return $this->fornecedor;
    }

    public function setFornecedor($fornecedor) {
        $this->fornecedor = $fornecedor;

        return $this;
    }

    public function getNrContrato() {
        return $this->nr_contrato;
    }

    public function setNrContrato($nr_contrato) {
        $this->nr_contrato = $nr_contrato;

        return $this;
    }

    public function getNrPedido() {
        return $this->nr_pedido;
    }

    public function setNrPedido($nr_pedido) {
        $this->nr_pedido = $nr_pedido;

        return $this;
    }

    public function getNrEmpenho() {
        return $this->nr_empenho;
    }

    public function setNrEmpenho($nr_empenho) {
        $this->nr_empenho = $nr_empenho;

        return $this;
    }

    public function getCentral() {
        return $this->central;
    }

    public function setCentral($central) {
        $this->central = $central;

        return $this;
    }

    public function getIdTipoGasto() {
        return $this->id_tipo_gasto;
    }

    public function setIdTipoGasto($id_tipo_gasto) {
        $this->id_tipo_gasto = $id_tipo_gasto;

        return $this;
    }

    public function getSituacao() {
        return $this->situacao;
    }

    public function setSituacao($situacao) {
        $this->situacao = $situacao;

        return $this;
    }

    public function retornaPesquisaOrdemAdministracao() {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $daoFinOrdemAdministracao = new DaoFinOrdemAdministracao();
        } catch (Exception $ex) {
            
        }
    }

    private function montaFiltroSql() {
        $filtro = "";


        if ($this->getNumero_pagamento()) {
            //removendo barra do numero do pagamento
            $this->numero_pagamento = str_replace("/", "", $this->numero_pagamento);
            //----------------------------------------------------------
            $filtro .= (empty($filtro)) ? " where pagamento.nr_pagamento ilike '%" . $this->getNumero_pagamento() . "%' " : " and pagamento.nr_pagamento '%" . $this->getNumero_pagamento() . "%' ";
        }

        if ($this->getExecio_pagamento()) {
            $filtro .= (empty($filtro)) ? " where extract(year from pagamento.dt_pagamento) = " . $this->getExecio_pagamento() : "and extract(year from pagamento.dt_pagamento) = " . $this->getExecio_pagamento();
        }

        if ($this->getFornecedor()) {
            $filtro .= (empty($filtro)) ? " where pj.id_pessoa = " . $this->getFornecedor() : " and pj.id_pessoa = " . $this->getFornecedor();
        }

        if ($this->getSituacao()) {
            $filtro .= (empty($filtro)) ? " where pagamento.id_pagamento_situacao = " . $this->getSituacao() : " and pagamento.id_pagamento_situacao = " . $this->getSituacao();
        }

        if ($this->getTipo_gato()) {
            $filtro .= (empty($filtro)) ? " where tpGasto.id_tipo_gasto = " . $this->getTipoGasto() : " and tpGasto.id_tipo_gasto = " . $this->getTipoGasto();
        }

        if ($this->getNumero_contrato()) {
            $filtro .= (empty($filtro)) ? " where contrato.nr_contrato ilike '%" . $this->getNumero_contrato() . "%' " : " and contrato.nr_contrato ilike '%" . $this->getNumero_contrato() . "%' ";
        }

        if ($this->getNumero_pedido()) {
            $filtro .= (empty($filtro)) ? " where pedido.nr_pedido ilike '%" . $this->getNumero_pedido() . "%' " : " and pedido.nr_pedido ilike '%" . $this->getNumero_pedido() . "%' ";
        }

        if ($this->getNumero_empenho()) {
            //removendo barra do numero do empenho
            $this->numero_empenho = str_replace("/", "", $this->numero_empenho);
            //----------------------------------------------------------
            $filtro .= (empty($filtro)) ? " where empenho.nr_empenho ilike '%" . $this->getNumero_empenho() . "%' " : " and empenho.nr_empenho ilike '%" . $this->getNumero_empenho() . "%' ";
        }

        if ($this->getNumero_liquidacao()) {
            //removendo barra do numero da liquidação
            $this->numero_liquidacao = str_replace("/", "", $this->numero_liquidacao);
            //----------------------------------------------------------
            $filtro .= (empty($filtro)) ? " where liquidacao.nr_liquidacao ilike '%" . $this->getNumero_liquidacao() . "%' " : " and liquidacao.nr_liquidacao ilike '%" . $this->getNumero_liquidacao() . "%' ";
        }

        return $filtro;
    }

}
