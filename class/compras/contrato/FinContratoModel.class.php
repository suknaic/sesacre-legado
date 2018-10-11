<?php
//require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/fiscais/FinFiscaisModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/compras/gcon/processo/DaoProcesso.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/compras/DaoFinContrato.class.php";

class FinContratoModel {

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
    private $sq_contrato = null;
    private $id_contrato_aditivo_pai = null;
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
    //Tabela Fornecedor
    private $fornecedor = null;
    private $contratoAditivo = null;
    private $items = null;
    private $sucesso = false;
    private $msgRetorno = null;

    public function getMsgRetorno() {
        return $this->msgRetorno;
    }

    public function sucesso() {
        return $this->sucesso;
    }

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

    public function getSqContrato() {
        return $this->sq_contrato;
    }

    public function getIdContratoAditivoPai() {
        return $this->id_contrato_aditivo_pai;
    }

    public function setSqContrato($sq_contrato) {
        $this->sq_contrato = $sq_contrato;
    }

    public function setIdContratoAditivoPai($id_contrato_aditivo_pai) {
        $this->id_contrato_aditivo_pai = $id_contrato_aditivo_pai;
    }

    public function getFornecedor() {
        return $this->fornecedor;
    }

    public function getContratoAditivo() {
        return $this->contratoAditivo;
    }

    public function setFornecedor(FinFornecedoresModel $fornecedor) {
        $this->fornecedor = $fornecedor;
    }

    public function setContratoAditivo(FinContratoAditivo $contratoAditivo) {
        $this->contratoAditivo = $contratoAditivo;
    }

    public function getItems() {
        return $this->items;
    }

    public function setItems(ItemModel $items) {
        $this->items[$items->getIdContItens()] = $items;
    }

    /**
     * Metodo responsavel por cadastrar a ata no sistema
     * @return type
     */
    public function cadastraAta() {
        try {

            if (empty($this->id_pessoaFornecedor) || empty($this->id_pessoa) || empty($this->id_tipo_gasto) || empty($this->nr_contrato) || empty($this->ds_objeto) || empty($this->id_processo) || empty($this->dt_ini_vigencia_contrato) ||
                    empty($this->dt_fim_vigencia_contrato) || empty($this->dt_assinatura) || empty($this->dt_publicacao) || empty($this->tp_contrato)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            if (!empty($this->fl_carona) && empty($this->id_orgao_gerenciador)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $daoFinContrato = new DaoFinContrato();
            $sucesso = true;
            //setando dados para o cadastramento da ata
            $daoFinContrato->setNrContrato($this->nr_contrato);
            $daoFinContrato->setIdProcesso($this->id_processo);
            $daoFinContrato->setIdPessoa($this->id_pessoa);
            $daoFinContrato->setDsObjeto($this->ds_objeto);
            $daoFinContrato->setDtIniVigenciaContrato(Metodos::ConverteDataING($this->dt_ini_vigencia_contrato));
            $daoFinContrato->setDtFimVigenciaContrato(Metodos::ConverteDataING($this->dt_fim_vigencia_contrato));
            $daoFinContrato->setDtAssinatura(Metodos::ConverteDataING($this->dt_assinatura));
            $daoFinContrato->setDtPublicacao(Metodos::ConverteDataING($this->dt_publicacao));

            if (!empty($this->ds_obs_contrato)) {
                $daoFinContrato->setDsObsContrato($this->ds_obs_contrato);
            }
            $daoFinContrato->setFlCarona($this->fl_carona);
            $daoFinContrato->setIdOrgaoGerenciador($this->id_orgao_gerenciador);
            $daoFinContrato->setIdProgramaTrabalho($this->id_programa_trabalho);
            $daoFinContrato->setIdFonte($this->id_fonte);
            $daoFinContrato->setIdTipoGasto($this->id_tipo_gasto);
            $daoFinContrato->setTpContrato(1);
            //chamando o metodo para cadastrar a ata
            $daoFinContrato->cadastrarAta($pdo);
            //verificando cadastramento da ata
            if (!$daoFinContrato->sucesso()) {
                $sucesso = false;
                $retorno = Metodos::retornoAjax("Erro1", "console", $daoFinContrato->getMsgRetorno());
                $pdo->rollBack();
                return $retorno;
            }
            //pegando id da ata
            $daoFinContrato->setIdContrato($pdo->lastInsertId('fin_contrato_id_contrato_seq'));
            //cadastrar centrais
            if (!empty($this->id_lotacaoCentral)) {
                $finCentraisModel = new FinCentraisModel();

                foreach ($this->id_lotacaoCentral as $valor) {
                    $finCentraisModel->setIdContrato($daoFinContrato->getIdContrato());
                    $finCentraisModel->setIdLotacao($valor);
                    $finCentraisModel->cadastrarCentralContrato($pdo);
                    if (!$finCentraisModel->sucesso()) {
                        $sucesso = false;
                        break;
                    }

                    if ($sucesso == false) {
                        $retorno = Metodos::retornoAjax("Erro2", "console", $finCentraisModel->getMsgRetorno());
                        $pdo->rollBack();
                        return $retorno;
                    }
                }
            }

            //cadastrar fornecedor
            $fornecedor = new FinFornecedoresModel();
            $fornecedor->setIdContrato($daoFinContrato->getIdContrato());
            $fornecedor->setIdPessoa($this->id_pessoaFornecedor);
            $fornecedor->cadastrarFornecedores($pdo);
            if (!$fornecedor->sucesso()) {
                $sucesso = false;
            }
            //cadastrar vigencia
            $daoFinContrato->cadastrarContratoVigencia($pdo);
            //pegando id da vigencia
            $idVigencia = (is_numeric($pdo->lastInsertId('fin_vigencia_id_vigencia_seq'))) ? $pdo->lastInsertId('fin_vigencia_id_vigencia_seq') : null;
            //log da vigencia da ata
            if (!Log::SalvaLogI('fin_vigencia', $idVigencia, $pdo)) {
                $sucesso = false;
            }

            //log do cadastramento da ata
            if (!Log::SalvaLogI('fin_contrato', $daoFinContrato->getIdContrato(), $pdo)) {
                $sucesso = false;
            }

            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", $fornecedor->getMsgRetorno());
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
        } catch (Exception $ex) {
            
        }
    }

    /**
     * Metodo responsavel por editar a ata no sistema
     * @return type
     */
    public function editarAta() {
        try {

            if (empty($this->id_contrato) || empty($this->id_pessoaFornecedor) || empty($this->id_pessoa) || empty($this->nr_contrato) || empty($this->ds_objeto) || empty($this->id_processo) || empty($this->dt_ini_vigencia_contrato) ||
                    empty($this->dt_fim_vigencia_contrato) || empty($this->dt_assinatura) || empty($this->dt_publicacao) || empty($this->tp_contrato)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $daoFinContrato = new DaoFinContrato();
            $sucesso = true;
            //setando dados para o cadastramento da ata

            $daoFinContrato->setIdContrato($this->id_contrato);
            $daoFinContrato->setNrContrato($this->nr_contrato);
            $daoFinContrato->setIdProcesso($this->id_processo);
            $daoFinContrato->setIdPessoa($this->id_pessoa);
            $daoFinContrato->setDsObjeto($this->ds_objeto);
            $daoFinContrato->setDtIniVigenciaContrato(Metodos::ConverteDataING($this->dt_ini_vigencia_contrato));
            $daoFinContrato->setDtFimVigenciaContrato(Metodos::ConverteDataING($this->dt_fim_vigencia_contrato));
            $daoFinContrato->setDtAssinatura(Metodos::ConverteDataING($this->dt_assinatura));
            $daoFinContrato->setDtPublicacao(Metodos::ConverteDataING($this->dt_publicacao));

            if (!empty($this->ds_obs_contrato)) {
                $daoFinContrato->setDsObsContrato($this->ds_obs_contrato);
            }
            $daoFinContrato->setTpContrato(1);
            $daoFinContrato->setIdTipoGasto($this->id_tipo_gasto);
            //chamando o metodo para cadastrar a ata
            $daoFinContrato->editarAta($pdo);
            //verificando cadastramento da ata
            if (!$daoFinContrato->sucesso()) {
                $sucesso = false;
                $retorno = Metodos::retornoAjax("Erro1", "console", $daoFinContrato->getMsgRetorno());
                $pdo->rollBack();
                return $retorno;
            }

            //cadastrar centrais
            if (!empty($this->id_lotacaoCentral)) {
                $finCentraisModel = new FinCentraisModel();

                foreach ($this->id_lotacaoCentral as $valor) {
                    $finCentraisModel->setIdContrato($this->id_contrato);
                    $finCentraisModel->setIdLotacao($valor);
                    if (!$finCentraisModel->verificaCentralCadastro($pdo)) {
                        $finCentraisModel->cadastrarCentralContrato($pdo);

                        if (!$finCentraisModel->sucesso()) {
                            $sucesso = false;
                            break;
                        }

                        if ($sucesso == false) {
                            $retorno = Metodos::retornoAjax("Erro2", "console", $finCentraisModel->getMsgRetorno());
                            $pdo->rollBack();
                            return $retorno;
                        }
                    }
                }
            }

            //editar fornecedor
            $fornecedor = new FinFornecedoresModel();
            $fornecedor->setIdPessoa($this->id_pessoaFornecedor);
            $fornecedor->setIdFornecedor($this->id_fornecedor);
            $fornecedor->editarFornecedor($pdo);

            if (!$fornecedor->sucesso()) {
                $sucesso = false;
            }


            $daoFinContrato->retornaContrato($pdo);
            $busca = $daoFinContrato->getMsgRetorno();

            //log do cadastramento da ata
            if (!Log::SalvaLogU('fin_contrato', $this->id_contrato, $busca, $pdo)) {
                $sucesso = false;
            }

            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", $this->id_fornecedor);
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR . '25');
                $pdo->rollBack();
                return $retorno;
            }
        } catch (Exception $ex) {
            
        }
    }

    /**
     * Metodo responsavel por editar a ata no sistema
     * @return type
     */
    public function editarContrato() {
        try {
            if (empty($this->id_contrato) || empty($this->id_pessoaFornecedor) || empty($this->id_pessoa) || empty($this->nr_contrato) || empty($this->ds_objeto) || empty($this->id_processo) || empty($this->dt_ini_vigencia_contrato) ||
                empty($this->dt_fim_vigencia_contrato) || empty($this->dt_assinatura) || empty($this->dt_publicacao) || empty($this->tp_contrato)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $daoFinContrato = new DaoFinContrato();
            $sucesso = true;
            //setando dados para o cadastramento da ata

            $daoFinContrato->setIdContrato($this->id_contrato);
            $daoFinContrato->setNrContrato($this->nr_contrato);
            $daoFinContrato->setIdProcesso($this->id_processo);
            $daoFinContrato->setIdPessoa($this->id_pessoa);
            $daoFinContrato->setDsObjeto($this->ds_objeto);
            $daoFinContrato->setDtIniVigenciaContrato(Metodos::ConverteDataING($this->dt_ini_vigencia_contrato));
            $daoFinContrato->setDtFimVigenciaContrato(Metodos::ConverteDataING($this->dt_fim_vigencia_contrato));
            $daoFinContrato->setDtAssinatura(Metodos::ConverteDataING($this->dt_assinatura));
            $daoFinContrato->setDtPublicacao(Metodos::ConverteDataING($this->dt_publicacao));

            if (!empty($this->ds_obs_contrato)) {
                $daoFinContrato->setDsObsContrato($this->ds_obs_contrato);
            }
            $daoFinContrato->setTpContrato(2);
            $daoFinContrato->setIdTipoGasto($this->id_tipo_gasto);
            //chamando o metodo para cadastrar a ata
            $daoFinContrato->editarContrato($pdo);

            //verificando cadastramento da ata
            if (!$daoFinContrato->sucesso()) {
                $sucesso = false;
                $retorno = Metodos::retornoAjax("Erro1", "console", $daoFinContrato->getMsgRetorno());
                $pdo->rollBack();
                return $retorno;
            }

            //cadastrar centrais
            if (!empty($this->id_lotacaoCentral)) {
                $finCentraisModel = new FinCentraisModel();

                foreach ($this->id_lotacaoCentral as $valor) {
                    $finCentraisModel->setIdContrato($this->id_contrato);
                    $finCentraisModel->setIdLotacao($valor);
                    if (!$finCentraisModel->verificaCentralCadastro($pdo)) {
                        $finCentraisModel->cadastrarCentralContrato($pdo);

                        if (!$finCentraisModel->sucesso()) {
                            $sucesso = false;
                            break;
                        }

                        if ($sucesso == false) {
                            $retorno = Metodos::retornoAjax("Erro2", "console", $finCentraisModel->getMsgRetorno());
                            $pdo->rollBack();
                            return $retorno;
                        }
                    }
                }
            }

            //****************************** Gestores do Contrato *****************************
            $finGestor = new FinGestorModel();
            $finGestor->setIdContrato($this->id_contrato);
            $gestoresTitulares = $finGestor->retornarGestoresContrato(1);
            //************************ cadastrar gestor titular ************************
            if (empty($gestoresTitulares) && !empty($this->id_pessoa_gestor_titular)) {
                $finGestor->cadastraGestor($pdo, $this->id_contrato, $this->id_pessoa_gestor_titular);
                if (!$finGestor->sucesso()) {
                    $sucesso = false;
                }

                if ($sucesso == false) {
                    $retorno = Metodos::retornoAjax("Erro", "console", $finGestor->getMsgRetorno());
                    $pdo->rollBack();
                    return $retorno;
                }
            }

            if (!empty($gestoresTitulares) && empty($this->id_pessoa_gestor_titular)) {
                foreach ($gestoresTitulares as $pessoa){
                    $finGestor->setIdGestor($pessoa['id_gestor']);
                    $deleta = $finGestor->deleteGestorContrato();
                    if (!$deleta) {
                        return Metodos::retornoAjax('Erro', 'console', $deleta);
                    }
                }
            }

            if (!empty($gestoresTitulares) && !empty($this->id_pessoa_gestor_titular)) {
                $idPessoa = array();
                foreach ($gestoresTitulares as $titular) {
                    $idPessoa[] = $titular['id_pessoa'];
                }
                $delete = array_diff($idPessoa, $this->id_pessoa_gestor_titular);
                if (!empty($delete)) {
                    foreach ($delete as $gestor) {
                        foreach ($gestoresTitulares as $pessoa) {
                            if ($gestor == $pessoa['id_pessoa']) {
                                $finGestor->setIdGestor($pessoa['id_gestor']);
                                $deleta = $finGestor->deleteGestorContrato();

                                if (!$deleta) {
                                    return Metodos::retornoAjax('Erro', 'console', $deleta);
                                }
                            }
                        }
                    }
                }

                $insert = array_diff($this->id_pessoa_gestor_titular, $idPessoa);
                if (!empty($insert)) {
                    $finGestor->cadastraGestor($pdo, $this->id_contrato, $insert, 1);
                    if (!$finGestor->sucesso()) {
                        $retorno = Metodos::retornoAjax("Erro", "console", $finGestor->getMsgRetorno());
                        $pdo->rollBack();
                        return $retorno;
                    }
                }
            }
            //***************************************************************************
            $gestoresSubstitutos = $finGestor->retornarGestoresContrato(2);
            //************************ cadastrar gestor substituto **********************
            if (empty($gestoresSubstitutos) && !empty($this->id_pessoa_gestor_substituto)) {
                if (!empty($this->id_pessoa_gestor_substituto)) {
                    $finGestor->cadastraGestor($pdo, $this->id_contrato, $this->id_pessoa_gestor_substituto, 2);
                    if (!$finGestor->sucesso()) {
                        $sucesso = false;
                    }
                    if ($sucesso == false) {
                        $retorno = Metodos::retornoAjax("Erro5", "console", $finGestor->getMsgRetorno());
                        $pdo->rollBack();
                        return $retorno;
                    }
                }
            }

            if (!empty($gestoresSubstitutos) && empty($this->id_pessoa_gestor_substituto)) {
                foreach ($gestoresSubstitutos as $pessoa){
                    $finGestor->setIdGestor($pessoa['id_gestor']);
                    $deleta = $finGestor->deleteGestorContrato();
                    if (!$deleta) {
                        return Metodos::retornoAjax('Erro', 'console', $deleta);
                    }
                }
            }

            if (!empty($gestoresSubstitutos) && !empty($this->id_pessoa_gestor_substituto)) {
                $idPessoa = array();
                foreach ($gestoresSubstitutos as $substituto) {
                    $idPessoa[] = $substituto['id_pessoa'];
                }
                $delete = array_diff($idPessoa, $this->id_pessoa_gestor_substituto);
                if (!empty($delete)) {
                    foreach ($delete as $gestor) {
                        foreach ($gestoresSubstitutos as $pessoa) {
                            if ($gestor == $pessoa['id_pessoa']) {
                                $finGestor->setIdGestor($pessoa['id_gestor']);
                                $deleta = $finGestor->deleteGestorContrato();

                                if (!$deleta) {
                                    return Metodos::retornoAjax('Erro', 'console', $deleta);
                                }
                            }
                        }
                    }
                }

                $insert = array_diff($this->id_pessoa_gestor_substituto, $idPessoa);
                if (!empty($insert)) {
                    $finGestor->cadastraGestor($pdo, $this->id_contrato, $insert, 2);
                    if (!$finGestor->sucesso()) {
                        $retorno = Metodos::retornoAjax("Erro", "console", $finGestor->getMsgRetorno());
                        $pdo->rollBack();
                        return $retorno;
                    }
                }
            }
            //**********************************************************************************

            //******************************** Fiscais do Contrato *****************************
            $finFiscais = new FinFiscaisModel();
            $finFiscais->setIdContrato($this->id_contrato);
            $fiscaisTitulares = $finFiscais->retornarFiscaisContrato(1);
            //************************ cadastrar ficais titular ************************
            if (empty($fiscaisTitulares) && !empty($this->id_pessoa_fiscal_titular)) {
                if (!empty($this->id_pessoa_fiscal_titular)) {
                    foreach ($this->id_pessoa_fiscal_titular as $fiscalTitular) {
                        $finFiscais->setIdContrato($this->id_contrato);
                        $finFiscais->setIdPessoa($fiscalTitular);
                        $finFiscais->setDtIniFiscal(date('Y-m-d'));
                        $finFiscais->setTpFiscal(1);
                        $finFiscais->cadastraFiscal($pdo);
                        if (!$finFiscais->sucesso()) {
                            $sucesso = false;
                        }

                        if ($sucesso == false) {
                            $retorno = Metodos::retornoAjax("Erro", "console", $finFiscais->getMsgRetorno());
                            $pdo->rollBack();
                            return $retorno;
                            break;
                        }
                    }
                }
            }

            if (!empty($fiscaisTitulares) && empty($this->id_pessoa_fiscal_titular)) {
                foreach ($fiscaisTitulares as $idFiscal) {
                    $finFiscais->setIdFiscal($idFiscal['id_fiscal']);
                    $deleta = $finFiscais->deleteFiscalContrato();

                    if (!$deleta) {
                        return Metodos::retornoAjax('Erro', 'console', $deleta);
                    }
                }
            }

            if (!empty($fiscaisTitulares) && !empty($this->id_pessoa_fiscal_titular)){
                $idPessoa = array();
                foreach ($fiscaisTitulares as $fiscais) {
                    $idPessoa[] = $fiscais['id_pessoa'];
                }
                $delete = array_diff($idPessoa, $this->id_pessoa_fiscal_titular);
                if (!empty($delete)) {
                    foreach ($delete as $fiscal) {
                        foreach ($fiscaisTitulares as $pessoa) {
                            if ($fiscal == $pessoa['id_pessoa']) {
                                $finFiscais->setIdFiscal($pessoa['id_fiscal']);
                                $deleta = $finFiscais->deleteFiscalContrato();

                                if (!$deleta) {
                                    return Metodos::retornoAjax('Erro', 'console', $deleta);
                                }
                            }
                        }
                    }
                }

                $insert = array_diff($this->id_pessoa_fiscal_titular, $idPessoa);
                if (!empty($insert)) {
                    foreach ($insert as $fiscalTitular) {
                        $finFiscais->setIdContrato($this->id_contrato);
                        $finFiscais->setIdPessoa($fiscalTitular);
                        $finFiscais->setDtIniFiscal(date('Y-m-d'));
                        $finFiscais->setTpFiscal(1);
                        $finFiscais->cadastraFiscal($pdo);
                        if (!$finFiscais->sucesso()) {
                            $sucesso = false;
                        }

                        if ($sucesso == false) {
                            $retorno = Metodos::retornoAjax("Erro", "console", $finFiscais->getMsgRetorno());
                            $pdo->rollBack();
                            return $retorno;
                            break;
                        }
                    }
                }
            }
            //***************************************************************************
            $fiscaisSubstitutos = $finFiscais->retornarFiscaisContrato(2);
            //************************ cadastrar fiscais substituto **********************
            if (empty($fiscaisSubstitutos) && !empty($this->id_pessoa_fiscal_substituto)){
                if (!empty($this->id_pessoa_fiscal_substituto)) {
                    foreach ($this->id_pessoa_fiscal_substituto as $ficalSubstituto) {
                        $finFiscais->setIdContrato($this->id_contrato);
                        $finFiscais->setIdPessoa($ficalSubstituto);
                        $finFiscais->setDtIniFiscal(date('Y-m-d'));
                        $finFiscais->setTpFiscal(2);
                        $finFiscais->cadastraFiscal($pdo);
                        if (!$finFiscais->sucesso()) {
                            $sucesso = false;
                        }

                        if ($sucesso == false) {
                            $retorno = Metodos::retornoAjax("Erro", "console", $finFiscais->getMsgRetorno());
                            $pdo->rollBack();
                            return $retorno;
                            break;
                        }
                    }
                }
            }

            if (!empty($fiscaisSubstitutos) && empty($this->id_pessoa_fiscal_substituto)) {
                foreach ($fiscaisSubstitutos as $idFiscal) {
                    $finFiscais->setIdFiscal($idFiscal['id_fiscal']);
                    $deleta = $finFiscais->deleteFiscalContrato();

                    if (!$deleta) {
                        return Metodos::retornoAjax('Erro', 'console', $deleta);
                    }
                }
            }

            if (!empty($fiscaisSubstitutos) && !empty($this->id_pessoa_fiscal_substituto)) {
                $idPessoa = array();
                foreach ($fiscaisSubstitutos as $fiscais) {
                    $idPessoa[] = $fiscais['id_pessoa'];
                }
                $delete = array_diff($idPessoa, $this->id_pessoa_fiscal_substituto);
                if (!empty($delete)) {
                    foreach ($delete as $fiscal) {
                        foreach ($fiscaisSubstitutos as $pessoa) {
                            if ($fiscal == $pessoa['id_pessoa']) {
                                $finFiscais->setIdFiscal($pessoa['id_fiscal']);
                                $deleta = $finFiscais->deleteFiscalContrato();

                                if (!$deleta) {
                                    return Metodos::retornoAjax('Erro', 'console', $deleta);
                                }
                            }
                        }
                    }
                }

                $insert = array_diff($this->id_pessoa_fiscal_substituto, $idPessoa);
                if (!empty($insert)) {
                    foreach ($insert as $fiscalSubstituto) {
                        $finFiscais->setIdContrato($this->id_contrato);
                        $finFiscais->setIdPessoa($fiscalSubstituto);
                        $finFiscais->setDtIniFiscal(date('Y-m-d'));
                        $finFiscais->setTpFiscal(2);
                        $finFiscais->cadastraFiscal($pdo);
                        if (!$finFiscais->sucesso()) {
                            $sucesso = false;
                        }

                        if ($sucesso == false) {
                            $retorno = Metodos::retornoAjax("Erro", "console", $finFiscais->getMsgRetorno());
                            $pdo->rollBack();
                            return $retorno;
                            break;
                        }
                    }
                }
            }
            //**********************************************************************************

            //******************************** Sub-Fiscais do Contrato *****************************
            $finSubFiscais = new SubFiscalModel();
            $finSubFiscais->setIdContrato($this->id_contrato);
            $subFiscais = $finSubFiscais->retornarSubFiscaisContrato(1);
            //************************ cadastrar sub-ficais titular ************************
            if (empty($subFiscais) && !empty($this->id_pessoa_sub_fiscal_titular)) {
                if (!empty($this->id_pessoa_sub_fiscal_titular)) {
                    foreach ($this->id_pessoa_sub_fiscal_titular as $SubFiscalTitular) {
                        $finSubFiscais->setIdContrato($this->id_contrato);
                        $finSubFiscais->setIdPessoa($SubFiscalTitular);
                        $finSubFiscais->setDtIniSubFiscal(date('Y-m-d'));
                        $finSubFiscais->setTpSubFiscal(1);
                        $finSubFiscais->cadastraSubFiscal($pdo);
                        if (!$finSubFiscais->sucesso()) {
                            $sucesso = false;
                        }

                        if ($sucesso == false) {
                            $retorno = Metodos::retornoAjax("Erro", "console", $finSubFiscais->getMsgRetorno());
                            $pdo->rollBack();
                            return $retorno;
                            break;
                        }
                    }
                }
            }

            if (!empty($subFiscais) && empty($this->id_pessoa_sub_fiscal_titular)) {
                foreach ($subFiscais as $idSubFiscal) {
                    $finSubFiscais->setIdSubFiscal($idSubFiscal['id_sub_fiscal']);
                    $deleta = $finSubFiscais->deleteSubFiscalContrato();

                    if (!$deleta) {
                        return Metodos::retornoAjax('Erro', 'console', $deleta);
                    }
                }
            }

            if (!empty($subFiscais) && !empty($this->id_pessoa_sub_fiscal_titular)) {
                $idPessoa = array();
                foreach ($subFiscais as $sub) {
                    $idPessoa[] = $sub['id_pessoa'];
                }
                $delete = array_diff($idPessoa, $this->id_pessoa_sub_fiscal_titular);
                if (!empty($delete)) {
                    foreach ($delete as $subFiscal) {
                        foreach ($subFiscais as $pessoa) {
                            if ($subFiscal == $pessoa['id_pessoa']) {
                                $finSubFiscais->setIdSubFiscal($pessoa['id_sub_fiscal']);
                                $deleta = $finSubFiscais->deleteSubFiscalContrato();

                                if (!$deleta) {
                                    return Metodos::retornoAjax('Erro', 'console', $deleta);
                                }
                            }
                        }
                    }
                }

                $insert = array_diff($this->id_pessoa_sub_fiscal_titular, $idPessoa);
                if (!empty($insert)) {
                    foreach ($insert as $subFiscalTitular) {
                        $finSubFiscais->setIdContrato($this->id_contrato);
                        $finSubFiscais->setIdPessoa($subFiscalTitular);
                        $finSubFiscais->setDtIniSubFiscal(date('Y-m-d'));
                        $finSubFiscais->setTpSubFiscal(1);
                        $finSubFiscais->cadastraSubFiscal($pdo);
                        if (!$finSubFiscais->sucesso()) {
                            $sucesso = false;
                        }

                        if ($sucesso == false) {
                            $retorno = Metodos::retornoAjax("Erro", "console", $finSubFiscais->getMsgRetorno());
                            $pdo->rollBack();
                            return $retorno;
                            break;
                        }
                    }
                }
            }
            //***************************************************************************
            $subFiscaisSub = $finSubFiscais->retornarSubFiscaisContrato(2);
            //************************ cadastrar sub-fiscais substituto **********************
            if (empty($subFiscaisSub) && !empty($this->id_pessoa_sub_fiscal_substituto)) {
                if (!empty($this->id_pessoa_sub_fiscal_substituto)) {
                    foreach ($this->id_pessoa_sub_fiscal_substituto as $subFicalSubstituto) {
                        $finSubFiscais->setIdContrato($this->id_contrato);
                        $finSubFiscais->setIdPessoa($subFicalSubstituto);
                        $finSubFiscais->setDtIniSubFiscal(date('Y-m-d'));
                        $finSubFiscais->setTpSubFiscal(2);
                        $finSubFiscais->cadastraSubFiscal($pdo);
                        if (!$finSubFiscais->sucesso()) {
                            $sucesso = false;
                        }

                        if ($sucesso == false) {
                            $retorno = Metodos::retornoAjax("Erro", "console", $finFiscais->getMsgRetorno());
                            $pdo->rollBack();
                            return $retorno;
                            break;
                        }
                    }
                }
            }

            if (!empty($subFiscaisSub) && empty($this->id_pessoa_sub_fiscal_substituto)) {
                foreach ($subFiscaisSub as $idSubFiscais) {
                    $finSubFiscais->setIdSubFiscal($idSubFiscais['id_sub_fiscal']);
                    $deleta = $finSubFiscais->deleteSubFiscalContrato();

                    if (!$deleta) {
                        return Metodos::retornoAjax('Erro', 'console', $deleta);
                    }
                }
            }

            if (!empty($subFiscaisSub) && !empty($this->id_pessoa_sub_fiscal_substituto)) {
                $idPessoa = array();
                foreach ($subFiscaisSub as $sub) {
                    $idPessoa[] = $sub['id_pessoa'];
                }
                $delete = array_diff($idPessoa, $this->id_pessoa_sub_fiscal_substituto);
                if (!empty($delete)) {
                    foreach ($delete as $subFiscal) {
                        foreach ($subFiscaisSub as $pessoa) {
                            if ($subFiscal == $pessoa['id_pessoa']) {
                                $finSubFiscais->setIdSubFiscal($pessoa['id_sub_fiscal']);
                                $deleta = $finSubFiscais->deleteSubFiscalContrato();

                                if (!$deleta) {
                                    return Metodos::retornoAjax('Erro', 'console', $deleta);
                                }
                            }
                        }
                    }
                }

                $insert = array_diff($this->id_pessoa_sub_fiscal_substituto, $idPessoa);
                if (!empty($insert)) {
                    foreach ($insert as $subFiscalSubstituto) {
                        $finSubFiscais->setIdContrato($this->id_contrato);
                        $finSubFiscais->setIdPessoa($subFiscalSubstituto);
                        $finSubFiscais->setDtIniSubFiscal(date('Y-m-d'));
                        $finSubFiscais->setTpSubFiscal(2);
                        $finSubFiscais->cadastraSubFiscal($pdo);
                        if (!$finSubFiscais->sucesso()) {
                            $sucesso = false;
                        }

                        if ($sucesso == false) {
                            $retorno = Metodos::retornoAjax("Erro", "console", $finSubFiscais->getMsgRetorno());
                            $pdo->rollBack();
                            return $retorno;
                            break;
                        }
                    }
                }
            }
            //**********************************************************************************

            //editar fornecedor
            $fornecedor = new FinFornecedoresModel();
            $fornecedor->setIdPessoa($this->id_pessoaFornecedor);
            $fornecedor->setIdFornecedor($this->id_fornecedor);
            $fornecedor->editarFornecedor($pdo);

            if (!$fornecedor->sucesso()) {
                $sucesso = false;
            }

            $daoFinContrato->retornaContrato($pdo);
            $busca = $daoFinContrato->getMsgRetorno();

            //log do cadastramento da ata
            if (!Log::SalvaLogU('fin_contrato', $this->id_contrato, $busca, $pdo)) {
                $sucesso = false;
            }

            if ($sucesso) {
                $retorno = Metodos::retornoAjax("ok", "html", $this->id_fornecedor);
                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR . '25');
                $pdo->rollBack();
                return $retorno;
            }
        } catch (Exception $ex) {
            
        }
    }

    /**
     * Metodo responsavel por cadastrar o contrato no sistema
     * @return type
     */
    public function cadastrarContrato() {
        try {
            if (empty($this->id_pessoa) || empty($this->id_pessoaFornecedor) || empty($this->nr_contrato) || empty($this->nr_prazo_entrega) || empty($this->ds_objeto) || empty($this->dt_ini_vigencia_contrato) || empty($this->dt_fim_vigencia_contrato) || empty($this->dt_assinatura) || empty($this->dt_publicacao)) {
                return Metodos::retornoAjax("Erro1", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $daoContrato = new DaoFinContrato();
            $sucesso = true;
            //Seta os campos
            $daoContrato->setNrContrato($this->nr_contrato);
            $daoContrato->setIdProcesso($this->id_processo);
            $daoContrato->setNrPrazoEntrega($this->nr_prazo_entrega);
            if (empty($this->id_contrato_alt)) {
                $daoContrato->setIdContratoAlt(null);
            } else {
                $daoContrato->setIdContratoAlt($this->id_contrato_alt);
            }
            $daoContrato->setDsObjeto($this->ds_objeto);
            $daoContrato->setDtIniVigenciaContrato(Metodos::ConverteDataING($this->dt_ini_vigencia_contrato));
            $daoContrato->setDtFimVigenciaContrato(Metodos::ConverteDataING($this->dt_fim_vigencia_contrato));
            $daoContrato->setDtAssinatura(Metodos::ConverteDataING($this->dt_assinatura));
            $daoContrato->setDtPublicacao(Metodos::ConverteDataING($this->dt_publicacao));
            $daoContrato->setDsObsContrato($this->ds_obs_contrato);
            $daoContrato->setTpContrato(2);
            //verificar valoes opcionais
            if ($this->fl_servico_continuado != '' && $this->fl_servico_continuado != "" && $this->fl_servico_continuado != null) {
                $daoContrato->setFlServicoContinuado($this->fl_servico_continuado);
            } else {
                $daoContrato->setFlServicoContinuado(0);
            }
            $daoContrato->setIdTipoGasto($this->id_tipo_gasto);
            //primeiro result é para verificar ser o contrato foi armazenado no banco de daods
            $daoContrato->insertContrato($pdo);
            if (!$daoContrato->sucesso()) {
                $retorno = Metodos::retornoAjax("Erro2", "console", $daoContrato->getMsgRetorno());
                $pdo->rollBack();
                return $retorno;
            }
            //pegando o id do contrato
            $daoContrato->setIdContrato($pdo->lastInsertId('fin_contrato_id_contrato_seq'));

            //cadastrar centrais
            if (!empty($this->id_lotacaoCentral)) {
                $finCentraisModel = new FinCentraisModel();

                foreach ($this->id_lotacaoCentral as $valor) {
                    $finCentraisModel->setIdContrato($daoContrato->getIdContrato());
                    $finCentraisModel->setIdLotacao($valor);
                    $finCentraisModel->cadastrarCentralContrato($pdo);
                    if (!$finCentraisModel->sucesso()) {
                        $sucesso = false;
                        break;
                    }

                    if ($sucesso == false) {
                        $retorno = Metodos::retornoAjax("Erro3", "console", $finCentraisModel->getMsgRetorno());
                        $pdo->rollBack();
                        return $retorno;
                    }
                }
            } else {
                return Metodos::retornoAjax("Erro1", "alert", STR_PREENCHER_CAMPOS);
            }

            //cadastrar gestor titular
            if (!empty($this->id_pessoa_gestor_titular)) {
                $finGestor = new FinGestorModel();
                $finGestor->cadastraGestor($pdo, $daoContrato->getIdContrato(), $this->id_pessoa_gestor_titular, 1);
                if (!$finGestor->sucesso()) {
                    $sucesso = false;
                }

                if ($sucesso == false) {
                    $retorno = Metodos::retornoAjax("Erro4", "console", $finGestor->getMsgRetorno());
                    $pdo->rollBack();
                    return $retorno;
                }
            }

            //cadastrar gestor substituto
            if (!empty($this->id_pessoa_gestor_substituto)) {
                $finGestor = new FinGestorModel();
                $finGestor->cadastraGestor($pdo, $daoContrato->getIdContrato(), $this->id_pessoa_gestor_substituto, 2);

                if (!$finGestor->sucesso()) {
                    $sucesso = false;
                }

                if ($sucesso == false) {
                    $retorno = Metodos::retornoAjax("Erro5", "console", $finGestor->getMsgRetorno());
                    $pdo->rollBack();
                    return $retorno;
                }
            }

            //cadastrar fiscal
            if (!empty($this->id_pessoa_fiscal_titular)) {
                $finFiscaisModel = new FinFiscaisModel();
                foreach ($this->id_pessoa_fiscal_titular as $valor) {
                    $finFiscaisModel->setIdPessoa($valor);
                    $finFiscaisModel->setIdContrato($daoContrato->getIdContrato());
                    $finFiscaisModel->setTpFiscal(1);
                    $finFiscaisModel->cadastraFiscal($pdo);

                    if (!$finFiscaisModel->sucesso()) {
                        $sucesso = false;
                        break;
                    }
                }

                if ($sucesso == false) {
                    $retorno = Metodos::retornoAjax("Erro6", "console", $finFiscaisModel->getMsgRetorno());
                    $pdo->rollBack();
                    return $retorno;
                }
            }

            //cadastrar fiscal substituto
            if (!empty($this->id_pessoa_fiscal_substituto)) {
                $finFiscaisModel = new FinFiscaisModel();
                foreach ($this->id_pessoa_fiscal_substituto as $valor) {
                    $finFiscaisModel->setIdPessoa($valor);
                    $finFiscaisModel->setIdContrato($daoContrato->getIdContrato());
                    $finFiscaisModel->setTpFiscal(2);
                    $finFiscaisModel->cadastraFiscal($pdo);

                    if (!$finFiscaisModel->sucesso()) {
                        $sucesso = false;
                        break;
                    }
                }

                if ($sucesso == false) {
                    $retorno = Metodos::retornoAjax("Erro7", "console", $finFiscaisModel->getMsgRetorno());
                    $pdo->rollBack();
                    return $retorno;
                }
            }

            //cadastrar Subfiscal
            if (!empty($this->id_pessoa_sub_fiscal_titular)) {
                $subFiscalModel = new SubFiscalModel();
                foreach ($this->id_pessoa_sub_fiscal_titular as $valor) {
                    $subFiscalModel->setIdPessoa($valor);
                    $subFiscalModel->setIdContrato($daoContrato->getIdContrato());
                    $subFiscalModel->setTpSubFiscal(1);
                    $subFiscalModel->cadastraSubFiscal($pdo);

                    if (!$subFiscalModel->sucesso()) {
                        $sucesso = false;
                        break;
                    }
                }

                if ($sucesso == false) {
                    $retorno = Metodos::retornoAjax("Erro8", "console", $subFiscalModel->getMsgRetorno());
                    $pdo->rollBack();
                    return $retorno;
                }
            }

            //cadastrar Subfiscal substituto
            if (!empty($this->id_pessoa_sub_fiscal_substituto)) {
                $subFiscalModel = new SubFiscalModel();
                foreach ($this->id_pessoa_sub_fiscal_substituto as $valor) {
                    $subFiscalModel->setIdPessoa($valor);
                    $subFiscalModel->setIdContrato($daoContrato->getIdContrato());
                    $subFiscalModel->setTpSubFiscal(2);
                    $subFiscalModel->cadastraSubFiscal($pdo);

                    if (!$subFiscalModel->sucesso()) {
                        $sucesso = false;
                        break;
                    }
                }

                if ($sucesso == false) {
                    $retorno = Metodos::retornoAjax("Erro9", "console", $subFiscalModel->getMsgRetorno());
                    $pdo->rollBack();
                    return $retorno;
                }
            }

            //cadastrar fornecedor
            $fornecedor = new FinFornecedoresModel();
            $fornecedor->setIdContrato($daoContrato->getIdContrato());
            $fornecedor->setIdPessoa($this->id_pessoaFornecedor);
            $fornecedor->cadastrarFornecedores($pdo);
            if (!$fornecedor->sucesso()) {
                $sucesso = false;
            }

            //segundo result verifica ser a vigencia do contrato foi armazenada no banco
            $daoContrato->cadastrarContratoVigencia($pdo);
            if (!$daoContrato->sucesso()) {
                $retorno = Metodos::retornoAjax("Erro", "console10", $daoContrato->getMsgRetorno());
                $pdo->rollBack();
                return $retorno;
            }

            if (Log::SalvaLogI('fin_contrato', $daoContrato->getIdContrato(), $pdo)) {
                $sucesso = true;
            } else {
                $retorno = Metodos::retornoAjax("Erro11", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }
            if ($sucesso) {
                //verifico ser o contrato tem ata ou nao
                if (empty($this->id_contrato_alt)) {
                    $retorno = Metodos::retornoAjax("ok", "noAta", $fornecedor->getMsgRetorno());
                } else {
                    $retorno = Metodos::retornoAjax("ok", "ata", $fornecedor->getMsgRetorno());
                }

                $pdo->commit();
                return $retorno;
            } else {
                $retorno = Metodos::retornoAjax("Erro12", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }

        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro14", "console", $exc->getMessage());
        }
    }

    /**
     * [retornaLicitacaoGcon esse metodo foi criado só para teste tem que ser retirado a sim que criar a classe do gcon]
     * @return [type] [retorna um array com os dados do gcon de acordo com alguma licitação]
     */
    public function retornaLicitacaoGcon() {
        try {
            //variaveis do sistema
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoContrato = new DaoFinContrato();
            $retorno = '';
            $result = 0;
            $result = $daoContrato->retornaProcessoCombo($pdo);
            foreach ($result as $value) {
                $retorno .= '<tr class="selecionaItem" processo="' . $value["id_processo"] . '" style="cursor:pointer;">
                <td>' . $value["cd_ada_cpr"] . '</td>
                <td>' . $value["cd_pregao"] . '</td>
                <td>' . $value["tipo_gasto"] . '</td>
                <td>' . $value["nm_objeto"] . '</td>
                <td>' . $value["modalidade"] . '</td>
                </tr>';
            }
            return $retorno;
        } catch (Exception $e) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    /**
     * Metodos que retorna os contratos vigentes 
     * @return string
     */
    public function retornaOptionsContratosVigentes() {
        try {
            //variaveis do sistema
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoContrato = new DaoFinContrato();
            $retorno = '';
            //fim de variaveis
            $daoContrato->retornaContratosBasicoVigentes($pdo);
            foreach ($daoContrato->getMsgRetorno() as $value) {
                $retorno .= '<option value=' . $value["id_contrato"] . '>' . $value["nr_contrato"] . '-' . $value["nm_objeto"] . '</option>';
            }
            return $retorno;
        } catch (Exception $e) {
            return Metodos::retornoAjax("Erro", "console", $e->getMessage());
        }
    }

    public function retornaContratosVigentes() {
        try {
            //variaveis do sistema
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoContrato = new DaoFinContrato();
            //fim de variaveis
            $daoContrato->retornaContratosBasicoVigentes($pdo);
            if ($daoContrato->sucesso()) {
                $result = $daoContrato->getMsgRetorno();
            } else {
                $result = [];
            }

            return json_encode($result);
        } catch (Exception $e) {
            return Metodos::retornoAjax("Erro", "console", $e->getMessage());
        }
    }

    public function retornaPesquisaContrato($dados = '') {
        try {
            //variaveis do sistema
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoContrato = new DaoFinContrato();
            $filter = array();
            //fim de variaveis
            if (!empty($dados['tipoCont'])) {
                $filter[] = "cont.tp_contrato = '" . $dados['tipoCont'] . "'";
            }

            if (!empty($dados['tipoGasto'])) {
                $filter[] = "processo.id_tipo_gasto = '" . $dados['tipoGasto'] . "'";
            }

            if (!empty($dados['central'])) {
                $daoContrato->setIdLotacaoCentral($dados['central']);
                $daoContrato->retornaIdContratoPorCentrais($pdo);
                $idContrato = '';
                $arrayIdContrato = array();
                if ($daoContrato->sucesso()) {
                    foreach ($daoContrato->getMsgRetorno() as $linha) {
                        $arrayIdContrato [] = $linha["id_contrato"];
                    }
                    $idContrato = implode(' , ', $arrayIdContrato);
                }

                $filter[] = "cont.id_contrato in(" . $idContrato . ")";
            }

            if (!empty($dados['contratado'])) {
                $filter[] = "itens.id_pessoa = '" . $dados['contratado'] . "'";
            }

            //*************************************************
            if (count($filter) > 0) {
                $filtro = " and " . implode(' and ', $filter);
            } else {
                return false;
            }


//            $daoContrato->retornaContratoCombo($pdo, $filtro);
            $daoContrato->retornaContratoComValores($pdo, $filtro);
            if ($daoContrato->sucesso()) {
                $result = $daoContrato->getMsgRetorno();
            } else {
                return Metodos::retornoAjax("Erro", "console", $daoContrato->getMsgRetorno());
                $result = [];
            }
            $tabela = '';
            $central = 0;

            foreach ($result as $linha) {
                $daoContrato->setIdContrato($linha["id_contrato"]);
                $daoContrato->retornaCentraisContrato($pdo);
                $central = $daoContrato->getMsgRetorno();
                $tabela .= '<tr>
                                <td class = "text-center">' . $linha["nr_contrato"] . '</td>
                                <td class = "text-center">' . $linha["nm_pessoa"] . '</td>
                                <td class = "text-center">' . $linha["nm_tipo_gasto"] . '</td>
                                <td class = "text-center">' . $linha["nm_modalidade"] . '</td>
                                <td class = "text-center">';
                foreach ($central as $l) {
                    $tabela .= $l["nm_lotacao"] . "<br/>";
                }
                $tabela .= '</td>';


                if (!empty($linha['total_geral'])) { //Para evitar divisão por '0'
                    $percentualUtilizado = ($linha['total_utilizado'] * 100) / $linha['total_geral'];
                } else {
                    $percentualUtilizado = 0;
                }


                $tabela .= '<td class = "text-center">' . number_format($percentualUtilizado, 2, ",", ".") . '</td>';

                $tabela .= '<td class = "text-center">';
                if ($linha['fl_bloqueado'] == 0) {
                    $tabela .= '<button type = "button" title = "bloquear" class = "bloquear" value = "' . $linha['id_contrato'] . '">
                                <i class="fa fa-check text-success" aria-hidden="true"></i>
                                </button >';
                } else {
                    $tabela .= '<button type = "button" title = "bloquear" class = "bloquear" value = "' . $linha['id_contrato'] . '">
                                <i class="fa fa-ban text-danger" aria-hidden="true"></i>
                                </button >';
                }
                $tabela .= '
                    <button type = "button" title = "espelho do contrato" class = "espelho" value = "' . $linha['id_fornecedor'] . '">
                    <i class="fa fa-file-text-o text-info" aria-hidden="true"></i>
                    </button >

                    <button type = "button" title = "editar" class = "editar" value = "' . $linha['id_fornecedor'] . '">
                    <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>
                    </button >

                    <button type="button" title="Excluir ordem" class="excluir text-danger" value="' . $linha['id_fornecedor'] . '" >
                    <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>  
                </td>
                </tr>';
            }
            return Metodos::retornoAjax("ok", "tabela", $tabela);
        } catch (Exception $e) {
            return Metodos::retornoAjax("Erro", "console", $e->getMessage());
        }
    }

    public function verificarAtaContrato() {
        try {
            //variaveis do sistema
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoContrato = new DaoFinContrato();
            $daoContrato->setIdFornecedor($this->id_fornecedor);
            $daoContrato->verificarContratoAta($pdo);
            if ($daoContrato->sucesso()) {
                echo "sim";
            } else {
                echo "nao";
            }
            //fim de variaveis
        } catch (Exception $e) {
            return Metodos::retornoAjax("Erro", "console", $e->getMessage());
        }
    }

    public function retornaDados() {
        try {
            //variaveis do sistema
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoContrato = new DaoFinContrato();
            $daoContrato->setIdFornecedor($this->id_fornecedor);
            $daoContrato->retornaDadosParaEdicao($pdo);

            if ($daoContrato->sucesso()) {
                return $daoContrato->getMsgRetorno();
            } else {
                return FALSE;
            }
            //fim de variaveis
        } catch (Exception $e) {
            return Metodos::retornoAjax("Erro", "console", $e->getMessage());
        }
    }

    public function retornaTipoDeGastoLicitacao($idProcesso) {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $licitacao = new DaoProcesso();
            $licitacao->setIdProcesso($idProcesso);
            $retorno = '<option value = "">Seleciona um tipo de gasto</option>';

            $busca = $licitacao->retornaTiposGastoProcesso($pdo);
            foreach ($busca as $value) {
                if (count($busca) > 1) {
                    $retorno .= '<option value = "' . $value["id_tipo_gasto"] . '">' . $value["nm_tipo_gasto"] . '</option>';
                } else {
                    $retorno .= '<option value = "' . $value["id_tipo_gasto"] . '" selected>' . $value["nm_tipo_gasto"] . '</option>';
                }
            }
            return $retorno;
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

    /**
     * Retorna uma TR contendo os dados do contrato que será utilizado na tela do aditivo 
     * para o usuário selecionar Qual contrato irá utilizar para aquele aditivo
     * @return string
     */
    public function retornaContratoSelectItem() {
        try {
            //variaveis do sistema
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoContrato = new DaoFinContrato();
            $daoContrato->setNrContrato($this->nr_contrato);
            $retorno = '';
            $daoContrato->pesquisaContratoPorNumero($pdo);
            if ($daoContrato->sucesso()) {
                foreach ($daoContrato->getMsgRetorno() as $value) {
                    $retorno .= "<tr class='selecionaItem' data-contrato='" . json_encode($value) . "' contrato='" . $value["id_contrato"] . "' style='cursor:pointer;'>";

                    $retorno .= '<td>' . $value["nr_contrato"] . '</td>
                        <td>' . $value['nm_pessoa'] . '</td>
                        <td>' . $value["nm_tipo_gasto"] . '</td>
                        <td>' . $value["nm_objeto"] . '</td>
                        <td>' . $value["nm_modalidade"] . '</td>
                        <td>' . $value["valor"] . '</td>
                        </tr>';
                }
            }

            return $retorno;
        } catch (Exception $e) {
            return Metodos::retornoAjax("Erro", "console", $e->getMessage());
        }
    }

    function retornaDadosContratoCompleto(PDO $pdo) {

        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }

            $daoContrato = new DaoFinContrato();
            $daoContrato->setIdContrato($this->id_contrato);
            $daoContrato->retornaDadosSemItens($pdo);
            if (!$daoContrato->sucesso()) {
                $this->msgRetorno = $daoContrato->getMsgRetorno();
                $this->sucesso = false;
                return;
            }
            $r = $daoContrato->getMsgRetorno();

            $cont = new FinContratoModel();
            $cont->setIdContrato($r['id_contrato']);
            $cont->setNrContrato($r['nr_contrato']);
            $cont->setNrPrazoEntrega($r['nr_prazo_entrega']);
            $cont->setIdProcesso($r['id_processo'])
                    ->setIdPessoa($r['id_pessoa'])
                    ->setDsObjeto($r['ds_objeto'])
                    ->setFlServicoContinuado($r['fl_servico_continuado'])
                    ->setDtIniVigenciaContrato($r['dt_ini_vigencia_contrato'])
                    ->setDtFimVigenciaContrato($r['dt_fim_vigencia_contrato'])
                    ->setDtAssinatura($r['dt_assinatura'])
                    ->setDtPublicacao($r['dt_publicacao'])
                    ->setDsObsContrato($r['ds_obs_contrato'])
                    ->setStAtivo($r['st_ativo'])
                    ->setIdModalidade($r['id_modalidade'])
                    ->setDsAreaAbrangencia($r['ds_area_abrangencia'])
                    ->setDsUnidadeContemplada($r['ds_unidade_contemplada'])
                    ->setIdOrgaoGerenciador($r['id_orgao_gerenciador'])
                    ->setIdTipoGasto($r['id_tipo_gasto'])
                    ->setVlContrato($r['vl_contrato'])
                    ->setTpContrato($r['tp_contrato'])
                    ->setFlCarona($r['fl_carona'])
                    ->setIdContratoAlt($r['id_contrato_alt'])
                    ->setSqContrato($r['sq_contrato']);
            $cont->setIdContratoAditivoPai($r['id_contrato_aditivo_pai']);

            $fornecedor = new FinFornecedoresModel();
            $fornecedor->setIdContrato($r['contrato_fornecedor']);
            $fornecedor->setIdFornecedor($r['id_fornecedor']);
            $fornecedor->setIdPessoa($r['pessoa_fornecedor']);
            $fornecedor->setSitFornecedor($r['sit_fornecedor']);

            $cont->setFornecedor($fornecedor);

            //Carrega Dados do Aditivo
            $contratoAditivo = new FinContratoAditivo();
            $contratoAditivo->setIdContratoAditivo($r['id_contrato_aditivo']);
            $contratoAditivo->setIdContrato($r['contrato_aditivo']);
            $contratoAditivo->setIdMotivo($r['id_contrato_motivo']);
            $contratoAditivo->setIdFinalidade($r['id_contrato_finalidade']);
            $contratoAditivo->setIdInstrumento($r['id_contrato_instrumento']);
            $contratoAditivo->setIdBaseCalculo($r['id_contrato_base_calculo']);
            $contratoAditivo->setIdUnidadeCalculo($r['id_contrato_unidade_calculo']);
            $contratoAditivo->setIdTipoAquisicao($r['id_contrato_aquisicao']);
            $contratoAditivo->setDsJustificativa($r['ds_justificativa']);
            $contratoAditivo->setNumeroNovoAditivo($r['nr_aditivo']);
            $contratoAditivo->setDtPeriodoInicial($r['dt_inicial']);
            $contratoAditivo->setDtPeriodoFinal($r['dt_final']);
            $contratoAditivo->setPercentual($r['nr_percentual_indice']);

            $cont->setContratoAditivo($contratoAditivo);

            //Busca dos Itens
            $itens = new ItemModel();
            $itens->setIdFornecedor($r['id_fornecedor']);
            $itens->retornaItensPorFornecedor($pdo);

            if ($itens->Sucesso()) {
                foreach ($itens->getMsgRetorno() as $key => $result) {
                    $item = new ItemModel();
                    $item->setIdContItens($result['id_cont_itens']);
                    $item->setNrItem($result['nr_item']);
                    $item->setNrLote($result['nr_lote']);
                    $item->setNmMarca($result['nm_marca']);
                    $item->setNmModelo($result['nm_modelo']);
                    $item->setQtItens($result['qt_itens']);
                    $item->setVlItens($result['vl_itens']);
                    $item->setPcDesconto($result['pc_desconto']);
                    $item->setFlValorVariavel($result['fl_valor_variavel']);
                    $item->setDescItem($result['nm_material']);
                    $item->setIdMaterial($result['id_material']);
                    $item->setIdFornecedor($result['id_fornecedor']);
                    $item->setIdContItensAlt($result['id_cont_itens_alt']);
                    $item->setIdUnidadeMedida($result['id_unidade_medida']);    
                    $item->setIdContItensAditivo($result['id_cont_itens_aditivo']);                    
                    $item->setQtItensAux($result['qt_itens_aux']);                    
                    $cont->setItems($item);
                }
            }

            $this->msgRetorno = $cont;
            $this->sucesso = true;
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

    public function cadastrarContratoComAditivo(FinContratoTb $c, FinFornecedoresTb $f
    , FinContratoAditivoTb $finContratoAdtivo
    , array $centraisDoContrato
    , array $gestorTitular = NULL, array $gestorSubstituto = NULL
    , array $fiscal = NULL, array $fiscalSubstituto = NULL
    , array $subFiscal = NULL, array $subFiscalSubstituto = NULL
    , $itens
    , PDO $pdo) {
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();
            }

            if (empty($c->getNrContrato()) || empty($c->getDtIniVigenciaContrato()) || empty($c->getDtFimVigenciaContrato()) || empty($c->getDtAssinatura()) || empty($c->getDtPublicacao()) || empty($itens)) {
                $this->sucesso = false;
                $this->msgRetorno = STR_PREENCHER_CAMPOS;
                $pdo->rollBack();
                return;
            }

            $daoContrato = new DaoFinContrato();
            //Seta os campos
            $daoContrato->setNrContrato($c->getNrContrato());
            $daoContrato->setIdProcesso($c->getIdProcesso());
            $daoContrato->setNrPrazoEntrega($c->getNrPrazoEntrega());

            if (empty($c->getIdPessoa())) {
                $daoContrato->setIdPessoa(NULL);
            } else {
                $daoContrato->setIdPessoa($c->getIdPessoa());
            }

            $daoContrato->setDsObjeto($c->getDsObjeto());

            if (!empty($c->getFlServicoContinuado())) {
                $daoContrato->setFlServicoContinuado($c->getFlServicoContinuado());
            } else {
                $daoContrato->setFlServicoContinuado(0);
            }
            $daoContrato->setDtIniVigenciaContrato($c->getDtIniVigenciaContrato());
            $daoContrato->setDtFimVigenciaContrato($c->getDtFimVigenciaContrato());
            $daoContrato->setDtAssinatura($c->getDtAssinatura());
            $daoContrato->setDtPublicacao($c->getDtPublicacao());
            $daoContrato->setDsObsContrato($c->getDsObsContrato());

            if (empty($c->getIdModalidade())) {
                $daoContrato->setIdModalidade(NULL);
            } else {
                $daoContrato->setIdModalidade($c->getIdModalidade());
            }

            $daoContrato->setDsAreaAbrangencia($c->getDsAreaAbrangencia());
            $daoContrato->setDsUnidadeContemplada($c->getDsUnidadeContemplada());

            if (empty($c->getIdOrgaoGerenciador())) {
                $daoContrato->setIdOrgaoGerenciador(NULL);
            } else {
                $daoContrato->setIdOrgaoGerenciador($c->getIdOrgaoGerenciador());
            }

            if (empty($c->getIdTipoGasto())) {
                $daoContrato->setIdTipoGasto(NULL);
            } else {
                $daoContrato->setIdTipoGasto($c->getIdTipoGasto());
            }

            $daoContrato->setTpContrato(2);

            if (empty($c->getIdContratoAlt())) {
                $daoContrato->setIdContratoAlt(NULL);
            } else {
                $daoContrato->setIdContratoAlt($c->getIdContratoAlt());
            }

            $daoContrato->setSqContrato($c->getSqContrato());
            $daoContrato->setIdContratoAditivoPai($c->getIdContratoAditivoPai());


            //primeiro result é para verificar ser o contrato foi armazenado no banco de daods
            $daoContrato->insertContratoParaAditivo($pdo);
            if (!$daoContrato->sucesso()){
                $this->sucesso = false;
                $this->msgRetorno = $daoContrato->getMsgRetorno();
                $pdo->rollBack();
                return;
            }
            //Pegando o id do contrato
            $daoContrato->setIdContrato($pdo->lastInsertId('fin_contrato_id_contrato_seq'));
            if (Log::SalvaLogI('fin_contrato', $daoContrato->getIdContrato(), $pdo)) {
                $sucesso = true;
            } else {
                $this->sucesso = false;
                $this->msgRetorno = STR_ERROR;
                $pdo->rollBack();
                return;
            }

            //Final do Cadastro do Contrato
            //Iniciar o Cadastro do Fornecedor
            //cadastrar fornecedor
            $fornecedor = new FinFornecedoresModel();
            $fornecedor->setIdContrato($daoContrato->getIdContrato());
            $fornecedor->setIdPessoa($f->getIdPessoa());
            $fornecedor->cadastrarFornecedores($pdo);
            if (!$fornecedor->sucesso()) {
                $this->sucesso = false;
                $this->msgRetorno = "Não foi Possível Cadastrar o novo Fornecedor";
                $pdo->rollBack();
                return;
            }

            $fornecedor->setIdFornecedor($fornecedor->getMsgRetorno());


            //Inicia o Cadastro do Aditivo
            $aditivo = new FinContratoAditivo();
            $finContratoAdtivo->setIdContrato($daoContrato->getIdContrato());
            $aditivo->inserirAditivo($finContratoAdtivo, $pdo);

            if (!$aditivo->Sucesso()) {
                $this->sucesso = false;
                $this->msgRetorno = "Não foi possível Cadastrar os Dados do Aditivo";
                $pdo->rollBack();
                return;
            }

            //Adiciona os Itens para o Novo Fornecedor
            $itemModal = new ItemModel();
            $itemModal->cadastraItensContratoAditivo($itens, (int) $fornecedor->getIdFornecedor(), $pdo);
            if (!$itemModal->Sucesso()) {
                $this->sucesso = false;
                $this->msgRetorno = "Não foi possível Cadastrar os Itens do Contrato";
                $pdo->rollBack();
                return;
            }
            
            //Ajusta Dados do Saldo
            
            $itensComIds = $itemModal->getMsgRetorno();
            //$itensComIds[0]['']
            
            $motivo = "Cadastro de Aditivo";
            $novoGrupo = false;
            if($aditivo->getMotivoPorPrazo() == $finContratoAdtivo->getIdContratoMotivo()
                    || $aditivo->getMotivoPorValorePrazo() == $finContratoAdtivo->getIdContratoMotivo()){
                $novoGrupo = true;
            }            
            
            $novoGrupo = true;
            $finContItensSaldo = new FinContItensSaldo();
            $finContItensSaldo->salvar($itensComIds, $novoGrupo, $motivo, $pdo);
            
            echo "<pre>";
            print_r($finContItensSaldo->getMsgRetorno());
            echo "</pre>";
            
//            echo "<pre>";
//            print_r($itensComIds);
//            echo "</pre>";
            $this->sucesso = false;
            $this->msgRetorno = "OW YEAH";
            $pdo->rollBack();
            return;
            
            //
            //Adiciona as Centrais do Contrato no Fin Cont Central, Se Existir
            if (!empty($centraisDoContrato)) {
                $finCentraisModel = new FinCentraisModel();
                $finCentraisModel->setIdContrato($daoContrato->getIdContrato());
                foreach ($centraisDoContrato as $value) {
                    $finCentraisModel->setIdLotacao($value['id_lotacao']);
                    $finCentraisModel->cadastrarCentralContrato($pdo);
                    if (!$finCentraisModel->sucesso()) {
                        $this->sucesso = false;
                        $this->msgRetorno = $finCentraisModel->getMsgRetorno();
                        $pdo->rollBack();
                        return;
                    }
                }
            }


            //cadastrar gestor titular
            if (!empty($gestorTitular)){
                $finGestor = new FinGestorModel();
                $finGestor->setIdContrato($daoContrato->getIdContrato());
                $finGestor->setTpGestor(1);
                $finGestor->setDtIniGestor($daoContrato->getDtIniVigenciaContrato());
                foreach ($gestorTitular as $valor){
                    $finGestor->setIdPessoa($valor);
                    $finGestor->cadastraGestorAditivo($pdo);
                    if (!$finGestor->sucesso()){
                        $this->sucesso = false;
                        $this->msgRetorno = $finGestor->getMsgRetorno();
                        $pdo->rollBack();
                        return;
                    }
                }
            }

            //cadastrar gestor substituto
            if (!empty($gestorSubstituto)){
                $finGestor = new FinGestorModel();
                $finGestor->setIdContrato($daoContrato->getIdContrato());
                $finGestor->setTpGestor(2);
                $finGestor->setDtIniGestor($daoContrato->getDtIniVigenciaContrato());
                foreach ($gestorSubstituto as $valor){
                    $finGestor->setIdPessoa($valor);

                    $finGestor->cadastraGestorAditivo($pdo);
                    if (!$finGestor->sucesso()){
                        $this->sucesso = false;
                        $this->msgRetorno = $finGestor->getMsgRetorno();
                        $pdo->rollBack();
                        return;
                    }
                }
            }

            //cadastrar fiscal
            if (!empty($fiscal)){
                $finFiscaisModel = new FinFiscaisModel();
                $finFiscaisModel->setIdContrato($daoContrato->getIdContrato());
                $finFiscaisModel->setDtIniFiscal($daoContrato->getDtIniVigenciaContrato());
                $finFiscaisModel->setTpFiscal(1);
                foreach ($fiscal as $valor){
                    $finFiscaisModel->setIdPessoa($valor);
                    $finFiscaisModel->cadastraFiscalAditivo($pdo);
                    if (!$finFiscaisModel->sucesso()){
                        $this->sucesso = false;
                        $this->msgRetorno = $finFiscaisModel->getMsgRetorno();
                        $pdo->rollBack();
                        return;
                    }
                }
            }

            //cadastrar fiscal substituto
            if (!empty($fiscalSubstituto)){
                $finFiscaisModel = new FinFiscaisModel();
                $finFiscaisModel->setIdContrato($daoContrato->getIdContrato());
                $finFiscaisModel->setDtIniFiscal($daoContrato->getDtIniVigenciaContrato());
                $finFiscaisModel->setTpFiscal(2);
                foreach ($fiscalSubstituto as $valor){
                    $finFiscaisModel->setIdPessoa($valor);
                    $finFiscaisModel->cadastraFiscalAditivo($pdo);
                    if (!$finFiscaisModel->sucesso()){
                        $this->sucesso = false;
                        $this->msgRetorno = $finFiscaisModel->getMsgRetorno();
                        $pdo->rollBack();
                        return;
                    }
                }
            }


            //cadastrar Subfiscal
            if (!empty($subFiscal)){
                $subFiscalModel = new SubFiscalModel();
                $subFiscalModel->setIdContrato($daoContrato->getIdContrato());
                $subFiscalModel->setDtIniSubFiscal($daoContrato->getDtIniVigenciaContrato());
                $subFiscalModel->setTpSubFiscal(1);
                foreach ($subFiscal as $valor) {
                    $subFiscalModel->setIdPessoa($valor);
                    $subFiscalModel->cadastraSubFiscalAditivo($pdo);
                    if (!$subFiscalModel->sucesso()){
                        $this->sucesso = false;
                        $this->msgRetorno = $subFiscalModel->getMsgRetorno();
                        $pdo->rollBack();
                        return;
                    }
                }
            }

            //cadastrar Subfiscal substituto
            if (!empty($subFiscalSubstituto)){
                $subFiscalModel = new SubFiscalModel();
                $subFiscalModel->setIdContrato($daoContrato->getIdContrato());
                $subFiscalModel->setDtIniSubFiscal($daoContrato->getDtIniVigenciaContrato());
                $subFiscalModel->setTpSubFiscal(2);
                foreach ($subFiscalSubstituto as $valor){
                    $subFiscalModel->setIdPessoa($valor);
                    $subFiscalModel->cadastraSubFiscalAditivo($pdo);
                    if (!$subFiscalModel->sucesso()){
                        $this->sucesso = false;
                        $this->msgRetorno = $subFiscalModel->getMsgRetorno();
                        $pdo->rollBack();
                        return;
                    }
                }
            }

            $this->sucesso = true;
            $this->msgRetorno = "ok";

            return;
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
            $pdo->rollBack();
            return;
        }
    }

    public function carregaDados(PDO $pdo) {
        try {

            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }

            if (empty($this->id_contrato)) {
                $this->sucesso = false;
                $this->msgRetorno = "Não foi possível localizar o Contrato";
                return;
            }

            $dao = new DaoFinContrato();
            $dao->setIdContrato($this->id_contrato);
            $dao->retornaContrato($pdo);

            if ($dao->sucesso()) {

                $result = $dao->getMsgRetorno();
                $this->nr_contrato = $result['nr_contrato'];
                $this->nr_prazo_entrega = $result['nr_prazo_entrega'];
                $this->id_processo = $result['id_processo'];
                $this->id_pessoa = $result['id_pessoa'];
                $this->ds_objeto = $result['ds_objeto'];
                $this->fl_servico_continuado = $result['fl_servico_continuado'];
                $this->dt_ini_vigencia_contrato = $result['dt_ini_vigencia_contrato'];
                $this->dt_fim_vigencia_contrato = $result['dt_fim_vigencia_contrato'];
                $this->dt_assinatura = $result['dt_assinatura'];
                $this->dt_publicacao = $result['dt_publicacao'];
                $this->ds_obs_contrato = $result['ds_obs_contrato'];
                $this->id_modalidade = $result['id_modalidade'];
                $this->ds_area_abrangencia = $result['ds_area_abrangencia'];
                $this->ds_unidade_contemplada = $result['ds_unidade_contemplada'];
                $this->id_orgao_gerenciador = $result['id_orgao_gerenciador'];
                $this->id_tipo_gasto = $result['id_tipo_gasto'];
                $this->vl_contrato = $result['vl_contrato'];
                $this->tp_contrato = $result['tp_contrato'];
                $this->fl_carona = $result['fl_carona'];
                $this->id_contrato_alt = $result['id_contrato_alt'];
                $this->sq_contrato = $result['sq_contrato'];
                $this->id_contrato_aditivo_pai = $result['id_contrato_aditivo_pai'];

                $this->sucesso = true;
                return;
            } else {
                $this->sucesso = false;
                $this->msgRetorno = $dao->getMsgRetorno();
                return;
            }

            $this->sucesso = false;
            $this->msgRetorno = "Não foi possível localizar o Contrato";
            return;
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
            return;
        }
    }

    public function removeContratoAditivo(int $idContrato, int $idFornecedor, int $idContratoAditivo, PDO $pdo) {
        try {

            //Remove Sub Fiscal do Contrato
            $finSubFiscal = new SubFiscalModel();
            $finSubFiscal->setIdContrato($idContrato);
            $finSubFiscal->removerAditivoPorContrato($pdo);
            if (!$finSubFiscal->sucesso()) {
                $this->sucesso = false;
                $this->msgRetorno = $finSubFiscal->getMsgRetorno();
                return;
            }

            //Remove Fiscal do Contrato
            $finFiscal = new FinFiscaisModel();
            $finFiscal->setIdContrato($idContrato);
            $finFiscal->removerAditivoPorContrato($pdo);
            if (!$finFiscal->sucesso()) {
                $this->sucesso = false;
                $this->msgRetorno = $finFiscal->getMsgRetorno();
                return;
            }

            //Remove Gestor do Contrato
            $finGestor = new FinGestorModel();
            $finGestor->setIdContrato($idContrato);
            $finGestor->removerAditivoPorContrato($pdo);
            if (!$finGestor->sucesso()) {
                $this->sucesso = false;
                $this->msgRetorno = $finGestor->getMsgRetorno();
                return;
            }


            //Remover o Contrato do Cont Central
            $finContCentral = new FinCentraisModel();
            $finContCentral->setIdContrato($idContrato);
            $finContCentral->removerAditivoPorContrato($pdo);
            if (!$finContCentral->sucesso()) {
                $this->sucesso = false;
                $this->msgRetorno = $finContCentral->getMsgRetorno();
                return;
            }


            //Remover os Itens do Contrato
            $finContItens = new ItemModel();
            $finContItens->setIdFornecedor($idFornecedor);
            $finContItens->removerAditivoPorFornecedor($pdo);
            if (!$finContItens->sucesso()) {
                $this->sucesso = false;
                $this->msgRetorno = $finContItens->getMsgRetorno();
                return;
            }


            //Remover o Fornecedor
            $finFornecedor = new FinFornecedoresModel();
            $finFornecedor->setIdFornecedor($idFornecedor);
            $finFornecedor->removerAditivoPorFornecedor($pdo);
            if (!$finFornecedor->sucesso()) {
                $this->sucesso = false;
                $this->msgRetorno = $finFornecedor->getMsgRetorno();
                return;
            }


            //Remover o Contrato Aditivo
            $finContratoAditivo = new FinContratoAditivo();
            $finContratoAditivo->setIdContratoAditivo($idContratoAditivo);
            $finContratoAditivo->removerAditivoPorContratoAditivo($pdo);
            if (!$finContratoAditivo->Sucesso()) {
                $this->sucesso = false;
                $this->msgRetorno = $finContratoAditivo->getMsgRetorno();
                return;
            }


            //Remover o Contrato
            $dao = new DaoFinContrato();
            $dao->setIdContrato($idContrato);
            $dao->retornaContrato($pdo);
            if ($dao->Sucesso()) {
                if (!Log::SalvaLogD('fin_contrato', $dao->getIdContrato(), $pdo)) {
                    $this->sucesso = false;
                    $this->msgRetorno = "Erro no Log do Contrato";
                    return;
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Não foi possível localizar o Contrato.";
                return;
            }

            $dao->delete($pdo);
            if (!$dao->Sucesso()) {
                $this->sucesso = false;
                $this->msgRetorno = $dao->getMsgRetorno();
                return;
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
            return;
        }
    }

    public function retornaContratoGdof($pdo, $nr_pedido) {
        try {

            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $dadosContrato = '';
            $daoContrato = new DaoFinContrato();
            $daoContrato->retornaDadosContratoGdof($pdo, $nr_pedido);
            if ($daoContrato->sucesso()) {
                $campos = $daoContrato->getMsgRetorno();

                $dadosContrato .= '<div class="panel-group" id="accordionOne" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingOne">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordionOne" href="#collapseOne" 
                                                        aria-expanded="false" aria-controls="collapseOne" class="collapsed">
                                                        <i class="glyphicon glyphicon-chevron-down"></i>
                                                        <b>Dados do Contrato: </b><span style="color:#758697"> Nº ' . $campos["nr_contrato"] . '</span> 
                                                    </a>
                                                </h4>
                                            </div>
                                        
                                            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false">
                                                <div class="panel-body">
                                                
                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Licitação:</b></div>
                                                        <div class="col-sm-10">' . $campos["cd_pregao"] . '</div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Tipo de Gasto:</b></div>
                                                        <div class="col-sm-10">' . $campos["nm_tipo_gasto"] . '</div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Objeto:</b></div>
                                                        <div class="col-sm-10">' . $campos["nm_objeto"] . '</div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Modalidade:</b></div>
                                                        <div class="col-sm-10">' . $campos["nm_modalidade"] . '</div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Fornecedor:</b></div>
                                                        <div class="col-sm-10">' . $campos["nm_pessoa"] . '</div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>CPF/CNPJ do Fornecedor:</b></div>
                                                        <div class="col-sm-10">' . Metodos::formataCnpj($campos["cpfcnpj"]) . '</div>
                                                    </div>
                                                    
                                                     <div class="form-group">
                                                        <div class="col-sm-2"><b>Processo Administrativo da Despesa Publica:</b></div>
                                                        <div class="col-sm-10"></div>
                                                    </div>
                                                </div>
                                            </div>
                                         </div>
                                    </div>';
                return $dadosContrato;
            }
            return $dadosContrato;
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
            return;
        }
    }

    public function retornaDadosContratoJson() {
        try {
            //variaveis do sistema
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoContrato = new DaoFinContrato();
            $daoContrato->setIdContrato($this->id_contrato);
            $retorno = '';
            $daoContrato->pesquisaDadosContrato($pdo);
            if ($daoContrato->sucesso()) {
                return json_encode($daoContrato->getMsgRetorno());
            }

            return $retorno;
        } catch (Exception $e) {
            return Metodos::retornoAjax("Erro", "console", $e->getMessage());
        }
    }

    public function retornaPesquisaComSaldoCondicao(string $filtro, PDO $pdo = null) {
        $this->sucesso = false;
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoContrato = new DaoFinContrato();
            $daoContrato->retornaContratoComValores($pdo, $filtro);
            if ($daoContrato->sucesso()) {
                $this->sucesso = true;
                $this->msgRetorno = $daoContrato->getMsgRetorno();
            } else {
                $this->sucesso = false;
                $this->msgRetorno = $daoContrato->getMsgRetorno();
            }
        } catch (Exception $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

}
