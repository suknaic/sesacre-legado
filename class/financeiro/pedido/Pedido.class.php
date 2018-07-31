<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/pedido/DaoFinPedido.class.php";

class Pedido {

    private $idPedido = null;
    private $nrPedido = null;
    private $idTipoSolicitacao = null;
    private $idFornecedor = null;
    private $idPortaria = null;
    private $idConvenio = null;
    private $idFonte = null;
    private $idProgramaTrabalho = null;
    private $idDespesaElemento = null;
    private $idDespesa = null;
    private $idTipoGasto = null;
    private $idLotacao = null;
    private $dsPedido = null;
    private $vlPedido = null;
    private $dtPedido = null;
    private $stPedido = null;
    private $contratado = null;
    private $ano = null;
    //atributos para vincular a diaria
    private $idUsuario = null;
    private $idDiaria = null;

    function getIdUsuario() {
        return $this->idUsuario;
    }

    function getIdDiaria() {
        return $this->idDiaria;
    }

    function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    function setIdDiaria($idDiaria) {
        $this->idDiaria = $idDiaria;
    }

    function getIdPedido() {
        return $this->idPedido;
    }

    function getNrPedido() {
        return $this->nrPedido;
    }

    function getIdTipoSolicitacao() {
        return $this->idTipoSolicitacao;
    }

    function getIdFornecedor() {
        return $this->idFornecedor;
    }

    function getIdPortaria() {
        return $this->idPortaria;
    }

    function getIdConvenio() {
        return $this->idConvenio;
    }

    function getIdFonte() {
        return $this->idFonte;
    }

    function getIdProgramaTrabalho() {
        return $this->idProgramaTrabalho;
    }

    function getIdDespesaElemento() {
        return $this->idDespesaElemento;
    }

    function getIdDespesa() {
        return $this->idDespesa;
    }

    function getIdTipoGasto() {
        return $this->idTipoGasto;
    }

    function getIdLotacao() {
        return $this->idLotacao;
    }

    function getDsPedido() {
        return $this->dsPedido;
    }

    function getVlPedido() {
        return $this->vlPedido;
    }

    function getDtPedido() {
        return $this->dtPedido;
    }

    function getStPedido() {
        return $this->stPedido;
    }

    function getContratado() {
        return $this->contratado;
    }

    function setIdPedido($idPedido) {
        $this->idPedido = $idPedido;
    }

    function setNrPedido($nrPedido) {
        $this->nrPedido = $nrPedido;
    }

    function setIdTipoSolicitacao($idTipoSolicitacao) {
        $this->idTipoSolicitacao = $idTipoSolicitacao;
    }

    function setIdFornecedor($idFornecedor) {
        $this->idFornecedor = $idFornecedor;
    }

    function setIdPortaria($idPortaria) {
        $this->idPortaria = $idPortaria;
    }

    function setIdConvenio($idConvenio) {
        $this->idConvenio = $idConvenio;
    }

    function setIdFonte($idFonte) {
        $this->idFonte = $idFonte;
    }

    function setIdProgramaTrabalho($idProgramaTrabalho) {
        $this->idProgramaTrabalho = $idProgramaTrabalho;
    }

    function setIdDespesaElemento($idDespesaElemento) {
        $this->idDespesaElemento = $idDespesaElemento;
    }

    function setIdDespesa($idDespesa) {
        $this->idDespesa = $idDespesa;
    }

    function setIdTipoGasto($idTipoGasto) {
        $this->idTipoGasto = $idTipoGasto;
    }

    function setIdLotacao($idLotacao) {
        $this->idLotacao = $idLotacao;
    }

    function setDsPedido($dsPedido) {
        $this->dsPedido = $dsPedido;
    }

    function setVlPedido($vlPedido) {
        $this->vlPedido = $vlPedido;
    }

    function setDtPedido($dtPedido) {
        $this->dtPedido = $dtPedido;
    }

    function setStPedido($stPedido) {
        $this->stPedido = $stPedido;
    }

    function setContratado($contratado) {
        $this->contratado = $contratado;
    }

    function getAno() {
        return $this->ano;
    }

    function setAno($ano) {
        $this->ano = $ano;
    }

    public function getSituacaoPedidos(): array {
        $arr_situacao = array(
            '0' => 'Cancelado',
            '9' => 'Aguardando Finalização da Pré-Ordem',
            '10' => 'Aguardando Autorização do Gerente de Ação',
            '11' => 'Aguardando Autorização do Gerente da Central',
            '12' => 'Aguardando Autorização do Gerente de Planejamento',
            '13' => 'Aguardando Autorização do Gerente Financeiro',
            '14' => 'Aguardando Autorização do Ordenador de Despesa',
            '15' => 'Empenho',
            '16' => 'Ordem'
        );
        return $arr_situacao;
    }
    
    private function getPedidoNecessidadeStatus(): array {
        $arr_status = array(
            '9' => 'Aguardando finaliza a pre-ordem',
            '10' => 'Aguardando autorização do responsável imediato' ,
            '11' => 'Aguardando autorização do responsável da central',
            '12' => 'Aguardando autorização de orçamentário',
            '13' => 'Aguardando autorização financeiro',
            '14' => 'Aguardando autorização ordenador de despesa',
            '15' => 'Aguardando empenho',
            '16' => 'Aguardando ordem'
        );
        return $arr_status;
    }

    public static function getPermiteCancelamento(string $st_pedido) {
        if ($st_pedido == '9' or $st_pedido == '10' or $st_pedido == '11' or $st_pedido == '12' or $st_pedido == '13' or $st_pedido == '14' or $st_pedido == '15') {
            return true;
        } else {
            return false;
        }
    }

    public function salvaPedido() {
        try {
            if (empty($this->idTipoSolicitacao) || empty($this->idFornecedor) || empty($this->idFonte) || empty($this->idProgramaTrabalho) ||
                    empty($this->idDespesaElemento) || empty($this->dsPedido) || empty($this->idLotacao) || empty($this->idTipoGasto)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $daoFinPedido = new DaoFinPedido();
            //chamando a funcao que retorna o numero do pedido de necessidade
            $daoFinPedido->NumeroPedido($pdo);
            //fim
            //verificar saldo de liberaçao
            $finCentralLiberacaoModel = new FinCentralLiberacaoModel();
            $dados = array(
                "ano" => $this->ano,
                "fonte" => $this->idFonte,
                "projeto" => $this->idProgramaTrabalho,
                "despesa" => $this->idDespesaElemento,
                "tipoDeGasto" => $this->idTipoGasto,
                "central" => $this->idLotacao
            );
            $finCentralLiberacaoModel->retornaSaldoValorLiberado($dados);
            $daoFinPedido->setNrPedido($daoFinPedido->getMsgRetorno()['numero']);
            $daoFinPedido->setIdFornecedor($this->idFornecedor);
            $daoFinPedido->setIdTipoSolicitacao($this->idTipoSolicitacao);
            $daoFinPedido->setIdFonte($this->idFonte);
            $daoFinPedido->setIdProgramaTrabalho($this->idProgramaTrabalho);
            $daoFinPedido->setIdDespesaElemento($this->idDespesaElemento);
            $daoFinPedido->setIdDespesa($this->idDespesa);
            $daoFinPedido->setIdTipoGasto($this->idTipoGasto);
            $daoFinPedido->setIdLotacao($this->idLotacao);
            $daoFinPedido->setDsPedido($this->dsPedido);
            $daoFinPedido->setVlPedido($this->vlPedido);
            $daoFinPedido->setStPedido(9);
            $daoFinPedido->cadastrarFinPedido($pdo);

            //log do pedido de necessidade
            $daoFinPedido->setIdPedido($pdo->lastInsertId('fin_pedido_id_pedido_seq'));
            if (!Log::SalvaLogI('fin_pedido', $daoFinPedido->getIdPedido(), $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }

            if ($daoFinPedido->Sucesso()) {
                $pdo->commit();
                //verifico ser o contrato tem ata ou nao
                if (empty($this->idFornecedor)) {
                    $retorno = Metodos::retornoAjax("ok", "offPre", $daoFinPedido->getIdPedido());
                } else {
                    $retorno = Metodos::retornoAjax("ok", "pre", $daoFinPedido->getIdPedido());
                }
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", $daoFinPedido->getMsgRetorno());
                $pdo->rollBack();
            }
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function salvaPedidoSemFornecedor() {
        try {
            if (empty($this->idTipoSolicitacao) || empty($this->idFonte) || empty($this->idProgramaTrabalho) || empty($this->vlPedido) ||
                    empty($this->idDespesaElemento) || empty($this->dsPedido) || empty($this->idLotacao) || empty($this->idTipoGasto)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $daoFinPedido = new DaoFinPedido();
            //chamando a funcao que retorna o numero do pedido de necessidade
            $daoFinPedido->NumeroPedido($pdo);
            //fim
            //verificar saldo de liberaçao
            $finCentralLiberacaoModel = new FinCentralLiberacaoModel();
            $dados = array(
                "ano" => $this->ano,
                "fonte" => $this->idFonte,
                "projeto" => $this->idProgramaTrabalho,
                "despesa" => $this->idDespesaElemento,
                "tipoDeGasto" => $this->idTipoGasto,
                "central" => $this->idLotacao
            );
            $saldo = 0;
            $saldo = $finCentralLiberacaoModel->retornaSaldoValorLiberado($dados);
            if ($saldo < Metodos::ConverteValorIng($this->vlPedido)) {
                return Metodos::retornoAjax("Erro", "alert", "Não foi liberado recurso suficiente para essa ação");
            }
            $daoFinPedido->setNrPedido($daoFinPedido->getMsgRetorno()['numero']);
            $daoFinPedido->setIdTipoSolicitacao($this->idTipoSolicitacao);
            $daoFinPedido->setIdFonte($this->idFonte);
            $daoFinPedido->setIdProgramaTrabalho($this->idProgramaTrabalho);
            $daoFinPedido->setIdDespesaElemento($this->idDespesaElemento);
            $daoFinPedido->setIdDespesa($this->idDespesa);
            $daoFinPedido->setIdTipoGasto($this->idTipoGasto);
            $daoFinPedido->setIdLotacao($this->idLotacao);
            $daoFinPedido->setDsPedido($this->dsPedido);
            $daoFinPedido->setVlPedido(Metodos::ConverteValorIng($this->vlPedido));
            $daoFinPedido->setStPedido(11);

            $daoFinPedido->cadastrarFinPedidoSemFornecedor($pdo);
            //log do pedido de necessidade
            $daoFinPedido->setIdPedido($pdo->lastInsertId('fin_pedido_id_pedido_seq'));
            if (!Log::SalvaLogI('fin_pedido', $daoFinPedido->getIdPedido(), $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }

            if ($daoFinPedido->Sucesso()) {

                //Se for diaria, irá vincular com o pedido
                if ($this->idTipoGasto == 13) {
                    //pega o ano do pedido para adicionar esta informação no historico da diaria
                    $daoFinPedido->retornaDadosPedido($pdo);
                    $dataPedido = new DateTime($daoFinPedido->getMsgRetorno()['dt_pedido']);
                    $retorno2 = !$this->associaPedidoDiaria($pdo, $daoFinPedido->getIdPedido(), (int) $dataPedido->format('Y'));
                } else {
                    $retorno2 = true;
                }
                if ($retorno2) {
                    $pdo->commit();
                    //verifico ser o contrato tem ata ou nao
                    if (empty($this->idFornecedor)) {
                        $retorno = Metodos::retornoAjax("ok", "offPre", $daoFinPedido->getIdPedido());
                    } else {
                        $retorno = Metodos::retornoAjax("ok", "pre", $daoFinPedido->getIdPedido());
                    }
                } else {
                    $retorno = Metodos::retornoAjax("Erro", "alert", 'Erro na vinculação do pedido com a diária.');
                }
            } else {
                $retorno = Metodos::retornoAjax("Erro", "alert", $daoFinPedido->getMsgRetorno());
                $pdo->rollBack();
            }
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    function associaPedidoDiaria(PDO $pdo = null, int $idPedido, int $anoPedido) {
        try {
            $diaria = new Diaria();
            $diaria->setIdDiaria($this->getIdDiaria());
            $diaria->setIdPedido($idPedido);
            $diaria->setAnoPedido($anoPedido);
            $diaria->setUsuarioPedido($this->getIdUsuario());
            return $diaria->vinculaPedidoDiaria($pdo);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaDadosPedido() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoFinPedido = new DaoFinPedido();
            $daoFinPedido->setIdPedido($this->idPedido);
            $daoFinPedido->retornaDadosPedido($pdo);
            return $daoFinPedido->getMsgRetorno();
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaDadosPedidoOrdem(Session $session) {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoFinPedido = new DaoFinPedido();
            $condicao = "";
            $result = "";
            if (!$session->vPGeral()) {
                $centralResponsavel = new CentralResponsavel();
                //retorna os ids da lotacao liberado para o usuario
                $centralResponsavel->setIdPessoa($session->getIdUser());
                $result = $centralResponsavel->retornaIdCentralLiberacao($pdo);
                if ($result != false) {
                    foreach ($result as $dados) {
                        $idLotacao[] = $dados["id_lotacao"];
                    }
                }
                $condicao = " and p.id_lotacao in (" . implode(' , ', $idLotacao) . ") ";
            }
            $daoFinPedido->setNrPedido($this->nrPedido);
            $daoFinPedido->retornaDadosPedidoOrdem($pdo, $condicao);
            $retorno = '';
            if ($daoFinPedido->Sucesso()) {
                foreach ($daoFinPedido->getMsgRetorno() as $linha) {
                    $retorno .= '<tr class="selecionaItem" pedido="' . $linha["id_pedido"] . '" tipoCont="' . $linha["tp_contrato"] . '" style="cursor:pointer;">
                <td>' . $linha["pedido"] . '</td>
                <td>' . $linha["ds_pedido"] . '</td>
                <td>' . $linha["nm_tipo_gasto"] . '</td>    
                <td>' . $linha["nr_fonte"] . '</td>
                <td>' . $linha["ds_despesa_elemento"] . '</td>
                <td>' . Metodos::ConverteValorBr($linha["vl_pedido"], 4) . '</td>
                <td>' . $linha["tp_contrato"] . '</td>
                <td>' . $linha["contrato"] . '</td>    
                <td>' . $linha["nm_modalidade"] . '</td>
                <td>' . $linha["cd_programa_trabalho"] . "-" . $linha["ds_programa_trabalho"] . '</td>
                <td>' . $linha["nr_empenho"] . '</td>
                </tr>';
                }
            }
            if (empty($retorno)) {
                return "Nenhum pedido encontrado";
            }
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function listaPedidoJSON() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoFinPedido = new DaoFinPedido();
            $daoFinPedido->retornaTodosPedidos($pdo);
            return json_encode($daoFinPedido->getMsgRetorno());
            // return $daoFinPedido->getMsgRetorno();
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaPesquisaPedido() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoFinPedido = new DaoFinPedido();
            $filtro = [];
            $tabela = "";
            if (!empty($this->nrPedido)) {
                $filtro[] = "nr_pedido = '" . $this->nrPedido . "'";
            }

            if (!empty($this->idLotacao)) {
                $filtro[] = "p.id_lotacao = '" . $this->idLotacao . "'";
            }

            if (!empty($this->idTipoGasto)) {
                $filtro[] = "p.id_tipo_gasto = '" . $this->idTipoGasto . "'";
            }

            if (!empty($this->idFornecedor)) {
                $filtro[] = "f.id_fornecedor = '" . $this->idFornecedor . "'";
            }

            if (!empty($this->ano)) {
                $filtro[] = "to_char(p.dt_pedido, 'YYYY') = '" . $this->ano . "'";
            }

            if (count($filtro) > 0) {
                $filtro = " and " . implode(' and ', $filtro);
            } else {
                return false;
            }
//            $daoFinPedido->retornaPedidoPesquisa($pdo, $filtro);
            $daoFinPedido->retornaPedidoPesquisaComOrdens($pdo, $filtro);
            
            //Carrega a status os possíveis
            $opcoesStatus = $this->getPedidoNecessidadeStatus();

            if ($daoFinPedido->Sucesso()) {

                foreach ($daoFinPedido->getMsgRetorno() as $dados) { 
                    $statusPedido = $this->retornaStatusPedido($dados,$opcoesStatus);
                    $tabela .= '<tr><td class = "text-center">' . $dados["id_lotacao"] . '-' . $dados["nr_pedido"] . '/' . $dados["ano"] . '</td>
                                <td class = "text-center">' . $dados["nm_tipo_solicitacao"] . '</td>
                                <td class = "text-center">' . $dados["cd_programa_trabalho"] . '-' . $dados["ds_programa_trabalho"] . '</td>        
                                <td class = "text-center">' . $dados["nr_fonte"] . '</td>    
                                <td class = "text-center">' . $dados["cd_despesa"] . '-' . $dados["ds_despesa_elemento"] . '</td>
                                <td class = "text-center">' . $dados["nm_tipo_gasto"] . '</td>
                                <td class = "text-center">' . $dados["nm_lotacao"] . '</td>
                                <td class = "text-center">' . $dados["ds_pedido"] . '</td>     
                                <td class = "text-center">' . Metodos::ConverteValorBr($dados["vl_pedido"], 4) . '</td>  
                                <td class = "text-center">' . $statusPedido . '</td>    
                                <td class = "text-center">
                                    <a type = "button" title = "Visualiza pedido" href="/pages/financeiro/necessidade_central/ver_pedido.php?id=' . $dados['id_pedido'] . '" class = "verPedido" >
                                    <i class="fa fa-search-plus fa-lg text-info" aria-hidden="true"></i>
                                    </a >
                                </td>
                                </tr>';
                }
                
            }
            return Metodos::retornoAjax("ok", "tabela", $tabela);
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function listaSituacaoQuantidadeJSON() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoFinPedido = new DaoFinPedido();
            $daoFinPedido->retornaQuantidadeSituacaoPedido($pdo);

            $array = array(
                '11' => 'Aut. Central',
                '12' => 'Aut. Orçamento',
                '13' => 'Aut. Financeiro',
                '14' => 'Aut. Ordenador'
            );

            $arraySituacao = array(
                11 => array(
                    "situacao" => "Aut. Central",
                    "quantidade" => 0
                ),
                12 => array(
                    "situacao" => "Aut. Orçamento",
                    "quantidade" => 0
                ),
                13 => array(
                    "situacao" => "Aut. Financeiro",
                    "quantidade" => 0
                ),
                14 => array(
                    "situacao" => "Aut. Ordenador",
                    "quantidade" => 0
                ),
            );

            $arrayQuantidade = array();
            foreach ($daoFinPedido->getMsgRetorno() as $value) {
                if (array_key_exists($value['st_pedido'], $arraySituacao)) {
                    $arraySituacao[$value['st_pedido']]['quantidade'] = $value['quantidade'];
                }
            }

            foreach ($arraySituacao as $key => $value) {
                $arrayQuantidade[] = $value;
            }


            return json_encode($arrayQuantidade);
            return json_encode($daoFinPedido->getMsgRetorno());
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaPedidoComOrdemGdof($pdo) {
        try {

            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }

            $daoFinPedido = new DaoFinPedido();
            $daoFinPedido->setNrPedido($this->nrPedido);
            $daoFinPedido->retornaPedidoOrdemGdof($pdo);
            $retorno = '';
            if ($daoFinPedido->Sucesso()) {
                foreach ($daoFinPedido->getMsgRetorno() as $linha) {
                    $retorno .= '<tr class="selecionaItem" pedido="' . $linha["id_pedido"] . '" tipoCont="' . $linha["tp_contrato"] . '" style="cursor:pointer;">
                <td>' . $linha["pedido"] . '</td>
                <td>' . $linha["ds_pedido"] . '</td>
                <td>' . $linha["nm_tipo_gasto"] . '</td>    
                <td>' . $linha["nr_fonte"] . '</td>
                <td>' . $linha["ds_despesa_elemento"] . '</td>
                <td>' . Metodos::ConverteValorBr($linha["vl_pedido"], 4) . '</td>
                <td>' . $linha["tp_contrato"] . '</td>
                <td>' . $linha["contrato"] . '</td>    
                <td>' . $linha["nm_modalidade"] . '</td>
                <td>' . $linha["cd_programa_trabalho"] . "-" . $linha["ds_programa_trabalho"] . '</td>
                <td>' . $linha["nr_empenho"] . '</td>
                </tr>';
                }
            }
            if (empty($retorno)) {
                return "Nenhum pedido encontrado";
            }
            return $retorno;
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
            return;
        }
    }

    public function retornaPedidoGdof($pdo) {
        try {

            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $dadosPedido = '';
            $daoFinPedido = new DaoFinPedido();
            $daoFinPedido->setNrPedido($this->nrPedido);
            $daoFinPedido->retornaPedidoGdof($pdo);

            if ($daoFinPedido->sucesso()) {
                $campos = $daoFinPedido->getMsgRetorno();

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
            return;
        }
    }

    public function retornaIdPedidoPeloNumero($pdo) {
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoFinPedido = new DaoFinPedido();
            $daoFinPedido->setNrPedido($this->nrPedido);
            $daoFinPedido->retornaIdPedidoPorNumero($pdo);
            if ($daoFinPedido->Sucesso()) {
                return $daoFinPedido->getMsgRetorno()["id_pedido"];
            }
            return false;
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
            return;
        }
    }
    
    private function retornaStatusPedido(array $dados, array $opcoesStatus){
        try {
            
            $statusPedido = $opcoesStatus[$dados["status"]];
            
            if (!empty($dados['ordens'])) { //Se existir ordens, o status é 'Aguardando entrega'
                $statusPedido = "Aguardando entrega";
                
                if (!(strpos($dados["sit_entrega"], "1") === false)) { //Se existir ordem com entrega parcial
                    $statusPedido = "Aguardando Finalização da Entrega";
                } elseif (!(strpos($dados["sit_entrega"], "2") === false)) { //Se existir ordem com entrega total
                    $statusPedido = "Aguardando Pagamento";
                }
            }

            return $statusPedido;
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
            return;
        }
    }

}
