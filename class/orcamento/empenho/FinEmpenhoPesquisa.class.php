<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/orcamento/empenho/DaoFinEmpenho.class.php";

class FinEmpenhoPesquisa {
    
    private $nr_empenho = null;
    private $ano_exercicio = null;
    private $fornecedor = null;
    private $nr_contrato = null;
    private $nr_pedido = null;
    private $tipo_gasto = null;
    private $situacao = null;
    
    function getNrEmpenho() {
        return $this->nr_empenho;
    }

    function getAnoExercicio() {
        return $this->ano_exercicio;
    }

    function getFornecedor() {
        return $this->fornecedor;
    }

    function getNrContrato() {
        return $this->nr_contrato;
    }

    function getNrPedido() {
        return $this->nr_pedido;
    }

    function getTipoGasto() {
        return $this->tipo_gasto;
    }

    function getSituacao() {
        return $this->situacao;
    }

    function setNrEmpenho($nr_empenho) {
        $this->nr_empenho = $nr_empenho;
        return $this;
    }

    function setAnoExercicio($ano_exercicio) {
        $this->ano_exercicio = $ano_exercicio;
        return $this;
    }

    function setFornecedor($fornecedor) {
        $this->fornecedor = $fornecedor;
        return $this;
    }

    function setNrContrato($nr_contrato) {
        $this->nr_contrato = $nr_contrato;
        return $this;
    }

    function setNrPedido($nr_pedido) {
        $this->nr_pedido = $nr_pedido;
        return $this;
    }

    function setTipoGasto($tipo_gasto) {
        $this->tipo_gasto = $tipo_gasto;
        return $this;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
        return $this;
    }

    private function getSituacoes() : array {
        $situacoes = array(
            '1' => 'Cadastrado',
            '2' => 'Liquidado Parcial',
            '3' => 'Liquidado Total',
            '4' => 'Pago Parcial',
            '5' => 'Pago Total',
            '6' => 'Cancelado'
        );
        return $situacoes;
    }
    
    function optionsSituacao(){
        $opcoes = '<option value="0">Selecione uma situação</option>';
        foreach ($this->getSituacoes() as $indice => $valor) {
            $opcoes .= '<option value='.$indice.'>'.$valor.'</option>';
        }
        return $opcoes;
    }
    
    function retornaEmpenhos(){
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $tabela = '';
            $daoFinEmpenho = new DaoFinEmpenho();
            $daoFinEmpenho->retornaEmpenhos($pdo);
            if ($daoFinEmpenho->sucesso()) {
                foreach ($daoFinEmpenho->getMsgRetorno() as $linha) {
                    $tabela .= '<tr>'
                                . '<td class="text-center">'.$linha['nr_empenho'].'</td>'
                                . '<td class="text-center">'.$linha['nr_pedido'].'</td>'
                                . '<td class="text-center">'.$linha['cpf_cnpj'] . ' - '. $linha['nome_razao'].'</td>'
                                . '<td class="text-center">'.$linha['nm_tipo_empenho'].'</td>'
                                . '<td class="text-center">'.$linha['competencia'].'</td>'
                                . '<td class="text-center">'.$linha['dt_empenho_safira'].'</td>'
                                . '<td class="text-center">'.$linha['vl_empenho'].'</td>'
                                . '<td class="text-center">'.$linha['situacao'].'</td>'
                                . '<td class="text-center"></td>'
                            . '</tr>';
                }
            } else {
                return Metodos::retornoAjax("Erro", "alert", $daoFinEmpenho->getMsgRetorno() );
            }
            return $tabela;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "alert", STR_ERROR );
        }
    }

}

