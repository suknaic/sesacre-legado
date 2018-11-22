<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/contabil/liquidacao/DaoConLiquidacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/contabil/liquidacao/DaoConLiquidacaoSituacao.class.php";

class LiquidacaoPesquisa {
    private $nrLiquidacao = null;
    private $anoLiquidacao = null;
    private $contratado = null;
    private $nrContrato = null;
    private $nrPedido = null;
    private $nrEmpenho = null;
    private $nrDocumentoFiscal = null;
    private $tipoGasto = null;
    private $situacao = null;
    private $sitCadastrado = 1;
    private $sitPagoParcial = 2;
    private $sitPago = 3;
    private $sitCancelado = 4;
    private $usuario = null;
    
    function getUsuario() {
        return $this->usuario;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
        return $this;
    }
    
    function getSitCadastrado() {
        return $this->sitCadastrado;
    }

    function getSitPagoParcial() {
        return $this->sitPagoParcial;
    }

    function getSitPago() {
        return $this->sitPago;
    }

    function getSitCancelado() {
        return $this->sitCancelado;
    }

        
    function getNrLiquidacao() {
        return $this->nrLiquidacao;
    }

    function getAnoLiquidacao() {
        return $this->anoLiquidacao;
    }

    function getContratado() {
        return $this->contratado;
    }

    function getNrContrato() {
        return $this->nrContrato;
    }

    function getNrPedido() {
        return $this->nrPedido;
    }

    function getNrEmpenho() {
        return $this->nrEmpenho;
    }

    function getNrDocumentoFiscal() {
        return $this->nrDocumentoFiscal;
    }

    function getTipoGasto() {
        return $this->tipoGasto;
    }

    function getSituacao() {
        return $this->situacao;
    }

    function setNrLiquidacao($nrLiquidacao) {
        $this->nrLiquidacao = $nrLiquidacao;
        return $this;
    }

    function setAnoLiquidacao($anoLiquidacao) {
        $this->anoLiquidacao = $anoLiquidacao;
        return $this;
    }

    function setContratado($contratado) {
        $this->contratado = $contratado;
        return $this;
    }

    function setNrContrato($nrContrato) {
        $this->nrContrato = $nrContrato;
        return $this;
    }

    function setNrPedido($nrPedido) {
        $this->nrPedido = $nrPedido;
        return $this;
    }

    function setNrEmpenho($nrEmpenho) {
        $this->nrEmpenho = $nrEmpenho;
        return $this;
    }

    function setNrDocumentoFiscal($nrDocumentoFiscal) {
        $this->nrDocumentoFiscal = $nrDocumentoFiscal;
        return $this;
    }

    function setTipoGasto($tipoGasto) {
        $this->tipoGasto = $tipoGasto;
        return $this;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
        return $this;
    }
    
    public function retornaOptionsSituacao(){
        $opcoes = "<option value=0>Selecione uma situação</option>";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoConLiquidacaoSituacao = new DaoConLiquidacaoSituacao();
            $daoConLiquidacaoSituacao->retornaTodos($pdo);
            
            if ($daoConLiquidacaoSituacao->Sucesso()) {
                foreach ($daoConLiquidacaoSituacao->getMsgRetorno() as $linha) {
                    $opcoes .= "<option value=".$linha['id_liquidacao_situacao'].">".$linha['nm_liquidacao_situacao']."</option>";   
                }
            }
            return $opcoes;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    
    public function retornaLiquidacoes(){
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            //Só pode visualziar os botões de Edição ou Cancelar Empenho quem tiver Tramitação Empenhar
            $tramitacao = new VincularTramitacao();
            $tramitacao->setIdPessoa($this->usuario);
            $tramitacao->setIdTramitacao($tramitacao->getTramitacaoLiquidar());
            $tramitacao->verificaPessoaTramitacao($pdo);
            $flVisualizaBotoes = false;
            if($tramitacao->Sucesso()){
                $flVisualizaBotoes = true;
            }
            
            //Só pode visualizar o botão de Pagamento quem tiver Tramitação Pagar
            $tramitacao->setIdTramitacao($tramitacao->getTramitacaoPagar());
            $tramitacao->verificaPessoaTramitacao($pdo);
            $flVisualizaBtnPagamento = false;
            if($tramitacao->Sucesso()){
                $flVisualizaBtnPagamento = true;
            }
            
            $daoConLiquidacao = new DaoConLiquidacao();

            $daoConLiquidacao->retornaLiquidacoes($pdo, $this->montaFiltroSql());
            
            if ($daoConLiquidacao->Sucesso()) {
                foreach ($daoConLiquidacao->getMsgRetorno() as $linha) {
                    $cnpj_razao = empty($linha['nr_cnpj']) ? "" : Metodos::formataCnpj($linha['nr_cnpj'])." - ".$linha['nm_fantasia'];
                    $retorno .= "<tr data-id=".$linha['id_liquidacao']." data-objeto='". json_encode($linha)."'>"
                                . "<td class='text-center'>".$linha['nr_liquidacao']."</td>"
                                . "<td class='text-center'>".$linha['nr_pedido']."/".$linha['ano_pedido']."</td>"
                                . "<td class='text-center'>".$linha['nr_empenho']."</td>"
                                . "<td class='text-center'>".$linha['documentos_fiscais']."</td>"
                                . "<td class='text-center'>".$cnpj_razao ."</td>"
                                . "<td class='text-center'>".$linha['dt_liquidacao']."</td>"
                                . "<td class='text-center'>".$linha['vl_liquidacao']."</td>"
                                . "<td class='text-center'>".$linha['nm_liquidacao_situacao']."</td>"
                                . "<td class='text-center'>"
                                    . "<button type='button' title='Ver Liquidação' class='ver-liquidacao' value=".$linha['id_liquidacao'].">"
                                        . "<i class='fa fa-file-text-o text-info' aria-hidden='true'></i>"
                                    . "</button>";
                    if ($flVisualizaBtnPagamento and $linha['id_liquidacao_situacao'] <= 2){
                        $retorno .=  '<button type="button" title="Fazer Pagamento" class="incluir-pagamento" value="'.$linha['nr_liquidacao_sm'].'">'
                                        . '<i class="fa fa-credit-card texto-pagamento" aria-hidden="true"></i>'
                                    . '</button>';
                    }
                    if ($linha['id_liquidacao_situacao'] == $this->getSitCadastrado() and $flVisualizaBotoes) {
                        $retorno .= "<button type='button' title='Editar Liquidação' class='editar-liquidacao' value=".$linha['id_liquidacao'].">"
                                        . "<i class='fa fa-pencil-square-o text-primary' aria-hidden='true'></i>"
                                    . "</button>"
                                    . "<button type='button' title='Excluir Liquidação' class='excluir-liquidacao' value=".$linha['id_liquidacao'].">"
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


    private function montaFiltroSql(){

        $array_filtro = array();
        $and_ou_where = '';
        
        try {
            
            if (!empty($this->getNrDocumentoFiscal())){
                $and_ou_where = empty($array_filtro) ? " where " : " and ";
                $array_filtro[] = array(
                    'sql' => $and_ou_where . "liqDoc.documentos_fiscais ilike :documento", 
                    'bind' => ':documento',
                    'valor' => $this->getNrDocumentoFiscal() .'%',
                    'pdo_param' => PDO::PARAM_STR);
            }
            
            if (!empty($this->getNrLiquidacao())) {
                //removendo barra do numero da Liquidação
                $this->nrLiquidacao = str_replace("/", "", $this->nrLiquidacao);
                //----------------------------------------------------------
                $and_ou_where = empty($array_filtro) ? " where " : " and ";
                $array_filtro[] = array(
                    'sql' => $and_ou_where . "liq.nr_liquidacao ilike :nr_liquidacao", 
                    'bind' => ':nr_liquidacao',
                    'valor' => '%'. $this->getNrLiquidacao() .'%',
                    'pdo_param' => PDO::PARAM_STR);
            }
            
            if (!empty($this->getNrEmpenho())) {
                //removendo barra do numero do empenho
                $this->nrEmpenho = str_replace("/", "", $this->nrEmpenho);
                //----------------------------------------------------------
                $and_ou_where = empty($array_filtro) ? " where " : " and ";
                $array_filtro[] = array(
                    'sql' => $and_ou_where . "emp.nr_empenho ilike :nr_empenho", 
                    'bind' => ':nr_empenho',
                    'valor' => '%'. $this->getNrEmpenho() .'%',
                    'pdo_param' => PDO::PARAM_STR);
            }
            
            if (!empty($this->getAnoLiquidacao())) {
                $and_ou_where = empty($array_filtro) ? " where " : " and ";
                $array_filtro[] = array(
                    'sql' => $and_ou_where . "to_char(liq.dt_liquidacao,'YYYY') = :ano_liquidacao",
                    'bind' => ':ano_liquidacao',
                    'valor' => $this->getAnoLiquidacao(),
                    'pdo_param' => PDO::PARAM_STR);
            }
            
            if (!empty($this->getContratado())) {
                $and_ou_where = empty($array_filtro) ? " where " : " and ";
                $array_filtro[] = array(
                    'sql' => $and_ou_where . "pj.id_pessoa = :contratado",
                    'bind' => ':contratado',
                    'valor' => $this->getContratado(),
                    'pdo_param' => PDO::PARAM_INT);
            }
            
            if (!empty($this->getNrContrato())) {
                $and_ou_where = empty($array_filtro) ? " where " : " and ";
                $array_filtro[] = array(
                    'sql' => $and_ou_where . "contrato.nr_contrato ilike :nr_contrato", 
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
                    'sql' => $and_ou_where . "liq.id_liquidacao_situacao = :situacao",
                    'bind' => ':situacao',
                    'valor' => $this->getSituacao(),
                    'pdo_param' => PDO::PARAM_STR);
            }
            
            return $array_filtro;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
    
}

