<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/orcamento/empenho/DaoFinEmpenho.class.php";

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
            $condicao .= ' AND p.id_lotacao = ' . $dados['central'];
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
            // return $daoFinEmpenho->getMsgRetorno();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function salvaEmpenho() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
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
            $daoFinEmpenho->setDsEmpenho($this->ds_empenho);
            //verificar ser o empenho ja estar cadastrado
            $daoFinEmpenho->verificarEmpenhoPeloNumero($pdo);
            if ($daoFinEmpenho->sucesso()) {
                return Metodos::retornoAjax("Erro", "alert", "Empenho já foi cadastrado!");
            }

            $daoFinEmpenho->updateStPedidoEmpenho($pdo, '16');

            if (!$daoFinEmpenho->sucesso()) {
                $pdo->rollBack();
                $sucesso = false;
                return Metodos::retornoAjax("Erro", "alert", "Erro ao atualizar o status do pedido");
            }

            $daoFinEmpenho->insertEmpenho($pdo);
            $daoFinEmpenho->setIdEmpenho((is_numeric($pdo->lastInsertId('fin_empenho_id_empenho_seq'))) ? $pdo->lastInsertId('fin_empenho_id_empenho_seq') : null);
            if ($daoFinEmpenho->sucesso()) {
                $sucesso = true;
                if (!Log::SalvaLogI('fin_empenho', $daoFinEmpenho->getIdEmpenho(), $pdo)) {
                    $sucesso = false;
                }
            } else {
                $pdo->rollBack();
                $sucesso = false;
                return Metodos::retornoAjax("Erro1", "alert", STR_ERROR);
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
                        return Metodos::retornoAjax("Erro4", "alert", "Não existe saldo no QDD para esse empenho");
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

            if ($sucesso) {
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", "Empenho cadastrado com sucesso");
            }
            $pdo->rollBack();
            return Metodos::retornoAjax("Erro7", "alert", STR_ERROR . '1');
        } catch (Exception $ex) {
            return $ex->getMessage();
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
            return $ex->getMessage();
        }
    }

}
