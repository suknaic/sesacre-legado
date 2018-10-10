<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/contabil/pagamento/DaoConPagamento.class.php";

class PagamentoPesquisa {

    private $numero_pagamento = null;
    private $numero_contrato = null;
    private $numero_documento_fiscal = null;
    private $execio_pagamento = null;
    private $fornecedor = null;
    private $numero_pedido = null;
    private $numero_empenho = null;
    private $tipo_gato = null;
    private $situacao = null;

    function getNumero_pagamento() {
        return $this->numero_pagamento;
    }

    function getNumero_contrato() {
        return $this->numero_contrato;
    }

    function getNumero_documento_fiscal() {
        return $this->numero_documento_fiscal;
    }

    function getExecio_pagamento() {
        return $this->execio_pagamento;
    }

    function getFornecedor() {
        return $this->fornecedor;
    }

    function getNumero_pedido() {
        return $this->numero_pedido;
    }

    function getNumero_empenho() {
        return $this->numero_empenho;
    }

    function getTipo_gato() {
        return $this->tipo_gato;
    }

    function getSituacao() {
        return $this->situacao;
    }

    function setNumero_pagamento($numero_pagamento) {
        $this->numero_pagamento = $numero_pagamento;
    }

    function setNumero_contrato($numero_contrato) {
        $this->numero_contrato = $numero_contrato;
    }

    function setNumero_documento_fiscal($numero_documento_fiscal) {
        $this->numero_documento_fiscal = $numero_documento_fiscal;
    }

    function setExecio_pagamento($execio_pagamento) {
        $this->execio_pagamento = $execio_pagamento;
    }

    function setFornecedor($fornecedor) {
        $this->fornecedor = $fornecedor;
    }

    function setNumero_pedido($numero_pedido) {
        $this->numero_pedido = $numero_pedido;
    }

    function setNumero_empenho($numero_empenho) {
        $this->numero_empenho = $numero_empenho;
    }

    function setTipo_gato($tipo_gato) {
        $this->tipo_gato = $tipo_gato;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    public function retornaPagamento() {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $daoConPagamento = new DaoConPagamento();

            $daoConPagamento->retornaLiquidacoes($pdo, $this->montaFiltroSql());

            if ($daoConLiquidacao->Sucesso()) {
                foreach ($daoConLiquidacao->getMsgRetorno() as $linha) {
                    $cnpj_razao = empty($linha['nr_cnpj']) ? "" : Metodos::formataCnpj($linha['nr_cnpj']) . " - " . $linha['nm_fantasia'];
                    $retorno .= "<tr data-id=" . $linha['id_liquidacao'] . " data-objeto='" . json_encode($linha) . "'>"
                            . "<td class='text-center'>" . $linha['nr_liquidacao'] . "</td>"
                            . "<td class='text-center'>" . $linha['nr_pedido'] . "</td>"
                            . "<td class='text-center'>" . $linha['nr_empenho'] . "</td>"
                            . "<td class='text-center'>" . $linha['documentos_fiscais'] . "</td>"
                            . "<td class='text-center'>" . $cnpj_razao . "</td>"
                            . "<td class='text-center'>" . $linha['dt_liquidacao'] . "</td>"
                            . "<td class='text-center'>" . $linha['vl_liquidacao'] . "</td>"
                            . "<td class='text-center'>" . $linha['nm_liquidacao_situacao'] . "</td>"
                            . "<td class='text-center'>"
                            . "<button type='button' title='Ver Liquidação' class='ver-liquidacao' value=" . $linha['id_liquidacao'] . ">"
                            . "<i class='fa fa-file-text-o text-info' aria-hidden='true'></i>"
                            . "</button>";
                    if ($linha['id_liquidacao_situacao'] == $this->getSitLiquidado()) {
                        $retorno .= "<button type='button' title='Editar Liquidação' class='editar-liquidacao' value=" . $linha['id_liquidacao'] . ">"
                                . "<i class='fa fa-pencil-square-o text-primary' aria-hidden='true'></i>"
                                . "</button>"
                                . "<button type='button' title='Excluir Liquidação' class='excluir-liquidacao' value=" . $linha['id_liquidacao'] . ">"
                                . "<i class='fa fa-trash text-danger' aria-hidden='true'></i>"
                                . "</button>";
                    }
                    $retorno .= "</td></tr>";
                }
            }

            return $retorno;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

}
