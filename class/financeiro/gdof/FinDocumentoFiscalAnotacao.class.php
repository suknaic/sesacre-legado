<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/gdof/DaoFinDocumentoFiscalAnotacao.class.php";

class FinDocumentoFiscalAnotacao {

    private $id_documento_fiscal_anotacao = null;
    private $id_pessoa = null;
    private $id_documento_fiscal = null;
    private $dh_documento_fiscal_anotacao = null;
    private $ds_documento_fiscal_anotacao = null;

    function getIdDocumentoFiscalAnotacao() {
        return $this->id_documento_fiscal_anotacao;
    }

    function getIdPessoa() {
        return $this->id_pessoa;
    }

    function getIdDocumentoFiscal() {
        return $this->id_documento_fiscal;
    }

    function getDhDocumentoFiscalAnotacao() {
        return $this->dh_documento_fiscal_anotacao;
    }

    function getDsFocumentoFiscalAnotacao() {
        return $this->ds_documento_fiscal_anotacao;
    }

    function setIdDocumentoFiscalAnotacao($id_documento_fiscal_anotacao) {
        $this->id_documento_fiscal_anotacao = $id_documento_fiscal_anotacao;
        return $this;
    }

    function setIdPessoa($id_pessoa) {
        $this->id_pessoa = $id_pessoa;
        return $this;
    }

    function setIdDocumentoFiscal($id_documento_fiscal) {
        $this->id_documento_fiscal = $id_documento_fiscal;
        return $this;
    }

    function setDhDocumentoFiscalAnotacao($dh_documento_fiscal_anotacao) {
        $this->dh_documento_fiscal_anotacao = $dh_documento_fiscal_anotacao;
        return $this;
    }

    function setDsDocumentoFiscalAnotacao($ds_documento_fiscal_anotacao) {
        $this->ds_documento_fiscal_anotacao = $ds_documento_fiscal_anotacao;
        return $this;
    }

    public function salvar($pdo = null) {
        try {
            if (empty($this->id_documento_fiscal) or empty($this->ds_documento_fiscal_anotacao) or empty($this->id_pessoa)) {
                return Metodos::retornoAjax("Erro", "alert", "Não foi possível salvar a anotação, alguma informação obrigatória não foi informada.");
            }

            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }

            $daoFinDocumentoFiscalAnotacao = new DaoFinDocumentoFiscalAnotacao();
            $daoFinDocumentoFiscalAnotacao->setIdDocumentoFiscal($this->id_documento_fiscal)
                    ->setIdPessoa($this->id_pessoa)
                    ->setDsDocumentoFiscalAnotacao($this->ds_documento_fiscal_anotacao);

            $daoFinDocumentoFiscalAnotacao->insere($pdo);


            if (!$daoFinDocumentoFiscalAnotacao->sucesso()) {
                return false;
            }

            $this->id_documento_fiscal_anotacao = ($pdo->lastInsertId('fin_documento_fiscal_anotacao_id_documento_fiscal_anotacao_seq'));

            if (!Log::SalvaLogI('fin_documento_fiscal_anotacao', $this->id_documento_fiscal_anotacao, $pdo)) {
                return false;
            }
            return true;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "alert", $exc->getMessage());
        }
    }

    public function salvarComRetorno() {
        try {
            if (empty($this->id_documento_fiscal) or empty($this->ds_documento_fiscal_anotacao) or empty($this->id_pessoa)) {
                return Metodos::retornoAjax("Erro", "alert", "Não foi possível salvar a anotação, alguma informação obrigatória não foi informada.");
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $daoFinDocumentoFiscalAnotacao = new DaoFinDocumentoFiscalAnotacao();
            $daoFinDocumentoFiscalAnotacao->setIdDocumentoFiscal($this->id_documento_fiscal)
                    ->setIdPessoa($this->id_pessoa)
                    ->setDsDocumentoFiscalAnotacao($this->ds_documento_fiscal_anotacao);

            $daoFinDocumentoFiscalAnotacao->insere($pdo);


            if (!$daoFinDocumentoFiscalAnotacao->sucesso()) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Erro ao salvar a anotação para o documento fiscal.");
            }

            $this->id_documento_fiscal_anotacao = ($pdo->lastInsertId('fin_documento_fiscal_anotacao_id_documento_fiscal_anotacao_seq'));

            if (!Log::SalvaLogI('fin_documento_fiscal_anotacao', $this->id_documento_fiscal_anotacao, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Erro no log.");
            }

            $pdo->commit();
            return Metodos::retornoAjax("ok", "html", "Anotação salva com sucesso.");
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "alert", $exc->getMessage());
        }
    }
    
    public function listaAnotacoes(){
                try {
            if (empty($this->id_documento_fiscal)) {
                return Metodos::retornoAjax("Erro", "alert", "Não foi possível lista a anotação, alguma informação obrigatória não foi informada.");
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $daoFinDocumentoFiscalAnotacao = new DaoFinDocumentoFiscalAnotacao();
            $daoFinDocumentoFiscalAnotacao->setIdDocumentoFiscal($this->id_documento_fiscal);
            $retorno = '';        
            $daoFinDocumentoFiscalAnotacao->lista($pdo);
            
            if($daoFinDocumentoFiscalAnotacao->sucesso()){
                foreach ($daoFinDocumentoFiscalAnotacao->getMsgRetorno() as $linha){
                    $retorno .= $linha['dh_documento_fiscal_anotacao'] ." - ". $linha['nm_pessoa'] .": ".$linha['ds_documento_fiscal_anotacao']. "\n";
                }
            }

            return Metodos::retornoAjax("ok", "html", $retorno);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "alert", $exc->getMessage());
        }
    }

}
