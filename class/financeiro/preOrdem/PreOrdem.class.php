<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/preOrdem/DaoFinPreOrdem.class.php";

class PreOrdem {

    private $idPreOrdem = null;
    private $idContItens = null;
    private $idPedido = null;
    private $idFornecedor = null;
    private $qtItensPre = null;
    private $vlItensPre = null;
    private $tipoMaterial = null;
    private $sucesso = false;
    private $msgRetorno = null;
    private $vlTotal = null;
    
    public function getVlTotal() {
        return $this->vlTotal;
    }

    public function setVlTotal($vlTotal) {
        $this->vlTotal = $vlTotal;
        return $this;
    }
        
    public function Sucesso() {
        return $this->sucesso;
    }

    public function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function getIdPreOrdem() {
        return $this->idPreOrdem;
    }

    function getIdContItens() {
        return $this->idContItens;
    }

    function getIdPedido() {
        return $this->idPedido;
    }

    function getIdFornecedor() {
        return $this->idFornecedor;
    }

    function getQtItensPre() {
        return $this->qtItensPre;
    }

    function getVlItensPre() {
        return $this->vlItensPre;
    }

    function getTipoMaterial() {
        return $this->tipoMaterial;
    }

    function setIdPreOrdem($idPreOrdem) {
        $this->idPreOrdem = $idPreOrdem;
    }

    function setIdContItens($idContItens) {
        $this->idContItens = $idContItens;
    }

    function setIdPedido($idPedido) {
        $this->idPedido = $idPedido;
    }

    function setIdFornecedor($idFornecedor) {
        $this->idFornecedor = $idFornecedor;
    }

    function setQtItensPre($qtItensPre) {
        $this->qtItensPre = $qtItensPre;
    }

    function setVlItensPre($vlItensPre) {
        $this->vlItensPre = $vlItensPre;
    }

    function setTipoMaterial($tipoMaterial) {
        $this->tipoMaterial = $tipoMaterial;
    }

    public function cadastrarPreOrdem($array = null) {
        try {
            //conexao com banco dedados
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //criar objeto da preOrdem
            $daoFinPreOrdem = new DaoFinPreOrdem();
            //busca os id do item da ata, assim consigo joga no in
            $item = '';
            $item = array_map(function ($obj) {
                return $obj->idItem;
            }, $array);
            $item = implode(", ", $item);
            //criando objeto do Dao dos itens
            $daoFinItens = new DaoFinItens();
            $daoFinItens->retornaItensPorID($pdo, $item);
            $cont = count($daoFinItens->getMsgRetorno());
            $result = $daoFinItens->getMsgRetorno();
            //criando objeto do fornecedor para pega o id do fornecedor
            $finFornecedoresModel = new FinFornecedoresModel();
            $finFornecedoresModel->retornaFornecedorPeloIdPedido($pdo, $array[0]->id);
            $fornecedor = 0;
            $fornecedor = $finFornecedoresModel->getMsgRetorno()['id_fornecedor'];
            //criado objeto do item para pega o metodo verificaSaldoAtaContrato
            $valorPedido = 0;
            $itemModel = new ItemModel();
            if ($daoFinItens->Sucesso()) {
                $erro = false;

                for ($i = 0; $i < $cont; $i++) {
                    $itemModel->setFlValorVariavel($result[$i]['fl_valor_variavel']);
                    if (($array[$i]->tp == 'C' || $array[$i]->tp == 'P') && $result[$i]['fl_valor_variavel'] == "0") {
                        $valorPedido += (Metodos::ConverteValorIng($array[$i]->qtd) * $result[$i]['vl_itens']);
                        $itemModel->setQtItens($array[$i]->qtd);
                        if ($itemModel->verificaSaldoAtaContrato($array[$i]->tp, " where f.id_fornecedor = " . $fornecedor . " and item.id_cont_itens =   " . $array[$i]->idItem, ' ', $pdo)) {
                            $daoFinPreOrdem->setIdContItens($array[$i]->idItem);
                            $daoFinPreOrdem->setIdPedido($array[$i]->id);
                            $daoFinPreOrdem->setIdFornecedor($fornecedor);
                            $daoFinPreOrdem->setQtItensPre(Metodos::ConverteValorIng($array[$i]->qtd));
                            $daoFinPreOrdem->setVlItensPre($result[$i]['vl_itens']);
                        } else {
                            return Metodos::retornoAjax("Erro", "alert", "Saldo indisponível, por favor verifique os itens");
                            $erro = true;
                        }
                    } else {
                        $valorPedido += (Metodos::ConverteValorIng($array[$i]->qtd) * Metodos::ConverteValorIng($array[$i]->vl));
                        $itemModel->setVlItens($array[$i]->vl);
                        $itemModel->setQtItens($array[$i]->qtd);
                        if ($itemModel->verificaSaldoAtaContrato($array[$i]->tp, " where f.id_fornecedor = " . $fornecedor . " and item.id_cont_itens =   " . $array[$i]->idItem, ' ', $pdo)) {
                            $daoFinPreOrdem->setIdContItens($array[$i]->idItem);
                            $daoFinPreOrdem->setIdPedido($array[$i]->id);
                            $daoFinPreOrdem->setIdFornecedor($fornecedor);
                            $daoFinPreOrdem->setQtItensPre(Metodos::ConverteValorIng($array[$i]->qtd));
                            $daoFinPreOrdem->setVlItensPre(Metodos::ConverteValorIng($array[$i]->vl));
                        } else {
                            return Metodos::retornoAjax("Erro", "alert", "Saldo indisponível, por favor verifique os itens");
                            $erro = true;
                        }
                    }
                    
                    $daoFinPreOrdem->setVlTotal($daoFinPreOrdem->getQtItensPre() * $daoFinPreOrdem->getVlItensPre());
                    
                    $daoFinPreOrdem->cadastrarPreOrdem($pdo);

                    if (!$daoFinPreOrdem->Sucesso()) {
                        $erro = true;
                    }
                }
                

                //setando o id do pedido para pode atualiza o valor
                $this->idPedido = $array[0]->id;
                if (!$this->atualizaValorPedido($pdo)) {
                    $erro = true;
                }

                //veriicar saldo liberado
                $daoPedido = new DaoFinPedido();
                $daoPedido->setIdPedido($this->idPedido);
                //retorna dados do pedido 
                $daoPedido->retornaDadosPedido($pdo);
                if ($daoPedido->Sucesso()) {
                    //pega data do pedido
                    $date = new DateTime($daoPedido->getMsgRetorno()["dt_pedido"]);
                    //array com as informaçoes do pedido
                    $arrayPedido = array(
                        "ano" => $date->format('Y'),
                        "fonte" => $daoPedido->getMsgRetorno()["id_fonte"],
                        "projeto" => $daoPedido->getMsgRetorno()["id_programa_trabalho"],
                        "despesa" => $daoPedido->getMsgRetorno()["id_despesa_elemento"],
                        "tipoDeGasto" => $daoPedido->getMsgRetorno()["id_tipo_gasto"],
                        "central" => $daoPedido->getMsgRetorno()["id_lotacao"]
                    );
                    $finCentralLiberacaoModel = new FinCentralLiberacaoModel();
                    $saldo = $finCentralLiberacaoModel->retornaSaldoValorLiberado($arrayPedido);
                    $saldo = (float) $saldo;
                   
                    if ($saldo < $valorPedido) {
                        $erro = true;
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "alert", "Não foi liberado recurso suficiente para essa ação");
                    }
                } else {
                    $erro = true;
                }

                //log
                $daoFinPreOrdem->setIdPreOrdem($pdo->lastInsertId('fin_pre_ordem_id_pre_ordem_seq'));
                if (!Log::SalvaLogI('fin_pre_ordem', $daoFinPreOrdem->getIdPreOrdem(), $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                }

                if (!$erro) {
                    $pdo->commit();
                    $erro = true;
                    return Metodos::retornoAjax("ok", "html", $array[0]->id);
                }

                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", $daoFinPreOrdem->getMsgRetorno());
            } else {
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function editarPreOrdem() {
        try {

            if (empty($this->idContItens) && empty($this->idPedido) && empty($this->idFornecedor)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            //conexao com banco dedados
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $daoFinPreOrdem = new DaoFinPreOrdem();
            $busca = '';
            $erro = false;
            $valorPedido = 0;
            $daoFinPreOrdem->retornaItemPreOrdem($pdo, " where id_pre_ordem = " . $this->idPreOrdem);
            $busca = $daoFinPreOrdem->getMsgRetorno();

            if ($this->tipoMaterial == 'C' || $this->tipoMaterial == 'P') {
                $valorPedido = (Metodos::ConverteValorIng($this->qtItensPre) * $busca['vl_itens_pre']);
                if ($this->saldoPreOrdem(" where item.id_cont_itens = " . $this->idContItens, " and pre.id_pre_ordem <> " . $this->idPreOrdem, $pdo)) {
                    $daoFinPreOrdem->setIdPreOrdem($this->idPreOrdem);
                    $daoFinPreOrdem->setQtItensPre(Metodos::ConverteValorIng($this->qtItensPre));
                    $daoFinPreOrdem->setVlItensPre($busca['vl_itens_pre']);
                    $daoFinPreOrdem->setVlTotal($daoFinPreOrdem->getQtItensPre() * $daoFinPreOrdem->getVlItensPre());
                    $daoFinPreOrdem->editarItensPreOrdem($pdo);
                } else {
                    return Metodos::retornoAjax("Erro", "alert", "Saldo indisponível, por favor verifique os itens");
                    $erro = true;
                }
            } else if ($this->tipoMaterial == 'S') {
                $valorPedido = (Metodos::ConverteValorIng($this->qtItensPre) * Metodos::ConverteValorIng($this->vlItensPre));
                if ($this->saldoPreOrdem(" where item.id_cont_itens = " . $this->idContItens, " and pre.id_pre_ordem <> " . $this->idPreOrdem, $pdo)) {
                    $daoFinPreOrdem->setIdPreOrdem($this->idPreOrdem);
                    $daoFinPreOrdem->setQtItensPre(Metodos::ConverteValorIng($this->qtItensPre));
                    $daoFinPreOrdem->setVlItensPre(Metodos::ConverteValorIng($this->vlItensPre));
                    $daoFinPreOrdem->setVlTotal($daoFinPreOrdem->getQtItensPre() * $daoFinPreOrdem->getVlItensPre());
                    $daoFinPreOrdem->editarItensPreOrdem($pdo);
                } else {
                    return Metodos::retornoAjax("Erro", "alert", "Saldo indisponível, por favor verifique os itens");
                    $erro = true;
                }
            }


            //veriicar saldo liberado
            $daoPedido = new DaoFinPedido();
            $daoPedido->setIdPedido($this->idPedido);
            //retorna dados do pedido 
            $daoPedido->retornaDadosPedido($pdo);
            if ($daoPedido->Sucesso()) {
                //pega data do pedido
                $date = new DateTime($daoPedido->getMsgRetorno()["dt_pedido"]);
                //array com as informaçoes do pedido
                $arrayPedido = array(
                    "ano" => $date->format('Y'),
                    "fonte" => $daoPedido->getMsgRetorno()["id_fonte"],
                    "projeto" => $daoPedido->getMsgRetorno()["id_programa_trabalho"],
                    "despesa" => $daoPedido->getMsgRetorno()["id_despesa_elemento"],
                    "tipoDeGasto" => $daoPedido->getMsgRetorno()["id_tipo_gasto"],
                    "central" => $daoPedido->getMsgRetorno()["id_lotacao"],
                    "idPedido" => $this->idPedido,
                );

                $finCentralLiberacaoModel = new FinCentralLiberacaoModel();
                $saldo = $finCentralLiberacaoModel->retornaSaldoValorLiberado($arrayPedido);
                $saldo = (float) $saldo;
               
                if ($saldo < $valorPedido) {
                    $erro = true;
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", "Não foi liberado recurso suficiente para essa ação");
                }
            } else {
                $erro = true;
            }

            if (!Log::SalvaLogU('fin_pre_ordem', $this->idPreOrdem, $busca, $pdo)) {
                $pdo->rollBack();
                $erro = true;
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }

            if (!$this->atualizaValorPedido($pdo)) {
                $erro = true;
            }

            if ($daoFinPreOrdem->Sucesso() && !$erro) {
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", "Edição do Item realizado com Sucesso.");
            }

            $pdo->rollBack();
            return Metodos::retornoAjax("Erro", "alert", $daoFinPreOrdem->getMsgRetorno());
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function retornaTrPreOrdemPorPedido() {
        try {

            if (!empty($this->idPedido)) {
                //conexao com banco dedados
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $daoFinPreOrdem = new DaoFinPreOrdem();
                $daoFinPreOrdem->setIdPedido($this->idPedido);
                $daoFinPreOrdem->retornaPreOdemPedido($pdo);
                $total = 0;
                $tabela = '';
                if ($daoFinPreOrdem->Sucesso()) {
                    foreach ($daoFinPreOrdem->getMsgRetorno() as $value) {
                        $total += $value["total"];
                        $tabela .= '<tr>
                    <td>' . $value["nr_item"] . '</td>
                    <td>' . $value["nm_material"] . '</td>
                    <td>' . $value['cd_desc_material'] . ' - ' . $value['nm_desc_material']. '</td>
                    <td>' . $value["nm_grupo"] . '</td>
                    <td>' . $value["nm_sub_grupo"] . '</td>
                    <td>' . $value["nm_unidade_medida"] . '</td>    
                    <td>' . $value["cd_despesa"] . '</td>
                    <td>' . $value["tp_material"] . '</td>
                    <td class="text-center">' . $value["nr_lote"] . '</td>
                    <td class="text-center">' . Metodos::ConverteValorBr($value["qt_itens_pre"], 4) . '</td>
                    <td class="text-center">' . Metodos::ConverteValorBr($value["vl_itens_pre"], 4) . '</td>
                    <td class="text-center">' . Metodos::ConverteValorBr($value["total"], 4) . '</td>
                    <td>
                    <button type="button" class="btn btn-default btn-edit btn-xs" title="Editar" value="' . $value["id_cont_itens"] . '"
                    tpMaterial = "' . $value["tp_material"] . '" fornecedor = "' . $value["id_fornecedor"] . '" idPreOrdem = "' . $value["id_pre_ordem"] . '">
                    <i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>
                    </button>

                    <button type="button" class="btn btn-default btn-remover btn-xs" title="Remover"
                    value="' . $value["id_pre_ordem"] . '" nomeMaterial="' . $value["nm_material"] . '">
                    <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                    </button>
                    </td>
                    </tr>';
                    }
                    $tabela .= '<tr>
                <td colspan="11" class="text-right"><strong>Total</strong></td>
                <td  colspan="2">' . Metodos::ConverteValorBr($total, 4) . '</td>
                </tr>';
                    return $tabela;
                } else {
                    return "Nenhum item encontrado !";
                }
            } else {
                echo 'dsds';
                return false;
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

    public function retornaDadosPreOrdem() {
        //conexao com banco dedados
        $conexao = new Conexao();
        $pdo = $conexao->connect();
        //criando objeto do Dao dos itens da ata
        $daoFinPreOrdem = new DaoFinPreOrdem();
        //chamando o metodo que retorna o iten da ata
        $daoFinPreOrdem->retornaDadosEdicaoPreOrdem($pdo, " where pre.id_cont_itens = " . $this->idContItens . " and pre.id_pedido = " . $this->idPedido);
        //verificando se deu tudo certo na busca do iten da ata
        if ($daoFinPreOrdem->Sucesso() && empty($daoFinPreOrdem->getMsgRetorno()) == false) {
            //esse array foi criado devido a necessidade de formata os valores
            $array = '';
            $array['cd_desc_material'] = $daoFinPreOrdem->getMsgRetorno()[0]['cd_desc_material'];
            $array['nm_material'] = $daoFinPreOrdem->getMsgRetorno()[0]['nm_material'];
            $array['nm_desc_material'] = $daoFinPreOrdem->getMsgRetorno()[0]['nm_desc_material'];
            $array['nm_grupo'] = $daoFinPreOrdem->getMsgRetorno()[0]['nm_grupo'];
            $array['nm_sub_grupo'] = $daoFinPreOrdem->getMsgRetorno()[0]['nm_sub_grupo'];
            $array['cd_elemento_despesa'] = $daoFinPreOrdem->getMsgRetorno()[0]['cd_elemento_despesa'];
            $array['tp_material'] = $daoFinPreOrdem->getMsgRetorno()[0]['tp_material'];
            $array['nr_lote'] = $daoFinPreOrdem->getMsgRetorno()[0]['nr_lote'];
            $array['nm_marca'] = $daoFinPreOrdem->getMsgRetorno()[0]['nm_marca'];
            $array['nm_modelo'] = $daoFinPreOrdem->getMsgRetorno()[0]['nm_modelo'];
            $array['nr_lote'] = $daoFinPreOrdem->getMsgRetorno()[0]['nr_lote'];
            $array['qt_itens'] = Metodos::ConverteValorBr($daoFinPreOrdem->getMsgRetorno()[0]['qt_itens_pre'], '4');
            $array['vl_itens'] = Metodos::ConverteValorBr($daoFinPreOrdem->getMsgRetorno()[0]['vl_itens_pre'], '4');
            $array['pc_desconto'] = $daoFinPreOrdem->getMsgRetorno()[0]['pc_desconto'];
            $array['ds_itens'] = $daoFinPreOrdem->getMsgRetorno()[0]['ds_itens'];
            $array['id_cont_itens'] = $daoFinPreOrdem->getMsgRetorno()[0]['id_cont_itens'];
            return Metodos::retornoAjax("ok", "html", $array);
        }
        //caso não de certo retorna uma mensagen de erro
        return Metodos::retornoAjax("nao_encontrou", "erro", $daoFinPreOrdem->getMsgRetorno());
    }

    public function saldoPreOrdem($condicao = '', $subCondicao = '', $pdo = null) {
        try {
            if (empty($pdo)) {
                //conexao com banco de dados
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }

            $daoFinPreOrdem = new DaoFinPreOrdem();
            //verifica o saldo do item
            $daoFinPreOrdem->retornaSaldoPreOrdem($pdo, $condicao, $subCondicao);

            if (($this->tipoMaterial == 'C' || $this->tipoMaterial == 'P') && $daoFinPreOrdem->Sucesso()) {

                if (($daoFinPreOrdem->getMsgRetorno()[0]["saldo"] < Metodos::ConverteValorIng($this->qtItensPre)) && !empty($this->qtItensPre)) {
                    return false;
                }
            } else if ($this->tipoMaterial == 'S' && $daoFinPreOrdem->Sucesso() && !empty($this->qtItensPre) && !empty($this->qtItensPre)) {

                if ($daoFinPreOrdem->getMsgRetorno()[0]["saldo"] < (Metodos::ConverteValorIng($this->qtItensPre) * Metodos::ConverteValorIng($this->vlItensPre))) {
                    return false;
                }
            }

            return true;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function atualizaValorPedido($pdo = null) {
        try {
            if (empty($pdo)) {
                //conexao com banco de dados
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoFinPreOrdem = new DaoFinPreOrdem();
            $daoFinPreOrdem->setIdPedido($this->idPedido);
            $daoFinPreOrdem->updateValorPedido($pdo);
            return $daoFinPreOrdem->Sucesso();
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        } catch (Exception $ex) {
            
        }
    }

    public function atualizaStatusPedidoOrdem($pdo = null) {
        try {
            if (empty($pdo)) {
                //conexao com banco de dados
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoFinPreOrdem = new DaoFinPreOrdem();
            $daoFinPreOrdem->setIdPedido($this->idPedido);
            $daoFinPreOrdem->updateStatusPedidoOrdem($pdo);
            if ($daoFinPreOrdem->Sucesso()) {
                return "ok";
            } else {
                return "erro";
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        } catch (Exception $ex) {
            
        }
    }

    public function deletaItemPreOrdem($pdo = null) {
        try {
            if (empty($pdo)) {
                //conexao com banco de dados
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoFinPreOrdem = new DaoFinPreOrdem();
            $daoFinPreOrdem->setIdPreOrdem($this->idPreOrdem);
            $daoFinPreOrdem->verificarItemEmOrdem($pdo);
            $erro = false;
            if (!$daoFinPreOrdem->Sucesso()) {
                $daoFinPreOrdem->removeItemPreOrdem($pdo);
                if ($daoFinPreOrdem->Sucesso()) {

                    if (!$this->atualizaValorPedido($pdo)) {
                        $erro = true;
                    }
                } else {
                    return Metodos::retornoAjax("Erro", "console", $daoFinPreOrdem->getMsgRetorno());
                }
            } else {
                return Metodos::retornoAjax("Erro", "console", $daoFinPreOrdem->getMsgRetorno());
            }

            if (!$erro) {
                return Metodos::retornoAjax("ok", "html", "Item removido com sucesso.");
            } else {
                return Metodos::retornoAjax("Erro", "console", $daoFinPreOrdem->getMsgRetorno());
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        } catch (Exception $ex) {
            
        }
    }
    
    
    public function editarPreOrdemAnulacaoEmpenho(PDO $pdo = null) {
        try {
            
            if(empty($pdo)){
                $this->sucesso = false;
                $this->msgRetorno = "Não Possui conexão ativa.";
                return;
            }
           
            $daoFinPreOrdem = new DaoFinPreOrdem();
            $daoFinPreOrdem->setIdPreOrdem($this->idPreOrdem);
            $daoFinPreOrdem->retorna($pdo);
            if(!$daoFinPreOrdem->Sucesso()){
                $this->sucesso = false;
                $this->msgRetorno = "Não Possui conexão ativa.";
                return;                
            }
            
            $busca = $daoFinPreOrdem->getMsgRetorno();
            
            $daoFinPreOrdem->setQtItensPre($this->qtItensPre);
            $daoFinPreOrdem->setVlTotal($this->vlTotal);
            $daoFinPreOrdem->editarQuantidadeTotalPreOrdem($pdo);
            if(!$daoFinPreOrdem->Sucesso()){
                $this->sucesso = false;
                $this->msgRetorno = "Não foi possível atualizar a Pre Ordem";
                return;
            }
            
            if (!Log::SalvaLogU('fin_pre_ordem', $this->idPreOrdem, $busca, $pdo)) {                
                $this->sucesso = false;
                $this->msgRetorno = "Não foi possível atualizar a Pre Ordem. LOG";
                return;                                
            }
            
            $this->sucesso = true;
            $this->msgRetorno = "Atualização da Pre Ordem Salva com Sucesso";
            return;


//            //veriicar saldo liberado
//            $daoPedido = new DaoFinPedido();
//            $daoPedido->setIdPedido($this->idPedido);
//            //retorna dados do pedido 
//            $daoPedido->retornaDadosPedido($pdo);
//            if ($daoPedido->Sucesso()) {
//                //pega data do pedido
//                $date = new DateTime($daoPedido->getMsgRetorno()["dt_pedido"]);
//                //array com as informaçoes do pedido
//                $arrayPedido = array(
//                    "ano" => $date->format('Y'),
//                    "fonte" => $daoPedido->getMsgRetorno()["id_fonte"],
//                    "projeto" => $daoPedido->getMsgRetorno()["id_programa_trabalho"],
//                    "despesa" => $daoPedido->getMsgRetorno()["id_despesa_elemento"],
//                    "tipoDeGasto" => $daoPedido->getMsgRetorno()["id_tipo_gasto"],
//                    "central" => $daoPedido->getMsgRetorno()["id_lotacao"],
//                    "idPedido" => $this->idPedido,
//                );
//
//                $finCentralLiberacaoModel = new FinCentralLiberacaoModel();
//                $saldo = $finCentralLiberacaoModel->retornaSaldoValorLiberado($arrayPedido);
//                $saldo = (float) $saldo;
//               
//                if ($saldo < $valorPedido) {
//                    $erro = true;
//                    $pdo->rollBack();
//                    return Metodos::retornoAjax("Erro", "alert", "Não foi liberado recurso suficiente para essa ação");
//                }
//            } else {
//                $erro = true;
//            }
            

           

        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

}
