<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/gdof/DaoFinDocumentoFiscal.class.php";

class FinDocumentoFiscal {

    private $id_documento_fiscal = null;
    private $nr_processo_administrativo = null;
    private $nr_documento_fiscal = null;
    private $competencia = null;
    private $dt_emissao = null;
    private $dt_atesto = null;
    private $vl_documento = null;
    private $fl_encontro_contas = null;
    private $nr_encontro_dae = null;
    private $fl_grp = null;
    private $nr_grp_numero = null;
    private $ds_observacao = null;
    private $st_ativo = null;
    private $id_lotacao = null;
    private $id_documento_situacao = null;
    private $id_tipo_documento = null;
    private $entrega = null;

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
    public function getNrProcessoAdministrativo() {
        return $this->nr_processo_administrativo;
    }

    /**
     * @param mixed $nr_processo_administrativo
     *
     * @return self
     */
    public function setNrProcessoAdministrativo($nr_processo_administrativo) {
        $this->nr_processo_administrativo = $nr_processo_administrativo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNrDocumentoFiscal() {
        return $this->nr_documento_fiscal;
    }

    /**
     * @param mixed $nr_documento_fiscal
     *
     * @return self
     */
    public function setNrDocumentoFiscal($nr_documento_fiscal) {
        $this->nr_documento_fiscal = $nr_documento_fiscal;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCompetencia() {
        return $this->competencia;
    }

    /**
     * @param mixed $competencia
     *
     * @return self
     */
    public function setCompetencia($competencia) {
        $this->competencia = $competencia;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtEmissao() {
        return $this->dt_emissao;
    }

    /**
     * @param mixed $dt_emissao
     *
     * @return self
     */
    public function setDtEmissao($dt_emissao) {
        $this->dt_emissao = $dt_emissao;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtAtesto() {
        return $this->dt_atesto;
    }

    /**
     * @param mixed $dt_atesto
     *
     * @return self
     */
    public function setDtAtesto($dt_atesto) {
        $this->dt_atesto = $dt_atesto;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVlDocumento() {
        return $this->vl_documento;
    }

    /**
     * @param mixed $vl_documento
     *
     * @return self
     */
    public function setVlDocumento($vl_documento) {
        $this->vl_documento = $vl_documento;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFlEncontroContas() {
        return $this->fl_encontro_contas;
    }

    /**
     * @param mixed $fl_encontro_contas
     *
     * @return self
     */
    public function setFlEncontroContas($fl_encontro_contas) {
        $this->fl_encontro_contas = $fl_encontro_contas;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNrEncontroDae() {
        return $this->nr_encontro_dae;
    }

    /**
     * @param mixed $nr_encontro_dae
     *
     * @return self
     */
    public function setNrEncontroDae($nr_encontro_dae) {
        $this->nr_encontro_dae = $nr_encontro_dae;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFlGrp() {
        return $this->fl_grp;
    }

    /**
     * @param mixed $fl_grp
     *
     * @return self
     */
    public function setFlGrp($fl_grp) {
        $this->fl_grp = $fl_grp;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNrGrpNumero() {
        return $this->nr_grp_numero;
    }

    /**
     * @param mixed $nr_grp_numero
     *
     * @return self
     */
    public function setNrGrpNumero($nr_grp_numero) {
        $this->nr_grp_numero = $nr_grp_numero;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDsObservacao() {
        return $this->ds_observacao;
    }

    /**
     * @param mixed $ds_observacao
     *
     * @return self
     */
    public function setDsObservacao($ds_observacao) {
        $this->ds_observacao = $ds_observacao;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStAtivo() {
        return $this->st_ativo;
    }

    /**
     * @param mixed $st_ativo
     *
     * @return self
     */
    public function setStAtivo($st_ativo) {
        $this->st_ativo = $st_ativo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdLotacao() {
        return $this->id_lotacao;
    }

    /**
     * @param mixed $id_lotacao
     *
     * @return self
     */
    public function setIdLotacao($id_lotacao) {
        $this->id_lotacao = $id_lotacao;

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
    public function getIdTipoDocumento() {
        return $this->id_tipo_documento;
    }

    /**
     * @param mixed $id_tipo_documento
     *
     * @return self
     */
    public function setIdTipoDocumento($id_tipo_documento) {
        $this->id_tipo_documento = $id_tipo_documento;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEntrega() {
        return $this->entrega;
    }

    /**
     * @param mixed $entrega
     *
     * @return self
     */
    public function setEntrega($entrega) {
        $this->entrega = $entrega;

        return $this;
    }

    public function salvaDocumentoFiscal() {
        try {
            if (empty($this->nr_processo_administrativo) && empty($this->nr_documento_fiscal) && empty($this->id_tipo_documento) && empty($this->dt_atesto) &&
                    empty($this->dt_emissao) && empty($this->vl_documento) && empty($this->entrega)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            //conexao 
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //
            $daoFinDocumentoFiscal = new DaoFinDocumentoFiscal();
            $daoFinDocumentoFiscal->setNrProcessoAdministrativo($this->nr_processo_administrativo);
            $daoFinDocumentoFiscal->setNrDocumentoFiscal($this->nr_documento_fiscal);
            $daoFinDocumentoFiscal->setMmCompetencia("03");
            $daoFinDocumentoFiscal->setAaCompetencia("2018");
            $daoFinDocumentoFiscal->setDtAtesto(Metodos::ConverteDataING($this->dt_atesto));
            $daoFinDocumentoFiscal->setDtEmissao(Metodos::ConverteDataING($this->dt_emissao));
            $daoFinDocumentoFiscal->setVlDocumento(Metodos::ConverteValorIng($this->vl_documento));
            $daoFinDocumentoFiscal->setFlGrp($this->fl_grp);
            $daoFinDocumentoFiscal->setNrGrpNumero($this->nr_grp_numero);
            $daoFinDocumentoFiscal->setFlEncontroContas(0);
            $daoFinDocumentoFiscal->setIdLotacao(1);
            $daoFinDocumentoFiscal->setIdDocumentoSituacao(1);
            $daoFinDocumentoFiscal->setIdTipoDocumento($this->id_tipo_documento);
            $daoFinDocumentoFiscal->cadasTraDocumentoFiscal($pdo);

            if (!$daoFinDocumentoFiscal->sucesso()) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Erro ao salva o documento fiscal");
            }

            $this->id_documento_fiscal = ($pdo->lastInsertId('fin_documento_fiscal_id_documento_fiscal_seq'));

            if (!Log::SalvaLogI('fin_documento_fiscal', $this->id_documento_fiscal, $pdo)) {
                return false;
            }

            //codigo abaixo cadastra as entregas do documento fiscal
            $finEntregaDocumento = new FinEntregaDocumento();
            foreach ($this->entrega as $dados) {
                $finEntregaDocumento->setIdDocumentoFiscal($this->id_documento_fiscal);
                $finEntregaDocumento->setIdEntregaConfirmacao($dados);
               
                if (!$finEntregaDocumento->cadastrarEntregaDocumento($pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", "Erro ao salva a(s) entrega(s) do documento fiscal.");
                }
            }

            $pdo->commit();
            return Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
            
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

}
