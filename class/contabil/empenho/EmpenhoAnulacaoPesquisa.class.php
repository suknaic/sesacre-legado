<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/contabil/empenho/anulacao/DaoConEmpenhoAnulacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/contabil/empenho/anulacao/DaoConEmpenhoAnulacaoSituacao.class.php";

class EmpenhoAnulacaoPesquisa {

    private $nr_empenho_anulacao = null;
    private $ano_empenho_anulacao = null;
    private $id_fornecedor = null;
    private $nr_contrato = null;
    private $nr_pedido = null;
    private $nr_empenho = null;
    private $central_demanda = null;
    private $tipo_gasto = null;
    private $situacao = null;
    
    function getNrEmpenhoAnulacao() {
        return $this->nr_empenho_anulacao;
    }

    function getAnoEmpenhoAnulacao() {
        return $this->ano_empenho_anulacao;
    }

    function getIdFornecedor() {
        return $this->id_fornecedor;
    }

    function getNrContrato() {
        return $this->nr_contrato;
    }

    function getNrPedido() {
        return $this->nr_pedido;
    }

    function getNrEmpenho() {
        return $this->nr_empenho;
    }

    function getCentralDemanda() {
        return $this->central_demanda;
    }

    function getTipoGasto() {
        return $this->tipo_gasto;
    }

    function getSituacao() {
        return $this->situacao;
    }

    function setNrEmpenhoAnulacao($nr_empenho_anulacao) {
        $this->nr_empenho_anulacao = $nr_empenho_anulacao;
        return $this;
    }

    function setAnoEmpenhoAnulacao($ano_empenho_anulacao) {
        $this->ano_empenho_anulacao = $ano_empenho_anulacao;
        return $this;
    }

    function setIdFornecedor($id_fornecedor) {
        $this->id_fornecedor = $id_fornecedor;
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

    function setNrEmpenho($nr_empenho) {
        $this->nr_empenho = $nr_empenho;
        return $this;
    }

    function setCentralDemanda($central_demanda) {
        $this->central_demanda = $central_demanda;
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

    function retornaOptionsEmpenhoAnulacaoSituacoes(){
        $options = "<option value='0'>Selecione uma situação</option>";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoEmpenhoAnulacaoSituacao = new DaoConEmpenhoAnulacaoSituacao();
            $daoEmpenhoAnulacaoSituacao->retornaTodos($pdo);
            if ($daoEmpenhoAnulacaoSituacao->getSucesso()) {
                foreach ($daoEmpenhoAnulacaoSituacao->getMsgRetorno() as $linha) {
                    $options .= "<option value=".$linha['id_empenho_anulacao_situacao'].">".$linha['nm_empenho_anulacao_situacao']."</option>";
                }
            }
            return $options;
        } catch (Exception $exc) {
            return $exc->getMessage();
        }
    }
    
    function retornaAnulacoes(){
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $tabela = '';
            $daoConEmpenhoAnulacao = new DaoConEmpenhoAnulacao();
            $daoConEmpenhoAnulacao->retornaPesquisaEmpenhoAnulacao($pdo, $this->filtroSql());
            if ($daoConEmpenhoAnulacao->getSucesso()) {
                foreach ($daoConEmpenhoAnulacao->getMsgRetorno() as $linha) {
                    $cpf_cnpj_mascarado = !empty($linha['doc_fornecedor']) ? Metodos::formataCnpj($linha['doc_fornecedor']) : "";
                    $tabela .= '<tr>'
                                . '<td class="text-center">'.$linha['nr_empenho_anulacao'].'</td>'
                                . '<td class="text-center">'.$linha['nr_empenho'].'</td>'
                                . '<td class="text-center">'.$linha['nr_pedido'].'</td>'
                                . '<td class="text-center">'.$cpf_cnpj_mascarado . ' - '. $linha['nm_fornecedor'].'</td>'
                                . '<td class="text-center">'.$linha['nm_tipo_gasto'].'</td>'
                                . '<td class="text-center">'.$linha['nm_lotacao'].'</td>'                                
                                . '<td class="text-center">'.$linha['dt_empenho_anulacao'].'</td>'
                                . '<td class="text-center">'.$linha['vl_empenho_anulacao'].'</td>'
                                . '<td class="text-center">'.$linha['nm_empenho_anulacao_situacao'].'</td>'
                                . '<td class="text-center">'
                                    . '<button type="button" title="Ver Anulação do Empenho" class="ver-anulacao-empenho" value='.$linha['id_empenho_anulacao'].'>'
                                        . '<i class="fa fa-file-text-o text-info" aria-hidden="true"></i>'
                                    . '</button>'
                                .'</td>'
                            . '</tr>';                    
                    }
                }
            return $tabela;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "alert", STR_ERROR );
        }
    }
    
    function retornaAnulacoesAutorizacao(){
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $tabela = '';
            $daoConEmpenhoAnulacao = new DaoConEmpenhoAnulacao();
            $daoConEmpenhoAnulacao->retornaPesquisaEmpenhoAnulacao($pdo, $this->filtroSql());
            if ($daoConEmpenhoAnulacao->getSucesso()) {
                foreach ($daoConEmpenhoAnulacao->getMsgRetorno() as $linha) {
                    $cpf_cnpj_mascarado = !empty($linha['doc_fornecedor']) ? Metodos::formataCnpj($linha['doc_fornecedor']) : "";
                    $tabela .= '<tr>'
                                . '<td class="text-center">'.$linha['nr_empenho_anulacao'].'</td>'
                                . '<td class="text-center">'.$linha['nr_empenho'].'</td>'
                                . '<td class="text-center">'.$linha['nr_pedido'].'</td>'
                                . '<td class="text-center">'.$cpf_cnpj_mascarado . ' - '. $linha['nm_fornecedor'].'</td>'    
                                . '<td class="text-center">'.$linha['nm_tipo_gasto'].'</td>'                                
                                . '<td class="text-center">'.$linha['nm_lotacao'].'</td>'                                
                                . '<td class="text-center">'.$linha['dt_empenho_anulacao'].'</td>'
                                . '<td class="text-center">'.$linha['vl_empenho_anulacao'].'</td>'
                                . '<td class="text-center">'.$linha['nm_empenho_anulacao_situacao'].'</td>'
                                . '<td class="text-center">'
                                    . '<button type="button" title="Ver do Anulação do Empenho" class="ver-anulacao-empenho" value='.$linha['id_empenho_anulacao'].'>'
                                        . '<i class="fa fa-file-text-o text-info" aria-hidden="true"></i>'
                                    . '</button>';
                    
                        if ($linha['id_empenho_anulacao_situacao'] == 1) {
                            $tabela .=  '<button type="button" title="Autorizar Anulação do Empenho" class="autorizar-anulacao-empenho" value='.$linha['id_empenho_anulacao'].'>'
                                        . '<i class="fa fa-gavel text-info" aria-hidden="true"></i>'
                                    . '</button>';
                        }
                                    
                        $tabela .= '</td>'
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
            
            if (!empty($this->getNrEmpenhoAnulacao())) {
                $and_ou_where = empty($array_filtro) ? " where " : " and ";
                $array_filtro[] = array(
                    'sql' => $and_ou_where . "anulacaoEmp.nr_empenho_anulacao ilike :nr_empenho_anulacao", 
                    'bind' => ':nr_empenho_anulacao',
                    'valor' => '%'. $this->getNrEmpenhoAnulacao() .'%',
                    'pdo_param' => PDO::PARAM_STR);
            }
            
            if (!empty($this->getNrEmpenho())) {
                $and_ou_where = empty($array_filtro) ? " where " : " and ";
                $array_filtro[] = array(
                    'sql' => $and_ou_where . "emp.nr_empenho ilike :nr_empenho", 
                    'bind' => ':nr_empenho',
                    'valor' => '%'. $this->getNrEmpenho() .'%',
                    'pdo_param' => PDO::PARAM_STR);
            }
            
            if (!empty($this->getAnoEmpenhoAnulacao())) {
                $and_ou_where = empty($array_filtro) ? " where " : " and ";
                $array_filtro[] = array(
                    'sql' => $and_ou_where . "to_char(dh_empenho_anulacao,'YYYY') = :ano_empenho_anulacao",
                    'bind' => ':ano_empenho_anulacao',
                    'valor' => $this->getAnoEmpenhoAnulacao(),
                    'pdo_param' => PDO::PARAM_INT);
            }
            
            if (!empty($this->getIdFornecedor())) {
                $and_ou_where = empty($array_filtro) ? " where " : " and ";
                $array_filtro[] = array(
                    'sql' => $and_ou_where . "fornecedor.id_pessoa = :id_fornecedor",
                    'bind' => ':id_fornecedor',
                    'valor' => $this->getIdFornecedor(),
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
                    'sql' => $and_ou_where . "anulacaoEmp.id_empenho_anulacao_situacao = :id_empenho_anulacao_situacao",
                    'bind' => ':id_empenho_anulacao_situacao',
                    'valor' => $this->getSituacao(),
                    'pdo_param' => PDO::PARAM_INT);
            }
            
            if (!empty($this->getCentralDemanda())) {
                $and_ou_where = empty($array_filtro) ? " where " : " and ";
                $array_filtro[] = array(
                    'sql' => $and_ou_where . "central.id_lotacao = :central",
                    'bind' => ':central',
                    'valor' => $this->getCentralDemanda(),
                    'pdo_param' => PDO::PARAM_INT);
            }
            
            return $array_filtro;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
}


