<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/gdof/DaoFinDocTramitacao.class.php";

class DocTramitacao {

    private $id_doc_tramitacao = null;
    private $id_documento_fiscal = null;
    private $id_pessoa = null;
    private $dh_doc_tramitacao = null;
    private $ds_doc_tramitacao = null;
    private $id_doc_origem = null;
    private $id_doc_destino = null;
    private $id_documento_situacao = null;
    private $id_tipo_tramitacao = null;

    /**
     * @return mixed
     */
    public function getIdDocTramitacao() {
        return $this->id_doc_tramitacao;
    }

    /**
     * @param mixed $id_doc_tramitacao
     *
     * @return self
     */
    public function setIdDocTramitacao($id_doc_tramitacao) {
        $this->id_doc_tramitacao = $id_doc_tramitacao;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdDocumentoFiscal() {
        return $this->id_documento_fiscal;
    }

    /**
     * @param mixed $id_documento_fiscal
     *
     * @return self
     */
    public function setIdDocumentoFiscal($id_documento_fiscal) {
        $this->id_documento_fiscal = $id_documento_fiscal;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdPessoa() {
        return $this->id_pessoa;
    }

    /**
     * @param mixed $id_pessoa
     *
     * @return self
     */
    public function setIdPessoa($id_pessoa) {
        $this->id_pessoa = $id_pessoa;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDhDocTramitacao() {
        return $this->dh_doc_tramitacao;
    }

    /**
     * @param mixed $dh_doc_tramitacao
     *
     * @return self
     */
    public function setDhDocTramitacao($dh_doc_tramitacao) {
        $this->dh_doc_tramitacao = $dh_doc_tramitacao;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDsDocTramitacao() {
        return $this->ds_doc_tramitacao;
    }

    /**
     * @param mixed $ds_doc_tramitacao
     *
     * @return self
     */
    public function setDsDocTramitacao($ds_doc_tramitacao) {
        $this->ds_doc_tramitacao = $ds_doc_tramitacao;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdDocOrigem() {
        return $this->id_doc_origem;
    }

    /**
     * @param mixed $id_doc_origem
     *
     * @return self
     */
    public function setIdDocOrigem($id_doc_origem) {
        $this->id_doc_origem = $id_doc_origem;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdDocDestino() {
        return $this->id_doc_destino;
    }

    /**
     * @param mixed $id_doc_destino
     *
     * @return self
     */
    public function setIdDocDestino($id_doc_destino) {
        $this->id_doc_destino = $id_doc_destino;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdDocumentoSituacao() {
        return $this->id_documento_situacao;
    }

    /**
     * @param mixed $id_documento_situacao
     *
     * @return self
     */
    public function setIdDocumentoSituacao($id_documento_situacao) {
        $this->id_documento_situacao = $id_documento_situacao;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdTipoTramitacao() {
        return $this->id_tipo_tramitacao;
    }

    /**
     * @param mixed $id_tipo_tramitacao
     *
     * @return self
     */
    public function setIdTipoTramitacao($id_tipo_tramitacao) {
        $this->id_tipo_tramitacao = $id_tipo_tramitacao;

        return $this;
    }

    public function cadastraTramitacao($pdo) {
        if (empty($pdo)) {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
        }

        $daoFinDocTramitacao = new DaoFinDocTramitacao();
        $daoFinDocTramitacao->setIdDocumentoFiscal($this->id_documento_fiscal);
        $daoFinDocTramitacao->setIdPessoa($this->id_pessoa);
        $daoFinDocTramitacao->setIdDocOrigem($this->id_doc_origem);
        $daoFinDocTramitacao->setIdDocDestino($this->id_doc_destino);
        $daoFinDocTramitacao->setIdDocumentoSituacao($this->id_documento_situacao);
        $daoFinDocTramitacao->setDsDocTramitacao($this->ds_doc_tramitacao);
        $daoFinDocTramitacao->setIdTipoTramitacao($this->id_tipo_tramitacao);
        $daoFinDocTramitacao->insert($pdo);

        $this->id_doc_tramitacao = ($pdo->lastInsertId('fin_doc_tramitacao_id_doc_tramitacao_seq'));
        if (!Log::SalvaLogI('fin_doc_tramitacao', $this->id_doc_tramitacao, $pdo)) {
            return false;
        }

        $this->atualizaTramitacaoDocumento($pdo);


        return $daoFinDocTramitacao->getSucesso();
    }

    public function atualizaTramitacaoDocumento(PDO $pdo) {
        if (empty($pdo)) {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
        }
        
        $daoFinDocTramitacao = new DaoFinDocTramitacao();
        $daoFinDocTramitacao->setIdDocumentoFiscal($this->id_documento_fiscal);
        $daoFinDocTramitacao->setIdDocTramitacao($this->id_doc_tramitacao);
        $daoFinDocTramitacao->atualizaIdDocTramitacaoDocumento($pdo);
        return $daoFinDocTramitacao->getSucesso();
    }

}
