<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/contabil/liquidacao/DaoConLiquidacao.class.php";

class Liquidacao {

    private $nrLiquidacao = null;
    private $idEmpenho = null;
    private $idLiquidacaoSituacao = null;
    private $idLotacao = null;
    private $idDocTipoLotacao = null;
    private $dtLiquidacao = null;
    private $vlLiquidacao = null;
    private $dsLiquidacao = null;
    private $stAtivo = null;
    
    private $documentos = null;
    
    function getNrLiquidacao() {
        return $this->nrLiquidacao;
    }

    function getIdEmpenho() {
        return $this->idEmpenho;
    }

    function getIdLiquidacaoSituacao() {
        return $this->idLiquidacaoSituacao;
    }

    function getIdLotacao() {
        return $this->idLotacao;
    }

    function getIdDocTipoLotacao() {
        return $this->idDocTipoLotacao;
    }

    function getDtLiquidacao() {
        return $this->dtLiquidacao;
    }

    function getVlLiquidacao() {
        return $this->vlLiquidacao;
    }

    function getDsLiquidacao() {
        return $this->dsLiquidacao;
    }

    function getStAtivo() {
        return $this->stAtivo;
    }

    function getDocumentos() {
        return $this->documentos;
    }

    function setNrLiquidacao($nrLiquidacao) {
        $this->nrLiquidacao = $nrLiquidacao;
        return $this;
    }

    function setIdEmpenho($idEmpenho) {
        $this->idEmpenho = $idEmpenho;
        return $this;
    }

    function setIdLiquidacaoSituacao($idLiquidacaoSituacao) {
        $this->idLiquidacaoSituacao = $idLiquidacaoSituacao;
        return $this;
    }

    function setIdLotacao($idLotacao) {
        $this->idLotacao = $idLotacao;
        return $this;
    }

    function setIdDocTipoLotacao($idDocTipoLotacao) {
        $this->idDocTipoLotacao = $idDocTipoLotacao;
        return $this;
    }

    function setDtLiquidacao($dtLiquidacao) {
        $this->dtLiquidacao = $dtLiquidacao;
        return $this;
    }

    function setVlLiquidacao($vlLiquidacao) {
        $this->vlLiquidacao = $vlLiquidacao;
        return $this;
    }

    function setDsLiquidacao($dsLiquidacao) {
        $this->dsLiquidacao = $dsLiquidacao;
        return $this;
    }

    function setStAtivo($stAtivo) {
        $this->stAtivo = $stAtivo;
        return $this;
    }

    function setDocumentos(FinDocumentoFiscal $documento) {
        $this->documentos[] = $documento;
    }

    
    public function retornaOptionsDocsEmpenho(PDO $pdo = null){
        try {
            $opcoes = "<option value=0>Selecione um Documento Fiscal</option>";
            
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            
            $daoConLiquidacao = new DaoConLiquidacao();
            $daoConLiquidacao->setIdEmpenho($this->getIdEmpenho());
            $daoConLiquidacao->retornaDocumentosPorEmpenho($pdo);
            
            if ($daoConLiquidacao->Sucesso()) {
                foreach ($daoConLiquidacao->getMsgRetorno() as $linha) {
                    $opcoes .= "<option data-objeto='". json_encode($linha)."' value=".$linha['id_documento_fiscal'].">".$linha['nr_documento_fiscal']. ' - ' .$linha['competencia']."</option>";
                }
            }
            return $opcoes;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    
}

