<?php
        
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/gdof/DaoFinDocumentoSituacao.class.php";

class DocumentoSituacao {

    private $idDocumentoSituacao = null;
    private $nmSituacao = null;
    private $stAtivo = null;
    
    function getIdDocumentoSituacao() {
        return $this->idDocumentoSituacao;
    }

    function getNmSituacao() {
        return $this->nmSituacao;
    }

    function getStAtivo() {
        return $this->stAtivo;
    }

    function setIdDocumentoSituacao($idDocumentoSituacao) {
        $this->idDocumentoSituacao = $idDocumentoSituacao;
        return $this;
    }

    function setNmSituacao($nmSituacao) {
        $this->nmSituacao = $nmSituacao;
        return $this;
    }

    function setStAtivo($stAtivo) {
        $this->stAtivo = $stAtivo;
        return $this;
    }

    function situacoesOptions(){
        try {
            $retorno = "<option value=0>Selecione uma Situação do Documento Fiscal</option>";
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoFinDocumentoSituacao = new DaoFinDocumentoSituacao();
            
            if ($this->getIdDocumentoSituacao()) {
                $daoFinDocumentoSituacao->setIdDocumentoSituacao($this->getIdDocumentoSituacao());
            }
            $daoFinDocumentoSituacao->select($pdo);
            
            if ($daoFinDocumentoSituacao->getSucesso()) {
                foreach ($daoFinDocumentoSituacao->getMsgRetorno() as $linha) {
                    $retorno .= "<option value=".$linha['id_documento_situacao'].">".$linha['nm_situacao']."</option>";
                }
            } else {
                $retorno = $daoFinDocumentoSituacao->getMsgRetorno();
            }
            
            return $retorno;
            
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console",$exc->getMessage());
        }
    }

}

