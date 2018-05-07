<?php

class FinContratoTb {

    private $id_contrato = null;
    private $nr_contrato = null;
    private $nr_prazo_entrega = null;
    private $id_processo = null;
    private $id_pessoa = null;
    private $ds_objeto = null;
    private $fl_servico_continuado = null;
    private $dt_ini_vigencia_contrato = null;
    private $dt_fim_vigencia_contrato = null;
    private $dt_assinatura = null;
    private $dt_publicacao = null;
    private $ds_obs_contrato = null;
    private $st_ativo = null;
    private $id_modalidade = null;
    private $id_programa_trabalho = null;
    private $id_fonte = null;
    private $ds_area_abrangencia = null;
    private $id_tipo_gasto = null;
    private $ds_unidade_contemplada = null;
    private $vl_contrato = null;
    private $tp_contrato = null;
    private $fl_carona = null;
    private $id_contrato_alt = null;
    //fornecedor
    private $id_fornecedor = null;
    private $id_pessoaFornecedor = null;
    //fin_cont_central
    private $id_cont_central = null;
    private $id_lotacaoCentral = null;
    //fin_gestor Titular
    private $id_gestor = null;
    private $id_pessoa_gestor_titular = null;
    private $id_pessoa_gestor_substituto = null;
    //fin_fiscal
    private $id_fiscal = null;
    private $id_pessoa_fiscal_titular = null;
    private $id_pessoa_fiscal_substituto = null;
    //fin_sub_fiscal
    private $id_sub_fiscal = null;
    private $id_pessoa_sub_fiscal_titular = null;
    private $id_pessoa_sub_fiscal_substituto = null;
    //fin_orgao_gerenciador
    private $id_orgao_gerenciador = null;

    /**
     * @return mixed
     */
    public function getIdContrato() {
        return $this->id_contrato;
    }

    /**
     * @param mixed $id_contrato
     *
     * @return self
     */
    public function setIdContrato($id_contrato) {
        $this->id_contrato = $id_contrato;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNrContrato() {
        return $this->nr_contrato;
    }

    /**
     * @param mixed $nr_contrato
     *
     * @return self
     */
    public function setNrContrato($nr_contrato) {
        $this->nr_contrato = $nr_contrato;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNrPrazoEntrega() {
        return $this->nr_prazo_entrega;
    }

    /**
     * @param mixed $nr_prazo_entrega
     *
     * @return self
     */
    public function setNrPrazoEntrega($nr_prazo_entrega) {
        $this->nr_prazo_entrega = $nr_prazo_entrega;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdProcesso() {
        return $this->id_processo;
    }

    /**
     * @param mixed $id_processo
     *
     * @return self
     */
    public function setIdProcesso($id_processo) {
        $this->id_processo = $id_processo;

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
    public function getDsObjeto() {
        return $this->ds_objeto;
    }

    /**
     * @param mixed $ds_objeto
     *
     * @return self
     */
    public function setDsObjeto($ds_objeto) {
        $this->ds_objeto = $ds_objeto;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFlServicoContinuado() {
        return $this->fl_servico_continuado;
    }

    /**
     * @param mixed $fl_servico_continuado
     *
     * @return self
     */
    public function setFlServicoContinuado($fl_servico_continuado) {
        $this->fl_servico_continuado = $fl_servico_continuado;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtIniVigenciaContrato() {
        return $this->dt_ini_vigencia_contrato;
    }

    /**
     * @param mixed $dt_ini_vigencia_contrato
     *
     * @return self
     */
    public function setDtIniVigenciaContrato($dt_ini_vigencia_contrato) {
        $this->dt_ini_vigencia_contrato = $dt_ini_vigencia_contrato;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtFimVigenciaContrato() {
        return $this->dt_fim_vigencia_contrato;
    }

    /**
     * @param mixed $dt_fim_vigencia_contrato
     *
     * @return self
     */
    public function setDtFimVigenciaContrato($dt_fim_vigencia_contrato) {
        $this->dt_fim_vigencia_contrato = $dt_fim_vigencia_contrato;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtAssinatura() {
        return $this->dt_assinatura;
    }

    /**
     * @param mixed $dt_assinatura
     *
     * @return self
     */
    public function setDtAssinatura($dt_assinatura) {
        $this->dt_assinatura = $dt_assinatura;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtPublicacao() {
        return $this->dt_publicacao;
    }

    /**
     * @param mixed $dt_publicacao
     *
     * @return self
     */
    public function setDtPublicacao($dt_publicacao) {
        $this->dt_publicacao = $dt_publicacao;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDsObsContrato() {
        return $this->ds_obs_contrato;
    }

    /**
     * @param mixed $ds_obs_contrato
     *
     * @return self
     */
    public function setDsObsContrato($ds_obs_contrato) {
        $this->ds_obs_contrato = $ds_obs_contrato;

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
    public function getIdModalidade() {
        return $this->id_modalidade;
    }

    /**
     * @param mixed $id_modalidade
     *
     * @return self
     */
    public function setIdModalidade($id_modalidade) {
        $this->id_modalidade = $id_modalidade;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdProgramaTrabalho() {
        return $this->id_programa_trabalho;
    }

    /**
     * @param mixed $id_programa_trabalho
     *
     * @return self
     */
    public function setIdProgramaTrabalho($id_programa_trabalho) {
        $this->id_programa_trabalho = $id_programa_trabalho;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdFonte() {
        return $this->id_fonte;
    }

    /**
     * @param mixed $id_fonte
     *
     * @return self
     */
    public function setIdFonte($id_fonte) {
        $this->id_fonte = $id_fonte;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDsAreaAbrangencia() {
        return $this->ds_area_abrangencia;
    }

    /**
     * @param mixed $ds_area_abrangencia
     *
     * @return self
     */
    public function setDsAreaAbrangencia($ds_area_abrangencia) {
        $this->ds_area_abrangencia = $ds_area_abrangencia;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdTipoGasto() {
        return $this->id_tipo_gasto;
    }

    /**
     * @param mixed $id_tipo_gasto
     *
     * @return self
     */
    public function setIdTipoGasto($id_tipo_gasto) {
        $this->id_tipo_gasto = $id_tipo_gasto;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDsUnidadeContemplada() {
        return $this->ds_unidade_contemplada;
    }

    /**
     * @param mixed $ds_unidade_contemplada
     *
     * @return self
     */
    public function setDsUnidadeContemplada($ds_unidade_contemplada) {
        $this->ds_unidade_contemplada = $ds_unidade_contemplada;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVlContrato() {
        return $this->vl_contrato;
    }

    /**
     * @param mixed $vl_contrato
     *
     * @return self
     */
    public function setVlContrato($vl_contrato) {
        $this->vl_contrato = $vl_contrato;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTpContrato() {
        return $this->tp_contrato;
    }

    /**
     * @param mixed $tp_contrato
     *
     * @return self
     */
    public function setTpContrato($tp_contrato) {
        $this->tp_contrato = $tp_contrato;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFlCarona() {
        return $this->fl_carona;
    }

    /**
     * @param mixed $fl_carona
     *
     * @return self
     */
    public function setFlCarona($fl_carona) {
        $this->fl_carona = $fl_carona;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdContratoAlt() {
        return $this->id_contrato_alt;
    }

    /**
     * @param mixed $id_contrato_alt
     *
     * @return self
     */
    public function setIdContratoAlt($id_contrato_alt) {
        $this->id_contrato_alt = $id_contrato_alt;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdFornecedor() {
        return $this->id_fornecedor;
    }

    /**
     * @param mixed $id_fornecedor
     *
     * @return self
     */
    public function setIdFornecedor($id_fornecedor) {
        $this->id_fornecedor = $id_fornecedor;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdPessoaFornecedor() {
        return $this->id_pessoaFornecedor;
    }

    /**
     * @param mixed $id_pessoaFornecedor
     *
     * @return self
     */
    public function setIdPessoaFornecedor($id_pessoaFornecedor) {
        $this->id_pessoaFornecedor = $id_pessoaFornecedor;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdContCentral() {
        return $this->id_cont_central;
    }

    /**
     * @param mixed $id_cont_central
     *
     * @return self
     */
    public function setIdContCentral($id_cont_central) {
        $this->id_cont_central = $id_cont_central;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdLotacaoCentral() {
        return $this->id_lotacaoCentral;
    }

    /**
     * @param mixed $id_lotacaoCentral
     *
     * @return self
     */
    public function setIdLotacaoCentral($id_lotacaoCentral) {
        $this->id_lotacaoCentral = $id_lotacaoCentral;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdGestor() {
        return $this->id_gestor;
    }

    /**
     * @param mixed $id_gestor
     *
     * @return self
     */
    public function setIdGestor($id_gestor) {
        $this->id_gestor = $id_gestor;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdPessoaGestorTitular() {
        return $this->id_pessoa_gestor_titular;
    }

    /**
     * @param mixed $id_pessoa_gestor_titular
     *
     * @return self
     */
    public function setIdPessoaGestorTitular($id_pessoa_gestor_titular) {
        $this->id_pessoa_gestor_titular = $id_pessoa_gestor_titular;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdPessoaGestorSubstituto() {
        return $this->id_pessoa_gestor_substituto;
    }

    /**
     * @param mixed $id_pessoa_gestor_substituto
     *
     * @return self
     */
    public function setIdPessoaGestorSubstituto($id_pessoa_gestor_substituto) {
        $this->id_pessoa_gestor_substituto = $id_pessoa_gestor_substituto;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdFiscal() {
        return $this->id_fiscal;
    }

    /**
     * @param mixed $id_fiscal
     *
     * @return self
     */
    public function setIdFiscal($id_fiscal) {
        $this->id_fiscal = $id_fiscal;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdPessoaFiscalTitular() {
        return $this->id_pessoa_fiscal_titular;
    }

    /**
     * @param mixed $id_pessoa_fiscal_titular
     *
     * @return self
     */
    public function setIdPessoaFiscalTitular($id_pessoa_fiscal_titular) {
        $this->id_pessoa_fiscal_titular = $id_pessoa_fiscal_titular;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdPessoaFiscalSubstituto() {
        return $this->id_pessoa_fiscal_substituto;
    }

    /**
     * @param mixed $id_pessoa_fiscal_substituto
     *
     * @return self
     */
    public function setIdPessoaFiscalSubstituto($id_pessoa_fiscal_substituto) {
        $this->id_pessoa_fiscal_substituto = $id_pessoa_fiscal_substituto;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdSubFiscal() {
        return $this->id_sub_fiscal;
    }

    /**
     * @param mixed $id_sub_fiscal
     *
     * @return self
     */
    public function setIdSubFiscal($id_sub_fiscal) {
        $this->id_sub_fiscal = $id_sub_fiscal;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdPessoaSubFiscalTitular() {
        return $this->id_pessoa_sub_fiscal_titular;
    }

    /**
     * @param mixed $id_pessoa_sub_fiscal_titular
     *
     * @return self
     */
    public function setIdPessoaSubFiscalTitular($id_pessoa_sub_fiscal_titular) {
        $this->id_pessoa_sub_fiscal_titular = $id_pessoa_sub_fiscal_titular;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdPessoaSubFiscalSubstituto() {
        return $this->id_pessoa_sub_fiscal_substituto;
    }

    /**
     * @param mixed $id_pessoa_sub_fiscal_substituto
     *
     * @return self
     */
    public function setIdPessoaSubFiscalSubstituto($id_pessoa_sub_fiscal_substituto) {
        $this->id_pessoa_sub_fiscal_substituto = $id_pessoa_sub_fiscal_substituto;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdOrgaoGerenciador() {
        return $this->id_orgao_gerenciador;
    }

    /**
     * @param mixed $id_orgao_gerenciador
     *
     * @return self
     */
    public function setIdOrgaoGerenciador($id_orgao_gerenciador) {
        $this->id_orgao_gerenciador = $id_orgao_gerenciador;

        return $this;
    }
}

?>
