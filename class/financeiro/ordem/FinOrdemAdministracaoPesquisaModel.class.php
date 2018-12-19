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
            $daoFinOrdemAdministracao->retornaReativacaoAdministracaoOrdem($pdo, $this->condicoes());

            if (!$daoFinOrdemAdministracao->Sucesso()) {
                return "";
            }

            foreach ($daoFinOrdemAdministracao->getMsgRetorno() as $linha) {
                $retorno .= "<tr data-objeto='" . json_encode($linha, JSON_HEX_APOS) . "'>"
                        . "<td class='text-center'>" . $linha['nr_ordem'] . '/' . $linha['aa_ordem'] . "</td>"
                        . "<td class='text-center'>" . $linha['pedido'] . "</td>"
                        . "<td class='text-center'>" . $linha['nr_empenho'] . "</td>"
                        . "<td class='text-center'>" . $linha['fornecedor'] . "</td>"
                        . "<td class='text-center'>" . $linha['nm_tipo_gasto'] . "</td>"
                        . "<td class='text-center'>" . $linha['data_emissao'] . "</td>"
                        . "<td class='text-center'>" . $linha['nm_tipo_gasto'] . "</td>"
                        . "<td class='text-center'>" . $linha['nm_lotacao'] . "</td>"
                        . "<td class='text-center'>" . Metodos::ConverteValorBr($linha['valor'], 4) . "</td>"
                        . "<td class='text-center'>" . $linha['situacao'] . "</td>"
                        . "<td class='text-center'>"
                        . "<button type='button' title='Ver a Reativação' class='ver-reativacao' value='" . $linha["id_ordem_administracao"] . "'><i class='fa fa-file-text-o text-info' aria-hidden='true'></i></button>";

                if ($linha["st_ordem_administracao"] == 1) {
                    $retorno .= "<button type='button' title='Excluir a Reativação' class='excluir' value='" . $linha["id_ordem_administracao"] . "'><i class='fa fa-trash text-danger' aria-hidden='true'></i></button>";
                }


                $retorno .= "</td>";
            }
            return $retorno;
        } catch (Exception $ex) {
            
        }
    }

    private function condicoes() {
        try {
            $condicoes[] = array('ordem.nr_ordem', '=', $this->getNrOrdem(), 'string');
            $condicoes[] = array('ordem.aa_ordem', '=', $this->getAaOrdem(), 'ano');
            $condicoes[] = array('fornecedor.id_pessoa', '=', $this->getFornecedor(), 'int');
            $condicoes[] = array('contrato.nr_contrato', '=', $this->getNrContrato(), 'string');
            $condicoes[] = array('pedido.nr_pedido', '=', $this->getNrPedido(), 'string');
            $condicoes[] = array('empenho.nr_empenho', '=', str_replace("/", "", $this->getNrEmpenho()), 'string');
            $condicoes[] = array('pedido.id_tipo_gasto', '=', $this->getIdTipoGasto(), 'int');
            $condicoes[] = array('pedido.id_lotacao', '=', $this->getCentral(), 'int');
            $condicoes[] = array('admOrdem.st_ordem_administracao', '=', $this->getSituacao(), 'int');
            return Metodos::montaFiltroSQL($condicoes);
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

}
