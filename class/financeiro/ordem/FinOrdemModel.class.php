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
            if (empty($ordem)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
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
            $date = new DateTime($ordem[0]->vig_inicial);
            $daoFinOrdem->setAaOrdem($date->format('Y'));

            if ($ordem[0]->pergunta == 1) {
                $daoFinOrdem->setDtIniOrdem(Metodos::ConverteDataING($ordem[0]->vig_inicial));
                $daoFinOrdem->setDtFimOrdem(Metodos::ConverteDataING($ordem[0]->vig_final));
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
                    if ($linha->tp == "C" || $linha->tp == "P") {

                        $finOrdemItensModel->setIdPedido($ordem[0]->idPedido);
                        $finOrdemItensModel->setTpItem($linha->tp);
                        $finOrdemItensModel->setIdOrdem($idOrdem);
                        $finOrdemItensModel->setIdPreOrdem($linha->idPreOrdem);
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
                    } else if ($linha->tp == "S") {
                        $finOrdemItensModel->setIdPedido($ordem[0]->idPedido);
                        $finOrdemItensModel->setTpItem($linha->tp);
                        $finOrdemItensModel->setIdOrdem($idOrdem);
                        $finOrdemItensModel->setIdPreOrdem($linha->idPreOrdem);
                        $finOrdemItensModel->setQdItensPre(Metodos::ConverteValorIng($linha->qtd));
                        $finOrdemItensModel->setVlItensPre(Metodos::ConverteValorIng($linha->vl));
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
                        $retorno .= '<tr>
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
                                        <td class="text-center">' . Metodos::ConverteValorBr($linha["saldo"], 4) . '</td>
                                        <td class="text-center itens">Quantidade<input type="text" name="qtd" id="qtd" idPedido="' . $linha["id_pedido"] . '"
                                         idPreOrdem="' . $linha["id_pre_ordem"] . '" tp="' . $linha["tp_material"] . '" 
                                         class="form-control input-sm qtd" >';

                        if ($linha["tp_material"] == 'S') {
                            $retorno .= 'Vlr. Unitário<input type="text" name="vl" id="vl" idPedido="' . $linha["id_pedido"] . '"
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
//        if (empty($this->central)) {
//            return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
//        }
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
                                <td class = 'text-center'>" . Metodos::ConverteValorBr($linha["valorordem"], 4) . "</td>
                                <td class = 'text-center'>
                                <button type = 'button' title = 'Editar' class = 'editar' value = '" . $linha['id_ordem'] . "'>
                                    <i class = 'fa fa-pencil text-primary'></i>
                                </button >

                                <button type = 'button' title = 'pdf' class = 'pdf' value = '" . $linha['id_ordem'] . "' tp='" . $linha['tp_ordem'] . "'>
                                 <i class='fa fa-file-pdf-o text-warning' aria-hidden='true'></i>
                                </button >

                                <button type = 'button' title = 'entrega' class = 'entrega' value = '" . $linha['id_ordem'] . "'>
                                <i class='fa fa-truck text-success' aria-hidden='true'></i></i>
                                </button >
                                
                                <button type='button' title='Excluir ordem' class='excluir text-danger' value='" . $linha['id_ordem'] . "' >
                                <i class='fa fa-trash' aria-hidden='true'></i>
                                </button>
                                
                               </td>
                            </tr>";
            }
            return Metodos::retornoAjax("ok", "html", $tabela);
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
                if(array_key_exists($value['tp_ordem'], $arrayTipo)){
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

}
