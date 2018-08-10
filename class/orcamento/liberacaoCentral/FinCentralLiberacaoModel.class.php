<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/orcamento/liberacaoCentral/DaoFinCentralLiberacao.php";

class FinCentralLiberacaoModel {

    //informacoes da tabela
    private $id_central_liberacao = null;
    private $dh_central_liberacao = null;
    private $ds_central_liberacao = null;
    private $tp_central_liberacao = null;
    private $id_pessoa = null;
    private $id_lotacao = null;
    private $st_central_liberacao = null;
    private $id_pessoa_valida = null;
    private $id_tipo_gasto = null;
    //informacoes da tela
    private $ano = null;
    private $projeto = null;
    private $despesa = null;
    private $fonte = null;
    private $valor = null;

    /**
     * @return mixed
     */
    public function getIdCentralLiberacao() {
        return $this->id_central_liberacao;
    }

    /**
     * @param mixed $id_central_liberacao
     *
     * @return self
     */
    public function setIdCentralLiberacao($id_central_liberacao) {
        $this->id_central_liberacao = $id_central_liberacao;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDhCentralLiberacao() {
        return $this->dh_central_liberacao;
    }

    /**
     * @param mixed $dh_central_liberacao
     *
     * @return self
     */
    public function setDhCentralLiberacao($dh_central_liberacao) {
        $this->dh_central_liberacao = $dh_central_liberacao;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDsCentralLiberacao() {
        return $this->ds_central_liberacao;
    }

    /**
     * @param mixed $ds_central_liberacao
     *
     * @return self
     */
    public function setDsCentralLiberacao($ds_central_liberacao) {
        $this->ds_central_liberacao = $ds_central_liberacao;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTpCentralLiberacao() {
        return $this->tp_central_liberacao;
    }

    /**
     * @param mixed $tp_central_liberacao
     *
     * @return self
     */
    public function setTpCentralLiberacao($tp_central_liberacao) {
        $this->tp_central_liberacao = $tp_central_liberacao;

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
    public function getStCentralLiberacao() {
        return $this->st_central_liberacao;
    }

    /**
     * @param mixed $st_central_liberacao
     *
     * @return self
     */
    public function setStCentralLiberacao($st_central_liberacao) {
        $this->st_central_liberacao = $st_central_liberacao;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdPessoaValida() {
        return $this->id_pessoa_valida;
    }

    /**
     * @param mixed $id_pessoa_valida
     *
     * @return self
     */
    public function setIdPessoaValida($id_pessoa_valida) {
        $this->id_pessoa_valida = $id_pessoa_valida;

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
    public function getAno() {
        return $this->ano;
    }

    /**
     * @param mixed $ano
     *
     * @return self
     */
    public function setAno($ano) {
        $this->ano = $ano;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getProjeto() {
        return $this->projeto;
    }

    /**
     * @param mixed $projeto
     *
     * @return self
     */
    public function setProjeto($projeto) {
        $this->projeto = $projeto;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDespesa() {
        return $this->despesa;
    }

    /**
     * @param mixed $despesa
     *
     * @return self
     */
    public function setDespesa($despesa) {
        $this->despesa = $despesa;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFonte() {
        return $this->fonte;
    }

    /**
     * @param mixed $fonte
     *
     * @return self
     */
    public function setFonte($fonte) {
        $this->fonte = $fonte;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getValor() {
        return $this->valor;
    }

    /**
     * @param mixed $valor
     *
     * @return self
     */
    public function setValor($valor) {
        $this->valor = $valor;

        return $this;
    }

    public function salvaLiberacao(array $dados, int $ano) {
        try {
            //Parte Inicial é Obrigatória
            if ((!is_array($dados) || count($dados) < 1) || strlen((string) $ano) != 4) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            //conexao com o banco de dados
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $daoFinCentralLiberacao = new DaoFinCentralLiberacao();
            //qdd
            $qdd = new Qdd();
            $qdd->setAaQdd($ano);
            $qdd->verificaExisteCarregaDados($pdo);
            //central liberacao trans
            $finCentralLiberacaoTransModel = new FinCentralLiberacaoTransModel();
            //qddvalor
            $qddValor = new QddValor();
            //erro 
            $erro = false;
            if (!empty($qdd->getIdQdd())) {

                foreach ($dados as $v) {
                    $daoFinCentralLiberacao->setIdPessoa($_SESSION['idUser']);
                    $daoFinCentralLiberacao->setIdLotacao($v["central"]);
                    $daoFinCentralLiberacao->setIdTipoGasto($v["tipoDeGasto"]);
                    $daoFinCentralLiberacao->setDsCentralLiberacao($v["obs_liberacao"]);
                    $daoFinCentralLiberacao->setTpCentralLiberacao(1);
                    $daoFinCentralLiberacao->setStCentralLiberacao(1);
                    $daoFinCentralLiberacao->salvaLiberacao($pdo);
                    $this->id_central_liberacao = $pdo->lastInsertId('fin_central_liberacao_id_central_liberacao_seq');
                    //log da tabela de central liberacao
                    if (!Log::SalvaLogI('fin_central_liberacao', $this->id_central_liberacao, $pdo)) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro1", "alert", STR_ERROR);
                    }

                    $qddValor->setIdQdd($qdd->getIdQdd());
                    $qddValor->setIdFonte($v["fonte"]);
                    $qddValor->setIdProgramaTrabalho($v["projeto"]);
                    $qddValor->setIdDespesaElemento($v["despesa"]);
                    $qddValor->carregaDadosQddFonteProgDespesa($pdo);
                    if (empty($qddValor->getIdQddValor())) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "alert", "Não existe qdd cadastrado com essas informações!");
                    }

                    if ((float) $qddValor->getVlAtual() < ($qddValor->getVlLiberado() + Metodos::ConverteValorIng($v["valor"]))) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "alert", "Valor liberado e maior que o saldo atual!");
                    }
                    //cadastrar 
                    $finCentralLiberacaoTransModel->setIdCentralLiberacao($this->id_central_liberacao);
                    $finCentralLiberacaoTransModel->setIdQddValor($qddValor->getIdQddValor());
                    $finCentralLiberacaoTransModel->setVlCentralLiberacaoTrans(Metodos::ConverteValorIng($v["valor"]));

                    if (!$finCentralLiberacaoTransModel->salvaLiberacaoTrans($pdo)) {
                        $erro = true;
                    }
                }

                if ($erro == false) {
                    $pdo->commit();
                    return Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
                } else {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro2", "alert", STR_ERROR);
                }
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function salvaReducao(array $dados, int $ano) {
        try {
            //Parte Inicial é Obrigatória
            if ((!is_array($dados) || count($dados) < 1) || strlen((string) $ano) != 4) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            //conexao com o banco de dados
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $daoFinCentralLiberacao = new DaoFinCentralLiberacao();
            //qdd
            $qdd = new Qdd();
            $qdd->setAaQdd($ano);
            $qdd->verificaExisteCarregaDados($pdo);
            //central liberacao trans
            $finCentralLiberacaoTransModel = new FinCentralLiberacaoTransModel();
            //qddvalor
            $qddValor = new QddValor();
            //pedido 
            $pedido = new Pedido();
            if (!empty($qdd->getIdQdd())) {
                $daoFinCentralLiberacao->setIdPessoa($_SESSION['idUser']);
                $daoFinCentralLiberacao->setIdLotacao($dados[0]["central"]);
                $daoFinCentralLiberacao->setIdTipoGasto($dados[0]["tipoDeGasto"]);
                $daoFinCentralLiberacao->setTpCentralLiberacao(2);
                $daoFinCentralLiberacao->setStCentralLiberacao(1);
                $daoFinCentralLiberacao->salvaLiberacao($pdo);
                $this->id_central_liberacao = $pdo->lastInsertId('fin_central_liberacao_id_central_liberacao_seq');
                //log da tabela de central liberacao
                if (!Log::SalvaLogI('fin_central_liberacao', $this->id_central_liberacao, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro1", "alert", STR_ERROR);
                }
                //erro 
                $erro = false;
                foreach ($dados as $v) {

                    $qddValor->setIdQdd($qdd->getIdQdd());
                    $qddValor->setIdFonte($v["fonte"]);
                    $qddValor->setIdProgramaTrabalho($v["projeto"]);
                    $qddValor->setIdDespesaElemento($v["despesa"]);
                    $qddValor->carregaDadosQddFonteProgDespesa($pdo);
                    if (empty($qddValor->getIdQddValor())) {
                        return Metodos::retornoAjax("Erro", "alert", "Não existe qdd cadastrado com essas informações!");
                    }
                    //cadastrar 
                    $finCentralLiberacaoTransModel->setIdCentralLiberacao($this->id_central_liberacao);
                    $finCentralLiberacaoTransModel->setIdQddValor($qddValor->getIdQddValor());
                    $finCentralLiberacaoTransModel->setVlCentralLiberacaoTrans(Metodos::ConverteValorIng($v["valor"]));


                    if ($finCentralLiberacaoTransModel->salvaLiberacaoTrans($pdo) == false) {
                        $erro = true;
                    }

                    $pedido->setIdFonte($v["fonte"]);
                    $pedido->setIdProgramaTrabalho($v["projeto"]);
                    $pedido->setIdDespesaElemento($v["despesa"]);
                    $pedido->setIdTipoGasto($v["tipoDeGasto"]);
                    $pedido->setIdLotacao($v["central"]);
                    $vlPedidoExecucao = $pedido->retornaPedidoExecutado($pdo)["sum"];

                    if (!$erro) {

                        if (round(($qddValor->getVlLiberado() - Metodos::ConverteValorIng($v["valor"]) - $vlPedidoExecucao), 4) < 0) {
                            $erro = true;
                            return Metodos::retornoAjax("Erro", "alert", 'Redução estar maior do que foi liberado ou executado');
                        }
                    }
                }

                if ($erro == false && $qddValor->Sucesso() == true) {
                    $pdo->commit();
                    return Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
                    ;
                } else {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                }
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function trPesquisaLiberacao(array $dados) {
        //Parte Inicial é Obrigatória
        if ((!is_array($dados) || count($dados) < 1)) {
            return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
        }
        //conexao com o banco de dados
        $conexao = new Conexao();
        $pdo = $conexao->connect();
        //qdd
        $qdd = new Qdd();
        $qdd->setAaQdd($dados["ano"]);
        $qdd->verificaExisteCarregaDados($pdo);
        $resultado = array();
        if (empty($qdd->getIdQdd())) {
            return Metodos::retornoAjax("Erro", "alert", "Não foi possível localizar QDD para esse Ano.");
        }
        //qddvalor
        $qddValor = new QddValor();

        $idProgramaTrabalho = empty($dados['projeto']) ? NULL : $dados['projeto'];
        $idLotacao = empty($dados['central']) ? NULL : $dados['central'];
        $idTipoGasto = empty($dados['tipoDeGasto']) ? NULL : $dados['tipoDeGasto'];
        $idDespesaElemento = empty($dados['despesa']) ? NULL : $dados['despesa'];
        $idFonte = empty($dados['fonte']) ? NULL : $dados['fonte'];

        $daoFinCentralLiberacao = new DaoFinCentralLiberacao();
        $daoFinCentralLiberacao->retornaDadosLiberacao($qdd->getIdQdd(), $idProgramaTrabalho
                , $idLotacao, $idTipoGasto, $idDespesaElemento, $idFonte, $pdo);

        if (!$daoFinCentralLiberacao->Sucesso()) {
            return Metodos::retornoAjax("Erro", "alert", "Não existe liberação com essas informações!");
        }


        if ((!is_array($daoFinCentralLiberacao->getMsgRetorno()) || count($daoFinCentralLiberacao->getMsgRetorno()) < 1)) {
            return Metodos::retornoAjax("Erro", "alert", "Não existe liberação com essas informações!");
        }
        $tr = '';
        $total = 0;
        foreach ($daoFinCentralLiberacao->getMsgRetorno() as $v) {
            $total += $v["vl_central_liberacao_trans"];
            $tr .= '<tr>
                        <td class="text-center">' . $v["cd_programa_trabalho"] . '-' . $v["ds_programa_trabalho"] . '</td>
                        <td class="text-center">' . $v["nm_lotacao"] . '</td>
                        <td class="text-center">' . $v["nm_pessoa"] . '</td>    
                        <td class="text-center">' . $v["nm_tipo_gasto"] . '</td>
                        <td class="text-center">' . $v["cd_despesa_elemento"] . '-' . $v["ds_despesa_categoria"] . '</td>
                        <td class="text-center">' . $v["nr_fonte"] . '</td>
                        <td class="text-center">' . Metodos::ConverteDataBR($v["data"]) . '</td>
                        <td class="text-center">' . $v["ds_central_liberacao"] . '</td>
                        <td class="text-center">';
            if ($v["tipo"] == 'Redução') {
                $tr .= '<span class="text-danger">' . $v["tipo"] . '</span>';
            } else {
                $tr .= '<span class="text-success">' . $v["tipo"] . '</span>';
            }

            $tr .= '</td>   
                        <td class="text-center">' . Metodos::ConverteValorBr($v["vl_central_liberacao_trans"], 4) . '</td>
                        <td>';
            if ($v['st_central_liberacao'] == '0') {
                $tr .= '<span class="label label-danger">Não validado</span>';
            } else if ($v['st_central_liberacao'] == '1') {
                $tr .= '<span class="label label-warning">Esperando Validação</span>';
            } else if ($v['st_central_liberacao'] == '2') {
                $tr .= '<span class="label label-success">Validado</span>';
            }
            '</td></tr>';
        }
        $resultado[] = $tr;
        $resultado[] = '<tr>
                            <td colspan="9" class="text-right"><strong>Total</strong></td>
                            <td class="text-center"><strong>' . Metodos::ConverteValorBr($total, 4) . '</strong></td>
                           <td></td>     
                        </tr>';
        return Metodos::retornoAjax("ok", "html", $resultado);
    }

    public function trPesquisaReducao(array $dados) {
        //Parte Inicial é Obrigatória
        if ((!is_array($dados) || count($dados) < 1)) {
            return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
        }
        //conexao com o banco de dados
        $conexao = new Conexao();
        $pdo = $conexao->connect();
        //qdd
        $qdd = new Qdd();
        $qdd->setAaQdd($dados["ano"]);
        $qdd->verificaExisteCarregaDados($pdo);
        //qddvalor
        $qddValor = new QddValor();

        $qddValor->setIdQdd($qdd->getIdQdd());
        $qddValor->setIdFonte($dados["fonte"]);
        $qddValor->setIdProgramaTrabalho($dados["projeto"]);
        $qddValor->setIdDespesaElemento($dados["despesa"]);
        $qddValor->carregaDadosQddFonteProgDespesa($pdo);

        if (empty($qddValor->getIdQddValor())) {
            return Metodos::retornoAjax("Erro", "alert", "Não existe qdd cadastrado com essas informações!");
        }
        //central liberacao
        $daoFinCentralLiberacao = new DaoFinCentralLiberacao();
        $daoFinCentralLiberacao->setIdTipoGasto($dados["tipoDeGasto"]);
        $daoFinCentralLiberacao->setIdLotacao($dados["central"]);
        $daoFinCentralLiberacao->retornaDadosReducao($pdo, $qddValor->getIdQddValor());

        if ((!is_array($daoFinCentralLiberacao->getMsgRetorno()) || count($daoFinCentralLiberacao->getMsgRetorno()) < 1)) {
            return Metodos::retornoAjax("Erro", "alert", "Não existe liberação com essas informações!");
        }
        $tr = '';
        $total = 0;
        foreach ($daoFinCentralLiberacao->getMsgRetorno() as $v) {
            $total += $v["vl_central_liberacao_trans"];
            $tr .= '<tr>
                        <td class="text-center">' . $v["cd_programa_trabalho"] . '-' . $v["ds_programa_trabalho"] . '</td>
                        <td class="text-center">' . $v["nm_lotacao"] . '</td>
                        <td class="text-center">' . $v["nm_tipo_gasto"] . '</td>
                        <td class="text-center">' . $v["cd_despesa_elemento"] . '-' . $v["ds_despesa_categoria"] . '</td>
                        <td class="text-center">' . $v["nr_fonte"] . '</td>
                        <td class="text-center">' . Metodos::ConverteValorBr($v["vl_central_liberacao_trans"], 4) . '</td>
                    </tr>';
        }
        $tr .= '<tr>
                    <td colspan="5" class="text-right"><strong>Total</strong></td>
                    <td  class="text-center">' . Metodos::ConverteValorBr($total, 4) . '</td>
              </tr>';
        return Metodos::retornoAjax("ok", "html", $tr);
    }

    public function retornaSaldoValorLiberado(array $dados) {
        //Parte Inicial é Obrigatória
        if ((!is_array($dados) || count($dados) < 1)) {
            return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
        }
        //conexao com o banco de dados
        $conexao = new Conexao();
        $pdo = $conexao->connect();
        //qdd
        $qdd = new Qdd();
        $qdd->setAaQdd($dados["ano"]);
        $qdd->verificaExisteCarregaDados($pdo);
        //qddvalor
        $qddValor = new QddValor();
        $qddValor->setIdQdd($qdd->getIdQdd());
        $qddValor->setIdFonte($dados["fonte"]);
        $qddValor->setIdProgramaTrabalho($dados["projeto"]);
        $qddValor->setIdDespesaElemento($dados["despesa"]);
        $qddValor->carregaDadosQddFonteProgDespesa($pdo);

        if (empty($qddValor->getIdQddValor())) {
            return Metodos::retornoAjax("Erro", "alert", "Não existe qdd cadastrado com essas informações!");
        }

        //central liberacao
        $daoFinCentralLiberacao = new DaoFinCentralLiberacao();
        $daoFinCentralLiberacao->setIdTipoGasto($dados["tipoDeGasto"]);
        $daoFinCentralLiberacao->setIdLotacao($dados["central"]);
        if (!empty($dados['idPedido'])) {
            $daoFinCentralLiberacao->retornaSaldoValorLiberado($pdo, $qddValor->getIdQddValor(), $dados, ' and p.id_pedido <> ' . $dados['idPedido'] . '');
        } else {
            $daoFinCentralLiberacao->retornaSaldoValorLiberado($pdo, $qddValor->getIdQddValor(), $dados, '');
        }

        if ((!is_array($daoFinCentralLiberacao->getMsgRetorno()) || count($daoFinCentralLiberacao->getMsgRetorno()) < 1)) {
            return Metodos::retornoAjax("Erro", "alert", "Não existe liberação com essas informações!");
        }

        return $daoFinCentralLiberacao->getMsgRetorno()["saldo"];
    }

    public function excluirValorLiberado() {
        if (empty($this->id_central_liberacao)) {
            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        }
        //conexao com o banco de dados
        $conexao = new Conexao();
        $pdo = $conexao->connect();
        $pdo->beginTransaction();
        //central liberacao
        $daoFinCentralLiberacao = new DaoFinCentralLiberacao();
        $daoFinCentralLiberacao->setIdCentralLiberacao($this->id_central_liberacao);
        $daoFinCentralLiberacao->retornaPkLiberacao($pdo);
        $erro = false;
        $pk = array();
        $pk = $daoFinCentralLiberacao->getMsgRetorno();
        if (empty($pk)) {
            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        }
        $daoFinCentralLiberacao->setIdTipoGasto($pk["id_tipo_gasto"]);
        $daoFinCentralLiberacao->setIdLotacao($pk["id_lotacao"]);
        //pega o saldo da liberacao
        $daoFinCentralLiberacao->retornaSaldoValorLiberado($pdo, $pk["id_qdd_valor"], $pk, '');
        $saldo = $daoFinCentralLiberacao->getMsgRetorno()["saldo"];
        //pega o valor da libeaçao
        $daoFinCentralLiberacao->retornaValorLiberado($pdo, $pk["id_qdd_valor"]);
        $valor = $daoFinCentralLiberacao->getMsgRetorno()["valor"];

        if ($pk["tp_central_liberacao"] == 1 && ($saldo - $valor) < 0) {
            $erro = true;
            return Metodos::retornoAjax("Erro", "alert", "Valor liberado já foi utilizado!");
        }

        $daoFinCentralLiberacao->deletaLiberacao($pdo);
        //verificar ser ocorreu tudo certo na mudança de status da liberaçao
        if (!$daoFinCentralLiberacao->Sucesso()) {
            $erro = true;
        }

        if ($erro == false) {
            $pdo->commit();
            return Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
        } else {
            $pdo->rollBack();
            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
        }
    }

    /**
     * Tr da validacao da liberacao 
     * @return type
     */
    public function trParaValidarLiberacao() {
        //conexao com o banco de dados
        $conexao = new Conexao();
        $pdo = $conexao->connect();
        //central liberacao
        $daoFinCentralLiberacao = new DaoFinCentralLiberacao();
        $daoFinCentralLiberacao->retornaLiberacaoParaValidacao($pdo);
        $tr = '';
        $total = 0;
        $resultado = array();
        if ($daoFinCentralLiberacao->Sucesso()) {
            foreach ($daoFinCentralLiberacao->getMsgRetorno() as $v) {
                $total += $v["vl_central_liberacao_trans"];
                $tr .= '<tr>
                        <td class="text-center">' . $v["cd_programa_trabalho"] . '-' . $v["ds_programa_trabalho"] . '</td>
                        <td class="text-center">' . $v["nm_lotacao"] . '</td>
                        <td class="text-center">' . $v["nm_tipo_gasto"] . '</td>
                        <td class="text-center">' . $v["cd_despesa_elemento"] . '-' . $v["ds_despesa_elemento"] . '</td>
                        <td class="text-center">' . $v["nr_fonte"] . '</td>
                        <td class="text-center">' . Metodos::ConverteDataBR($v["dh_central_liberacao"]) . '</td>
                        <td class="text-center">' . $v["ds_central_liberacao"] . '</td>
                        <td class="text-right">' . Metodos::ConverteValorBr($v["vl_central_liberacao_trans"], 4) . '</td>
                        <td class="text-center "><b>' . $v["tipo"] . '</b></td>
                        <td class="text-center">
                            <button type="button" class="btn btn-default btn-nao-validar btn-xs" title="Não Validar" value="' . $v["id_qdd_valor"] . '" '
                        . 'idLiberacao = "' . $v["id_central_liberacao"] . '" tipoLiberacao = "' . $v["tp_central_liberacao"] . '">
                            <i class="fa fa-thumbs-o-down fa-lg text-danger" aria-hidden="true"></i>
                            </button> 
                            <button type="button" class="btn btn-default btn-validar btn-xs" title="Validar" value="' . $v["id_qdd_valor"] . '" '
                        . 'idLiberacao = "' . $v["id_central_liberacao"] . '" tipoLiberacao = "' . $v["tp_central_liberacao"] . '">
                            <i class="fa fa-thumbs-o-up fa-lg text-success" aria-hidden="true"></i>
                            </button>
                        </td>    
                    </tr>';
            }
            $resultado[] = $tr;
            $resultado[] = '<tr>
                            <td colspan="7" class="text-right"><strong>Total</strong></td>
                            <td  class="text-right"><strong>' . Metodos::ConverteValorBr($total, 4) . '</strong></td>
                            <td></td>
                            <td></td>
                        </tr>';
            return Metodos::retornoAjax("ok", "html", $resultado);
        } else {
            return Metodos::retornoAjax("ok", "alert", "Nenhuma liberacao para validar.");
        }
    }

    public function dadosLiberacao(PDO $pdo = null) {
        //conexao com o banco de dados
        $conexao = new Conexao();
        $pdo = $conexao->connect();
        $daoFinCentralLiberacao = new DaoFinCentralLiberacao();

        $daoFinCentralLiberacao->setIdCentralLiberacao($this->id_central_liberacao);
        $daoFinCentralLiberacao->retornaDadosTrans($pdo);
        return $daoFinCentralLiberacao->getMsgRetorno();
    }

    public function desativaLiberacao(PDO $pdo) {
        //variaveis do sistema
        if (empty($pdo)) {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
        }
        $daoFinCentralLiberacao = new DaoFinCentralLiberacao();
        $daoFinCentralLiberacao->setIdCentralLiberacao($this->id_central_liberacao);
        $daoFinCentralLiberacao->desativaValorLiberado($pdo);
    }

    public function validaLiberacao($dados) {
        //variaveis do sistema
        if (empty($pdo)) {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
        }
        //conexao com o banco de dados
        $conexao = new Conexao();
        $pdo = $conexao->connect();
        $dadosQdd = null;
        $dadosLiberacao = null;
        //instanciando o dao
        $daoFinCentralLiberacao = new DaoFinCentralLiberacao();
        $qddValor = new QddValor();
        //central liberacao
        $this->id_central_liberacao = $dados["idLiberacao"];
        $dadosLiberacao = $this->dadosLiberacao($pdo);
        $qddValor->setIdQddValor($dados["id"]);
        $dadosQdd = $qddValor->retornaQddValorPorId($pdo);
        var_dump($dados);
        return false;
        if ($dados["validacao"] == 1) {

            if ($dados["tipoliberacao"] == 1) {
                $qddValor->setVlLiberado(($dadosLiberacao[0]["vl_central_liberacao_trans"] + $dadosQdd["vl_liberado"]));
            }

            if ($dados["tipoliberacao"] == 2) {
                $qddValor->setVlLiberado(($dadosLiberacao[0]["vl_central_liberacao_trans"] - $dadosQdd["vl_liberado"]));
            }

            $daoFinCentralLiberacao->setIdCentralLiberacao($dados["idLiberacao"]);
            $daoFinCentralLiberacao->validaLiberacao($pdo);
            $qddValor->atualizaValoresLiberado($pdo);
            return Metodos::retornoAjax("ok", "html", "Liberação validada com sucesso.");
        } else if ($dados["validacao"] == 0) {
            $this->desativaLiberacao($pdo);
            return Metodos::retornoAjax("ok", "html", "Liberação não foi validada.");
        }
    }

    public function retornaLiberacoesDastInicial() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoFinCentralLiberacao = new DaoFinCentralLiberacao();
            $idLotacao = [];
            $result = [];
            $centralResponsavel = new CentralResponsavel();
            $centralResponsavel->setIdPessoa($this->id_pessoa);
            //retorna os ids da lotacao liberado para o usuario
            $result = $centralResponsavel->retornaIdCentralLiberacao($pdo);
            if ($result != false) {
                foreach ($result as $dados) {
                    $idLotacao[] = $dados["id_lotacao"];
                }
            }
            if (empty($idLotacao)) {
                $idLotacao = '';
            } else {

                $idLotacao = " and cl.id_lotacao in (" . implode(' , ', $idLotacao) . ") ";
            }


            $daoFinCentralLiberacao->retornaLiberacaoPesquisa($pdo, $idLotacao);
            if ($daoFinCentralLiberacao->Sucesso()) {
                return json_encode($daoFinCentralLiberacao->getMsgRetorno());
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

}
