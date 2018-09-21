<?php

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

    
    public function salvar(){
        try {
            if (empty($this->id_documento_fiscal) or empty($this->ds_documento_fiscal_anotacao) or empty($this->id_pessoa)) {
                return Metodos::retornoAjax("Erro","alert","Não foi possível salvar a anotação, alguma informação obrigatória não foi informada.");
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
                return false;
            }
            
            $pdo->commit();
            return Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
            
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro","alert",$exc->getMessage());
        }
    }

}

