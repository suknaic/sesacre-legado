<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/ordem/entrega/DaoFinEntregaConfirmacao.class.php";

class FinEntregaConfirmacaoModel {

    private $id_entrega_confirmacao = null;
    private $id_ordem = null;
    private $id_protocolo = null;
    private $nr_entrega_confirmacao = null;
    private $dt_entrega = null;
    private $dh_cadastramento = null;
    private $sit_entrega = null;
    private $sucesso = false;
    private $msgRetorno = null;

    /**
     * @return mixed
     */
    public function getIdEntregaConfirmacao() {
        return $this->id_entrega_confirmacao;
    }

    /**
     * @param mixed $id_entrega_confirmacao
     *
     * @return self
     */
    public function setIdEntregaConfirmacao($id_entrega_confirmacao) {
        $this->id_entrega_confirmacao = $id_entrega_confirmacao;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdOrdem() {
        return $this->id_ordem;
    }

    /**
     * @param mixed $id_ordem
     *
     * @return self
     */
    public function setIdOrdem($id_ordem) {
        $this->id_ordem = $id_ordem;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdProtocolo() {
        return $this->id_protocolo;
    }

    /**
     * @param mixed $id_protocolo
     *
     * @return self
     */
    public function setIdProtocolo($id_protocolo) {
        $this->id_protocolo = $id_protocolo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNrEntregaConfirmacao() {
        return $this->nr_entrega_confirmacao;
    }

    /**
     * @param mixed $nr_entrega_confirmacao
     *
     * @return self
     */
    public function setNrEntregaConfirmacao($nr_entrega_confirmacao) {
        $this->nr_entrega_confirmacao = $nr_entrega_confirmacao;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtEntrega() {
        return $this->dt_entrega;
    }

    /**
     * @param mixed $dt_entrega
     *
     * @return self
     */
    public function setDtEntrega($dt_entrega) {
        $this->dt_entrega = $dt_entrega;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDhCadastramento() {
        return $this->dh_cadastramento;
    }

    /**
     * @param mixed $dh_cadastramento
     *
     * @return self
     */
    public function setDhCadastramento($dh_cadastramento) {
        $this->dh_cadastramento = $dh_cadastramento;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSitEntrega() {
        return $this->sit_entrega;
    }

    /**
     * @param mixed $sit_entrega
     *
     * @return self
     */
    public function setSitEntrega($sit_entrega) {
        $this->sit_entrega = $sit_entrega;

        return $this;
    }

    public function sucesso() {
        return $this->sucesso;
    }

    /**
     * @return mixed
     */
    public function getMsgRetorno() {
        return $this->msgRetorno;
    }

    public function inforLoadCadEntrega() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoFinEntregaConfirmacao = new DaoFinEntregaConfirmacao();
            $daoFinEntregaConfirmacao->setIdProtocolo($this->id_protocolo);
            $daoFinEntregaConfirmacao->retornaInforLoadProtocolo($pdo);
            if ($daoFinEntregaConfirmacao->sucesso()) {
                return $daoFinEntregaConfirmacao->getMsgRetorno();
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

    public function retornaItensCadEntrega() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoFinEntregaConfirmacao = new DaoFinEntregaConfirmacao();
            $daoFinEntregaConfirmacao->setIdOrdem($this->id_ordem);
            $daoFinEntregaConfirmacao->retornaInforParaEntrega($pdo);
            if ($daoFinEntregaConfirmacao->sucesso()) {
                return $daoFinEntregaConfirmacao->getMsgRetorno();
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function verificaSerAEntregaTotal($pdo) {
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoFinEntregaConfirmacao = new DaoFinEntregaConfirmacao();
            $daoFinEntregaConfirmacao->setIdEntregaConfirmacao($this->id_entrega_confirmacao);
            $daoFinEntregaConfirmacao->verificaSerAEntregaTotal($pdo);
            return $daoFinEntregaConfirmacao->sucesso();
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaUltimaDataEntrega($pdo) {
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoFinEntregaConfirmacao = new DaoFinEntregaConfirmacao();
            $daoFinEntregaConfirmacao->setIdProtocolo($this->id_protocolo);
            $daoFinEntregaConfirmacao->retornaUltimaDataEntrega($pdo);

            if ($daoFinEntregaConfirmacao->sucesso()) {
                $this->sucesso = true;
                $this->msgRetorno = $daoFinEntregaConfirmacao->getMsgRetorno();
            } else {
                $this->sucesso = false;
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function verificaMaiorItem($pdo, int $idEntregaItens = 0) {
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoFinEntregaConfirmacao = new DaoFinEntregaConfirmacao();
            $daoFinEntregaConfirmacao->setIdEntregaConfirmacao($this->id_entrega_confirmacao);
            $daoFinEntregaConfirmacao->retornaMaiorIdEntregaItens($pdo);
            if ($daoFinEntregaConfirmacao->sucesso()) {
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaNumeroEntregaConfirmacao(PDO $pdo) {
        try {

            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }

            $daoFinEntregaConfirmacao = new DaoFinEntregaConfirmacao();
            $daoFinEntregaConfirmacao->setIdProtocolo($this->id_protocolo);
            $daoFinEntregaConfirmacao->retornaNumeroEntregaConfirmacao($pdo);

            if (empty($daoFinEntregaConfirmacao->getMsgRetorno()->nr_entrega_confirmacao)) {
                return 0;
            }

            return $daoFinEntregaConfirmacao->getMsgRetorno()->nr_entrega_confirmacao;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function salvaEntregaConfirmacao($dados) {
        try {
            //conexao com o banco
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $daoFinEntregaConfirmacao = new DaoFinEntregaConfirmacao();
            $finEntregaItensModel = new FinEntregaItensModel();
            $finProtocoloModel = new FinProtocoloModel();
            $this->id_protocolo = $dados[0]->id_protocolo;

            $daoFinEntregaConfirmacao->setIdOrdem($dados[0]->idOrdem);
            $daoFinEntregaConfirmacao->setIdProtocolo($dados[0]->id_protocolo);
            $daoFinEntregaConfirmacao->setNrEntregaConfirmacao($this->retornaNumeroEntregaConfirmacao($pdo) + 1);
            $daoFinEntregaConfirmacao->setDtEntrega(Metodos::ConverteDataING($dados[0]->data));
            $daoFinEntregaConfirmacao->setSitEntrega($dados[0]->tipoEntrega);
            $daoFinEntregaConfirmacao->salvaEntregaConfirmacao($pdo);

            //verificar ser salvou a entrega confirmacao 
            if (!$daoFinEntregaConfirmacao->sucesso()) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }
            //pega o id da entrega confirmacao
            $finEntregaItensModel->setIdEntregaConfirmacao($pdo->lastInsertId('fin_entrega_confirmacao_id_entrega_confirmacao_seq'));
            //setando os dados para atualiza a situacao do protocolo
            $finProtocoloModel->setIdProtocolo($dados[0]->id_protocolo);
            $finProtocoloModel->setStProtocolo($dados[0]->tipoEntrega);
            $finProtocoloModel->setDtConfirmacao(Metodos::ConverteDataING($dados[0]->data));
            //verifica ser a entrega e parcial
            if ($finProtocoloModel->verificarStatusEntregaParcial($pdo) && $dados[0]->tipoEntrega == 2) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Você não pode lança uma entrega total pois existem entrega(s) parcial lançada");
            }


            $finProtocoloModel->setQtEntrega($this->retornaNumeroEntregaConfirmacao($pdo));
            $finProtocoloModel->atualizaQtEntrega($pdo);

            if (!$finProtocoloModel->Sucesso()) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Erro na atualização da quantidade de entrega");
            }

            //atualiza situaçao da entrega
            if (!$finProtocoloModel->atualizaSituacaoProtocolo($pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Erro na atualização da situação");
            }
            //atualiza data entregue dia 
            $finProtocoloModel->atualizaEntregueDia($pdo);

            if (!$finProtocoloModel->Sucesso()) {
                $pdo->rollBack();
                return $finProtocoloModel->getMsgRetorno();
            }

            //retorna os saldos dos itens
            $finOrdemItensModel = new FinOrdemItensModel();
            $finOrdemItensModel->setIdOrdem($dados[0]->idOrdem);
            $finOrdemItensModel->retornaArraySaldoOrdemItens($pdo);
            //verifica ser retornou o saldo com sucesso
            if (!$finOrdemItensModel->getSucesso()) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "O sistema não identificou o saldo dos itens");
            }

            $saldoItens = $finOrdemItensModel->getMsgRetorno();

            foreach ($dados as $valor) {
                $finEntregaItensModel->setIdOrdemItens($valor->idOrdemItens);

                //verificar ser precisa pega o valor dos itens
                if (($valor->tp == "C" || $valor->tp == "P") && $valor->fl_valor == 0) {

                    if ($valor->tipoEntrega == 1) {

                        $finEntregaItensModel->setQtItensEntrega(Metodos::ConverteValorIng($valor->qtd));
                    } else {
                        $finEntregaItensModel->setQtItensEntrega($valor->qtd);
                    }

                    if (!$finEntregaItensModel->verificarSaldoOrdemItens($saldoItens)) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "alert", "saldo insuficiente, por favor verifique os itens.");
                    }

                    $finEntregaItensModel->autoSetVlItemOrdem($pdo);
                } else if ($valor->tp == "S" || $valor->fl_valor == 1) {
                    $finEntregaItensModel->setQtItensEntrega(Metodos::ConverteValorIng($valor->qtd));
                    $finEntregaItensModel->setVlItensEntrega(Metodos::ConverteValorIng($valor->vl));

                    if (!$finEntregaItensModel->verificarSaldoOrdemItens($saldoItens)) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "alert", "saldo insuficiente, por favor verifique os itens.");
                    }
                }

                if (!$finEntregaItensModel->cadastraEntregaItens($pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                }
                //limpa qtd e valor
                $finEntregaItensModel->setQtItensEntrega(null);
                $finEntregaItensModel->setVlItensEntrega(null);
            }

            $finOrdemItensModel->setIdOrdem($dados[0]->idOrdem);
            $finOrdemItensModel->retornaArraySaldoOrdemItens($pdo);
            $parcial = 0;

            foreach ($finOrdemItensModel->getMsgRetorno() as $saldo) {
                if (round($saldo["saldoitens"], 4) > 0) {
                    $parcial++;
                }
            }

            if (empty($parcial)) {
                //atualiza situaçao da entrega
                $finProtocoloModel->setStProtocolo(2);
                if (!$finProtocoloModel->atualizaSituacaoProtocolo($pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", "Erro na atualização da situação");
                }
            }

            $pdo->commit();
            return Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
        } catch (Exception $ex) {
            $pdo->rollBack();
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaEntregaConfirmacao() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoFinEntregaConfirmacao = new DaoFinEntregaConfirmacao();

            if (!empty($this->id_ordem)) {
                $daoFinEntregaConfirmacao->setIdOrdem($this->id_ordem);
            }

            $daoFinEntregaConfirmacao->retornaEntregaConfirmacao($pdo);

            if ($daoFinEntregaConfirmacao->sucesso()) {
                return $daoFinEntregaConfirmacao->getMsgRetorno();
            }

            return false;
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaSituacaoEntrega() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoFinEntregaConfirmacao = new DaoFinEntregaConfirmacao();
            $tabela = "";
            $situacaoEntrega = array();
            $arraySituacaoEntrega = array();
            if (empty($this->id_ordem)) {
                return $tabela;
            }

            $daoFinEntregaConfirmacao->setIdOrdem($this->id_ordem);
            $daoFinEntregaConfirmacao->retornaSituacaoEntrega($pdo);


            if ($daoFinEntregaConfirmacao->sucesso()) {
                $situacaoEntrega = $daoFinEntregaConfirmacao->getMsgRetorno();
                //montando o array para gerar os campos da situaçao da entrega
                foreach ($situacaoEntrega as $valor) {


                    $arraySituacaoEntrega[$valor["nr_entrega_confirmacao"]][] = array(
                        "id_entrega_itens" => $valor["id_entrega_itens"],
                        "id_entrega_confirmacao" => $valor["id_entrega_confirmacao"],
                        "nr_item" => $valor["nr_item"],
                        "cd_desc_material" => $valor["cd_desc_material"],
                        "nm_material" => $valor["nm_material"],
                        "dt_entrega" => $valor["dt_entrega"],
                        "dh_cadastramento" => $valor["dh_cadastramento"],
                        "situacao" => $valor["situacao"],
                        "descricao" => $valor["descricao"],
                        "tp_material" => $valor["tp_material"],
                        "nr_lote" => $valor["nr_lote"],
                        "qt_itens_entrega" => $valor["qt_itens_entrega"],
                        "vl_itens_entrega" => $valor["vl_itens_entrega"],
                        "entregue" => $valor["entregue"]
                    );
                }

                foreach ($arraySituacaoEntrega as $key => $campos) {

                    $tabela .= ' <div class="panel-group" id="accordion' . $key . '" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="heading' . $key . '">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion' . $key . '" href="#' . $key . '" aria-expanded="false" aria-controls="collapse' . $key . '" class="collapsed">
                                                    <i class="glyphicon glyphicon-chevron-down"></i>
                                                    <b>Entrega: </b><span style="color:#758697">' . $key . '</span> <b style=" margin-left: 1%">Tipo de Entrega: </b>
                                                    <span style="color:#758697">' . $campos[0]["situacao"] . '</span> <b style=" margin-left: 1%">Data de Entrega: </b>
                                                    <span style="color:#758697">' . $campos[0]["dt_entrega"] . '</span>
                                                </a>
                                            </h4>
                                        </div>
                                    <div id="' . $key . '" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading' . $key . '" aria-expanded="false">
                                        <div class="panel-body">
                                             <table class="table table-striped table-bordered" id="tabela2">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">Nº</th>
                                                                <th class="text-center">Item</th>
                                                                <th class="text-center">Descrição</th>
                                                                <th class="text-center">Elemento de Despesa</th>
                                                                <th class="text-center">Tipo</th>
                                                                <th class="text-center">Lote</th>
                                                                <th class="text-center">Qtd</th>
                                                                <th class="text-center">Valor unit</th>
                                                                <th class="text-center">Entregue</th>
                                                                <th class="text-center">Ação</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>';

                    foreach ($campos as $c) {

                        $tabela .= '<tr>
                                    <td class="text-center">' . $c["nr_item"] . '</td>
                                    <td class="text-center">' . $c["cd_desc_material"] . ' - .' . $c["nm_material"] . '</td>
                                    <td class="text-center">' . $c["descricao"] . '</td>
                                    <td class="text-center">' . $c["nr_item"] . '</td>
                                    <td class="text-center">' . $c["tp_material"] . '</td>
                                    <td class="text-center">' . $c["nr_lote"] . '</td>
                                    <td class="text-center">' . Metodos::ConverteValorBr($c["qt_itens_entrega"], 4) . '</td>
                                    <td class="text-center">' . Metodos::ConverteValorBr($c["vl_itens_entrega"], 4) . '</td>
                                    <td class="text-center">' . Metodos::ConverteValorBr($c["entregue"],4) . '</td>
                                    <td class="text-center">
                                    <button type="button" title="Excluir itens" class="excluir text-danger" value="' . $c["id_entrega_itens"] . '" 
                                     nomeitem ="' . $c["nm_material"] . '" idEntrega = "' . $c["id_entrega_confirmacao"] . '">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </button>
                                    </td>    
                                </tr>';
                    }

                    $tabela .= ' </tbody>
                               </table>
                                    </div>
                                  </div>
                                </div>
                            </div>';
                }
                echo $tabela;
            }

            return false;
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function excluirEntrega(PDO $pdo) {
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoFinEntregaConfirmacao = new DaoFinEntregaConfirmacao();
            $daoFinEntregaConfirmacao->setIdEntregaConfirmacao($this->id_entrega_confirmacao);
            $daoFinEntregaConfirmacao->removeEntregaConfirmacao($pdo);

            if (!$daoFinEntregaConfirmacao->sucesso()) {
                return Metodos::retornoAjax("Erro", "alert", "Erro ao excluir a entrega confirmação");
            }

            if (!Log::SalvaLogD("fin_entrega_confirmacao", $this->id_entrega_confirmacao, $pdo)) {
                return Metodos::retornoAjax("Erro", "console", "Erro log delete entrega confirmacao");
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function verificaUltimaEntregaConfirmacao(PDO $pdo) {
        try {

            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }

            $daoFinEntregaConfirmacao = new DaoFinEntregaConfirmacao();
            $daoFinEntregaConfirmacao->setIdProtocolo($this->id_protocolo);
            $daoFinEntregaConfirmacao->verificarUltimaEntrega($pdo);
            $this->sucesso = $daoFinEntregaConfirmacao->sucesso();
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function atualizaSituacaoEntrega(PDO $pdo) {
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoFinEntregaConfirmacao = new DaoFinEntregaConfirmacao();
            $daoFinEntregaConfirmacao->setSitEntrega($this->sit_entrega);
            $daoFinEntregaConfirmacao->setIdEntregaConfirmacao($this->id_entrega_confirmacao);
            $daoFinEntregaConfirmacao->updateSitEntrega($pdo);
            $this->sucesso = $daoFinEntregaConfirmacao->sucesso();
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaOptionsEntregaOrdemGdof($dados) {
        try {
            if (empty($dados)) {
                return Metodos::retornoAjax("Erro", "console", "Entrega não encontrada");
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $arrayIdOrdens = array();
            foreach ($dados as $linha) {
                $arrayIdOrdens [] = $linha["id_ordem"];
            }
            $idOrdens = implode(' , ', $arrayIdOrdens);
            $daoFinEntregaConfirmacao = new DaoFinEntregaConfirmacao();
            $daoFinEntregaConfirmacao->retornaDadosOptionGdof($pdo, $idOrdens);
            $options = '<option value = "0" selected = "true">Selecione uma Entrega</option>';

            if ($daoFinEntregaConfirmacao->sucesso()) {
                foreach ($daoFinEntregaConfirmacao->getMsgRetorno() as $campo) {
                    $options .= '<option value = "' . $campo["id_entrega_confirmacao"] . '">' . $campo["nr_entrega_confirmacao"] . '-' . $campo["ordem"] . '</option>';
                }
                return $options;
            }
            return $options;
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaTabelaEntregasGdof($idEntregas) {
        try {

            if (empty($idEntregas)) {
                return Metodos::retornoAjax("Erro", "console", "Entrega não encontrada");
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $arrayIdEntregas = array();

            foreach ($idEntregas as $linha) {
                $arrayIdEntregas [] = $linha;
            }

            $idEntregas = implode(' , ', $arrayIdEntregas);

            $daoFinEntregaConfirmacao = new DaoFinEntregaConfirmacao();
            $daoFinEntregaConfirmacao->retornaEntregaGdof($pdo, $idEntregas);
            $tabela = '';

            if ($daoFinEntregaConfirmacao->sucesso()) {
                $totalEntrega = 0;
                foreach ($daoFinEntregaConfirmacao->getMsgRetorno() as $campos) {
                    $totalEntrega += $campos["valor"];
                    $tabela .= '<tr id= "ent' . $campos["id_entrega_confirmacao"] . '" ordem = "' . $campos["id_ordem"] . '" class = "trEntregas" idEntrega = "' . $campos["id_entrega_confirmacao"] . '">
                                 <td class = "text-center">' . $campos["nr_entrega_confirmacao"] . '</td>
                                 <td class = "text-center">' . $campos["ordem"] . '</td>
                                 <td class = "text-center">' . $campos["dataaviso"] . '</td>
                                 <td class = "text-center">' . $campos["datalimite"] . '</td>
                                 <td class = "text-center">' . $campos["nr_prazo_ordem"] . '</td>
                                 <td class = "text-center">' . $campos["entreguedia"] . '</td>
                                 <td class = "text-center">' . Metodos::ConverteValorBr($campos["valor"], 4) . '</td>
                                 <td class = "text-center">' . $campos["situacao"] . '</td>
                                 <td class = "text-center">
                                 <button type="button" title="Excluir ordem" class="excluirEntrega text-danger" value="' . $campos["id_entrega_confirmacao"] . '">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                                </td>
                                </tr>';
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
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

}
