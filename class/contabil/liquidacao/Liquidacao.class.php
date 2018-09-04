<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/contabil/liquidacao/DaoConLiquidacao.class.php";

class Liquidacao {

    private $idLiquidacao = null;
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
    
    function getIdLiquidacao() {
        return $this->idLiquidacao;
    }

    function setIdLiquidacao($idLiquidacao) {
        $this->idLiquidacao = $idLiquidacao;
        return $this;
    }
    
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

    function setDocumentos($documento) {
        $this->documentos = $documento;
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

    
    public function salvarLiquidacao(){
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $daoConLiquidacao = new DaoConLiquidacao();
            $daoConLiquidacao->setIdEmpenho($this->getIdEmpenho())
                             ->setIdLiquidacaoSituacao(1)
                             ->setIdLotacao($this->getIdLotacao())
                             ->setIdDocTipoLotacao($this->getIdDocTipoLotacao())
                             ->setNrLiquidacao($this->getNrLiquidacao())
                             ->setDtLiquidacao($this->getDtLiquidacao())
                             ->setVlLiquidacao($this->getVlLiquidacao())
                             ->setDsLiquidacao($this->getDsLiquidacao());
            
            $daoConLiquidacao->insert($pdo);
            
            if ($daoConLiquidacao->getSucesso()) {
                $idLiquidacao = $pdo->lastInsertId('con_liquidacao_id_liquidacao_seq');
                if (!Log::SalvaLogI('con_liquidacao', $idLiquidacao, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", "Erro ao Salvar a Liquidação no LOG. Operação Cadastro.");
                }
                $this->setIdLiquidacao($idLiquidacao);
                
                //percorre Documentos da Liquidação
                if ($this->getDocumentos()) {
                    
                    //Objetos
                    $liquidacaoDoc = new LiquidacaoDoc();
                    
                    $liquidacaoDoc->setIdLiquidacao($this->getIdLiquidacao());
                    
                    foreach ($this->getDocumentos() as $indice => $documento) {
                        $liquidacaoDoc->setIdDocumentoFiscal($documento[$indice]);
                        $liquidacaoDoc->salvarLiquidacaoDoc($pdo);
                    }
                }
            } else {
                return Metodos::retornoAjax("Erro", "alert", $daoConLiquidacao->getMsgRetorno());
            }
           
            
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
    
    
    
}

