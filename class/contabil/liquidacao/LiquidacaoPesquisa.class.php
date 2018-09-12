<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/contabil/liquidacao/DaoConLiquidacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/contabil/liquidacao/DaoConLiquidacaoSituacao.class.php";

class LiquidacaoPesquisa {
    private $nrLiquidacao = null;
    private $anoLiquidacao = null;
    private $contratado = null;
//    private $nrProtocolo = null;
    private $nrContrato = null;
    private $nrPedido = null;
    private $nrEmpenho = null;
    private $nrDocumentoFiscal = null;
    private $tipoGasto = null;
    private $situacao = null;
    
    private $sitLiquidado = 1;
    private $sitPagoParcial = 2;
    private $sitPago = 3;
    private $sitCancelado = 4;
    
    function getSitLiquidado() {
        return $this->sitLiquidado;
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

//    function getNrProtocolo() {
//        return $this->nrProtocolo;
//    }

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

//    function setNrProtocolo($nrProtocolo) {
//        $this->nrProtocolo = $nrProtocolo;
//        return $this;
//    }

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
            
            $daoConLiquidacao = new DaoConLiquidacao();
//            echo '<pre>';
//            print_r($this->montaFiltroSql());
//            echo '</pre>';
//            return;
            $daoConLiquidacao->retornaLiquidacoes($pdo, $this->montaFiltroSql());
            
            if ($daoConLiquidacao->Sucesso()) {
                foreach ($daoConLiquidacao->getMsgRetorno() as $linha) {
                    $retorno .= "<tr data-id=".$linha['id_liquidacao']." data-objeto='". json_encode($linha)."'>"
                                . "<td class='text-center'>".$linha['nr_liquidacao']."</td>"
                                . "<td class='text-center'>".$linha['nr_pedido']."</td>"
                                . "<td class='text-center'>".$linha['nr_empenho']."</td>"
                                . "<td class='text-center'>".$linha['documentos_fiscais']."</td>"
                                . "<td class='text-center'>".$linha['nr_cnpj']." - ".$linha['nm_fantasia']."</td>"
                                . "<td class='text-center'>".$linha['dt_liquidacao']."</td>"
                                . "<td class='text-center'>".$linha['vl_liquidacao']."</td>"
                                . "<td class='text-center'>".$linha['nm_liquidacao_situacao']."</td>"
                                . "<td class='text-center'>"
                                    . "<button type='button' title='Ver Liquidação' class='ver-liquidacao' value=".$linha['id_liquidacao'].">"
                                        . "<i class='fa fa-file-text-o text-info' aria-hidden='true'></i>"
                                    . "</button>";
                    if ($linha['id_liquidacao_situacao'] == $this->getSitLiquidado()) {
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
        $filtro = "";
 
       
        if ($this->getNrLiquidacao()) {
            
            $filtro .= (empty($filtro)) ? " where liq.nr_liquidacao ilike '%".$this->getNrLiquidacao()."%' " : " and liq.nr_liquidacao ilike '%".$this->getNrLiquidacao()."%' " ; 
        }
        
        if ($this->getAnoLiquidacao()) {
            $filtro .= (empty($filtro)) ? " where extract(year from liq.dt_liquidacao) = ".$this->getAnoLiquidacao() : "and extract(year from liq.dt_liquidacao) = ".$this->getAnoLiquidacao();
        }
        
        if ($this->getContratado()) {
            $filtro .= (empty($filtro)) ? " where pj.id_pessoa = ".$this->getContratado() : " and pj.id_pessoa = ".$this->getContratado(); 
        }
        
        if($this->getSituacao()){
            $filtro .= (empty($filtro)) ? " where liq.id_liquidacao_situacao = ".$this->getSituacao() : " and liq.id_liquidacao_situacao = ".$this->getSituacao(); 
        }
        
//        if ($this->getNrProtocolo()) {
//        }
        
        if ($this->getNrContrato()) {
            $filtro .= (empty($filtro)) ? " where contrato.nr_contrato ilike '%".$this->getNrContrato()."%' " : " and contrato.nr_contrato ilike '%".$this->getNrContrato()."%' " ; 
        }
        
        if ($this->getNrPedido()) {
            $filtro .= (empty($filtro)) ? " where ped.nr_pedido ilike '%".$this->getNrPedido()."%' " : " and ped.nr_pedido ilike '%".$this->getNrPedido()."%' " ; 
        }
        
        if ($this->getNrEmpenho()) {
            $filtro .= (empty($filtro)) ? " where emp.nr_empenho ilike '%".$this->getNrEmpenho()."%' " : " and emp.nr_empenho ilike '%".$this->getNrEmpenho()."%' " ; 
        }
        
        if ($this->getNrDocumentoFiscal()) {
            $filtro .= (empty($filtro)) ? " where docFis.nr_documento_fiscal ilike '%".$this->getNrDocumentoFiscal()."%' " : " and docFis.nr_documento_fiscal ilike '%".$this->getNrDocumentoFiscal()."%' " ; 
        }
        
        return $filtro;
    }
}

