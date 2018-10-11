<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/orcamento/empenho/DaoFinEmpenho.class.php";

class FinEmpenhoPesquisa {
    
    private $nr_empenho = null;
    private $ano_exercicio = null;
    private $fornecedor = null;
    private $nr_contrato = null;
    private $nr_pedido = null;
    private $tipo_gasto = null;
    private $central = null;
    private $situacao = null;
    
    function getCentral() {
        return $this->central;
    }

    function setCentral($central) {
        $this->central = $central;
        return $this;
    }
    
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
            $daoFinEmpenho->retornaEmpenhos($pdo, $this->filtroSql());
            if ($daoFinEmpenho->sucesso()) {
                foreach ($daoFinEmpenho->getMsgRetorno() as $linha) {
                    $tabela .= '<tr>'
                                . '<td class="text-center">'.$linha['nr_empenho'].'</td>'
                                . '<td class="text-center">'.$linha['nr_pedido'].'</td>'
                                . '<td class="text-center">'.$linha['cpf_cnpj'] . ' - '. $linha['nome_razao'].'</td>'
                                . '<td class="text-center">'.$linha['nm_tipo_empenho'].'</td>'
                                . '<td class="text-center">'.$linha['dt_empenho_safira'].'</td>'
                                . '<td class="text-center">'.$linha['nm_tipo_gasto'].'</td>'
                                . '<td class="text-center">'.$linha['central_demanda'].'</td>'
                                . '<td class="text-center">'.$linha['vl_empenho'].'</td>'
                                . '<td class="text-center">'.$linha['situacao'].'</td>'
                                . '<td class="text-center">'
                                    . '<button type="button" title="Ver Empenho" class="ver-empenho" value='.$linha['id_empenho'].'>'
                                        . '<i class="fa fa-file-text-o text-info" aria-hidden="true"></i>'
                                    . '</button>'
                                . '</td>'
                            . '</tr>';
                }
            } 
            return $tabela;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "alert", STR_ERROR );
        }
    }
    
    private function filtroSql(){

        $array_filtro = array();
        $and_ou_where = '';
        
        try {
            
            if (!empty($this->getNrEmpenho())) {
                $and_ou_where = empty($array_filtro) ? " where " : " and ";
                $array_filtro[] = array(
                    'sql' => $and_ou_where . "emp.nr_empenho ilike :nr_empenho", 
                    'bind' => ':nr_empenho',
                    'valor' => '%'. $this->getNrEmpenho() .'%',
                    'pdo_param' => PDO::PARAM_STR);
            }
            
            if (!empty($this->getAnoExercicio())) {
                $and_ou_where = empty($array_filtro) ? " where " : " and ";
                $array_filtro[] = array(
                    'sql' => $and_ou_where . "to_char(dt_empenho_safira,'YYYY') = :ano_exercicio",
                    'bind' => ':ano_exercicio',
                    'valor' => $this->getAnoExercicio(),
                    'pdo_param' => PDO::PARAM_INT);
            }
            
            if (!empty($this->getFornecedor())) {
                $and_ou_where = empty($array_filtro) ? " where " : " and ";
                $array_filtro[] = array(
                    'sql' => $and_ou_where . "fornec.id_pessoa = :fornecedor",
                    'bind' => ':fornecedor',
                    'valor' => $this->getFornecedor(),
                    'pdo_param' => PDO::PARAM_INT);
            }
            
            if (!empty($this->getNrContrato())) {
                $and_ou_where = empty($array_filtro) ? " where " : " and ";
                $array_filtro[] = array(
                    'sql' => $and_ou_where . "cnt.nr_contrato ilike :nr_contrato", 
                    'bind' => ':nr_contrato',
                    'valor' => '%'. $this->getNrContrato() .'%',
                    'pdo_param' => PDO::PARAM_STR);
            }
            
            if (!empty($this->getNrPedido())) {
                $and_ou_where = empty($array_filtro) ? " where " : " and ";
                $array_filtro[] = array(
                    'sql' => $and_ou_where . "ped.nr_pedido ilike :nr_pedido", 
                    'bind' => ':nr_pedido',
                    'valor' => '%'. $this->getNrPedido() .'%',
                    'pdo_param' => PDO::PARAM_STR);
            }
            
            if (!empty($this->getTipoGasto())) {
                $and_ou_where = empty($array_filtro) ? " where " : " and ";
                $array_filtro[] = array(
                    'sql' => $and_ou_where . "tpGasto.id_tipo_gasto = :tipo_gasto",
                    'bind' => ':tipo_gasto',
                    'valor' => $this->getTipoGasto(),
                    'pdo_param' => PDO::PARAM_INT);
            }
            
            if (!empty($this->getSituacao())) {
                $and_ou_where = empty($array_filtro) ? " where " : " and ";
                $array_filtro[] = array(
                    'sql' => $and_ou_where . "emp.sit_empenho = :situacao",
                    'bind' => ':situacao',
                    'valor' => $this->getSituacao(),
                    'pdo_param' => PDO::PARAM_STR);
            }
            
            if (!empty($this->getCentral())) {
                $and_ou_where = empty($array_filtro) ? " where " : " and ";
                $array_filtro[] = array(
                    'sql' => $and_ou_where . "central.id_lotacao = :central",
                    'bind' => ':central',
                    'valor' => $this->getCentral(),
                    'pdo_param' => PDO::PARAM_INT);
            }
            
            return $array_filtro;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

}

