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
    private $id_pessoa = null;
    private $id_doc_tramitacao = null;
    private $id_doc_origem = null;
    private $id_doc_destino = null;
    
    
    private $docSitCadastrado = 1;
    private $docSitALiquidar = 2;
    private $docSitLiquidado = 3;
    private $docSitAPagar = 4;
    private $docSitPagoParcial = 5;
    private $docSitPago = 6;
    private $docSitCancelado = 7;
    
    private $tpTramAguardandoTramitacao = 1;
    private $tpTramAguardandoEncaminhamento = 2;
    private $tpTramEncaminhado = 3;
    private $tpTramAguardandoRecebimento = 4;
    private $tpTramRecebido = 5;
    private $tpTramTramitacaoFinalizada = 6;           

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
    
    function getDocSitCadastrado() {
        return $this->docSitCadastrado;
    }

    function getDocSitALiquidar() {
        return $this->docSitALiquidar;
    }

    function getDocSitLiquidado() {
        return $this->docSitLiquidado;
    }

    function getDocSitAPagar() {
        return $this->docSitAPagar;
    }

    function getDocSitPagoParcial() {
        return $this->docSitPagoParcial;
    }

    function getDocSitPago() {
        return $this->docSitPago;
    }

    function getDocSitCancelado() {
        return $this->docSitCancelado;
    }

    function getTpTramAguardandoTramitacao() {
        return $this->tpTramAguardandoTramitacao;
    }

    function getTpTramAguardandoEncaminhamento() {
        return $this->tpTramAguardandoEncaminhamento;
    }

    function getTpTramEncaminhado() {
        return $this->tpTramEncaminhado;
    }

    function getTpTramAguardandoRecebimento() {
        return $this->tpTramAguardandoRecebimento;
    }

    function getTpTramRecebido() {
        return $this->tpTramRecebido;
    }

    function getTpTramTramitacaoFinalizada() {
        return $this->tpTramTramitacaoFinalizada;
    }       

    public function salvaDocumentoFiscal() {
        try {
            if (empty($this->nr_processo_administrativo) || empty($this->nr_documento_fiscal) 
                    || empty($this->id_tipo_documento) || empty($this->dt_atesto)
                    || empty($this->dt_emissao) || empty($this->vl_documento) || empty($this->entrega)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            
            //Valida campos obrigatórios
            
            
            
            
            //conexao
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //
            $daoFinDocumentoFiscal = new DaoFinDocumentoFiscal();
            $daoFinDocumentoFiscal->setNrProcessoAdministrativo($this->nr_processo_administrativo);
            $daoFinDocumentoFiscal->setNrDocumentoFiscal($this->nr_documento_fiscal);
            $daoFinDocumentoFiscal->setMmCompetencia(explode("/", $this->competencia)[0]);
            $daoFinDocumentoFiscal->setAaCompetencia(explode("/", $this->competencia)[1]);
            $daoFinDocumentoFiscal->setDtAtesto(Metodos::ConverteDataING($this->dt_atesto));
            $daoFinDocumentoFiscal->setDtEmissao(Metodos::ConverteDataING($this->dt_emissao));
            $daoFinDocumentoFiscal->setVlDocumento(Metodos::ConverteValorIng($this->vl_documento));
            $daoFinDocumentoFiscal->setFlGrp($this->fl_grp);
            $daoFinDocumentoFiscal->setNrGrpNumero($this->nr_grp_numero);
            $daoFinDocumentoFiscal->setFlEncontroContas(0);
            $daoFinDocumentoFiscal->setIdLotacao($this->id_lotacao);
            $daoFinDocumentoFiscal->setIdTipoDocumento($this->id_tipo_documento);
            $daoFinDocumentoFiscal->cadasTraDocumentoFiscal($pdo);
            if (!$daoFinDocumentoFiscal->sucesso()) {
                $pdo->rollBack();
                var_dump($daoFinDocumentoFiscal->getMsgRetorno());
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
            

            //codigo abaixo cadastra a tramitacao  "Aguardando Tramitação" e a situacao "Cadastrado" do documento fiscal
            $docTramitacao = new DocTramitacao();
            $docTramitacao->setIdDocumentoFiscal($this->id_documento_fiscal);
            $docTramitacao->setIdPessoa($this->id_pessoa);
            $docTramitacao->setIdDocOrigem($this->id_doc_origem);
            $docTramitacao->setIdDocumentoSituacao(1);
            $docTramitacao->setDsDocTramitacao($this->ds_observacao);
            $docTramitacao->setIdTipoTramitacao(1);
            $docTramitacao->setFlPesquisa(1);
            if (!$docTramitacao->cadastraTramitacao($pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Erro ao salva a tramitaçao.");
            }
            //codigo abaixo cadastra a tramitacao  "Aguardando Encaminhamento" e a situacao "Cadastrado" do documento fiscal
            $docTramitacao->setFlPesquisa(0);
            $docTramitacao->setIdTipoTramitacao(2);
            if (!$docTramitacao->cadastraTramitacao($pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Erro ao salva a tramitaçao.");
            }
            
            $pdo->commit();
            return Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }
    
    function removerDocumentoFiscal(){
        try {                        
            $this->id_pessoa = (int) $this->id_pessoa;
            if(empty($this->id_documento_fiscal) 
                || empty($this->id_pessoa)
                || empty(trim($this->ds_observacao))){
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
                        
            //Somente será permitido cancelar um documento fiscal
            //Se o documento estiver com a situação cadastrado
            $idSituacao = $this->getDocSitCadastrado();            
            $justificativa = trim($this->ds_observacao);
            
            $dao = new DaoFinDocumentoFiscal();
            $dao->setIdDocumentoFiscal((int)$this->id_documento_fiscal);            
            $dao->verificaPermissaoPessoaSituacaoAtual($this->id_pessoa, $idSituacao, $pdo);
            if(!$dao->sucesso()){
                return Metodos::retornoAjax("Erro", "alert", "Usuário não tem permissão para Cancelar esse Documento.");
            }
            $result = $dao->getMsgRetorno();
            
//            echo "<pre>";
//            print_r($result);
//            echo "</pre>";
//            return;
            
            $docTramitacao = new DocTramitacao();
            $docTramitacao->setIdPessoa($this->id_pessoa);
            $docTramitacao->setIdDocOrigem($result['id_doc_lotacao']);
            $docTramitacao->setIdDocDestino(NULL);
            $docTramitacao->setDsDocTramitacao($justificativa);
            $docTramitacao->setIdDocumentoSituacao($this->getDocSitCancelado());
            $docTramitacao->setIdTipoTramitacao($this->getTpTramTramitacaoFinalizada());
            $docTramitacao->setIdDocumentoFiscal($this->id_documento_fiscal);
            $docTramitacao->setFlPesquisa("1");            
            if (!$docTramitacao->cadastraTramitacao($pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Erro ao salva a tramitaçao.");
            }
            
            $pdo->commit();
            return Metodos::retornoAjax("ok", "html", "Cancelamento do Documento Fiscal Realizado com Sucesso.");
            
            $pdo->rollBack();
            echo "<pre>";
            print_r($dao->getMsgRetorno());
            echo "</pre>";
            
            
            return;
            
            /**
             * Valida se o Documento Fiscal está no 
             */
            
            
           
                
            
            
            return Metodos::retornoAjax("Erro", "console", "Não foi possível concluir o Cancelamento do Documento Fiscal.");
            
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console",$exc->getMessage());
        }
    }

    public function retornaDadosContrato($pdo) {
        try {

            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }

            $dadosContrato = '';
            $daoFinDocumentoFiscal = new DaoFinDocumentoFiscal();
            $daoFinDocumentoFiscal->setIdDocumentoFiscal($this->id_documento_fiscal);
            $daoFinDocumentoFiscal->retornaIfContratoPorIdDocumento($pdo);

            if ($daoFinDocumentoFiscal->sucesso()) {
                $campos = $daoFinDocumentoFiscal->getMsgRetorno();

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
                                                        <div class="col-sm-2"><b>Tipo de gasto:</b></div>
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
                                                        <div class="col-sm-10">' . $campos["cpfcnpj"] . '</div>
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

    public function retornaDadosPedidoNecessidade($pdo) {
        try {

            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $dadosPedido = '';
            $daoFinDocumentoFiscal = new DaoFinDocumentoFiscal();
            $daoFinDocumentoFiscal->setIdDocumentoFiscal($this->id_documento_fiscal);
            $daoFinDocumentoFiscal->retornaIfPedidoPorIdDocumento($pdo);
            if ($daoFinDocumentoFiscal->sucesso()) {
                $campos = $daoFinDocumentoFiscal->getMsgRetorno();

                $dadosPedido .= '<div class="panel-group" id="accordionTwo" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingTwo">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordionTwo" href="#collapseTwo"
                                                        aria-expanded="false" aria-controls="collapseTwo" class="collapsed">
                                                        <i class="glyphicon glyphicon-chevron-down"></i>
                                                        <b>Dados do Pedido de Necessidade: </b><span style="color:#758697"> Nº ' . $campos["nr_pedido"] . '</span>
                                                    </a>
                                                </h4>
                                            </div>

                                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false">
                                                <div class="panel-body">

                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Descrição:</b></div>
                                                        <div class="col-sm-10">' . $campos["ds_pedido"] . '</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Fonte:</b></div>
                                                        <div class="col-sm-10">' . $campos["nr_fonte"] . '</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Funcional programatica:</b></div>
                                                        <div class="col-sm-10">' . $campos["cd_programa_trabalho"] . '- ' . $campos["ds_programa_trabalho"] . '</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Despesa:</b></div>
                                                        <div class="col-sm-10">' . $campos["cd_despesa_elemento"] . '- ' . $campos["ds_despesa_elemento"] . '</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Valor do pedido:</b></div>
                                                        <div class="col-sm-10">' . Metodos::ConverteValorBr($campos["vl_pedido"], 4) . '</div>
                                                    </div>
                                                </div>
                                            </div>
                                         </div>
                                    </div>';
                return $dadosPedido;
            }
            return $dadosPedido;
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function retornaDadosEmpenho($pdo) {
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $dadosEmpenho = '';
            $daoFinDocumentoFiscal = new DaoFinDocumentoFiscal();
            $daoFinDocumentoFiscal->setIdDocumentoFiscal($this->id_documento_fiscal);
            $daoFinDocumentoFiscal->retornaIfEmpenhoPorIdDocumento($pdo);

            if ($daoFinDocumentoFiscal->sucesso()) {
                $campos = $daoFinDocumentoFiscal->getMsgRetorno();

                $dadosEmpenho .= '<div class="panel-group" id="accordion3" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingThree">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion3" href="#collapseThree"
                                                        aria-expanded="false" aria-controls="collapseThree" class="collapsed">
                                                        <i class="glyphicon glyphicon-chevron-down"></i>
                                                        <b>Dados do Pedido do Empenho: </b><span style="color:#758697"> Nº ' . $campos["nr_empenho"] . '</span>
                                                    </a>
                                                </h4>
                                            </div>

                                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree" aria-expanded="false">
                                                <div class="panel-body">

                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Data do Empenho:</b></div>
                                                        <div class="col-sm-3">' . $campos["dataempenho"] . '</div>
                                                        <div class="col-sm-7"></div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Tipo de Empenho:</b></div>
                                                        <div class="col-sm-3">' . $campos["nm_tipo_empenho"] . '</div>
                                                        <div class="col-sm-7"></div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Valor do Empenho:</b></div>
                                                        <div class="col-sm-3">' . Metodos::ConverteValorBr($campos["vl_empenho"], 4) . '</div>
                                                        <div class="col-sm-7"></div>
                                                    </div>

                                                </div>
                                            </div>
                                         </div>
                                    </div>';
                return $dadosEmpenho;
            }
            return $dadosEmpenho;
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function retornaTabelaOrdemGdof($pdo, $excluir = false) {
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $tabela = '';
            $daoFinDocumentoFiscal = new DaoFinDocumentoFiscal();
            $daoFinDocumentoFiscal->setIdDocumentoFiscal($this->id_documento_fiscal);
            $daoFinDocumentoFiscal->retornaOrdemVinculadaAoDocumentoFiscal($pdo);

            if ($daoFinDocumentoFiscal->sucesso()) {
                foreach ($daoFinDocumentoFiscal->getMsgRetorno() as $key => $valor) {
                    $tabela .= '<tr id = "' . $valor["id_ordem"] . '" class= "tabOrdem">
                                    <td class="text-center">' . $valor["ordem"] . '</td>
                                    <td class="text-center">' . $valor["tipo"] . '</td>
                                    <td class="text-center">' . Metodos::ConverteValorBr($valor["valor"], 4) . '</td>';
                    if ($excluir) {
                        $tabela .= ' <td class="text-center">
                                        <button type="button" title="Excluir ordem" class="excluirOrdem text-danger" value = "' . $valor["id_ordem"] . '">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                     </td>';
                    }

                    $tabela .= '</tr>';
                }
            }

            return $tabela;
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function retornaTabelaEntregaGdof($pdo, $excluir = false) {
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $tabela = '';
            $daoFinDocumentoFiscal = new DaoFinDocumentoFiscal();
            $daoFinDocumentoFiscal->setIdDocumentoFiscal($this->id_documento_fiscal);
            $daoFinDocumentoFiscal->retornaEntregaVinculadoAoDocumentoFiscal($pdo);
            $totalEntrega = 0;
            if ($daoFinDocumentoFiscal->sucesso()) {
                foreach ($daoFinDocumentoFiscal->getMsgRetorno() as $key => $campos) {
                    $totalEntrega += $campos["valor"];
                    $tabela .= '<tr id= "ent' . $campos["id_entrega_confirmacao"] . '" ordem = "' . $campos["id_ordem"] . '" class = "trEntregas" idEntrega = "' . $campos["id_entrega_confirmacao"] . '">
                                 <td class = "text-center">' . $campos["nr_entrega_confirmacao"] . '</td>
                                 <td class = "text-center">' . $campos["ordem"] . '</td>
                                 <td class = "text-center">' . $campos["dataaviso"] . '</td>
                                 <td class = "text-center">' . $campos["datalimite"] . '</td>
                                 <td class = "text-center">' . $campos["nr_prazo_ordem"] . '</td>
                                 <td class = "text-center">' . $campos["entreguedia"] . '</td>
                                 <td class = "text-center">' . Metodos::ConverteValorBr($campos["valor"], 4) . '</td>
                                 <td class = "text-center">' . $campos["situacao"] . '</td>';
                    if ($excluir) {
                        $tabela .= ' <td class="text-center">
                                      <button type="button" title="Excluir ordem" class="excluirEntrega text-danger" value="' . $campos["id_entrega_confirmacao"] . '">
                                       <i class="fa fa-trash" aria-hidden="true"></i>
                                       </button>
                                     </td>';
                    }
                }
                $totalEntrega = Metodos::ConverteValorBr($totalEntrega, 4);
                $tabela .= '<tr>
                                <td class="text-right" colspan="6">Total</td>
                                <td class="text-center valorEntregaTotal" valor= "' . $totalEntrega . '" >' . $totalEntrega . '</td>
                                <td class="text-right" colspan="2"></td>
                            </tr>';
            }

            return $tabela;
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function retornaDadosDocumento($pdo) {

        if (empty($pdo)) {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
        }

        $daoFinDocumentoFiscal = new DaoFinDocumentoFiscal();
        $daoFinDocumentoFiscal->setIdDocumentoFiscal($this->id_documento_fiscal);
        $daoFinDocumentoFiscal->retornaDadosDocumento($pdo);
        return $daoFinDocumentoFiscal->getMsgRetorno();
    }
    
//    public function retornaTramitacaoDocumentoFiscal(PDO $pdo){
//        try {
//            $sql = "select
//                        (to_char(dh_doc_tramitacao, 'dd/mm/yyyy hh24:mi:ss') || ' - ' || nm_pessoa || ': ' || nm_tipo_tramitacao || 
//                        case
//                           when
//                              tpTramitacao.id_tipo_tramitacao = 3 
//                           then
//                     ( ' para o(a) ' || coalesce(docTpLotDestino.nm_doc_tipo_lotacao, '') || '/' || coalesce(lotacaoDestino.nm_lotacao, '')) 
//                           else
//                     ( ' pelo(a) ' || docTpLotOrigem.nm_doc_tipo_lotacao || '/' || lotacaoOrigem.nm_lotacao) 
//                        end) as historico
//                     from
//                        fin_doc_tramitacao as tramitacao 
//                        inner join
//                           ses_pessoa as pessoa 
//                           on pessoa.id_pessoa = tramitacao.id_pessoa 
//                        inner join
//                           fin_tipo_tramitacao tpTramitacao 
//                           on tpTramitacao.id_tipo_tramitacao = tramitacao.id_tipo_tramitacao 
//                        inner join
//                           fin_documento_situacao as docSit 
//                           on docSit.id_documento_situacao = tramitacao.id_documento_situacao 
//                        left join
//                           fin_doc_lotacao as tpLotOrigem 
//                           on tpLotOrigem.id_doc_lotacao = tramitacao.id_doc_origem 
//                        left join
//                           fin_doc_tipo_lotacao as docTpLotOrigem 
//                           on tpLotOrigem.id_doc_tipo_lotacao = docTpLotOrigem.id_doc_tipo_lotacao 
//                        left join
//                           ses_lotacao as lotacaoOrigem 
//                           on lotacaoOrigem.id_lotacao = tpLotOrigem.id_lotacao 
//                        left join
//                           fin_doc_lotacao as tpLotDestino 
//                           on tpLotDestino.id_doc_lotacao = tramitacao.id_doc_destino 
//                        left join
//                           fin_doc_tipo_lotacao as docTpLotDestino 
//                           on tpLotDestino.id_doc_tipo_lotacao = docTpLotDestino.id_doc_tipo_lotacao 
//                        left join
//                           ses_lotacao as lotacaoDestino 
//                           on lotacaoDestino.id_lotacao = tpLotOrigem.id_lotacao 
//                     where
//                        id_documento_fiscal = :documento 
//                     order by
//                        dh_doc_tramitacao desc, fl_pesquisa asc";
//        } catch (Exception $exc) {
//            echo $exc->getTraceAsString();
//        }
//    }

}
