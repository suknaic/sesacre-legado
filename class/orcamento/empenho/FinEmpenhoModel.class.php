<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/orcamento/empenho/DaoFinEmpenho.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/vincular_tramitacao/VincularTramitacao.class.php";

class FinEmpenhoModel {

    private $id_empenho = null;
    private $id_pedido = null;
    private $id_pessoa = null;
    private $id_tipo_empenho = null;
    private $nr_empenho = null;
    private $dt_empenho_sistema = null;
    private $dt_empenho_safira = null;
    private $vl_empenho = null;
    private $ds_empenho = null;
    private $sit_empenho = null;
    private $anotacoes = null;
    private $id_empenho_status = null;
    private $sit_cadastrado = 1;
    private $sit_liquidado_parcial = 2;
    private $sit_liquidado_total = 3;
    private $sit_pago_parcial = 4;
    private $sit_pago_total = 5;
    private $sit_estornado = 6;
    private $sit_anulado = 7;
    private $statusAguardandoLiquidacao = 1;
    private $statusAguardandoFinalizarLiquidacao = 2;
    private $statusAguardandoPagamento = 3;
    private $statusAguardandoFinalizarPagamento = 4;
    private $statusFinalizado = 5;
    private $statusCancelado = 6;
    
    private $idLotacao = null;
    private $idDocTipoLotacao = null;
    
    private $sucesso = null;
    private $msgRetorno = null;

    public function sucesso() {
        return $this->sucesso;
    }

    public function getMsgRetorno() {
        return $this->msgRetorno;
    }
    
    function getIdLotacao() {
        return $this->idLotacao;
    }

    function getIdDocTipoLotacao() {
        return $this->idDocTipoLotacao;
    }

    function setIdLotacao($idLotacao) {
        $this->idLotacao = $idLotacao;
        return $this;
    }

    function setIdDocTipoLotacao($idDocTipoLotacao) {
        $this->idDocTipoLotacao = $idDocTipoLotacao;
        return $this;
    }
    
    function getAnotacoes() {
        return $this->anotacoes;
    }

    function setAnotacoes($anotacoes) {
        $this->anotacoes = $anotacoes;
        return $this;
    }

    function getStatusAguardandoLiquidacao() {
        return $this->statusAguardandoLiquidacao;
    }

    function getStatusAguardandoFinalizarLiquidacao() {
        return $this->statusAguardandoFinalizarLiquidacao;
    }

    function getStatusAguardandoPagamento() {
        return $this->statusAguardandoPagamento;
    }

    function getStatusAguardandoFinalizarPagamento() {
        return $this->statusAguardandoFinalizarPagamento;
    }

    function getStatusFinalizado() {
        return $this->statusFinalizado;
    }
    
    function getStatusCancelado() {
        return $this->statusCancelado;
    }

    function getSitCadastrado() {
        return $this->sit_cadastrado;
    }

    function getSitLiquidadoParcial() {
        return $this->sit_liquidado_parcial;
    }

    function getSitLiquidadoTotal() {
        return $this->sit_liquidado_total;
    }

    function getSitPagoParcial() {
        return $this->sit_pago_parcial;
    }

    function getSitPagoTotal() {
        return $this->sit_pago_total;
    }

    function getSitEstornado() {
        return $this->sit_estornado;
    }
    
    function setSit_anulado($sit_anulado) {
        $this->sit_anulado = $sit_anulado;
        return $this;
    }

    function getIdEmpenhoStatus() {
        return $this->id_empenho_status;
    }

    function setIdEmpenhoStatus($id_empenho_status) {
        $this->id_empenho_status = $id_empenho_status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdEmpenho() {
        return $this->id_empenho;
    }

    /**
     * @param mixed $id_empenho
     *
     * @return self
     */
    public function setIdEmpenho($id_empenho) {
        $this->id_empenho = $id_empenho;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdPedido() {
        return $this->id_pedido;
    }

    /**
     * @param mixed $id_pedido
     *
     * @return self
     */
    public function setIdPedido($id_pedido) {
        $this->id_pedido = $id_pedido;

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
    public function getIdTipoEmpenho() {
        return $this->id_tipo_empenho;
    }

    /**
     * @param mixed $id_tipo_empenho
     *
     * @return self
     */
    public function setIdTipoEmpenho($id_tipo_empenho) {
        $this->id_tipo_empenho = $id_tipo_empenho;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNrEmpenho() {
        return $this->nr_empenho;
    }

    /**
     * @param mixed $nr_empenho
     *
     * @return self
     */
    public function setNrEmpenho($nr_empenho) {
        $this->nr_empenho = $nr_empenho;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtEmpenhoSistema() {
        return $this->dt_empenho_sistema;
    }

    /**
     * @param mixed $dt_empenho_sistema
     *
     * @return self
     */
    public function setDtEmpenhoSistema($dt_empenho_sistema) {
        $this->dt_empenho_sistema = $dt_empenho_sistema;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtEmpenhoSafira() {
        return $this->dt_empenho_safira;
    }

    /**
     * @param mixed $dt_empenho_safira
     *
     * @return self
     */
    public function setDtEmpenhoSafira($dt_empenho_safira) {
        $this->dt_empenho_safira = $dt_empenho_safira;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVlEmpenho() {
        return $this->vl_empenho;
    }

    /**
     * @param mixed $vl_empenho
     *
     * @return self
     */
    public function setVlEmpenho($vl_empenho) {
        $this->vl_empenho = $vl_empenho;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDsEmpenho() {
        return $this->ds_empenho;
    }

    /**
     * @param mixed $ds_empenho
     *
     * @return self
     */
    public function setDsEmpenho($ds_empenho) {
        $this->ds_empenho = $ds_empenho;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSitEmpenho() {
        return $this->sit_empenho;
    }

    /**
     * @param mixed $sit_empenho
     *
     * @return self
     */
    public function setSitEmpenho($sit_empenho) {
        $this->sit_empenho = $sit_empenho;

        return $this;
    }

    /**
     * Retorna tr dos pedido disponivel para empenho
     * @param type $dados
     * @return string
     */
    public function retornaTrPedidoEmpenho($dados = null) {
        $conexao = new Conexao();
        $pdo = $conexao->connect();

        $condicao = '';

        if (!empty($dados['central'])) {
            $condicao .= ' AND p.idLotacao = ' . $dados['central'];
        }

        if (!empty($dados['numero'])) {
            $condicao .= " AND p.nr_pedido = '" . $dados['numero'] . "'";
        }

        if (!empty($dados['ano'])) {
            $condicao .= " AND to_char(p.dt_pedido, 'yyyy') = '" . $dados['ano'] . "'";
        }

        $daoFinEmpenho = new DaoFinEmpenho();
        $daoFinEmpenho->retornaPedidoParaEmpenho($pdo, $condicao);
        $tabela = '';
        if ($daoFinEmpenho->sucesso()) {
            foreach ($daoFinEmpenho->getMsgRetorno() as $l) {
                $tabela .= '<tr>
                                <td class="text-center">' . $l["numero"] . '</td>
                                <td class="text-center" style="width: 23%">' . $l["ds_pedido"] . '</td>
                                <td class="text-center">' . $l["nm_tipo_gasto"] . '</td>
                                <td class="text-center">' . $l["nr_fonte"] . '</td>
                                <td class="text-center">' . $l["cd_despesa_elemento"] . '</td>
                                <td class="text-center">' . $l["dt_aut_ordenador"] . '</td>
                                <td class="text-center">' . Metodos::ConverteValorBr($l["vl_pedido"], 4) . '</td>
                                <td class="text-center" style="width: 23%">' . $l["ds_pedido_anotacao"] . '</td>
                                <td class="text-center">
                                <a type="button" href="/pages/orcamento/empenho/cadEmpenho.php?id=' . $l["id_pedido"] . '" target="_blank" class="button">
                                    <i class="fa fa-search-plus fa-lg text-info" aria-hidden="true"></i>
                                </a>
                                </td>
                            </tr>';
            }
            return Metodos::retornoAjax("ok", "html", $tabela);
        } else {
            return Metodos::retornoAjax("Erro", "alert", "Nenhum empenho encontrado.");
        }
    }

    /**
     * Retorna os tipos do empenho
     * @return boolean|string
     */
    public function retornaOptionsTipoEmpenho() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoFinEmpenho = new DaoFinEmpenho();
            $daoFinEmpenho->retornaTipoEmpenho($pdo);
            $options = '<option value="">Selecionar o tipo do empenho</option>';
            if ($daoFinEmpenho->sucesso()) {
                foreach ($daoFinEmpenho->getMsgRetorno() as $l) {
                    if ($l["id_tipo_empenho"] == $this->id_tipo_empenho) {
                        $options .= '<option value = ' . $l["id_tipo_empenho"] . ' selected>' . $l["nm_tipo_empenho"] . '</option>';
                    } else {
                        $options .= '<option value = ' . $l["id_tipo_empenho"] . ' >' . $l["nm_tipo_empenho"] . '</option>';
                    }
                }
                return $options;
            } else {
                return false;
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    /**
     * Retorna Dados do pedido de necessidade 
     * @return type
     */
    public function retornaDadosPedido() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoFinEmpenho = new DaoFinEmpenho();
            $daoFinEmpenho->setIdPedido($this->id_pedido);
            $daoFinEmpenho->retornaInfPedidoEmpenho($pdo);
            return $daoFinEmpenho->getMsgRetorno();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function listaEmpenhoJSON() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoFinEmpenho = new DaoFinEmpenho();
            $daoFinEmpenho->retornaTodosEmpenhos($pdo);
            return json_encode($daoFinEmpenho->getMsgRetorno());
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function salvaEmpenho() {
        try {
            
            if (empty($this->dt_empenho_safira) || empty($this->nr_empenho) || empty($this->id_tipo_empenho) || empty($this->vl_empenho)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            //Só pode Editar o empenho quem possui a Tramitação de Empenhar
            $tramitacao = new VincularTramitacao();
            $tramitacao->setIdPessoa($this->id_pessoa);
            $tramitacao->setIdTramitacao($tramitacao->getTramitacaoEmpenhar());
            $tramitacao->verificaPessoaTramitacao($pdo);
            if(!$tramitacao->Sucesso()){
                return Metodos::retornoAjax("Erro", "alert", "Usuário Não possui Permissão para Cadastrar Empenho.");
            }
            
            $sucesso = false;
            $daoFinEmpenho = new DaoFinEmpenho();
            //removendo barra do numero do empenho
            $this->nr_empenho = str_replace("/", "", $this->nr_empenho);
            //----------------------------------------------------------
            $daoFinEmpenho->setIdPedido($this->id_pedido);
            $daoFinEmpenho->setIdPessoa($this->id_pessoa);
            $daoFinEmpenho->setIdTipoEmpenho($this->id_tipo_empenho);
            $daoFinEmpenho->setNrEmpenho($this->nr_empenho);
            $daoFinEmpenho->setDtEmpenhoSafira(Metodos::ConverteDataING($this->dt_empenho_safira));
            $daoFinEmpenho->setVlEmpenho(Metodos::ConverteValorIng($this->vl_empenho));
            $daoFinEmpenho->setDsEmpenho($this->ds_empenho ?? '');
            
            $daoFinEmpenho->setIdLotacao($this->getIdLotacao());
            $daoFinEmpenho->setIdDocTipoLotacao($this->getIdDocTipoLotacao());
            $daoFinEmpenho->setIdEmpenhoStatus($this->getStatusAguardandoLiquidacao());
            //verificar ser o empenho ja estar cadastrado
            $daoFinEmpenho->verificarEmpenhoPeloNumero($pdo);
            if ($daoFinEmpenho->sucesso()) {
                return Metodos::retornoAjax("Erro", "alert", "Empenho já foi cadastrado!");
            }
            
            $daoFinEmpenho->insertEmpenho($pdo);
            
            if ($daoFinEmpenho->sucesso()) {
                $daoFinEmpenho->setIdEmpenho((is_numeric($pdo->lastInsertId('fin_empenho_id_empenho_seq'))) ? $pdo->lastInsertId('fin_empenho_id_empenho_seq') : null);
                $this->id_empenho = $daoFinEmpenho->getIdEmpenho();
                $sucesso = true;
                if (!Log::SalvaLogI('fin_empenho', $daoFinEmpenho->getIdEmpenho(), $pdo)) {
                    $sucesso = false;
                }
            } else {
                $pdo->rollBack();
                $sucesso = false;
                return Metodos::retornoAjax("Erro1", "alert", STR_ERROR );
            }
            
            //Inserção de anotações, se houver
            if(!empty($this->anotacoes)){
                $finEmpenhoAnotacao = new FinEmpenhoAnotacao();
                $finEmpenhoAnotacao->setIdEmpenho($this->id_empenho);
                $finEmpenhoAnotacao->setDsEmpenhoAnotacao($this->anotacoes);
                $finEmpenhoAnotacao->setIdPessoa($this->id_pessoa);
                $finEmpenhoAnotacao->salvaAnotacao($pdo);
                if(!$finEmpenhoAnotacao->getSucesso()){
                    $pdo->rollBack();
                    $sucesso = false;
                    return Metodos::retornoAjax("Erro7", "alert", $finEmpenhoAnotacao->getMsgRetorno());
                }
            }
            //-------------------------------------------------
            //Salva Historico do Empenho
            if (!$this->salvarEmpenhoHistorico($pdo, $this->getSitCadastrado(), $this->getStatusAguardandoLiquidacao())) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", $this->getMsgRetorno());
            }
            
            $pedido = 0;
            //retorno os dados do pedido 
            $daoFinEmpenho->retornaInfPedidoEmpenho($pdo);
            if ($daoFinEmpenho->sucesso()) {
                $pedido = $daoFinEmpenho->getMsgRetorno();
            } else {
                $pdo->rollBack();
                $sucesso = false;
                return Metodos::retornoAjax("Erro2", "alert", STR_ERROR);
            }
            //--------------------------------------------
            $qdd = new Qdd();
            $data = new DateTime(Metodos::ConverteDataING($this->dt_empenho_safira));
            //seto o ano do empenho para pega o id do qdd
            $qdd->setAaQdd($data->format('Y'));
            $qdd->verificaExisteCarregaDados($pdo);
            if (!empty($qdd->getIdQdd())) {
                //instancio a classe do qddValor
                $qddValor = new QddValor();
                $qddValor->setIdQdd($qdd->getIdQdd());
                $qddValor->setIdFonte($pedido[0]['id_fonte']);
                $qddValor->setIdProgramaTrabalho($pedido[0]['id_programa_trabalho']);
                $qddValor->setIdDespesaElemento($pedido[0]['id_despesa_elemento']);
                $qddValor->carregaDadosQddFonteProgDespesa($pdo);
                if (!empty($qddValor->getIdQddValor())) {
                    //verificar ser tem saldo no qdd para o empenho
                    if ($qddValor->getVlSaldo() >= Metodos::ConverteValorIng($this->vl_empenho)) {
                        //somo o valor empenhado mais o valor do novo empenho
                        $valorEmpenho = $qddValor->getVlEmpenhado() + Metodos::ConverteValorIng($this->vl_empenho);
                        //seta o resultado da soma para atualiza o qdd
                        $qddValor->setVlEmpenhado($valorEmpenho);
                        $qddValor->atualizaValoresEmpenhado($pdo);
                        //esse array foi criado para atualiza os valores do qdd valor pois a classe espera um array
                        $array = array();
                        $array[] = $qddValor->getIdQddValor();
                        $qddValor->atualizaValoresPorArray($array, $pdo);
                        if (!$qddValor->Sucesso()) {
                            $pdo->rollBack();
                            $sucesso = false;
                            return Metodos::retornoAjax("Erro3", "alert", STR_ERROR);
                        }
                    } else {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "alert", "Não existe saldo no QDD para esse empenho");
                    }
                } else {
                    $pdo->rollBack();
                    $sucesso = false;
                    return Metodos::retornoAjax("Erro5", "alert", STR_ERROR);
                }
            } else {
                $pdo->rollBack();
                $sucesso = false;
                return Metodos::retornoAjax("Erro6", "alert", STR_ERROR);
            }

            $classPedido = new Pedido();
            $classPedido->setIdPedido($this->id_pedido);

            $classPedido->atualizaStatusSituacaoOficialPedido($pdo);
            if (!$classPedido->sucesso()) {
                $pdo->rollBack();
                return Metodos::retornoAjax("ok", "html", "Não foi possível Atualizar o Status/Situação do Pedido.");
            }

            if ($sucesso) {
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", "Empenho cadastrado com sucesso");
            }
            $pdo->rollBack();
            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    
    public function atualizaEmpenho(){
        try {
            if (empty($this->dt_empenho_safira) || empty($this->nr_empenho) || empty($this->id_tipo_empenho) || empty($this->vl_empenho)
                    || empty($this->idLotacao) || empty($this->idDocTipoLotacao)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            //Só pode Editar o empenho quem possui a Tramitação de Empenhar
            $tramitacao = new VincularTramitacao();
            $tramitacao->setIdPessoa($this->id_pessoa);
            $tramitacao->setIdTramitacao($tramitacao->getTramitacaoEmpenhar());
            $tramitacao->verificaPessoaTramitacao($pdo);
            if(!$tramitacao->Sucesso()){
                return Metodos::retornoAjax("Erro", "alert", "Usuário Não possui Permissão para Editar o Empenho.");
            }
            
            $daoFinEmpenho = new DaoFinEmpenho();
            //removendo barra do numero do empenho
            $this->nr_empenho = str_replace("/", "", $this->nr_empenho);
            //----------------------------------------------------------
            $daoFinEmpenho->setIdEmpenho($this->id_empenho);
            $daoFinEmpenho->setIdPessoa($this->id_pessoa);
            $daoFinEmpenho->setIdPedido($this->id_pedido);
            $daoFinEmpenho->setIdTipoEmpenho($this->id_tipo_empenho);
            $daoFinEmpenho->setNrEmpenho($this->nr_empenho);
            $daoFinEmpenho->setDtEmpenhoSafira(Metodos::ConverteDataING($this->dt_empenho_safira));
            $daoFinEmpenho->setVlEmpenho(Metodos::ConverteValorIng($this->vl_empenho));
            $daoFinEmpenho->setDsEmpenho($this->ds_empenho ?? '');
            $daoFinEmpenho->setIdLotacao($this->idLotacao);
            $daoFinEmpenho->setIdDocTipoLotacao($this->idDocTipoLotacao);
            
            //verificar se o empenho ja está cadastrado
            $daoFinEmpenho->verificarEmpenhoPeloNumeroUpdate($pdo);
            if ($daoFinEmpenho->sucesso()) {
                return Metodos::retornoAjax("Erro", "alert", "Já existe um empenho ativo com este número!");
            }
            
            //Verifica se o Empenho possui Ordem ou Documento Fiscal ou Liquidação
            $daoFinEmpenho->verificaExisteOrdemDocumentoLiquidacao($pdo);
            if ($daoFinEmpenho->sucesso()) {
                $msg = "";
                $msgArray = array();
                if (!empty($daoFinEmpenho->getMsgRetorno()['id_liquidacao'])) {
                    $msgArray[] = " Liquidação";
                }
                if (!empty($daoFinEmpenho->getMsgRetorno()['id_documento_fiscal'])) {
                    $msgArray[] = " Documento Fiscal";
                }
                if (!empty($daoFinEmpenho->getMsgRetorno()['id_ordem'])) {
                    $msgArray[] = " Ordem ";
                }
                $msg = implode(",", $msgArray);
                return Metodos::retornoAjax("Erro", "alert", "O Empenho Não pode ser Alterado, pois possui as Seguintes Restrições: " . $msg);
            }
            
            //retorna os dados anteriores do empenho para verificações posteriores
            $daoFinEmpenho->retorna($pdo);
            if (!$daoFinEmpenho->sucesso()) {
                return Metodos::retornoAjax("Erro", "alert", "Erro ao consultar os dados do empenho!");
            }
            $dadosEmpenho = $daoFinEmpenho->getMsgRetorno();
            
            
            $daoFinEmpenho->retornaInfPedidoEmpenho($pdo);
            if (!$daoFinEmpenho->sucesso()) {
                return Metodos::retornoAjax("Erro", "alert", "Erro ao consultar os dados do pedido de necessidade vinculado a este empenho!");
            }
            $dadosPedido = $daoFinEmpenho->getMsgRetorno();
            //Verificar se o valor do empenho esta diferente do valor do pedido de necessidade
            if ($dadosPedido[0]['vl_pedido'] != $daoFinEmpenho->getVlEmpenho()) {
                return Metodos::retornoAjax("Erro", "alert", "Valor do empenho está diferente do valor do pedido de necessidade!");
            }
            
            //Atualiza os dados do Empenho
            $daoFinEmpenho->updateEmpenho($pdo);
            if (!$daoFinEmpenho->sucesso()) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", $daoFinEmpenho->getMsgRetorno());
            }

            //Registra a operação no LOG
            if (!Log::SalvaLogU('fin_empenho', $this->id_empenho, $dadosEmpenho, $pdo)) {
                return Metodos::retornoAjax("Erro", "console", "Não foi possível atualizar Empenho. LOG");
            }
            
            //Atualiza o QDD pelo Empenho
            $qdd = new Qdd();
            $data = new DateTime(Metodos::ConverteDataING($this->dt_empenho_safira));
            //seto o ano do empenho para pega o id do qdd
            $qdd->setAaQdd($data->format('Y'));
            $qdd->verificaExisteCarregaDados($pdo);
            if (!empty($qdd->getIdQdd())) {
                //instancio a classe do qddValor
                $qddValor = new QddValor();
                $qddValor->setIdQdd($qdd->getIdQdd());
                $qddValor->setIdFonte($dadosPedido[0]['id_fonte']);
                $qddValor->setIdProgramaTrabalho($dadosPedido[0]['id_programa_trabalho']);
                $qddValor->setIdDespesaElemento($dadosPedido[0]['id_despesa_elemento']);
                $qddValor->carregaDadosQddFonteProgDespesa($pdo);
                
//                echo $dadosEmpenho['vl_empenho'] . ' - ' . Metodos::ConverteValorIng($this->vl_empenho) . ' - ' . $qddValor->getVlEmpenhado();
//                $pdo->rollBack();
//                return;
                if (!empty($qddValor->getIdQddValor())) {
                    //Verifica se o valor Empenho irá ficar menor que 0
                    $valorEmpenho = $qddValor->getVlEmpenhado() - $dadosEmpenho['vl_empenho'] + Metodos::ConverteValorIng($this->vl_empenho);
                    $valorEmpenho = round($valorEmpenho, 4);
                    if ($valorEmpenho >= 0) {
                        //seta o resultado da soma para atualiza o qdd
                        $qddValor->setVlEmpenhado($valorEmpenho);
                        $qddValor->atualizaValoresEmpenhado($pdo);
                        //esse array foi criado para atualiza os valores do qdd valor pois a classe espera um array
                        $array = array();
                        $array[] = $qddValor->getIdQddValor();
                        $qddValor->atualizaValoresPorArray($array, $pdo);
                        if (!$qddValor->Sucesso()) {
                            $pdo->rollBack();
                            return Metodos::retornoAjax("Erro","alert", "Não foi possível atualizar os Valores do QDD.");
                        }
                    } else {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro","alert", "O Valor Empenhado irá ficar Negativa se o Empenho for alterado.");
                    }
                } else {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro","alert", "Não foi possível localizar o QDD ao qual irá ajustar o valor");
                }
            } else {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro","alert", "Não foi possível localizar o QDD.");
            }
            $pdo->commit();
            return Metodos::retornoAjax("ok", "html", "Empenho Alterado com sucesso");
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro","console",$exc->getMessage());
        }
    }

    public function retornaEmpenhoGdof($pdo) {
        try {

            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }

            $dadosEmpenho = '';
            $daoFinEmpenho = new DaoFinEmpenho();
            $daoFinEmpenho->setIdPedido($this->id_pedido);
            $daoFinEmpenho->retornaEmpenhoGdof($pdo);
            if ($daoFinEmpenho->sucesso()) {
                $campos = $daoFinEmpenho->getMsgRetorno();

                $dadosEmpenho .= '<div class="panel-group" id="accordion3" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingThree">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion3" href="#collapseThree" 
                                                        aria-expanded="false" aria-controls="collapseThree" class="collapsed">
                                                        <i class="glyphicon glyphicon-chevron-down"></i>
                                                        <b>Dados do Empenho: </b><span style="color:#758697"> Nº ' . $campos["nr_empenho"] . '</span> 
                                                    </a>
                                                </h4>
                                            </div>
                                        
                                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree" aria-expanded="false">
                                                <div class="panel-body">
                                                    <input id="id_empenho" type="hidden" value="' . $campos['id_empenho'] . '" />
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
                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Saldo do Documento Fiscal a Empenhar:</b></div>
                                                        <div class="col-sm-3">' . Metodos::ConverteValorBr($campos["saldo_empenho_gdof"], 4) . '</div>
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
            return $ex->getMessage();
        }
    }

    public function retornaEmpenhoPagamento($pdo) {
        try {

            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $dadosEmpenho = '';
            $daoFinEmpenho = new DaoFinEmpenho();
            $daoFinEmpenho->setIdPedido($this->id_pedido);
            $daoFinEmpenho->retornaEmpenhoPagamento($pdo);

            if ($daoFinEmpenho->sucesso()) {
                $campos = $daoFinEmpenho->getMsgRetorno();

                $dadosEmpenho .= '<div class="panel-group" id="accordionThree" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingThree">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordionThree" href="#collapseThree" 
                                                        aria-expanded="false" aria-controls="collapseThree" class="collapsed">
                                                        <i class="glyphicon glyphicon-chevron-down"></i>
                                                        <b>Dados do Empenho: </b><span style="color:#758697"> Nº ' . $campos["nr_empenho"] . '</span> 
                                                    </a>
                                                </h4>
                                            </div>
                                        
                                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree" aria-expanded="false">
                                                <div class="panel-body">
                                                    <input id="id_empenho" type="hidden" value="' . $campos['id_empenho'] . '" />
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
                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Saldo do Empenho a Pagar:</b></div>
                                                        <div class="col-sm-3">' . Metodos::ConverteValorBr($campos["saldo_empenho_pagamento"], 4) . '</div>
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
            return $ex->getMessage();
        }
    }

    public function retornaEmpenhoLiquidacao($pdo) {
        try {

            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $dadosEmpenho = '';
            $daoFinEmpenho = new DaoFinEmpenho();
            $daoFinEmpenho->setIdPedido($this->id_pedido);
            $daoFinEmpenho->retornaEmpenhoLiquidacao($pdo);

            if ($daoFinEmpenho->sucesso()) {
                $campos = $daoFinEmpenho->getMsgRetorno();

                $dadosEmpenho .= '<div class="panel-group" id="accordion3" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingThree">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion3" href="#collapseThree" 
                                                        aria-expanded="false" aria-controls="collapseThree" class="collapsed">
                                                        <i class="glyphicon glyphicon-chevron-down"></i>
                                                        <b>Dados do Empenho: </b><span style="color:#758697"> Nº ' . $campos["nr_empenho"] . '</span> 
                                                    </a>
                                                </h4>
                                            </div>
                                        
                                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree" aria-expanded="false">
                                                <div class="panel-body">
                                                    <input id="id_empenho" type="hidden" value="' . $campos['id_empenho'] . '" />
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
                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Saldo do Empenho a Liquidar:</b></div>
                                                        <div class="col-sm-3">' . Metodos::ConverteValorBr($campos["saldo_empenho_liquidacao"], 4) . '</div>
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
            return $ex->getMessage();
        }
    }


    public function retornaEmpenhoAnulacao($pdo) {
        try {

            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $dadosEmpenho = '';
            $daoFinEmpenho = new DaoFinEmpenho();
            $daoFinEmpenho->setIdPedido($this->id_pedido);
            $daoFinEmpenho->retornaEmpenhoAnulacao($pdo);

            if ($daoFinEmpenho->sucesso()) {
                $campos = $daoFinEmpenho->getMsgRetorno();

                $dadosEmpenho .= '<div class="panel-group" id="accordion3" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingThree">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion3" href="#collapseThree" 
                                                        aria-expanded="false" aria-controls="collapseThree" class="collapsed">
                                                        <i class="glyphicon glyphicon-chevron-down"></i>
                                                        <b>Dados do Empenho: </b><span style="color:#758697"> Nº ' . $campos["nr_empenho"] . '</span> 
                                                    </a>
                                                </h4>
                                            </div>
                                        
                                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree" aria-expanded="false">
                                                <div class="panel-body">
                                                    <input id="id_empenho" type="hidden" value="' . $campos['id_empenho'] . '" />
                                                    <input id="numero_empenho" type="hidden" value="'.$campos["nr_empenho"].'" />
                                                    <input id="saldo_empenho" type="hidden" value="'.$campos["saldo"].'" />                                                    
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
                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Saldo a Anular do Empenho:</b></div>
                                                        <div class="col-sm-3">' . Metodos::ConverteValorBr($campos["saldo"], 4) . '</div>

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
            return $ex->getMessage();
        }
    }

    
    public function trEmpenhoBuscaLiquidacao() {
        $conexao = new Conexao();
        $pdo = $conexao->connect();
        
        //removendo barra do numero do empenho
        $this->nr_empenho = str_replace("/", "", $this->nr_empenho);
        
        $daoFinEmpenho = new DaoFinEmpenho();
        $daoFinEmpenho->setNrEmpenho($this->nr_empenho);
        $daoFinEmpenho->buscaEmpenhoPesquisaLiquidacao($pdo);

        $retorno = '';
        if ($daoFinEmpenho->sucesso()) {
            foreach ($daoFinEmpenho->getMsgRetorno() as $dados) {
                $retorno .= '<tr class="selecionaItem" pedido="' . $dados["id_pedido"] . '"  idEmpenho="' . $dados["id_empenho"] . '" nrPedido="' . $dados["nr_pedido"] . '" 
                    style="cursor:pointer;">
                <td>' . $dados["nr_empenho"] . '</td>
                <td>' . $dados["nm_tipo_empenho"] . '</td>
                <td>' . $dados["nr_fonte"] . '</td>
                <td>' . $dados["cd_despesa_elemento"] . '</td>
                <td>' . Metodos::ConverteValorBr($dados["vl_empenho"], 4) . '</td>    
                <td>' . Metodos::ConverteValorBr($dados["saldo"], 4) . '</td>
                </tr>';
            }
        }
        return $retorno;
    }
    
    public function trEmpenhoBuscaAnulacaoEmpenho() {
        $conexao = new Conexao();
        $pdo = $conexao->connect();
        $daoFinEmpenho = new DaoFinEmpenho();
        $daoFinEmpenho->setNrEmpenho($this->nr_empenho);
        $daoFinEmpenho->buscaEmpenhoPesquisaAnulacaoEmpenho($pdo);

        $retorno = '';
        if ($daoFinEmpenho->sucesso()) {
            foreach ($daoFinEmpenho->getMsgRetorno() as $dados) {
                $retorno .= '<tr class="selecionaItem" pedido="' . $dados["id_pedido"] . '"  idEmpenho="' . $dados["id_empenho"] . '" nrPedido="' . $dados["nr_pedido"] . '" 
                    style="cursor:pointer;">
                <td>' . $dados["nr_empenho"] . '</td>
                <td>' . $dados["nm_tipo_empenho"] . '</td>
                <td>' . $dados["nr_fonte"] . '</td>
                <td>' . $dados["cd_despesa_elemento"] . '</td>
                <td>' . Metodos::ConverteValorBr($dados["vl_empenho"], 4) . '</td>    
                <td>' . Metodos::ConverteValorBr($dados["saldo"], 4) . '</td>
                </tr>';
            }
        }
        return $retorno;
    }

    public function buscaEmpenhoParaLiquidacao() {
        $conexao = new Conexao();
        $pdo = $conexao->connect();
        $daoFinEmpenho = new DaoFinEmpenho();
        $daoFinEmpenho->setNrEmpenho($this->nr_empenho);
        $daoFinEmpenho->buscaEmpenhoPesquisaLiquidacao($pdo);

        if ($daoFinEmpenho->sucesso()) {
            foreach ($daoFinEmpenho->getMsgRetorno() as $dados) {
                return Metodos::retornoAjax("ok", "ok", $dados);
            }
        }
        return Metodos::retornoAjax("no", "no", array());
    }
    
    

    /**
     * Retorna os dados do empenho 
     */
    public function retornaDadosEmpenho($pdo) {
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoFinEmpenho = new DaoFinEmpenho();
            $daoFinEmpenho->setIdEmpenho($this->id_empenho);
            $daoFinEmpenho->retornaDadosEmpenho($pdo);
            if ($daoFinEmpenho->sucesso()) {
                return $daoFinEmpenho->getMsgRetorno();
            }
            return "";
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function retornaDadosEmpenhoPorPedido($pdo) {
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoFinEmpenho = new DaoFinEmpenho();
            $daoFinEmpenho->setIdPedido($this->id_pedido);
            $daoFinEmpenho->retornaDadosEmpenhoPorPedido($pdo);
            if ($daoFinEmpenho->sucesso()) {
                return $daoFinEmpenho->getMsgRetorno();
            }
            return "";
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    /*
     * Cancelar o Empenho Global
     * Os Ajustes que são feitos:
     * Mudar o status do Empenho
     * Mudar o status do Pedido
     * Atualiza a Anotação do Pedido
     * Atualiza o Autorização do Pedido
     * Se tiver Diária, deve ser desvinculada
     * Atualizar o QDD pelo Empenho
     * Não pode ter Ordem ou Documento Fiscal ou Liquidação     
     */

    public function cancelarEmpenho(string $justificativa) {
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();
            }
            
            //Só pode Cancelar empenho quem possui a Tramitação de Empenhar
            $tramitacao = new VincularTramitacao();
            $tramitacao->setIdPessoa($this->id_pessoa);
            $tramitacao->setIdTramitacao($tramitacao->getTramitacaoEmpenhar());
            $tramitacao->verificaPessoaTramitacao($pdo);
            if(!$tramitacao->Sucesso()){
                return Metodos::retornoAjax("Erro", "alert", "Usuário Não possui Permissão para Cancelar Empenho.");
            }
            
            
            $daoFinEmpenho = new DaoFinEmpenho();
            $daoFinEmpenho->setIdEmpenho($this->id_empenho);
            $daoFinEmpenho->retorna($pdo);

            if (!$daoFinEmpenho->sucesso()) {
                return Metodos::retornoAjax("Erro", "alert", "Não foi possível localizar o Empenho.");
            }
            $dadosEmpenho = $daoFinEmpenho->getMsgRetorno();

            //Busca dados do Pedido
            $pedido = new Pedido();
            $pedido->setIdPedido($dadosEmpenho['id_pedido']);
            $dadosPedido = $pedido->retornaDadosPedido();
            if (empty($dadosPedido)) {
                return Metodos::retornoAjax("Erro", "alert", "Não foi possível localizar os Dados do Pedido.");
            }
            $this->id_pedido = $dadosEmpenho['id_pedido'];
            //Verifica se o Empenho já está cancelado
            if ($dadosEmpenho['sit_empenho'] == $this->sit_cancelado) {
                return Metodos::retornoAjax("Erro", "alert", "Ação não realizado, pois o Empenho já foi Cancelado.");
            }

            //Verifica se o Empenho possui Ordem ou Documento Fiscal ou Liquidação
            $daoFinEmpenho->verificaExisteOrdemDocumentoLiquidacao($pdo);
            if ($daoFinEmpenho->sucesso()) {
                $msg = "";
                $msgArray = array();
                if (!empty($daoFinEmpenho->getMsgRetorno()['id_liquidacao'])) {
                    $msgArray[] = " Liquidação";
                }
                if (!empty($daoFinEmpenho->getMsgRetorno()['id_documento_fiscal'])) {
                    $msgArray[] = " Documento Fiscal";
                }
                if (!empty($daoFinEmpenho->getMsgRetorno()['id_ordem'])) {
                    $msgArray[] = " Ordem ";
                }
                $msg = implode(",", $msgArray);
                return Metodos::retornoAjax("Erro", "alert", "O Empenho Não pode ser Cancelado, pois possui as Seguintes Restrições: " . $msg);
            }
            
            //Salva Historico do Empenho
            if (!$this->salvarEmpenhoHistorico($pdo, $this->getSitEstornado(), $this->getStatusCancelado(), $justificativa)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", $this->getMsgRetorno());
            }

            //Muda Status e Situação do Empenho            
            $daoFinEmpenho->setSitEmpenho($this->getSitEstornado());
            $daoFinEmpenho->setIdEmpenhoStatus($this->getStatusCancelado());
            $daoFinEmpenho->atualizaSituacaoStatusEmpenho($pdo);
            if (!$daoFinEmpenho->sucesso()) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Não foi possível Atualizar o Status do Empenho.");
            }

            //Muda Status e Situação do Pedido
            $pedido->setStPedido(0);
            $pedido->setIdPedidoSituacao(10);
            $pedido->atualizaTramitacaoPedidoSituacao($pdo);
            if (!$pedido->sucesso()) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Não foi possível Atualizar o Status e a Situação do Pedido.");
            }

            //Atualiza o Fin Autorização do Pedido
            $finAutoriza = new FinAutorizacao();
            $finAutoriza->setIdPedido($dadosPedido['id_pedido']);
            $finAutoriza->setIdPessoa($this->id_pessoa);
            $finAutoriza->setStNivel(0);
            $finAutoriza->setDsAutorizacao($justificativa);
            $finAutoriza->salvaAutorizacaoPedidoSemUpdate($pdo);
            if (!$finAutoriza->Sucesso()) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Não foi possível Atualizar a Autorização do Pedido.");
            }


            //Se o Pedido Possui Diaria, então deve atualizar os Dados da Diária
            $diaria = new Diaria();
            $diaria->setIdPedido($this->id_pedido);
            $diaria->setUsuarioPedido($this->id_pessoa);
            $diaria->desvinculaPedidoDiariaSeExistir($pdo);
            if (!$diaria->sucesso()) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", $diaria->getMsgRetorno());
            }

            //Atualiza a Anotação do Pedido
            $finPedidoAnotacao = new PedidoAnotacao();
            $finPedidoAnotacao->setIdPedido($dadosPedido['id_pedido']);
            $finPedidoAnotacao->setIdPessoa($this->id_pessoa);
            $finPedidoAnotacao->setDsPedidoAnotacao("Cancelado: " . $justificativa);
            $finPedidoAnotacao->salvaAnotacao($pdo);
            if (!$finPedidoAnotacao->sucesso()) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", $finPedidoAnotacao->getMsgRetorno());
            }

            //Atualiza o QDD pelo Empenho
            $qdd = new Qdd();
            $data = new DateTime($dadosEmpenho['dt_empenho_safira']);
            //seto o ano do empenho para pega o id do qdd
            $qdd->setAaQdd($data->format('Y'));
            $qdd->verificaExisteCarregaDados($pdo);
            if (!empty($qdd->getIdQdd())) {
                //instancio a classe do qddValor
                $qddValor = new QddValor();
                $qddValor->setIdQdd($qdd->getIdQdd());
                $qddValor->setIdFonte($dadosPedido['id_fonte']);
                $qddValor->setIdProgramaTrabalho($dadosPedido['id_programa_trabalho']);
                $qddValor->setIdDespesaElemento($dadosPedido['id_despesa_elemento']);
                $qddValor->carregaDadosQddFonteProgDespesa($pdo);
                if (!empty($qddValor->getIdQddValor())) {
                    //Verifica se o valor Empenho irá ficar menor que 0
                    $valorEmpenho = $qddValor->getVlEmpenhado() - $dadosEmpenho['vl_empenho'];
                    $valorEmpenho = round($valorEmpenho, 4);
                    if ($valorEmpenho >= 0) {
                        //seta o resultado da soma para atualiza o qdd
                        $qddValor->setVlEmpenhado($valorEmpenho);
                        $qddValor->atualizaValoresEmpenhado($pdo);
                        //esse array foi criado para atualiza os valores do qdd valor pois a classe espera um array
                        $array = array();
                        $array[] = $qddValor->getIdQddValor();
                        $qddValor->atualizaValoresPorArray($array, $pdo);
                        if (!$qddValor->Sucesso()) {
                            $pdo->rollBack();
                            return Metodos::retornoAjax("Erro", "alert", "Não foi possível atualizar os Valores do QDD.");
                        }
                    } else {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "alert", "O Valor Empenhado irá ficar Negativa se o Empenho for cancelado. " . STR_ERROR);
                    }
                } else {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", "Não foi possível localizar o QDD ao qual irá ajustar o valor");
                }
            } else {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Não foi possível localizar o QDD");
            }


            //$pdo->rollBack();
            //echo "fechou;";

            $pdo->commit();
            return Metodos::retornoAjax("ok", "html", "Cancelamento do Empenho/Pedido de Necessidade Cancelado com Sucesso.");
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

    public function retornaTotalLiquidadoDoEmpenho($pdo) {
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoFinEmpenho = new DaoFinEmpenho();
            $daoFinEmpenho->setIdEmpenho($this->id_empenho);
            $daoFinEmpenho->retornaTotalLiquidadoDoEmpenho($pdo);
            if ($daoFinEmpenho->sucesso()) {
                return $daoFinEmpenho->getMsgRetorno();
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function atualizaValorEmpenhoAtualizaQDD($valorPedidoEmpenhoAntigo, PDO $pdo = null) {
        try {
            if (empty($pdo)) {
                $this->sucesso = false;
                $this->msgRetorno = "Conexão não possui nada.";
                return;
            }

            $daoFinEmpenho = new DaoFinEmpenho();
            $daoFinEmpenho->setIdEmpenho($this->id_empenho);
            $daoFinEmpenho->setIdPedido($this->id_pedido);
            $daoFinEmpenho->setVlEmpenho($this->vl_empenho);
            $daoFinEmpenho->retorna($pdo);

            if (!$daoFinEmpenho->sucesso()) {
                $this->sucesso = false;
                $this->msgRetorno = "Não foi possível localizar o Empenho.";
                return;
            }
            $dadosEmpenho = $daoFinEmpenho->getMsgRetorno();

            //Atualiza o Valor do Empenho
            $daoFinEmpenho->updateValorEmpenho($pdo);
            if (!$daoFinEmpenho->sucesso()) {
                $this->sucesso = false;
                $this->msgRetorno = $daoFinEmpenho->getMsgRetorno();
                return;
            }

            if (!Log::SalvaLogU('fin_empenho', $this->id_empenho, $dadosEmpenho, $pdo)) {
                $this->sucesso = false;
                $this->msgRetorno = "Não foi possível atualizar Empenho. LOG";
                return;
            }

            //Busca dados do Pedido
            $pedido = new Pedido();
            $pedido->setIdPedido($dadosEmpenho['id_pedido']);
            $dadosPedido = $pedido->retornaDadosPedido();
            if (empty($dadosPedido)) {
                $this->sucesso = false;
                $this->msgRetorno = "Não foi possível localizar os Dados do Pedido.";
                return;
            }

            //Atualiza o QDD pelo Empenho
            $qdd = new Qdd();
            $data = new DateTime($dadosEmpenho['dt_empenho_safira']);
            //seto o ano do empenho para pega o id do qdd
            $qdd->setAaQdd($data->format('Y'));
            $qdd->verificaExisteCarregaDados($pdo);
            if (!empty($qdd->getIdQdd())) {
                //instancio a classe do qddValor
                $qddValor = new QddValor();
                $qddValor->setIdQdd($qdd->getIdQdd());
                $qddValor->setIdFonte($dadosPedido['id_fonte']);
                $qddValor->setIdProgramaTrabalho($dadosPedido['id_programa_trabalho']);
                $qddValor->setIdDespesaElemento($dadosPedido['id_despesa_elemento']);
                $qddValor->carregaDadosQddFonteProgDespesa($pdo);
                if (!empty($qddValor->getIdQddValor())) {
                    //Verifica se o valor Empenho irá ficar menor que 0
                    $valorEmpenho = $qddValor->getVlEmpenhado() - $valorPedidoEmpenhoAntigo + $this->vl_empenho;
                    $valorEmpenho = round($valorEmpenho, 4);
                    if ($valorEmpenho >= 0) {
                        //seta o resultado da soma para atualiza o qdd
                        $qddValor->setVlEmpenhado($valorEmpenho);
                        $qddValor->atualizaValoresEmpenhado($pdo);
                        //esse array foi criado para atualiza os valores do qdd valor pois a classe espera um array
                        $array = array();
                        $array[] = $qddValor->getIdQddValor();
                        $qddValor->atualizaValoresPorArray($array, $pdo);
                        if (!$qddValor->Sucesso()) {
                            $this->sucesso = false;
                            $this->msgRetorno = "Não foi possível atualizar os Valores do QDD.";
                            return;
                        }
                    } else {
                        $this->sucesso = false;
                        $this->msgRetorno = "O Valor Empenhado irá ficar Negativa se o Empenho for anulado. " . STR_ERROR;
                        return;
                    }
                } else {
                    $this->sucesso = false;
                    $this->msgRetorno = "Não foi possível localizar o QDD ao qual irá ajustar o valor";
                    return;
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Não foi possível localizar o QDD";
                return;
            }

            $this->sucesso = true;
            $this->msgRetorno = "Empenho e QDD Atualziado";
        } catch (Exception $ex) {
            $this->sucesso = true;
            $this->msgRetorno = "Empenho e QDD Atualziado";
        }
    }

    public function retornaEmpenhoPedidoAccordion($pdo){
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $dadosPedido = '';
            $daoFinEmpenho = new DaoFinEmpenho();
            $daoFinEmpenho->setIdPedido($this->id_pedido);
            $daoFinEmpenho->retornaDadosEmpenhoPedido($pdo);
            
            if ($daoFinEmpenho->sucesso()) {
                $campos = $daoFinEmpenho->getMsgRetorno();
                $saldoOrdenar = '';
                if ($campos['id_tipo_solicitacao'] == '2') {
                    $saldoOrdenar = '<div class="form-group">
                                        <div class="col-sm-2"><b>Saldo a Ordenar:</b></div>
                                        <div class="col-sm-10">' . Metodos::ConverteValorBr($campos["saldo"], 4) . '</div>
                                    </div>';
                }
                $dadosPedido .= '<div class="form-group">
                                    <div  class="col-sm-12" style="margin-bottom: -4%;">
                                        <div class="panel-body">
                                            <div class="panel-group" id="pedido">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">
                                                            <a role="button" data-toggle="collapse" data-parent="#pedido" href="#pedidoDetalhes">
                                                                <i class="glyphicon glyphicon-chevron-down"></i>
                                                                <b>Dados do Pedido de Necessidade: </b><span style="color:#758697"> Nº ' . $campos["nr_pedido"] .'/'. $campos["ano"] . '</span>
                                                            </a>
                                                        </h4>
                                                    </div>

                                                    <div id="pedidoDetalhes" class="panel-collapse collapse" >
                                                        <div class="panel-body">

                                                            <div class="form-group">
                                                                <div class="col-sm-2"><b>Tipo do Pedido de Necessidade:</b></div>
                                                                <div class="col-sm-10">' . $campos["nm_tipo_solicitacao"] . '</div>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <div class="col-sm-2"><b>Central de Demanda:</b></div>
                                                                <div class="col-sm-10">' . $campos["nm_lotacao"] . '</div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="col-sm-2"><b>Descrição:</b></div>
                                                                <div class="col-sm-10">' . $campos["ds_pedido"] . '</div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="col-sm-2"><b>Fonte:</b></div>
                                                                <div class="col-sm-10">' . $campos["nr_fonte"] . '</div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="col-sm-2"><b>Funcional Programática:</b></div>
                                                                <div class="col-sm-10">' . $campos["cd_programa_trabalho"] . ' - ' . $campos["ds_programa_trabalho"] . '</div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="col-sm-2"><b>Elemento de Despesa:</b></div>
                                                                <div class="col-sm-10">' . $campos["cd_despesa_elemento"] . ' - ' . $campos["ds_despesa_elemento"] . '</div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="col-sm-2"><b>Sub-Elemento:</b></div>
                                                                <div class="col-sm-10">' . $campos["cd_despesa"] . ' - ' . $campos["ds_despesa"] . '</div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="col-sm-2"><b>Valor do Pedido de Necessidade:</b></div>
                                                                <div class="col-sm-10">' . Metodos::ConverteValorBr($campos["vl_pedido"], 4) . '</div>
                                                            </div>'
                                                            . $saldoOrdenar.
                                                            '<div class="form-group">
                                                                <div class="col-sm-2"><b>Saldo a Liquidar:</b></div>
                                                                <div class="col-sm-10">' . Metodos::ConverteValorBr($campos["saldo_liquidar"], 4) . '</div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-sm-2"><b>Saldo a Pagar:</b></div>
                                                                <div class="col-sm-10">' . Metodos::ConverteValorBr($campos["saldo_pagar"], 4) . '</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                 </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
            }
            return $dadosPedido;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }        
    }
    
    public function retornaEmpenhoPedidoDiariaAccordion($pdo){
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $dadosPedidoDiaria = '';
            $daoFinEmpenho = new DaoFinEmpenho();
            $daoFinEmpenho->setIdPedido($this->id_pedido);
            $daoFinEmpenho->retornaDadosEmpenhoPedidoDiaria($pdo);
            if ($daoFinEmpenho->sucesso()) {
                $destinos = '';
                $dadosGerais = $daoFinEmpenho->getMsgRetorno()[0];
                foreach ($daoFinEmpenho->getMsgRetorno() as $linha) {
                    $destinos .= "<tr>"
                                    . "<td class='text-center'>".$linha['nm_cidade_origem']. " - " . $linha['uf_cidade_origem'] ."</td>"
                                    . "<td class='text-center'>".$linha['nm_cidade_destino']. " - " . $linha['uf_cidade_destino'] ."</td>"
                                    . "<td class='text-center'>".$linha["dh_inicio"]."</td>"
                                    . "<td class='text-center'>".$linha["dh_fim"]."</td>"
                                    . "<td class='text-center'>".Metodos::ConverteValorBr($linha["qt_diaria_destino"],2)."</td>"
                                    . "<td class='text-center'>".Metodos::ConverteValorBr($linha["vl_diaria_destino"],2)."</td>"
                                    . "<td class='text-center'>".Metodos::ConverteValorBr($linha["qt_diaria_destino"] * $linha["vl_diaria_destino"],2)."</td>"
                                . "</tr>";
                }
                
                if (!empty($destinos)) {
                    $dadosPedidoDiaria .= "<div class='form-group'>"
                                            ."<div class='col-sm-12' style='margin-bottom: -4%;'>"
                                                ."<div class='panel-body'>"
                                                    ."<div class='panel-group' id='diaria'>"
                                                        . "<div class='panel panel-default'>"
                                                            . "<div class='panel-heading'>"
                                                                . "<h4 class='panel-title'>"
                                                                    . '<a role="button" data-toggle="collapse" data-parent="#diaria" href="#destinos">'
                                                                        . '<i class="glyphicon glyphicon-chevron-down"></i> '
                                                                        . '<b>Dados da Diária: <span style="color:#758697"> Nº ' . $dadosGerais["id_diaria"] .'/'. $dadosGerais["nr_protocolo"] . '</span></b>'
                                                                    . '</a>'
                                                                . "</h4>"
                                                            . "</div>"
                                                            . '<div id="destinos" class="panel-collapse collapse">'
                                                                . '<div class="panel-body">'
                                                                    . '<div class="row">'
                                                                        . '<div class="col-sm-6">'
                                                                            . '<div class="rpw">'
                                                                                .'<div class="form-group">'
                                                                                    .'<div class="col-sm-2"><b>Proponente:</b></div>'
                                                                                    .'<div class="col-sm-10">' . $dadosGerais["nm_proponente"] . '</div>'
                                                                                .'</div>'
                                                                                .'<div class="form-group">'
                                                                                    .'<div class="col-sm-2"><b>Lotação Proponente:</b></div>'
                                                                                    .'<div class="col-sm-10">' . $dadosGerais["lt_proponente"] . '</div>'
                                                                                .'</div>'
                                                                                .'<div class="form-group">'
                                                                                    .'<div class="col-sm-2"><b>Função Proponente:</b></div>'
                                                                                    .'<div class="col-sm-10">' . $dadosGerais["fn_proponente"] . '</div>'
                                                                                .'</div>'
                                                                            . '</div>'
                                                                        . '</div>'
                                                                        . '<div class="col-sm-6">'
                                                                            . '<div class="rpw">'
                                                                                .'<div class="form-group">'
                                                                                    .'<div class="col-sm-2"><b>Proposto:</b></div>'
                                                                                    .'<div class="col-sm-10">' . $dadosGerais["nm_proposto"] . '</div>'
                                                                                .'</div>'
                                                                                .'<div class="form-group">'
                                                                                    .'<div class="col-sm-2"><b>Lotação Proposto:</b></div>'
                                                                                    .'<div class="col-sm-10">' . $dadosGerais["lt_proposto"] . '</div>'
                                                                                .'</div>'
                                                                                .'<div class="form-group">'
                                                                                    .'<div class="col-sm-2"><b>Função Proposto:</b></div>'
                                                                                    .'<div class="col-sm-10">' . $dadosGerais["fn_proposto"] . '</div>'
                                                                                .'</div>'
                                                                            . '</div>'
                                                                        . '</div>'
                                                                    . '</div>'
                                                                    . '<table class="table table-striped table-bordered" cellspacing="0" widht="100%">'
                                                                        . '<thead>'
                                                                            . '<tr>'
                                                                                . '<th class="text-center">Origem</th>'
                                                                                . '<th class="text-center">Destino</th>'
                                                                                . '<th class="text-center">Horário Partida</th>'
                                                                                . '<th class="text-center">Horário Chegada</th>'
                                                                                . '<th class="text-center">Qtd. Diárias</th>'
                                                                                . '<th class="text-center">Valor Unitário</th>'
                                                                                . '<th class="text-center">Valor Total</th>'
                                                                            . '</tr>'
                                                                        . '</thead>'
                                                                        . '<tbody>'
                                                                        . $destinos
                                                                        . '</tbody>'
                                                                    . '</table>'   
                                                                . '</div>'                                    
                                                            . '</div>'
                                                        . "</div>"
                                                    . "</div>"
                                                . "</div>"
                                            . "</div>"
                                        . "</div>";
                }
            }
            return $dadosPedidoDiaria;
        } catch (Exception $exc) {
            return $ex->getMessage();
        }
    }
    
    public function retornaEmpenhoPedidoItensAccordion($pdo){
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $dadosPedidoItens = '';
            $daoFinEmpenho = new DaoFinEmpenho();
            $daoFinEmpenho->setIdPedido($this->id_pedido);
            $daoFinEmpenho->retornaDadosEmpenhoPedidoItens($pdo);
            if ($daoFinEmpenho->sucesso()) {
                $linhaItens = '';
                foreach ($daoFinEmpenho->getMsgRetorno() as $linha) {
                    $linhaItens .= '<tr>'
                                    . '<td class="text-center">'.$linha['nr_item'].'</td>'
                                    . '<td class="text-center">'.$linha['nm_material'].'</td>'
                                    . '<td class="text-center">'.$linha['cd_desc_material']. ' - ' . $linha['nm_desc_material'].'</td>'
                                    . '<td class="text-center">'.$linha['tp_material'].'</td>'
                                    . '<td class="text-center">'.Metodos::ConverteValorBr($linha['qt_itens_pre'],4).'</td>'
                                    . '<td class="text-center">'.Metodos::ConverteValorBr($linha['vl_itens_pre'],4).'</td>'
                                    . '<td class="text-center">'.Metodos::ConverteValorBr($linha['total'],4).'</td>'
                                    . '<td class="text-center">'.Metodos::ConverteValorBr($linha['qt_utilizado'],4).'</td>'
                                    . '<td class="text-center">'.Metodos::ConverteValorBr($linha['vl_utilizado'],4).'</td>'
                                    . '<td class="text-center">'.Metodos::ConverteValorBr($linha['saldo'],4).'</td>'
                                . '</td>';
                }
                if (empty($dadosPedidoItens)) {
                        $dadosPedidoItens = "<div class='form-group'>"
                                                ."<div class='col-sm-12' style='margin-bottom: -4%;'>"
                                                    ."<div class='panel-body'>"
                                                        .'<div class="panel-group" id="itensAccordion">'
                                                            . '<div class="panel panel-default">'
                                                                    . '<div class="panel-heading">'
                                                                        . '<h4 class="panel-title">'
                                                                            . '<a role="button" data-toggle="collapse" data-parent="#itensAccordion" href="#expandeItens">'
                                                                                . '<i class="glyphicon glyphicon-chevron-up"></i> '
                                                                                . '<b>Dados dos Itens do Pedido de Necessidade</b>'
                                                                            . '</a>'
                                                                        . '</h4>'
                                                                    . '</div>'
                                                                    . '<div id="expandeItens" class="panel-collapse collapse in" >'
                                                                        . '<div class="panel-body">'
                                                                            . '<table class="table table-striped table-bordered" cellspacing="0" widht="100%">'
                                                                                . '<thead>'
                                                                                    . '<tr>'
                                                                                        . '<th class="text-center">Nº</th>'
                                                                                        . '<th class="text-center">Item</th>'
                                                                                        . '<th class="text-center">Descrição</th>'
                                                                                        . '<th class="text-center">Tipo</th>'
                                                                                        . '<th class="text-center">Qtd.</th>'
                                                                                        . '<th class="text-center">Valor Unitário</th>'
                                                                                        . '<th class="text-center">Valor Total</th>'
                                                                                        . '<th class="text-center">Qtd. Utilizada</th>'
                                                                                        . '<th class="text-center">Valor Utilizado</th>'
                                                                                        . '<th class="text-center">Saldo a Ordenar</th>'
                                                                                    . '</tr>'
                                                                                . '</thead>'
                                                                                . '<tbody>'
                                                                                . $linhaItens
                                                                                . '</tbody>'
                                                                            . '</table>'
                                                                        . '</div>'                                    
                                                                    . '</div>'
                                                            . '</div>'
                                                        . '</div>'
                                                    . '</div>'
                                                . '</div>'
                                            . '</div>';
                    }
            }
            return $dadosPedidoItens;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    
    public function retornaEmpenhoPedidoItensAnuladosAccordion($pdo){
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $dadosPedidoItensAnulados = '';
            $daoFinEmpenho = new DaoFinEmpenho();
            $daoFinEmpenho->setIdPedido($this->id_pedido);
            $daoFinEmpenho->retornaDadosEmpenhoPedidoItensAnulados($pdo);
            if ($daoFinEmpenho->sucesso()) {
                $linhaItens = '';
                $nr_anulacao = '';
                foreach ($daoFinEmpenho->getMsgRetorno() as $linha) {
                    if ($nr_anulacao != $linha['id_empenho_anulacao']) {
                        
                        //Condição para fechar o panel do accordion, pois o resultado da função retorna os itens das várias anulações do empenho
                        if (!empty($nr_anulacao) and $nr_anulacao != $linha['id_empenho_anulacao']) {
                            $dadosPedidoItensAnulados .= '</tbody>'
                                                    . '</table>'
                                                . '</div>'
                                            . '</div>'
                                        . '</div>'
                                    . '</div>'
                                . '</div>'
                            . '</div>'
                        . '</div>';
                        }
                        
                        $nr_anulacao = $linha['id_empenho_anulacao'];
                        $dadosPedidoItensAnulados .= "<div class='form-group'>"
                                                        ."<div class='col-sm-12' style='margin-bottom: -4%;'>"
                                                            ."<div class='panel-body'>"
                                                                .'<div class="panel-group" id="itens_anulados'.$linha['id_empenho_anulacao'].'">'
                                                                    .'<div class="panel panel-default">'
                                                                        . '<div class="panel-heading">'
                                                                            . '<h4 class="panel-title">'
                                                                                . '<a class="accordion-toggle" data-toggle="collapse" href="#anulacao'.$linha['id_empenho_anulacao'].'">'
                                                                                    . '<i class="glyphicon glyphicon-chevron-down"></i> '
                                                                                    . '<b>Dados dos Itens Anulados do Pedido de Necessidade:</b> <span style="color:#758697">Anulação Nº '.$linha['nr_empenho_anulacao'].'</span>'
                                                                                . '</a>'
                                                                            . '</h4>'
                                                                        . '</div>'
                                                                        . '<div id="anulacao'.$linha['id_empenho_anulacao'].'" class="panel-collapse collapse">'
                                                                            . '<div class="panel-body">'
                                                                                . '<table class="table table-striped table-bordered" cellspacing="0" widht="100%">'
                                                                                    . '<thead>'
                                                                                        . '<tr>'
                                                                                            . '<th class="text-center">Nº</th>'
                                                                                            . '<th class="text-center">Item</th>'
                                                                                            . '<th class="text-center">Descrição</th>'
                                                                                            . '<th class="text-center">Tipo</th>'
                                                                                            . '<th class="text-center">Qtd.</th>'
                                                                                            . '<th class="text-center">Valor Unitário</th>'
                                                                                            . '<th class="text-center">Valor Total</th>'
                                                                                            . '<th class="text-center">Qtd. Utilizado</th>'
                                                                                            . '<th class="text-center">Valor Utilizado</th>'
                                                                                            . '<th class="text-center">Qtd. Anulado</th>'
                                                                                            . '<th class="text-center">Valor Anulado</th>'
                                                                                        . '</tr>'
                                                                                    . '</thead>'
                                                                                    . '<tbody>';
                    }
                    $dadosPedidoItensAnulados .= '<tr>'
                                    . '<td class="text-center">'.$linha['nr_item'].'</td>'
                                    . '<td class="text-center">'.$linha['nm_material'].'</td>'
                                    . '<td class="text-center">'.$linha['cd_desc_material']. ' - ' .$linha['nm_desc_material'].'</td>'
                                    . '<td class="text-center">'.$linha['tp_material'].'</td>'
                                    . '<td class="text-center">'.Metodos::ConverteValorBr($linha['qt_item'],4).'</td>'
                                    . '<td class="text-center">'.Metodos::ConverteValorBr($linha['vl_item'],4).'</td>'
                                    . '<td class="text-center">'.Metodos::ConverteValorBr($linha['qt_item'] * $linha['vl_item'] ,4).'</td>'
                                    . '<td class="text-center">'.Metodos::ConverteValorBr($linha['qt_utilizado'],4).'</td>'
                                    . '<td class="text-center">'.Metodos::ConverteValorBr($linha['vl_utilizado'],4).'</td>'
                                    . '<td class="text-center">'.Metodos::ConverteValorBr($linha['qt_anulado'],4).'</td>'
                                    . '<td class="text-center">'.Metodos::ConverteValorBr($linha['vl_anulado'],4).'</td>'
                                . '</td>';
                }
                $dadosPedidoItensAnulados .= '</tbody>'
                                            . '</table>'
                                        . '</div>'
                                    . '</div>'
                                . '</div>'
                            . '</div>'
                        . '</div>'
                    . '</div>'
                . '</div>';
            }
            return $dadosPedidoItensAnulados;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    
    public function retornaEmpenhoContratoAccordion($pdo){
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $dadosContrato = '';
            $daoFinEmpenho = new DaoFinEmpenho();
            $daoFinEmpenho->setIdPedido($this->id_pedido);
            $daoFinEmpenho->retornaDadosEmpenhoContrato($pdo);
            
            if ($daoFinEmpenho->sucesso()) {
                $campos = $daoFinEmpenho->getMsgRetorno();
                $dadosContrato .= '<div class="form-group">
                                        <div  class="col-sm-12" style="margin-bottom: -4%;">
                                            <div class="panel-body"><div class="panel-group" id="contrato">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">
                                                            <a role="button" data-toggle="collapse" data-parent="#contrato" href="#contratoDetalhes">
                                                                <i class="glyphicon glyphicon-chevron-down"></i>
                                                                <b>Dados do Contrato: </b><span style="color:#758697"> Nº ' . $campos["nr_contrato"] . '</span>
                                                            </a>
                                                        </h4>
                                                    </div>

                                                    <div id="contratoDetalhes" class="panel-collapse collapse" >
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
                                                                <div class="col-sm-2"><b>Central de Demanda:</b></div>
                                                                <div class="col-sm-10">' . mb_strtoupper($campos["nm_lotacao"],'UTF-8') . '</div>
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

                                                            <div class="row">
                                                                <div class="form-group">
                                                                    <div class="col-sm-2"><b>Processo Administrativo da Despesa Publica:</b></div>
                                                                    <div class="col-sm-10"></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-sm-2"><b>Valor do Contrato:</b></div>
                                                                <div class="col-sm-10">' . Metodos::ConverteValorBr($campos["vl_contrato"],4) . '</div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                 </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
            }
            return $dadosContrato;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }  
    }
    
    public function retornaStatusOficialEmpenho(PDO $pdo) {
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $dao = new DaoFinEmpenho();
            $dao->setIdEmpenho($this->id_empenho);
            $dao->retornaStatusEmpenho($pdo);
            if ($dao->sucesso()) {                
                return array("status" => $dao->getMsgRetorno()['status_oficial']
                        , "situacao" => $dao->getMsgRetorno()['situacao_oficial']);                                
            }
            return null;
        } catch (Exception $exc) {
            $this->msgRetorno = $exc->getMessage();            
            return null;
        }
    }
    
    public function atualizaStatusSituacaoOficialEmpenho(PDO $pdo) {
        try {
            if (empty($pdo)) {
                $this->sucesso = false;
                $this->msgRetorno = "Não existe transação ativa";
                return;
            }
            
            $retorno = $this->retornaStatusOficialEmpenho($pdo);
            if(empty($retorno)){
                $this->sucesso = false;
                $this->msgRetorno = "Não foi possível definir o Status do Empenho";
                return;
            }                        
            
            $daoFinEmpenho = new DaoFinEmpenho();
            $daoFinEmpenho->setIdEmpenho($this->id_empenho);
            
            $daoFinEmpenho->retorna($pdo);
            if (!$daoFinEmpenho->sucesso()) {
                $this->sucesso = false;
                $this->msgRetorno = "Não foi possível definir o Status do Empenho";
                return;
            }

            $busca = $daoFinEmpenho->getMsgRetorno();          

            if (!Log::SalvaLogU('fin_empenho', $daoFinEmpenho->getIdEmpenho(), $busca, $pdo)) {
                $this->sucesso = false;
                $this->msgRetorno = "Erro ao registrar a operação de atualização da situação e status do Empenho no LOG.";
                return false;
            }
                                                                                                
            $daoFinEmpenho->setIdEmpenhoStatus($retorno['status']);
            $daoFinEmpenho->setSitEmpenho($retorno['situacao']);
            $daoFinEmpenho->atualizaSituacaoStatusEmpenho($pdo);
            if(!$daoFinEmpenho->Sucesso()){
                $this->sucesso = false;
                $this->msgRetorno = "Não foi possível atualizar o Status do Empenho";
                return;
            }
            
            $this->sucesso = true;
            $this->msgRetorno = "Atualizado";                        
            
        } catch (Exception $exc) {
            $this->msgRetorno = $exc->getMessage();
            $this->sucesso = false;            
        }
    }
    
    function salvarEmpenhoHistorico(PDO $pdo = null, int $situacao, int $status, string $descricao = '') {
        try {
            $this->sucesso = true;
            $this->msgRetorno = null;
            if (!empty($pdo)) {
                $empenhoHistorico = new FinEmpenhoHistorico();
                $empenhoHistorico->setIdLotacao($this->getIdLotacao())
                        ->setIdEmpenho($this->getIdEmpenho())
                        ->setIdPessoa($this->getIdPessoa())
                        ->setIdDocTipoLotacao($this->getIdDocTipoLotacao())
                        ->setIdEmpenhoSituacao($situacao)
                        ->setIdEmpenhoStatus($status)
                        ->setDsEmpenhoHistorico($descricao);

                $empenhoHistorico->salvarEmpenhoHistorico($pdo);

                if (!$empenhoHistorico->getSucesso()) {
                    $this->sucesso = false;
                    $this->msgRetorno = $empenhoHistorico->getMsgRetorno();
                    return false;
                }

                return $this->sucesso;
            } else {
                $this->msgRetorno = "Sem conexão com o banco de dados";
                $this->sucesso = false;
            }
        } catch (Exception $exc) {
            //Se der algum erro, registra o erro no objeto
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
}
