<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/ordem/DaoFinOrdem.class.php";

class FinOrdemModel {

    private $id_ordem = null;
    private $id_pedido = null;
    private $id_lotacao = null;
    private $id_pessoa = null;
    private $nr_ordem = null;
    private $dh_ordem = null;
    private $aa_ordem = null;
    private $nr_prazo_ordem = null;
    private $tp_ordem = null;
    private $sit_ordem = null;
    private $dt_ini_ordem = null;
    private $dt_fim_ordem = null;
    //atributos para pesquisa da ordem
    private $nr_Pedido = null;
    private $central = null;
    private $ano = null;
    
    private $sit_cancelado = 0;
    private $sit_cadastrado = 1;
    private $sit_requisitado = 2;
    private $sit_finalizado_supressao_ordenado = 3;
    private $sit_finalizado_descumprimento_contratada = 4;
    private $sit_finalizado = 5;
    private $sit_liquidado_parcial = 6;
    private $sit_liquidado_total = 7;
    private $sit_pago_parcial = 8;
    private $sit_pago_total = 9;
    
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
    public function getNrOrdem() {
        return $this->nr_ordem;
    }

    /**
     * @param mixed $nr_ordem
     *
     * @return self
     */
    public function setNrOrdem($nr_ordem) {
        $this->nr_ordem = $nr_ordem;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDhOrdem() {
        return $this->dh_ordem;
    }

    /**
     * @param mixed $dh_ordem
     *
     * @return self
     */
    public function setDhOrdem($dh_ordem) {
        $this->dh_ordem = $dh_ordem;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAaOrdem() {
        return $this->aa_ordem;
    }

    /**
     * @param mixed $aa_ordem
     *
     * @return self
     */
    public function setAaOrdem($aa_ordem) {
        $this->aa_ordem = $aa_ordem;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNrPrazoOrdem() {
        return $this->nr_prazo_ordem;
    }

    /**
     * @param mixed $nr_prazo_ordem
     *
     * @return self
     */
    public function setNrPrazoOrdem($nr_prazo_ordem) {
        $this->nr_prazo_ordem = $nr_prazo_ordem;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTpOrdem() {
        return $this->tp_ordem;
    }

    /**
     * @param mixed $tp_ordem
     *
     * @return self
     */
    public function setTpOrdem($tp_ordem) {
        $this->tp_ordem = $tp_ordem;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSitOrdem() {
        return $this->sit_ordem;
    }

    /**
     * @param mixed $sit_ordem
     *
     * @return self
     */
    public function setSitOrdem($sit_ordem) {
        $this->sit_ordem = $sit_ordem;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtIniOrdem() {
        return $this->dt_ini_ordem;
    }

    /**
     * @param mixed $dt_ini_ordem
     *
     * @return self
     */
    public function setDtIniOrdem($dt_ini_ordem) {
        $this->dt_ini_ordem = $dt_ini_ordem;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtFimOrdem() {
        return $this->dt_fim_ordem;
    }

    /**
     * @param mixed $dt_fim_ordem
     *
     * @return self
     */
    public function setDtFimOrdem($dt_fim_ordem) {
        $this->dt_fim_ordem = $dt_fim_ordem;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNrPedido() {
        return $this->nr_Pedido;
    }

    /**
     * @param mixed $nr_Pedido
     *
     * @return self
     */
    public function setNrPedido($nr_Pedido) {
        $this->nr_Pedido = $nr_Pedido;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCentral() {
        return $this->central;
    }

    /**
     * @param mixed $central
     *
     * @return self
     */
    public function setCentral($central) {
        $this->central = $central;

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

    public function getTipoOrdem(): array {
        $arr_tipo = array(
            '1' => 'Entrega',
            '2' => 'Execução/Serviço'
        );
        return $arr_tipo;
    }
    
    public function cadastrarOrdem($ordem) {
        try {
            if (empty($ordem) || empty($ordem[0]->tipoOrdem) || empty($ordem[0]->local)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            
            //validação se os tipos dos itens correspodem ao tipo da ordem
            $tp_ordem = $ordem[0]->tipoOrdem;
            foreach ($ordem as $item) {       
                if (($tp_ordem == 2 && $item->tp != 'S') || ($tp_ordem != 2 && $item->tp == 'S')) { //Execução ou Serviço e item diferente do tipo 'S' ou Vice-versa
                    return Metodos::retornoAjax("Erro", "alert", "Tipo da ordem não corresponde aos itens selecionados");
                    break;
                }
            }
            
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $daoFinOrdem = new DaoFinOrdem();
            $daoFinOrdem->setIdPedido($ordem[0]->idPedido);
            $daoFinOrdem->setIdLotacao($ordem[0]->local);

            $numero = $daoFinOrdem->retornaNumeroMaxOrdem($pdo);
            $erro = false;
            if (empty($numero["numero"]) || $numero["numero"] <= 0) {
                $daoFinOrdem->setNrOrdem("1");
            } else {
                $daoFinOrdem->setNrOrdem($numero["numero"] + 1);
            }

            //seta o prazo de entrega;
            $daoFinOrdem->retornaPrazoEntrega($pdo);
            $daoFinOrdem->setNrPrazoOrdem($daoFinOrdem->getMsgRetorno()["nr_prazo_entrega"]);
            //pega ano ordem
            $daoFinOrdem->setAaOrdem(date("Y"));

            if ($ordem[0]->pergunta == 1) {
                if (Metodos::validaConverteDataING($ordem[0]->vig_inicial) != '' && Metodos::validaConverteDataING($ordem[0]->vig_inicial) != "") {
                    $daoFinOrdem->setDtIniOrdem(Metodos::validaConverteDataING($ordem[0]->vig_inicial));
                }

                if (Metodos::validaConverteDataING($ordem[0]->vig_final) != '' && Metodos::validaConverteDataING($ordem[0]->vig_final) != "") {
                    $daoFinOrdem->setDtFimOrdem(Metodos::validaConverteDataING($ordem[0]->vig_final));
                }
            }
            $daoFinOrdem->setIdPessoa($this->id_pessoa);
            $daoFinOrdem->setTpOrdem($ordem[0]->tipoOrdem);
            $daoFinOrdem->setSitOrdem(1);
            //chamando o metodo para cadastra a ordem no banco de dados
            $daoFinOrdem->cadastrarOrdem($pdo);

            //cadatrando os itens
            if ($daoFinOrdem->Sucesso()) {
                $idOrdem = ($pdo->lastInsertId('fin_ordem_id_ordem_seq'));
                $finOrdemItensModel = new FinOrdemItensModel();
                foreach ($ordem as $linha) {
                    if (($linha->tp == "C" || $linha->tp == "P") && $linha->flVariavel == '0') {

                        $finOrdemItensModel->setIdPedido($ordem[0]->idPedido);
                        $finOrdemItensModel->setTpItem($linha->tp);
                        $finOrdemItensModel->setIdOrdem($idOrdem);
                        $finOrdemItensModel->setIdPreOrdem($linha->idPreOrdem);
                        $finOrdemItensModel->setFlValorVariavel($linha->flVariavel);
                        $finOrdemItensModel->setQdItensPre(Metodos::ConverteValorIng($linha->qtd));

                        $daoFinOrdem->retornaValorPreOrdem($pdo, $linha->idPreOrdem);

                        if ($daoFinOrdem->Sucesso()) {
                            $finOrdemItensModel->setVlItensPre($daoFinOrdem->getMsgRetorno()["vl_itens_pre"]);
                        } else {
                            return Metodos::retornoAjax("Erro", "alert", "O sistema não identificou o valor unitário de algum item");
                            $pdo->rollBack();
                        }

                        $finOrdemItensModel->retornaSaldoItemPreOrdem($pdo);

                        if ($finOrdemItensModel->getSucesso()) {

                            $finOrdemItensModel->cadastrarItens($pdo);
                            if (!$finOrdemItensModel->getSucesso()) {
                                $erro = true;
                            }
                        } else {
                            return Metodos::retornoAjax("Erro", "alert", "Saldo insuficiente por favor verifique os itens!");
                            $pdo->rollBack();
                        }
                    } else if ($linha->tp == "S" || $linha->flVariavel == '1') {
                        $finOrdemItensModel->setIdPedido($ordem[0]->idPedido);
                        $finOrdemItensModel->setTpItem($linha->tp);
                        $finOrdemItensModel->setIdOrdem($idOrdem);
                        $finOrdemItensModel->setIdPreOrdem($linha->idPreOrdem);
                        $finOrdemItensModel->setQdItensPre(Metodos::ConverteValorIng($linha->qtd));
                        $finOrdemItensModel->setVlItensPre(Metodos::ConverteValorIng($linha->vl));
                        $finOrdemItensModel->setFlValorVariavel($linha->flVariavel);
                        $finOrdemItensModel->retornaSaldoItemPreOrdem($pdo);

                        if ($finOrdemItensModel->getSucesso()) {

                            $finOrdemItensModel->cadastrarItens($pdo);
                            if (!$finOrdemItensModel->getSucesso()) {
                                $erro = true;
                            }
                        } else {
                            return Metodos::retornoAjax("Erro", "alert", "Saldo insuficiente por favor verifique os itens!");
                            $pdo->rollBack();
                        }
                    } else {
                        $erro = true;
                    }
                }
            } else {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", $daoFinOrdem->getMsgRetorno());
            }

            $pedido = new Pedido();
            $pedido->setIdPedido($ordem[0]->idPedido);            
            $pedido->atualizaStatusSituacaoOficialPedido($pdo);
            if(!$pedido->sucesso()){
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Não foi possível atualizar o Status do Pedido."); 
            }
//            if ($ordem[0]->tipoOrdem == '1') {
//                $pedido->setStPedido("17");
//            } else if ($ordem[0]->tipoOrdem == '2') {
//                $pedido->setStPedido("19");
//            }
//
//
//            if (!$pedido->VerificarMaiorTramitacao($pdo)) {
//                $pedido->atualizaTramitacaoPedido($pdo);
//            }


            if (!$erro) {
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
            } else {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }
        } catch (Exception $ex) {
            $pdo->rollBack();
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

    public function retornaItensParaCadOrdem() {
        if (!empty($this->id_pedido)) {
            if (!empty($this->id_pedido) && !empty($this->id_ordem)) {
                //verificao a cima e para a ediçao da ordem
            } else if (!empty($this->id_pedido)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $daoFinOrdem = new DaoFinOrdem();
                $daoFinOrdem->setIdPedido($this->id_pedido);
                $daoFinOrdem->listaItensPreOrdem($pdo);
                $retorno = '';
                if ($daoFinOrdem->Sucesso()) {
                    foreach ($daoFinOrdem->getMsgRetorno() as $linha) {
                        $retorno .= '<tr data-tp-material='.$linha["tp_material"].' data-id-pre-ordem='.$linha["id_pre_ordem"].' data-id-pedido='.$linha["id_pedido"].' data-fl-valor-variavel='.$linha["fl_valor_variavel"].' class="itens">
                                        <td class="text-center">' . $linha["nr_item"] . '</td>
                                        <td class="text-center">' . $linha["nm_material"] . '</td>
                                        <td class="text-center">' . $linha["nm_desc_material"] . '</td>
                                        <td class="text-center">' . $linha["nm_grupo"] . '</td>
                                        <td class="text-center">' . $linha["nm_sub_grupo"] . '</td>
                                        <td class="text-center">' . $linha["nm_unidade_medida"] . '</td>    
                                        <td class="text-center">' . wordwrap($linha["ds_despesa_elemento"], 20, "<br />\n") . '</td>
                                        <td class="text-center">' . $linha["tp_material"] . '</td>
                                        <td class="text-center">' . $linha["nr_lote"] . '</td>
                                        <td class="text-center">' . Metodos::ConverteValorBr($linha["qt_itens_pre"], 4) . '</td>
                                        <td class="text-center">' . Metodos::ConverteValorBr($linha["vl_itens_pre"], 4) . '</td>
                                        <td class="text-center">' . Metodos::ConverteValorBr($linha["total"], 4) . '</td>
                                        <td class="text-center">' . Metodos::ConverteValorBr($linha["utilizado"], 4) . '</td>
                                        <td class="text-center">' . Metodos::ConverteValorBr($linha["saldoordem"], 4) . '</td>
                                        <td class="text-center">Quantidade<input type="text" name="qtd" id="qtd" idPedido="' . $linha["id_pedido"] . '"
                                         idPreOrdem="' . $linha["id_pre_ordem"] . '" tp="' . $linha["tp_material"] . '" 
                                         class="form-control input-sm qtd" >';

                        if ($linha["tp_material"] == 'S' || $linha["fl_valor_variavel"] == '1') {
                            $retorno .= '<br>Vlr. Unitário<input type="text" name="vl" id="vl" idPedido="' . $linha["id_pedido"] . '"
					tp="' . $linha["tp_material"] . '" class="form-control input-sm vl">';
                        }
                        $retorno .= '</td></tr>';
                    }
                }
                if (empty($retorno)) {
                    return "Nenhum pedido encontrado";
                }
                return $retorno;
            }
        }
    }

    public function retornaTrPesquisaOrdem() {

        $conexao = new Conexao();
        $pdo = $conexao->connect();
        $daoFinOrdem = new DaoFinOrdem();
        $condicao = "";

        if (!empty($this->nr_Pedido)) {
            $condicao .= " and p.nr_pedido = '" . $this->nr_Pedido . "'";
        }

        if (!empty($this->central)) {
            $condicao .= " and p.id_lotacao = '" . $this->central . "'";
        }

        $daoFinOrdem->retornaDadosTrPesquisa($pdo, $condicao, $this->ano);

        if ($daoFinOrdem->Sucesso()) {
            $tabela = "";
            foreach ($daoFinOrdem->getMsgRetorno() as $linha) {
                $tabela .= "<tr>
                                <td class = 'text-center'>" . $linha["nr_ordem"] . "</td>
                                <td class = 'text-center'>" . $linha["pedido"] . "</td>
                                <td class = 'text-center'>" . $linha["ds_pedido"] . "</td>
                                <td class = 'text-center'>" . $linha["tipo"] . "</td>        
                                <td class = 'text-center'>" . $linha["nm_tipo_gasto"] . "</td>
                                <td class = 'text-center'>" . $linha["nr_fonte"] . "</td>
                                <td class = 'text-center'>" . $linha["cd_despesa_elemento"] . "-" . $linha["ds_despesa_elemento"] . "</td>
                                <td class = 'text-center'>" . Metodos::ConverteValorBr($linha["valor"], 4) . "</td>
                                <td class = 'text-center'>" . $linha["situacao"] . "</td>    
                                <td class = 'text-center'>
                                <button type = 'button' title = 'Editar' class = 'editar' value = '" . $linha['id_ordem'] . "'>
                                    <i class = 'fa fa-pencil text-primary'></i>
                                </button >

                                <button type = 'button' title = 'pdf' class = 'pdf' value = '" . $linha['id_ordem'] . "' tp='" . $linha['tp_ordem'] . "'>
                                 <i class='fa fa-file-pdf-o text-warning' aria-hidden='true'></i>
                                </button >

                                <button type = 'button' title = 'entrega' class = 'entrega' value = '" . $linha['id_ordem'] . "'>
                                <i class='fa fa-truck text-success' aria-hidden='true'></i></i>
                                </button >";
                                
                if ($linha['sit_ordem'] == '1') { //A situação '1' indica que ainda não há protocolo de aviso ao fornecedor, apenas as ordens nesta situação(1 - Cadastrado) poderão ser canceladas
                    $tabela .= " <button type='button' title='Excluir ordem' class='excluir text-danger' value='" . $linha['id_ordem'] . "' >
                                <i class='fa fa-trash' aria-hidden='true'></i>
                                </button>";
                }
                                
                $tabela .=      "</td>
                            </tr>";
            }
            return Metodos::retornoAjax("ok", "html", $tabela);
        } else {
            return Metodos::retornoAjax("Erro", "alert", "Nenhum registro encontrado");
        }
    }

    public function listaTipoQuantidadeJSON() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $dao = new DaoFinOrdem();
            $dao->retornaQuantidadeTipo($pdo);

            $arrayTipo = array();

            foreach ($this->getTipoOrdem() as $key => $value) {
                $arrayTipo[$key] = array(
                    "tipo" => $value,
                    "quantidade" => 0
                );
            }

            $arrayQuantidade = array();
            foreach ($dao->getMsgRetorno() as $value) {
                if (array_key_exists($value['tp_ordem'], $arrayTipo)) {
                    $arrayTipo[$value['tp_ordem']]['quantidade'] = $value['quantidade'];
                }
            }

            foreach ($arrayTipo as $key => $value) {
                $arrayQuantidade[] = $value;
            }

            return json_encode($arrayQuantidade);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function cancelaOrdem() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoFinOrdem = new DaoFinOrdem();
            $pdo->beginTransaction();
            $daoFinOrdem->setIdOrdem($this->id_ordem);
            
            //verifica se a Ordem já possui protocolo de aviso ao fornecedor, se possuir, aborta a operação
            $daoFinOrdem->ordemProtocolo($pdo);
            if ($daoFinOrdem->Sucesso()) {
                return Metodos::retornoAjax("Erro", "alert", "A Ordem não pode ser cancelada, pois existe um protocolo de aviso ao fornecedor para a mesma.");
            }
            
            //verifica se a Ordem já possui entrega, se possuir, aborta a operação
            $daoFinOrdem->retornaEntregasOrdem($pdo);
            if ($daoFinOrdem->Sucesso()) {
                return Metodos::retornoAjax("Erro", "alert", "A Ordem não pode ser cancelada, pois existe entrega(s) para a mesma.");
            }
            
            $daoFinOrdem->deleteOrdem($pdo);
            $busca = "";
            if (!$daoFinOrdem->Sucesso()) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }


            $daoFinOrdem->retornaOrdem($pdo);
            $busca = $daoFinOrdem->getMsgRetorno();
            if (!Log::SalvaLogU('fin_ordem', $this->id_ordem, $busca, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }
            
            $pedido = new Pedido();
            $pedido->setIdPedido($busca['id_pedido']);            
            $pedido->atualizaStatusSituacaoOficialPedido($pdo);
            if(!$pedido->sucesso()){
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Não foi possível atualizar o Status do Pedido."); 
            }

            $pdo->commit();
            return Metodos::retornoAjax("ok", "html", "Ordem removida com sucesso.");
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaOrdemGdof() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoFinOrdem = new DaoFinOrdem();
            $daoFinOrdem->setIdPedido($this->id_pedido);
            $daoFinOrdem->ordemGdof($pdo);
            $options = '<option value="0" selected="true">Selecione uma ordem</option>';

            if (!($daoFinOrdem->getMsgRetorno() == 'Nenhum registro encontrado')) {
                foreach ($daoFinOrdem->getMsgRetorno() as $campos) {
                    $options .= '<option value="' . $campos["id_ordem"] . '">' . $campos["nr_ordem"] . '/' . $campos["aa_ordem"] . '</option>';
                }
            }
            return $options;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaTipoValorOrdem() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoFinOrdem = new DaoFinOrdem();
            $daoFinOrdem->setIdOrdem($this->id_ordem);
            $daoFinOrdem->retornaTipoValor($pdo);
            if ($daoFinOrdem->Sucesso()) {
                return json_encode($daoFinOrdem->getMsgRetorno());
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function montaTabelaOrdemGdof($dados) {
        try {
            $tabela = '';
            foreach ($dados as $key => $valor) {
                $tabela .= '<tr id = "' . $valor["id_ordem"] . '" class= "tabOrdem">
                                <td class="text-center">' . $valor["nr_ordem"] . '</td>
                                <td class="text-center">' . $valor["tipo_ordem"] . '</td>
                                <td class="text-center">' . $valor["valorOrdem"] . '</td>
                                <td class="text-center">' . $valor["situacao"] . '</td>
                                <td class="text-center">
                                <button type="button" title="Excluir ordem" class="excluirOrdem text-danger" value = "' . $valor["id_ordem"] . '">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                                </td>    
                            </tr>';
            }
            return $tabela;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function finalizaOrdem(PDO $pdo) {
        try {

            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }

            $daoFinOrdem = new DaoFinOrdem();
            $daoFinOrdem->setIdOrdem($this->id_ordem);
            $daoFinOrdem->setSitOrdem('3');
            
            $daoFinOrdem->atualizaSituacaoOrden($pdo);
            if (!$daoFinOrdem->Sucesso()) {
                return false;
            }
            
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
    
    public function finalizaPorSupressao(PDO $pdo) {
        try {

            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }

            $daoFinOrdem = new DaoFinOrdem();
            $daoFinOrdem->setIdOrdem($this->id_ordem);
            $daoFinOrdem->setSitOrdem('4');
            
            //verifica se a Ordem já possui entrega, se NÃO possuir, aborta a operação 
            $daoFinOrdem->retornaEntregasOrdem($pdo);
            if (!$daoFinOrdem->Sucesso()) {
                return false;
            }
            
            $daoFinOrdem->atualizaSituacaoOrden($pdo);
            if (!$daoFinOrdem->Sucesso()) {
                return false;
            }
            
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
    
     public function finalizaPorDescuprimento(PDO $pdo) {
        try {

            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }

            $daoFinOrdem = new DaoFinOrdem();
            $daoFinOrdem->setIdOrdem($this->id_ordem);
            $daoFinOrdem->setSitOrdem('5');
            
            //verifica se a Ordem já possui entrega, se NÃO possuir, aborta a operação 
            $daoFinOrdem->retornaEntregasOrdem($pdo);
            if (!$daoFinOrdem->Sucesso()) {
                return false;
            }
            
            $daoFinOrdem->atualizaSituacaoOrden($pdo);
            if (!$daoFinOrdem->Sucesso()) {
                return false;
            }
            
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
    
    
    
    
    public function retornaSePodeFinalizarAEntrega(){
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            
            $daoFinOrdem = new DaoFinOrdem();
            $daoFinOrdem->setIdOrdem($this->id_ordem);
            
            //verifica se a Ordem já possui entrega, se NÃO possuir, não permite a finalização da entrega 
            $daoFinOrdem->retornaEntregasOrdem($pdo);

            return $daoFinOrdem->Sucesso();
            
        } catch (Exception $exc) {
            return false;
        }
    }

    public function retornaValorSituacaoOrdem($pdo) {
        try {

            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            
            $daoFinOrdem = new DaoFinOrdem();
            $daoFinOrdem->setIdOrdem($this->id_ordem);
            $daoFinOrdem->retornaSituacaoOrdem($pdo);
            
            if (!$daoFinOrdem->Sucesso()) {
                return false;
            }
            return $daoFinOrdem->getMsgRetorno();
        } catch (Exception $ex) {
            return false;
        }
    }
    
    public function retornaItensParaAnulacaoEmpenho() {
        if (!empty($this->id_pedido)) {
            if (!empty($this->id_pedido) && !empty($this->id_ordem)) {
                //verificao a cima e para a ediçao da ordem
            } else if (!empty($this->id_pedido)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $daoFinOrdem = new DaoFinOrdem();
                $daoFinOrdem->setIdPedido($this->id_pedido);
                $daoFinOrdem->listaItensPreOrdem($pdo);
                $retorno = '';
                if ($daoFinOrdem->Sucesso()) {
                    foreach ($daoFinOrdem->getMsgRetorno() as $linha) {

                        $retorno .= '<tr data-tipo-material='.$linha['tp_material'].' data-fl-valor-variavel='.$linha['fl_valor_variavel'].'>
                                        <td class="text-center">' . $linha["nr_item"] . '</td>
                                        <td class="text-center">' . $linha["nm_material"] . '</td>
                                        <td class="text-center">' . wordwrap($linha["nm_desc_material"], 20, "<br />\n") . '</td>                                                                                                                        
                                        <td class="text-center">' . $linha["tp_material"] . '</td>

                                        <td class="text-center">' . $linha["nr_lote"] . '</td>
                                        <td class="text-center">' . Metodos::ConverteValorBr($linha["qt_itens_pre"], 4) . '</td>
                                        <td class="text-center">' . Metodos::ConverteValorBr($linha["vl_itens_pre"], 4) . '</td>
                                        <td class="text-center">' . Metodos::ConverteValorBr($linha["total"], 4) . '</td>
                                        <td class="text-center">' . Metodos::ConverteValorBr($linha["qt_utilizado"], 4) . '</td>
                                        <td class="text-center">' . Metodos::ConverteValorBr($linha["vl_utilizado"], 4) . '</td>
                                        <td class="text-center">' . Metodos::ConverteValorBr($linha["saldo"], 4) . '</td>';
                        
                        $label = "Quantidade";
//                        if ($linha["tp_material"] == 'S' || $linha['fl_valor_variavel'] == '1') {
//                            $label = "Vlr. Unitário";
//                        }
                        $inputAnulacao = '<td class="text-right itens"><input type="text" name="qtd" idPedido="' . $linha["id_pedido"] . '"
                                            idPreOrdem="' . $linha["id_pre_ordem"] . '" tp="' . $linha["tp_material"] . '" 
                                            quantidade="' . $linha["qt_itens_pre"] . '" valor_unitario="' . $linha["vl_itens_pre"] . '"
                                            fl_valor_variavel="'.$linha['fl_valor_variavel'].'"
                                            quantidade="' . $linha["saldo"] . '"
                                            class="form-control input-sm qtd_anulacao" ></td>';
                        
                        $tdValorAnulacao = '<td class="text-center valor_total_itens">' . Metodos::ConverteValorBr(0.0000, 4) . '</td>';
                        
                        if ($linha["tp_material"] == 'S' || $linha['fl_valor_variavel'] == '1') {
                            $retorno .= $tdValorAnulacao.$inputAnulacao;
                        }else{
                            $retorno .= $inputAnulacao.$tdValorAnulacao;
                        }
                        
                        

//                        if ($linha["tp_material"] == 'S' || $linha['fl_valor_variavel'] == '1') {
//                            $retorno .= 'Vlr. Unitário<input type="text" name="vl" idPedido="' . $linha["id_pedido"] . '"
//					tp="' . $linha["tp_material"] . '" class="form-control input-sm vl_anulacao">';
//                        }
                        $retorno .= '</tr>';
                    }
                }
                if (empty($retorno)) {
                    return "Nenhum pedido encontrado";
                }
                return $retorno;
            }
        }
    }
    
    public function retornaItensParaAnulacaoEmpenhoPorItens(array $itens, PDO $pdo = null){
        if (!empty($itens)){
            if(empty($pdo)){
                $conexao = new Conexao();
                $pdo = $conexao->connect();            
            }
                        
            $itens = implode(",", $itens);
            
            $daoFinOrdem = new DaoFinOrdem();            
            $daoFinOrdem->listaItensPreOrdemPorPreOrdem($itens, $pdo);            
            if ($daoFinOrdem->Sucesso()) {
                return $daoFinOrdem->getMsgRetorno();                
            }else{
                return false;
            }
        }
        return false;
    }
    
}
