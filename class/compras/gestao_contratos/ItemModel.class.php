<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/compras/DaoFinItens.class.php";

class ItemModel {

    //atributos fin_cont_itens
    private $idContItens = null;
    private $nrItem = null;
    private $nrLote = null;
    private $nmMarca = null;
    private $nmModelo = null;
    private $qtItens = null;
    private $vlItens = null;
    private $pcDesconto = null;
    private $idMaterial = null;
    private $idFornecedor = null;
    private $idContItensAlt = null;
    private $cdDescMaterial = null;
    private $descItem = null;
    private $idUnidadeMedida = null;
    private $flValorVariavel = null;
    
    private $sucesso = false;
    private $msgRetorno = null;

    public function getMsgRetorno() {
        return $this->msgRetorno;
    }
    
    public function Sucesso() {
        return $this->sucesso;
    }

    function getIdContItens() {
        return $this->idContItens;
    }

    function getNrItem() {
        return $this->nrItem;
    }

    function getNrLote() {
        return $this->nrLote;
    }

    function getNmMarca() {
        return $this->nmMarca;
    }

    function getNmModelo() {
        return $this->nmModelo;
    }

    function getQtItens() {
        return $this->qtItens;
    }

    function getVlItens() {
        return $this->vlItens;
    }

    function getPcDesconto() {
        return $this->pcDesconto;
    }

    function getIdMaterial() {
        return $this->idMaterial;
    }

    function getIdFornecedor() {
        return $this->idFornecedor;
    }

    function getIdContItensAlt() {
        return $this->idContItensAlt;
    }

    function getCdDescMaterial() {
        return $this->cdDescMaterial;
    }

    function getDescItem() {
        return $this->descItem;
    }

    function getIdUnidadeMedida() {
        return $this->idUnidadeMedida;
    }

    function setIdContItens($idContItens) {
        $this->idContItens = $idContItens;
    }

    function setNrItem($nrItem) {
        $this->nrItem = $nrItem;
    }

    function setNrLote($nrLote) {
        $this->nrLote = $nrLote;
    }

    function setNmMarca($nmMarca) {
        $this->nmMarca = $nmMarca;
    }

    function setNmModelo($nmModelo) {
        $this->nmModelo = $nmModelo;
    }

    function setQtItens($qtItens) {
        $this->qtItens = $qtItens;
    }

    function setVlItens($vlItens) {
        $this->vlItens = $vlItens;
    }

    function setPcDesconto($pcDesconto) {
        $this->pcDesconto = $pcDesconto;
    }

    function setIdMaterial($idMaterial) {
        $this->idMaterial = $idMaterial;
    }

    function setIdFornecedor($idFornecedor) {
        $this->idFornecedor = $idFornecedor;
    }

    function setIdContItensAlt($idContItensAlt) {
        $this->idContItensAlt = $idContItensAlt;
    }

    function setCdDescMaterial($cdDescMaterial) {
        $this->cdDescMaterial = $cdDescMaterial;
    }

    function setDescItem($descItem) {
        $this->descItem = $descItem;
    }

    function setIdUnidadeMedida($idUnidadeMedida) {
        $this->idUnidadeMedida = $idUnidadeMedida;
    }
    
    public function getFlValorVariavel() {
        return $this->flValorVariavel;
    }

    public function setFlValorVariavel($flValorVariavel) {
        $this->flValorVariavel = $flValorVariavel;
    }

    
    public function cadastrarItem() {
        try {
            //conexao com banco dedados
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //verificando a descrição do material
            if (!empty($this->cdDescMaterial)) {
                $itens = new Itens();
                $itens->setCdDescMaterial($this->cdDescMaterial);
                $itens->salva($pdo);
                //caso tudo esteja certo vou cadastra os itens da ata
                if ($itens->Sucesso()) {
                    $daoFinItens = new DaoFinItens();
                    $daoFinItens->setNrItem($this->nrItem);
                    $daoFinItens->setNrLote($this->nrLote);
                    $daoFinItens->setNmMarca($this->nmMarca);
                    $daoFinItens->setNmModelo($this->nmModelo);
                    $daoFinItens->setDescItem($this->descItem);
                    $daoFinItens->setQtItens(Metodos::ConverteValorIng($this->qtItens));
                    $daoFinItens->setVlItens(Metodos::ConverteValorIng($this->vlItens));
                    $daoFinItens->setPcDesconto($this->pcDesconto);
                    $daoFinItens->setIdMaterial($itens->getIdItem());
                    $daoFinItens->setIdFornecedor($this->idFornecedor);
                    $daoFinItens->setIdContItensAlt((is_numeric($this->idContItensAlt)) ? $this->idContItensAlt : null);
                    $daoFinItens->setIdUnidadeMedida($this->idUnidadeMedida);
                    $daoFinItens->cadastrarItem($pdo);

                    if ($daoFinItens->Sucesso()) {
                        //log
                        $daoFinItens->setIdContItens($pdo->lastInsertId('fin_cont_itens_id_cont_itens_seq'));
                        if (!Log::SalvaLogI('fin_cont_itens', $daoFinItens->getIdContItens(), $pdo)) {
                            $pdo->rollBack();
                            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                        }
                        //fim log
                        $pdo->commit();
                        return Metodos::retornoAjax("ok", "html", "Item cadastro com Sucesso.");
                    }

                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", $daoFinItens->getMsgRetorno());
                } else {
                    return Metodos::retornoAjax("Erro", "alert", $itens->getMsgRetorno());
                }
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    /**
     * [retornaTrItem Esse metodo retorna os tr dos itens de uma ata ou contrato]
     * @return [string] [Tr]
     */
    public function retornaTrItem() {
        //conexao com banco dedados
        $conexao = new Conexao();
        $pdo = $conexao->connect();

        //criando objeto do Dao dos itens da ata
        $daoFinItens = new DaoFinItens();
        //chamando o metodo que lista os itens da ata
        $daoFinItens->setIdFornecedor($this->idFornecedor);
        $daoFinItens->retornaItens($pdo, "where f.id_fornecedor = " . $this->idFornecedor);
        //verificando ser deu tudo certo na busca dos itens da ata
        if ($daoFinItens->Sucesso() && empty($daoFinItens->getMsgRetorno()) == false) {
            $tabela = '';
            $total = 0;

            foreach ($daoFinItens->getMsgRetorno() as $value) {
                $total += $value["total"];
                $tabela .= '<tr>
                                <td>' . $value["nr_item"] . '</td>
				<td>' . $value["nm_material"] . '</td>
				<td>' . $value["cd_desc_material"] . ' - ' . $value["nm_desc_material"] . '</td>
                                <td>' . $value["ds_itens"] . '</td>    
				<td>' . $value["nm_grupo"] . '</td>
				<td>' . $value["nm_sub_grupo"] . '</td>
                                <td>' . $value["nm_unidade_medida"] . '</td>    
				<td>' . $value["tp_material"] . '</td>
				<td>' . $value["cd_elemento_despesa"] . '</td>
				<td class="text-center">' . $value["nr_lote"] . '</td>
				<td class="text-center">' . Metodos::ConverteValorBr($value["qt_itens"], 4) . '</td>
				<td class="text-center">' . Metodos::ConverteValorBr($value["vl_itens"], 4) . '</td>
				<td class="text-center">' . Metodos::ConverteValorBr($value["total"], 4) . '</td>
                                <td class="text-center">' . Metodos::ConverteValorBr($value["utilizado"], 4) . '</td>
                                <td class="text-center">' . Metodos::ConverteValorBr($value["saldo"], 4) . '</td>
                                <td class="text-center">' . Metodos::ConverteValorBr($value["totalsaldo"], 4) . '</td>     
				</tr>';
            }
            $tabela .= '<tr>
			<td colspan="12" class="text-right"><strong>Total</strong></td>
			<td  colspan="4">' . Metodos::ConverteValorBr($total, 4) . '</td>
			</tr>';
            return $tabela;
        }
    }

    /**
     * [retornaTrItem Esse metodo retorna os tr dos itens de uma ata ou contrato]
     * @return [string] [Tr]
     */
    public function retornaTrAcaoItem() {
        //conexao com banco dedados
        $conexao = new Conexao();
        $pdo = $conexao->connect();

        //criando objeto do Dao dos itens da ata
        $daoFinItens = new DaoFinItens();
        //chamando o metodo que lista os itens da ata
        $daoFinItens->retornaItens($pdo, "where f.id_fornecedor = " . $this->idFornecedor);
        //verificando ser deu tudo certo na busca dos itens da ata
        if ($daoFinItens->Sucesso() && empty($daoFinItens->getMsgRetorno()) == false) {
            $tabela = '';
            $total = 0;
            foreach ($daoFinItens->getMsgRetorno() as $value) {
                $total += $value["total"];
                $tabela .= '<tr>
                                <td>' . $value["nr_item"] . '</td>
				<td>' . $value["nm_material"] . '</td>
				<td>' . $value["cd_desc_material"] . ' - ' . $value["nm_desc_material"] . '</td>
				<td>' . $value["nm_grupo"] . '</td>
				<td>' . $value["nm_sub_grupo"] . '</td>
                                <td>' . $value["nm_unidade_medida"] . '</td>    
				<td>' . $value["cd_elemento_despesa"] . '</td>
				<td>' . $value["tp_material"] . '</td>
				<td class="text-center">' . $value["nr_lote"] . '</td>
				<td class="text-center">' . Metodos::ConverteValorBr($value["qt_itens"], 4) . '</td>
				<td class="text-center">' . Metodos::ConverteValorBr($value["vl_itens"], 4) . '</td>
				<td class="text-center">' . $value["pc_desconto"] . '</td>
				<td class="text-center">' . Metodos::ConverteValorBr($value["total"], 4) . '</td>
				<td>
				<button type="button" class="btn btn-default btn-edit btn-xs" title="Editar" value="' . $value["id_cont_itens"] . '">
				<i class="fa fa-pencil-square-o fa-lg text-primary" aria-hidden="true"></i>
				</button>

				<button type="button" class="btn btn-default btn-remover btn-xs" title="Remover"
				value="' . $value["id_cont_itens"] . '" nomeMaterial="' . $value["nm_material"] . '">
				<i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
				</button>
				</td>
				</tr>';
            }
            $tabela .= '<tr>
			<td colspan="12" class="text-right"><strong>Total</strong></td>
			<td  colspan="2">' . Metodos::ConverteValorBr($total, 4) . '</td>
			</tr>';
            return $tabela;
        }
    }

    public function retornaDados() {
        //conexao com banco dedados
        $conexao = new Conexao();
        $pdo = $conexao->connect();
        //criando objeto do Dao dos itens da ata
        $daoFinItens = new DaoFinItens();
        //chamando o metodo que retorna o iten da ata
        $daoFinItens->retornaItens($pdo, "where item.id_cont_itens = " . $this->idContItens);
        //verificando se deu tudo certo na busca do iten da ata
        if ($daoFinItens->Sucesso() && empty($daoFinItens->getMsgRetorno()) == false) {
            //esse array foi criado devido a necessidade de formata os valores
            $array = '';
            $array['nr_item'] = $daoFinItens->getMsgRetorno()[0]['nr_item'];
            $array['cd_desc_material'] = $daoFinItens->getMsgRetorno()[0]['cd_desc_material'];
            $array['cd_desc_material'] = $daoFinItens->getMsgRetorno()[0]['cd_desc_material'];
            $array['nm_material'] = $daoFinItens->getMsgRetorno()[0]['nm_material'];
            $array['nm_desc_material'] = $daoFinItens->getMsgRetorno()[0]['nm_desc_material'];
            $array['nm_grupo'] = $daoFinItens->getMsgRetorno()[0]['nm_grupo'];
            $array['nm_sub_grupo'] = $daoFinItens->getMsgRetorno()[0]['nm_sub_grupo'];
            $array['cd_elemento_despesa'] = $daoFinItens->getMsgRetorno()[0]['cd_elemento_despesa'];
            $array['tp_material'] = $daoFinItens->getMsgRetorno()[0]['tp_material'];
            $array['nr_lote'] = $daoFinItens->getMsgRetorno()[0]['nr_lote'];
            $array['nm_marca'] = $daoFinItens->getMsgRetorno()[0]['nm_marca'];
            $array['nm_modelo'] = $daoFinItens->getMsgRetorno()[0]['nm_modelo'];
            $array['nr_lote'] = $daoFinItens->getMsgRetorno()[0]['nr_lote'];
            $array['qt_itens'] = Metodos::ConverteValorBr($daoFinItens->getMsgRetorno()[0]['qt_itens'], '4');
            $array['vl_itens'] = Metodos::ConverteValorBr($daoFinItens->getMsgRetorno()[0]['vl_itens'], '4');
            $array['pc_desconto'] = $daoFinItens->getMsgRetorno()[0]['pc_desconto'];
            $array['ds_itens'] = $daoFinItens->getMsgRetorno()[0]['ds_itens'];
            $array['id_cont_itens'] = $daoFinItens->getMsgRetorno()[0]['id_cont_itens'];
            $array['total'] = Metodos::ConverteValorBr($daoFinItens->getMsgRetorno()[0]['total'], '4');
            return Metodos::retornoAjax("ok", "html", $array);
        }
        //caso não de certo retorna uma mensagen de erro
        return Metodos::retornoAjax("nao_encontrou", "erro", $daoFinItens->getMsgRetorno());
    }

    public function editarItem() {
        try {
            //conexao com banco dedados
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $erro = false;
            //verificando a descrição do material
            if (!empty($this->cdDescMaterial)) {
                $itens = new Itens();
                $itens->setCdDescMaterial($this->cdDescMaterial);
                $itens->salva($pdo);
                //caso tudo esteja certo vou cadastra os itens da ata
                if ($itens->Sucesso()) {
                    $daoFinItens = new DaoFinItens();
                    if ($this->valorUtilizado($itens->getTipoMaterial(), $this->qtItens, '', 'where id_fornecedor = ' . $this->idFornecedor . ' and item.id_cont_itens = ' . $this->idContItens)) {
                        //pegando dados antigos para salva no log
                        $daoFinItens->retornaItensPorID($pdo, $this->idContItens);
                        $busca = $daoFinItens->getMsgRetorno();
                        //setando os dados para a edição
                        $daoFinItens->setNrItem($this->nrItem);
                        $daoFinItens->setIdContItens($this->idContItens);
                        $daoFinItens->setIdFornecedor($this->idFornecedor);
                        $daoFinItens->setIdMaterial($itens->getIdItem());
                        $daoFinItens->setNrLote($this->nrLote);
                        $daoFinItens->setNmMarca($this->nmMarca);
                        $daoFinItens->setNmModelo($this->nmModelo);
                        $daoFinItens->setQtItens(Metodos::ConverteValorIng($this->qtItens));
                        $daoFinItens->setVlItens(Metodos::ConverteValorIng($this->vlItens));
                        $daoFinItens->setPcDesconto($this->pcDesconto);
                        $daoFinItens->setDescItem($this->descItem);
                        $daoFinItens->setIdUnidadeMedida($this->idUnidadeMedida);
                    } else {
                        return Metodos::retornoAjax("Erro", "alert", "Valor abaixo do utilizado !");
                        $erro = true;
                    }

                    $daoFinItens->editarItens($pdo);
                    if (!Log::SalvaLogU('fin_cont_itens', $this->idContItens, $busca, $pdo)) {
                        $pdo->rollBack();
                        $erro = true;
                        return retornoAjax("Erro", "alert", STR_ERROR);
                    }

                    if ($daoFinItens->Sucesso() && !$erro) {
                        $pdo->commit();
                        return Metodos::retornoAjax("ok", "html", "Edição do Item realizado com Sucesso.");
                    }

                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", $daoFinItens->getMsgRetorno());
                }
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function excluirItem() {
        try {
            //conexao com banco dedados
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //criando objeto do Dao dos itens da ata
            $daoFinItens = new DaoFinItens();
            $daoFinItens->setIdContItens($this->idContItens);
            $daoFinItens->excluirItem($pdo);
            //verificando se deu tudo certo na busca do iten da ata
            if ($daoFinItens->Sucesso()) {
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", "Item removido com Sucesso.");
            }
            //caso não de certo retorna uma mensagen de erro
            $pdo->rollBack();
            return Metodos::retornoAjax("Erro", "console", $daoFinAtaItens->getMsgRetorno());
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaTrAtaContrato() {
        //conexao com banco dedados
        $conexao = new Conexao();
        $pdo = $conexao->connect();
        //pega dados do fornecedor
        $finFornecedoresModel = new FinFornecedoresModel();
        $finFornecedoresModel->setIdFornecedor($this->idFornecedor);
        //descobri o fornecedor da ata 
        $finFornecedoresModel->retornaFornecedorAta($pdo);
        //criando objeto do Dao dos itens da ata
        $daoFinItens = new DaoFinItens();
        //chamando o metodo que lista os itens da ata
        if (!empty($finFornecedoresModel->getMsgRetorno()['id_fornecedor'])) {
            $daoFinItens->setIdFornecedor($finFornecedoresModel->getMsgRetorno()['id_fornecedor']);
            $daoFinItens->retornaItensAtaSaldo($pdo);
        } else {
            return 'Id Ata não encontrado';
        }
        //verificando se deu tudo certo na busca dos itens da ata
        if ($daoFinItens->Sucesso() && !empty($daoFinItens->getMsgRetorno())) {
            $tabela = '';
            $total = 0;
            foreach ($daoFinItens->getMsgRetorno() as $value) {
                $total += $value["total"];
                $tabela .= '<tr>
                                <td>' . $value["nr_item"] . '</td>
				<td>' . $value["nm_material"] . '</td>
				<td>' . $value["cd_desc_material"] . ' - ' . $value["nm_desc_material"] . '</td>
				<td>' . $value["nm_grupo"] . '</td>
				<td>' . $value["nm_sub_grupo"] . '</td>
                                <td>' . $value["nm_unidade_medida"] . '</td>    
				<td>' . $value["cd_elemento_despesa"] . '</td>
				<td>' . $value["tp_material"] . '</td>
				<td class="text-center">' . $value["nr_lote"] . '</td>
				<td class="text-center">' . Metodos::ConverteValorBr($value["qt_itens"], 4) . '</td>
				<td class="text-center">' . Metodos::ConverteValorBr($value["vl_itens"], 4) . '</td>
				<td class="text-center">' . $value["pc_desconto"] . '</td>
				<td class="text-center">' . Metodos::ConverteValorBr($value["total"], 4) . '</td>
				<td class="text-center">' . Metodos::ConverteValorBr($value["utilizado"], 4) . '</td>
				<td class="text-center">' . Metodos::ConverteValorBr($value["saldo"], 4) . '</td>
				<td class="text-center itens">Quantidade<input type="text" name="qtd" id="qtd" itemId="' . $value["id_cont_itens"] . '"
				tp="' . $value["tp_material"] . '" class="form-control input-sm qtd" >';

                if ($value["tp_material"] == 'S') {
                    $tabela .= 'Vlr. Unitário<input type="text" name="vl" id="vl" itemId="' . $value["id_cont_itens"] . '"
					tp="' . $value["tp_material"] . '" class="form-control input-sm vl">';
                }
                $tabela .= '</td></tr>';
            }
            return $tabela;
        }
    }

    public function cadastraItemAtaContrato($array = null) {
        try {
            //conexao com banco dedados
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //pega dados do fornecedor
            $finFornecedoresModel = new FinFornecedoresModel();

            //criando objeto do Dao dos itens da ata
            $daoFinItens = new DaoFinItens();

            //busca os id do item da ata, assim consigo joga no in
            $item = '';
            $item = array_map(function ($obj) {
                return $obj->idItem;
            }, $array);

            $item = implode(", ", $item);
            $daoFinItens->retornaItensPorID($pdo, $item);
            $cont = 0;
            $cont = count($daoFinItens->getMsgRetorno());
            $result = $daoFinItens->getMsgRetorno();
            $ata = 0;
            if ($daoFinItens->Sucesso()) {
                $erro = false;

                for ($i = 0; $i < $cont; $i++) {

                    //seto o fornecedor
                    $finFornecedoresModel->setIdFornecedor($array[$i]->id);
                    //pego os dados desse fornecedor
                    $finFornecedoresModel->dadosFornecedorPorId($pdo);
                    //descubro o id da ata
                    $ata = $finFornecedoresModel->getMsgRetorno()['id_contrato'];

                    if (!empty($ata)) {
                        //seto o id da ata encontrato
                        $finFornecedoresModel->setIdFornecedor($ata);
                        //pega o fonecedor da ata verificar o saldo dela
                        $finFornecedoresModel->retornaFornecedorAta($pdo);
                        $fornecedor = 0;
                        $fornecedor = $finFornecedoresModel->getMsgRetorno();
                    }
                    $this->qtItens = 0;
                    $this->vlItens = 0;
                    if ($array[$i]->tp == 'C' || $array[$i]->tp == 'P') {
                        $this->qtItens = $array[$i]->qtd;
                        //funcção responsavel por verificar saldo => verificaSaldoAtaContrato($tipo=null ,$qtd = null, $valor = null, $condicao)
                        if ($this->verificaSaldoAtaContrato($array[$i]->tp, " where f.id_fornecedor = " . $fornecedor['id_fornecedor'] . " and item.id_cont_itens =   " . $array[$i]->idItem, "", $pdo)) {
                            $daoFinItens->setNrItem($result[$i]["nr_item"]);
                            $daoFinItens->setNrLote($result[$i]["nr_lote"]);
                            $daoFinItens->setDescItem($result[$i]["ds_itens"]);
                            $daoFinItens->setNmMarca($result[$i]["nm_marca"]);
                            $daoFinItens->setNmModelo($result[$i]["nm_modelo"]);
                            $daoFinItens->setQtItens(Metodos::ConverteValorIng($array[$i]->qtd));
                            $daoFinItens->setVlItens($result[$i]['vl_itens']);
                            $daoFinItens->setPcDesconto($result[$i]["pc_desconto"]);
                            $daoFinItens->setIdMaterial($result[$i]["id_material"]);
                            $daoFinItens->setIdFornecedor($array[$i]->id);
                            $daoFinItens->setIdContItensAlt((is_numeric($array[$i]->idItem)) ? $array[$i]->idItem : null);
                            $daoFinItens->setIdUnidadeMedida($result[$i]["id_unidade_medida"]);
                        } else {
                            return Metodos::retornoAjax("Erro", "alert", "Saldo indisponível, por favor verifique os itens");
                            $erro = true;
                        }
                    } else {
                        $this->qtItens = $array[$i]->qtd;
                        $this->vlItens = $array[$i]->vl;
                        if ($this->verificaSaldoAtaContrato($array[$i]->tp, " where f.id_fornecedor = " . $fornecedor['id_fornecedor'] . " and item.id_cont_itens =   " . $array[$i]->idItem, "", $pdo)) {
                            $daoFinItens->setNrItem($result[$i]["nr_item"]);
                            $daoFinItens->setNrLote($result[$i]["nr_lote"]);
                            $daoFinItens->setDescItem($result[$i]["ds_itens"]);
                            $daoFinItens->setNmMarca($result[$i]["nm_marca"]);
                            $daoFinItens->setNmModelo($result[$i]["nm_modelo"]);
                            $daoFinItens->setQtItens(Metodos::ConverteValorIng($array[$i]->qtd));
                            $daoFinItens->setVlItens(Metodos::ConverteValorIng($array[$i]->vl));
                            $daoFinItens->setPcDesconto($result[$i]["pc_desconto"]);
                            $daoFinItens->setIdMaterial($result[$i]["id_material"]);
                            $daoFinItens->setIdFornecedor($array[$i]->id);
                            $daoFinItens->setIdContItensAlt((is_numeric($array[$i]->idItem)) ? $array[$i]->idItem : null);
                            $daoFinItens->setIdUnidadeMedida($result[$i]["id_unidade_medida"]);
                        } else {

                            return Metodos::retornoAjax("Erro", "alert", "Saldo indisponível, por favor verifique os itens");
                            $erro = true;
                        }
                    }
                    $daoFinItens->cadastrarItem($pdo);


                    if (!$daoFinItens->Sucesso()) {
                        //log
                        $daoFinItens->setIdContItens($pdo->lastInsertId('fin_cont_itens_id_cont_itens_seq'));
                        if (!Log::SalvaLogI('fin_cont_itens', $daoFinItens->getIdContItens(), $pdo)) {
                            $pdo->rollBack();
                            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                            break;
                        }
                        //fim log
                        $erro = true;
                    }
                }

                if (!$erro) {
                    $pdo->commit();
                    return Metodos::retornoAjax("ok", "html", $array[0]->id);
                }

                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", $daoFinItens->getMsgRetorno());
            } else {
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function editarItemAtaContrato() {
        try {
            //conexao com banco dedados
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $erro = false;
            //verificando a descrição do material
            if (!empty($this->cdDescMaterial)) {
                $itens = new Itens();
                $itens->setCdDescMaterial($this->cdDescMaterial);
                $itens->salva($pdo);
                //caso tudo esteja certo vou cadastra os itens da ata
                if ($itens->Sucesso()) {
                    //instancio a classe de fornecedor
                    $finFornecedoresModel = new FinFornecedoresModel();
                    //seto o fornecedor
                    $finFornecedoresModel->setIdFornecedor($this->idFornecedor);
                    //retorno os dados do fornecedor para sabe em qual ata ele ta vinculado
                    $finFornecedoresModel->dadosFornecedorPorId($pdo);
                    //descubro o id da ata
                    $ata = $finFornecedoresModel->getMsgRetorno()['id_contrato'];

                    if (!empty($ata)) {
                        //seto o id da ata encontrato
                        $finFornecedoresModel->setIdFornecedor($ata);
                        //pega o fonecedor da ata para verificar o saldo dela
                        $finFornecedoresModel->retornaFornecedorAta($pdo);
                        $fornecedor = 0;
                        $fornecedor = $finFornecedoresModel->getMsgRetorno()['id_fornecedor'];
                    } else {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                    }
                    /**
                     * Agora preciso retorna os dados do item para conseguir o id_cont_itens_alt
                     * atrave dele que vou descobri ser tem saldo na ata para edição duvidas e só
                     * olha o diagrama do banco de dados
                     */
                    $daoFinItens = new DaoFinItens();
                    $daoFinItens->retornaItensPorID($pdo, $this->idContItens);
                    $dadosItem = $daoFinItens->getMsgRetorno();
                    $tipo = $itens->getTipoMaterial();
                    if ($tipo == 'C' || $tipo == 'P') {

                        $validacao1 = $this->verificaSaldoAtaContrato($tipo, " where f.id_fornecedor = " .
                                $fornecedor . " and item.id_cont_itens =   " . $dadosItem[0]['id_cont_itens_alt'], ' and it.id_cont_itens <> ' . $this->idContItens, $pdo);
                        if ($validacao1) {
                            $daoFinItens->setNrItem($this->nrItem);
                            $daoFinItens->setIdContItens($this->idContItens);
                            $daoFinItens->setIdFornecedor($this->idFornecedor);
                            $daoFinItens->setIdMaterial($itens->getIdItem());
                            $daoFinItens->setDescItem($this->descItem);
                            $daoFinItens->setNrLote($this->nrLote);
                            $daoFinItens->setNmMarca($this->nmMarca);
                            $daoFinItens->setNmModelo($this->nmModelo);
                            $daoFinItens->setQtItens(Metodos::ConverteValorIng($this->qtItens));
                            $daoFinItens->setVlItens($dadosItem[0]['vl_itens']);
                            $daoFinItens->setPcDesconto($this->pcDesconto);
                            $daoFinItens->setDescItem($this->descItem);
                            $daoFinItens->setIdUnidadeMedida($this->idUnidadeMedida);
                        } else {
                            return Metodos::retornoAjax("Erro", "alert", "Valor abaixo do utilizado !");
                        }
                    } else if ($itens->getTipoMaterial() == 'S') {
                        $validacao1 = $this->verificaSaldoAtaContrato($tipo, " where f.id_fornecedor = " .
                                $fornecedor . " and item.id_cont_itens =   " . $dadosItem[0]['id_cont_itens_alt'], ' and it.id_cont_itens <> ' . $this->idContItens, $pdo);
                        if ($validacao1) {
                            $daoFinItens->setNrItem($this->nrItem);
                            $daoFinItens->setIdContItens($this->idContItens);
                            $daoFinItens->setDescItem($this->descItem);
                            $daoFinItens->setIdFornecedor($this->idFornecedor);
                            $daoFinItens->setIdMaterial($itens->getIdItem());
                            $daoFinItens->setNrLote($this->nrLote);
                            $daoFinItens->setNmMarca($this->nmMarca);
                            $daoFinItens->setNmModelo($this->nmModelo);
                            $daoFinItens->setQtItens(Metodos::ConverteValorIng($this->qtItens));
                            $daoFinItens->setVlItens(Metodos::ConverteValorIng($this->vlItens));
                            $daoFinItens->setPcDesconto($this->pcDesconto);
                            $daoFinItens->setDescItem($this->descItem);
                            $daoFinItens->setIdUnidadeMedida($this->idUnidadeMedida);
                        } else {
                            return Metodos::retornoAjax("Erro", "alert", "Valor abaixo do utilizado !");
                        }
                    }
                    $daoFinItens->editarItens($pdo);

                    if ($daoFinItens->Sucesso()) {
                        $pdo->commit();
                        return Metodos::retornoAjax("ok", "html", "Edição do Item realizado com Sucesso.");
                    }

                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", $daoFinItens->getMsgRetorno());
                }
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function verificaSaldoAtaContrato($tipo = null, $condicao = '', $subCondicao = '', $pdo = null) {
        try {
            if (empty($pdo)) {
                //conexao com banco de dados
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }

            $daoFinItens = new DaoFinItens();
            //verifica o saldo do item
            $daoFinItens->retornaSaldoItemAta($pdo, $condicao, $subCondicao);

            if ($tipo == 'C' && $daoFinItens->Sucesso()) {

                if ((float) $daoFinItens->getMsgRetorno()[0]["saldo"] < Metodos::ConverteValorIng($this->qtItens) && !empty($this->qtItens)) {
                    return false;
                }
            } else if ($tipo == 'S' && $daoFinItens->Sucesso() && !empty($this->qtItens) && !empty($this->vlItens)) {
                if (round((float) $daoFinItens->getMsgRetorno()[0]["saldo"], 4) < round((Metodos::ConverteValorIng($this->qtItens) * Metodos::ConverteValorIng($this->vlItens)), 4)) {
                    return false;
                }
            }

            return true;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function valorUtilizado($tipo = null, $qtd = null, $valor = null, $condicao = '') {
        try {
            //conexao com banco de dados
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoFinItens = new DaoFinItens();
            //verifica o saldo do item
            $daoFinItens->valorUtilizadoItem($pdo, $condicao);

            if ($tipo == 'C' && $daoFinItens->Sucesso()) {
                if (Metodos::ConverteValorIng($qtd) < $daoFinItens->getMsgRetorno()[0]["utilizado"] && !empty($qtd)) {
                    return false;
                }
            } else if ($tipo == 'S' && $daoFinItens->Sucesso() && !empty($qtd) && !empty($valor)) {
                if ((Metodos::ConverteValorIng($qtd) * Metodos::ConverteValorIng($valor)) < $daoFinItens->getMsgRetorno()[0]["utilizado"]) {
                    return false;
                }
            }

            return true;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    /**
     * [retornaTrPedido retorna o tr dos itens por elemento e sub-elemento]
     * @return [type] [tr dos itens]
     */
    public function retornaTrPedido($subElemento = null) {
        //conexao com banco dedados
        $conexao = new Conexao();
        $pdo = $conexao->connect();

        //criando objeto do Dao dos itens da ata
        $daoFinItens = new DaoFinItens();
        //chamando o metodo que lista os itens da ata
        $daoFinItens->setIdFornecedor($this->idFornecedor);
        $daoFinItens->retornaItensPorSubElemento($pdo, $subElemento);
        //verificando se deu tudo certo na busca dos itens da ata
        if ($daoFinItens->Sucesso() && !empty($daoFinItens->getMsgRetorno())) {
            $tabela = '';
            $total = 0;
            foreach ($daoFinItens->getMsgRetorno() as $value) {
                $total += $value["total"];
                $tabela .= '<tr>
                                <td>' . $value["nr_item"] . '</td>
				<td>' . $value["nm_material"] . '</td>
				<td>' . $value["cd_desc_material"] . ' - ' . $value["nm_desc_material"] . '</td>
				<td>' . $value["nm_grupo"] . '</td>
				<td>' . $value["nm_sub_grupo"] . '</td>
                                <td>' . $value["nm_unidade_medida"] . '</td>    
				<td>' . $value["cd_elemento_despesa"] . '</td>
				<td>' . $value["tp_material"] . '</td>
				<td class="text-center">' . $value["nr_lote"] . '</td>
				<td class="text-center">' . Metodos::ConverteValorBr($value["qt_itens"], 4) . '</td>
				<td class="text-center">' . Metodos::ConverteValorBr($value["vl_itens"], 4) . '</td>
				<td class="text-center">' . $value["pc_desconto"] . '</td>
				<td class="text-center">' . Metodos::ConverteValorBr($value["total"], 4) . '</td>
				<td class="text-center">' . Metodos::ConverteValorBr($value["utilizado"], 4) . '</td>
				<td class="text-center">' . Metodos::ConverteValorBr($value["saldo"], 4) . '</td>
				<td class="text-center itens">Quantidade<input type="text" name="qtd" id="qtd" itemId="' . $value["id_cont_itens"] . '"
				tp="' . $value["tp_material"] . '" class="form-control input-sm qtd" >';

                if ($value["tp_material"] == 'S') {
                    $tabela .= 'Vlr. Unitário<input type="text" name="vl" id="vl" itemId="' . $value["id_cont_itens"] . '"
					tp="' . $value["tp_material"] . '" class="form-control input-sm vl">';
                }
                $tabela .= '</td></tr>';
            }
            return $tabela;
        }
    }

    public function retornaTrItensParaAditamento(int $idContrato) {
        //conexao com banco dedados
        $conexao = new Conexao();
        $pdo = $conexao->connect();
        //pega id do fornecedor
        $finFornecedoresModel = new FinFornecedoresModel();
        $finFornecedoresModel->setIdContrato($idContrato);

        //Retorna o id do Fornecedor, o primeiro, do contrato para buscar os itens dele
        $finFornecedoresModel->retornaPrimeiroFornecedorDoContrato($pdo);
        if (!$finFornecedoresModel->sucesso()) {
            return "Não foi possível Localizar o Fornecedor do Contrato.";
        }

        //criando objeto do Dao dos itens da ata
        $daoFinItens = new DaoFinItens();
        //chamando o metodo que lista os itens da ata
        if (!empty($finFornecedoresModel->getMsgRetorno()['id_fornecedor'])) {
            $daoFinItens->setIdFornecedor($finFornecedoresModel->getMsgRetorno()['id_fornecedor']);
            $daoFinItens->retornaItensFornecedor($pdo);
        } else {
            return 'Não foi possível Localizar os Itens do Contrato';
        }

        //verificando se deu tudo certo na busca dos itens da ata
        if ($daoFinItens->Sucesso() && !empty($daoFinItens->getMsgRetorno())) {
            $tabela = '';
            $total = 0;
            foreach ($daoFinItens->getMsgRetorno() as $value) {
                //$total += $value["total"];
                $tabela .= '<tr data-id='.$value['id_cont_itens'].'>
                                <td>' . $value["nr_item"] . '</td>
				<td>' . $value["nm_material"] . '</td>
				<td>' . $value["cd_desc_material"] . ' - ' . $value["nm_desc_material"] . '</td>
				<td>' . $value["nm_grupo"] . '</td>
				<td>' . $value["nm_sub_grupo"] . '</td>
                                <td>' . $value["nm_unidade_medida"] . '</td>    
				<td>' . $value["cd_elemento_despesa"] . '</td>
				<td>' . $value["tp_material"] . '</td>
				<td class="text-center">' . $value["nr_lote"] . '</td>
				<td class="text-center td_quantidade">' . Metodos::ConverteValorBr($value["qt_itens"], 4) . '</td>
				<td class="text-center td_valor_unitario">' . Metodos::ConverteValorBr($value["vl_itens"], 4) . '</td>								
				<td class="text-center">
                                    <span class="label-aditivo">Quantidade</span>
                                    <input type="text" name="qtd_aditivo" class="form-control input-sm qtd_aditivo quatro_casas" />
                                </td>				
				<td class="text-center td_total">0.0000</td>
                                <td class="">Saldo</td>
                                </tr>';                               
            }
            return $tabela;
        }
    }
    
    
    public function retornaItensPorFornecedor(PDO $pdo){     
        try {           
            if(empty($pdo)){
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
                
            $dao = new DaoFinItens();
            $dao->setIdFornecedor($this->idFornecedor);
            $dao->retornaItensFornecedor($pdo);
            if(!$dao->Sucesso()){
                $this->sucesso = false;            
                $this->msgRetorno = "Não foi possível Localizar Itens do Contrato";
                return;
            }
            
            $this->sucesso = true;
            $this->msgRetorno = $dao->getMsgRetorno();            
                                                   
        } catch (Exception $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    

}
