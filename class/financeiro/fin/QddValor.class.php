<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/fin/DaoFinQddValor.class.php";

class QddValor {

    private $idQddValor = null;
    private $idQdd = null;
    private $idFonte = null;
    private $idProgramaTrabalho = null;
    private $idDespesaElemento = null;
    private $vlQddInical = null;
    private $vlQddSuplementado = null;
    private $vlQddReduzido = null;
    private $vlEmpenhado = null;
    private $vlBloqueado = null;
    private $vlLiberado = null;
    private $vlAtual = null;
    private $vlSaldo = null;
    private $ano = null;
    private $valor = null;
    private $sucesso = null;
    private $msgRetorno = null;
    private $fonte = null;
    private $programaTrabalho = null;
    private $despesaElemento = null;

    function getFonte() {
        return $this->fonte;
    }

    function getProgramaTrabalho() {
        return $this->programaTrabalho;
    }

    function getDespesaElemento() {
        return $this->despesaElemento;
    }

    function setFonte($fonte) {
        $this->fonte = $fonte;
        return $this;
    }

    function setProgramaTrabalho($programaTrabalho) {
        $this->programaTrabalho = $programaTrabalho;
        return $this;
    }

    function setDespesaElemento($despesaElemento) {
        $this->despesaElemento = $despesaElemento;
        return $this;
    }

    public function Sucesso() {
        return $this->sucesso;
    }

    /**
     * @return mixed
     */
    public function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function getValor() {
        return $this->valor;
    }

    function setValor($valor) {
        $this->valor = $valor;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdQddValor() {
        return $this->idQddValor;
    }

    /**
     * @param mixed $idQddValor
     *
     * @return self
     */
    public function setIdQddValor($idQddValor) {
        $this->idQddValor = $idQddValor;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdQdd() {
        return $this->idQdd;
    }

    /**
     * @param mixed $idQdd
     *
     * @return self
     */
    public function setIdQdd($idQdd) {
        $this->idQdd = $idQdd;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdFonte() {
        return $this->idFonte;
    }

    /**
     * @param mixed $idFonte
     *
     * @return self
     */
    public function setIdFonte($idFonte) {
        $this->idFonte = $idFonte;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdProgramaTrabalho() {
        return $this->idProgramaTrabalho;
    }

    /**
     * @param mixed $idProgramaTrabalho
     *
     * @return self
     */
    public function setIdProgramaTrabalho($idProgramaTrabalho) {
        $this->idProgramaTrabalho = $idProgramaTrabalho;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdDespesaElemento() {
        return $this->idDespesaElemento;
    }

    /**
     * @param mixed $idDespesaElemento
     *
     * @return self
     */
    public function setIdDespesaElemento($idDespesaElemento) {
        $this->idDespesaElemento = $idDespesaElemento;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVlQddInical() {
        return $this->vlQddInical;
    }

    /**
     * @param mixed $vlQddInical
     *
     * @return self
     */
    public function setVlQddInical($vlQddInical) {
        $this->vlQddInical = $vlQddInical;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVlQddSuplementado() {
        return $this->vlQddSuplementado;
    }

    /**
     * @param mixed $vlQddSuplementado
     *
     * @return self
     */
    public function setVlQddSuplementado($vlQddSuplementado) {
        $this->vlQddSuplementado = $vlQddSuplementado;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVlQddReduzido() {
        return $this->vlQddReduzido;
    }

    /**
     * @param mixed $vlQddReduzido
     *
     * @return self
     */
    public function setVlQddReduzido($vlQddReduzido) {
        $this->vlQddReduzido = $vlQddReduzido;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVlEmpenhado() {
        return $this->vlEmpenhado;
    }

    /**
     * @param mixed $vlEmpenhado
     *
     * @return self
     */
    public function setVlEmpenhado($vlEmpenhado) {
        $this->vlEmpenhado = $vlEmpenhado;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVlBloqueado() {
        return $this->vlBloqueado;
    }

    /**
     * @param mixed $vlBloqueado
     *
     * @return self
     */
    public function setVlBloqueado($vlBloqueado) {
        $this->vlBloqueado = $vlBloqueado;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVlLiberado() {
        return $this->vlLiberado;
    }

    /**
     * @param mixed $vlLiberado
     *
     * @return self
     */
    public function setVlLiberado($vlLiberado) {
        $this->vlLiberado = $vlLiberado;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVlAtual() {
        return $this->vlAtual;
    }

    /**
     * @param mixed $vlSaldo
     *
     * @return self
     */
    public function setVlAtual($vlAtual) {
        $this->vlAtual = $vlAtual;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVlSaldo() {
        return $this->vlSaldo;
    }

    /**
     * @param mixed $vlSaldo
     *
     * @return self
     */
    public function setVlSaldo($vlSaldo) {
        $this->vlSaldo = $vlSaldo;

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

    public function salvarDotacaoInicial(array $registros) {
        try {

            if ($this->ano == "" || strlen($this->ano) != 4) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            /* @var $pdo PDO */
            $pdo = $conexao->connect();

            $pdo->beginTransaction();
            //Seta os Campos
            $qdd = new Qdd();
            $qdd->setAaQdd($this->ano);
            $qdd->verificaExisteCarregaDados($pdo);
            if (!empty($qdd->getIdQdd())) {
                $retorno = Metodos::retornoAjax("Erro", "alert", "Não foi possível Localizar o QDD.");
            }

            $dao = new DaoFinQddValor();
            $dao->setIdQdd($qdd->getIdQdd());

            //Preparar os Dados Para Dar Insert
            foreach ($registros as $key => $value) {

                //Seta os Campos para Salvar no Banco de Dados
                $dao->setIdProgramaTrabalho((int) $value['programa']);
                $dao->setIdFonte((int) $value['fonte']);
                $dao->setIdDespesaElemento((int) $value['despesa']);
                $dao->setVlQddInical(Metodos::ConverteValorIng($value['valor']));

                $dao->insertInicial($pdo);
                if (!$dao->Sucesso()) {
                    $retorno = Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
                    $pdo->rollBack();
                    return $retorno;
                }

                $dao->setIdQddValor($pdo->lastInsertId('fin_qdd_valor_id_qdd_valor_seq'));

                if (!Log::SalvaLogI('fin_qdd_valor', $dao->getIdQddValor(), $pdo)) {
                    $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                    $pdo->rollBack();
                    return $retorno;
                }
            }

            $retorno = Metodos::retornoAjax("ok", "html", "Registros Salvo com Sucesso.");
            $pdo->commit();
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function remover() {
        try {

            if (empty($this->idQddValor)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            /* @var $pdo PDO */
            $pdo = $conexao->connect();

            $pdo->beginTransaction();
            //Seta os Campos
            $dao = new DaoFinQddValor();

            $dao->setIdQddValor($this->idQddValor);

            //Verifica se Já existe algum Qdd Cadastrado no Sistema para esse Ano
            $dao->retorna($pdo);
            if (!$dao->Sucesso()) {
                $retorno = Metodos::retornoAjax("Erro", "alert", "Não foi Possível Localizar o Registro.");
                $pdo->rollBack();
                return $retorno;
            }
            $busca = $dao->getMsgRetorno();

            if (!Log::SalvaLogD('fin_qdd_valor', $dao->getIdQddValor(), $pdo)) {
                $retorno = Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                $pdo->rollBack();
                return $retorno;
            }

            $dao->delete($pdo);
            if (!$dao->Sucesso()) {
                $retorno = Metodos::retornoAjax("Erro", "console", $dao->getMsgRetorno());
                $pdo->rollBack();
                return $retorno;
            }
            $retorno = Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
            $pdo->commit();
            return $retorno;
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function alterarSuplementadoReduzido(string $tipo, PDO $pdo) {
        try {
            $this->sucesso = FALSE;

            $dao = new DaoFinQddValor();
            $dao->setIdQddValor($this->idQddValor);

            $dao->retorna($pdo);

            if (!$dao->Sucesso()) {
                $this->sucesso = FALSE;
                $this->msgRetorno = $dao->getMsgRetorno();
                $pdo->rollBack();
                return;
            }
            $busca = $dao->getMsgRetorno();

            if ($tipo == "S") {
                $dao->setVlQddSuplementado($this->vlQddSuplementado);
                $dao->updateSuplementado($pdo);
            } else {
                $dao->setVlBloqueado($this->vlBloqueado);
                if (!empty($this->vlQddReduzido)) {
                    $dao->setVlQddReduzido($this->vlQddReduzido);
                    $dao->updateReduzidoBloqueado($pdo);
                } else {
                    $dao->updateBloqueado($pdo);
                }
            }

            if (!$dao->Sucesso()) {
                $this->sucesso = FALSE;
                $this->msgRetorno = $dao->getMsgRetorno();
                $pdo->rollBack();
                return;
            }

            if (!Log::SalvaLogU('fin_qdd_valor', $dao->getIdQddValor(), $busca, $pdo)) {
                $this->sucesso = FALSE;
                $this->msgRetorno = STR_ERROR . " LOG";
                $pdo->rollBack();
                return;
            }
            $this->sucesso = TRUE;
        } catch (PDOException $exc) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $exc->getMessage();
        }
    }

    public function alterarBloqueado(PDO $pdo) {
        try {
            $this->sucesso = FALSE;

            $dao = new DaoFinQddValor();
            $dao->setIdQddValor($this->idQddValor);

            $dao->retorna($pdo);

            if (!$dao->Sucesso()) {
                $this->sucesso = FALSE;
                $this->msgRetorno = $dao->getMsgRetorno();
                $pdo->rollBack();
                return;
            }
            $busca = $dao->getMsgRetorno();

            $dao->setVlBloqueado($this->vlBloqueado);

            $dao->updateBloqueado($pdo);

            if (!$dao->Sucesso()) {
                $this->sucesso = FALSE;
                $this->msgRetorno = $dao->getMsgRetorno();
                $pdo->rollBack();
                return;
            }

            if (!Log::SalvaLogU('fin_qdd_valor', $dao->getIdQddValor(), $busca, $pdo)) {
                $this->sucesso = FALSE;
                $this->msgRetorno = STR_ERROR . " LOG";
                $pdo->rollBack();
                return;
            }
            $this->sucesso = TRUE;
        } catch (PDOException $exc) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $exc->getMessage();
        }
    }

    public function retornaFonteQDD(PDO $pdo = null) {
        if (empty($pdo)) {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
        }
        $daoFinQddValor = new DaoFinQddValor();
        $daoFinQddValor->fonteQdd($pdo);
        $retorno = '';
        if ($daoFinQddValor->Sucesso()) {
            foreach ($daoFinQddValor->getMsgRetorno() as $v) {
                $retorno .= "<option value='" . $v['id_fonte'] . "'>" . $v['nr_fonte'] . "</option>";
            }
            echo $retorno;
        }
    }

    public function retornaProgramaPorFonteQDD(PDO $pdo = null) {
        if (empty($pdo)) {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
        }
        $daoFinQddValor = new DaoFinQddValor();
        $daoFinQddValor->setIdFonte($this->idFonte);
        $daoFinQddValor->programaQddPorFonte($pdo, $this->ano);
        $retorno = '<option value="" >Selecione um projeto/atividade</option>';
        if ($daoFinQddValor->Sucesso()) {
            foreach ($daoFinQddValor->getMsgRetorno() as $v) {
                $retorno .= "<option value='" . $v['id_programa_trabalho'] . "'>" . $v['cd_programa_trabalho'] . "-" . $v['ds_programa_trabalho'] . "</option>";
            }
            echo $retorno;
        }
    }

    public function optionsProgetoAtividadePorAnoQDD(PDO $pdo = null, $idProjeto = null) {
        if (empty($pdo)) {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
        }
        if (!empty($this->ano)) {
            $options = '';
            $daoFinQddValor = new DaoFinQddValor();
            $daoFinQddValor->retornaProjetoAtividadeAnoQdd($pdo, $this->ano, "");
            if ($daoFinQddValor->Sucesso()) {

                foreach ($daoFinQddValor->getMsgRetorno() as $v) {

                    if ($idProjeto == $v["id_programa_trabalho"]) {
                        $options .= ' <option value="' . $v["id_programa_trabalho"] . '" selected>' . $v["cd_programa_trabalho"] . '-' . $v["ds_programa_trabalho"] . '</option>';
                    } else {
                        $options .= ' <option value="' . $v["id_programa_trabalho"] . '">' . $v["cd_programa_trabalho"] . '-' . $v["ds_programa_trabalho"] . '</option>';
                    }
                }
                return $options;
            }
        }
    }

    public function retornaQdd(PDO $pdo = null) {
        $retorno = "";
        if (empty($pdo)) {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
        }

        //Procurar Informação do QDD
        $qdd = new Qdd();
        $qdd->setAaQdd($this->ano);
        $qdd->verificaExisteCarregaDados($pdo);
        if (empty($qdd->getIdQdd())) {
            return "QDD Não Criado";
        }

        $daoFinQddValor = new DaoFinQddValor();
        $daoFinQddValor->setIdQdd($qdd->getIdQdd());
        $daoFinQddValor->retornaQddCompleto($pdo);
        $retorno = '';

        if ($daoFinQddValor->Sucesso()) {
            $result = $daoFinQddValor->getMsgRetorno();

            $retorno .= '<div class="panel panel-default">';

            $retorno .= '<table class="table table-bordered table-striped" id="tabela" cellspacing="0" width="100%">'
                    . '<tbody>';
            $retorno .= '<tr class="info text-bold">'
                    . '<td>' . STR_FUNCIONAL_PROGRAMATICA . '</td>'
                    . '<td>Fonte</td>'
                    . '<td class="text-center">Dotação Inicial</td>'
                    . '<td class="text-center">Suplementado</td>'
                    . '<td class="text-center">Reduzido</td>'
                    . '<td class="text-center">Atual</td>'
                    . '<td class="text-center">Liberado</td>'
                    . '<td class="text-center">Empenhado</td>'
                    . '<td class="text-center">Bloqueado</td>'
                    . '<td class="text-center">Saldo</td>'
                    . '</tr>';

            $idPrograma = 0;
            $idFonte = 0;
            $valorDotInicial = 0;
            $valorSuplementado = 0;
            $valorReduzido = 0;
            $valorAtual = 0;
            $valorEmpenhado = 0;
            $valorLiberado = 0;
            $valorBloqueado = 0;
            $valorSaldo = 0;

            $valorTotal = 0;
            $primeiro = 0;
            foreach ($result as $v) {
                if ($idPrograma != $v['id_programa_trabalho'] || $idFonte != $v['id_fonte']) {
                    if ($primeiro == 1) {
                        $retorno .= '<tr class="warning">'
                                . '<td><strong><span>Total<span></strong></td>'
                                . '<td></td>'
                                . '<td class="text-right"><strong>' . Metodos::ConverteValorBr($valorDotInicial, 2) . '</strong></td>'
                                . '<td class="text-right"><strong>' . Metodos::ConverteValorBr($valorSuplementado, 2) . '</strong></td>'
                                . '<td class="text-right"><strong>' . Metodos::ConverteValorBr($valorReduzido, 2) . '</strong></td>'
                                . '<td class="text-right"><strong>' . Metodos::ConverteValorBr($valorAtual, 2) . '</strong></td>'
                                . '<td class="text-right"><strong>' . Metodos::ConverteValorBr($valorLiberado, 2) . '</strong></td>'
                                . '<td class="text-right"><strong>' . Metodos::ConverteValorBr($valorEmpenhado, 2) . '</strong></td>'
                                . '<td class="text-right"><strong>' . Metodos::ConverteValorBr($valorBloqueado, 2) . '</strong></td>'
                                . '<td class="text-right"><strong>' . Metodos::ConverteValorBr($valorSaldo, 2) . '</strong></td>'
                                . '</tr>';
                    }
                    $retorno .= '<tr class="default">'
                            . '<td style="border: 1px solid black;"><strong><span class="col-sm-8">' . $v['ds_programa_trabalho'] . '</span> <span class="col-sm-4">' . $v['programa_trabalho'] . '<span></strong></td>'
                            . '<td colspan=9 style="border: 1px solid black;"></td>'
                            . '</tr>';
                    $valorDotInicial = 0;
                    $valorSuplementado = 0;
                    $valorReduzido = 0;
                    $valorAtual = 0;
                    $valorEmpenhado = 0;
                    $valorLiberado = 0;
                    $valorBloqueado = 0;
                    $valorSaldo = 0;
                }
                $primeiro = 1;
                $idPrograma = $v['id_programa_trabalho'];
                $idFonte = $v['id_fonte'];

                $valorDotInicial += $v['vl_qdd_inicial'];
                $valorSuplementado += $v['vl_qdd_suplementado'];
                $valorReduzido += $v['vl_qdd_reduzido'];
                $valorAtual += ($v['vl_qdd_inicial'] + $v['vl_qdd_suplementado'] - $v['vl_qdd_reduzido'] - $v['vl_bloqueado']);
                $valorEmpenhado += $v['vl_empenhado'];
                $valorLiberado += $v['vl_liberado'];
                $valorBloqueado += $v['vl_bloqueado'];
                $valorSaldo += $v['vl_saldo'];

                if ($v['vl_empenhado'] > $v['vl_liberado'] || $v['vl_liberado'] > ($v['vl_qdd_inicial'] + $v['vl_qdd_suplementado'] - $v['vl_qdd_reduzido'] - $v['vl_bloqueado'])) {
                    $retorno .= '<tr class="" style="color:red">'
                            . '<td> <span class="col-sm-2">' . $v['cd_despesa_elemento'] . '</span> <span class="col-sm-10">' . $v['ds_despesa_elemento'] . '<span></td>'
                            . '<td class="text-center">' . $v['nr_fonte'] . '</td>'
                            . '<td class="text-right">' . Metodos::ConverteValorBr($v['vl_qdd_inicial'], 2) . '</td>'
                            . '<td class="text-right">' . Metodos::ConverteValorBr($v['vl_qdd_suplementado'], 2) . '</td>'
                            . '<td class="text-right">' . Metodos::ConverteValorBr($v['vl_qdd_reduzido'], 2) . '</td>'
                            . '<td class="text-right">' . Metodos::ConverteValorBr(($v['vl_qdd_inicial'] + $v['vl_qdd_suplementado'] - $v['vl_qdd_reduzido'] - $v['vl_bloqueado']), 2) . '</td>'
                            . '<td class="text-right">' . Metodos::ConverteValorBr($v['vl_liberado'], 2) . '</td>'
                            . '<td class="text-right">' . Metodos::ConverteValorBr($v['vl_empenhado'], 2) . '</td>'
                            . '<td class="text-right">' . Metodos::ConverteValorBr($v['vl_bloqueado'], 2) . '</td>'
                            . '<td class="text-right">' . Metodos::ConverteValorBr($v['vl_saldo'], 2) . '</td>'
                            . '</tr>';
                } else {

                    $retorno .= '<tr>'
                            . '<td> <span class="col-sm-2">' . $v['cd_despesa_elemento'] . '</span> <span class="col-sm-10">' . $v['ds_despesa_elemento'] . '<span></td>'
                            . '<td class="text-center">' . $v['nr_fonte'] . '</td>'
                            . '<td class="text-right">' . Metodos::ConverteValorBr($v['vl_qdd_inicial'], 2) . '</td>'
                            . '<td class="text-right">' . Metodos::ConverteValorBr($v['vl_qdd_suplementado'], 2) . '</td>'
                            . '<td class="text-right">' . Metodos::ConverteValorBr($v['vl_qdd_reduzido'], 2) . '</td>'
                            . '<td class="text-right">' . Metodos::ConverteValorBr(($v['vl_qdd_inicial'] + $v['vl_qdd_suplementado'] - $v['vl_qdd_reduzido'] - $v['vl_bloqueado']), 2) . '</td>'
                            . '<td class="text-right">' . Metodos::ConverteValorBr($v['vl_liberado'], 2) . '</td>'
                            . '<td class="text-right">' . Metodos::ConverteValorBr($v['vl_empenhado'], 2) . '</td>'
                            . '<td class="text-right">' . Metodos::ConverteValorBr($v['vl_bloqueado'], 2) . '</td>'
                            . '<td class="text-right">' . Metodos::ConverteValorBr($v['vl_saldo'], 2) . '</td>'
                            . '</tr>';
                }
            }
            if ($primeiro == 1) {
                $retorno .= '<tr class="warning">'
                        . '<td><strong><span>Total<span></strong></td>'
                        . '<td></td>'
                        . '<td class="text-right"><strong>' . Metodos::ConverteValorBr($valorDotInicial, 2) . '</strong></td>'
                        . '<td class="text-right"><strong>' . Metodos::ConverteValorBr($valorSuplementado, 2) . '</strong></td>'
                        . '<td class="text-right"><strong>' . Metodos::ConverteValorBr($valorReduzido, 2) . '</strong></td>'
                        . '<td class="text-right"><strong>' . Metodos::ConverteValorBr($valorAtual, 2) . '</strong></td>'
                        . '<td class="text-right"><strong>' . Metodos::ConverteValorBr($valorLiberado, 2) . '</strong></td>'
                        . '<td class="text-right"><strong>' . Metodos::ConverteValorBr($valorEmpenhado, 2) . '</strong></td>'
                        . '<td class="text-right"><strong>' . Metodos::ConverteValorBr($valorBloqueado, 2) . '</strong></td>'
                        . '<td class="text-right"><strong>' . Metodos::ConverteValorBr($valorSaldo, 2) . '</strong></td>'
                        . '</tr>';
            }
            echo $retorno;
        } else {
            echo $retorno;
        }
    }

    public function retornaDespesaElementoQDD(PDO $pdo = null) {
        if (empty($pdo)) {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
        }
        $daoFinQddValor = new DaoFinQddValor();
        $daoFinQddValor->setIdFonte($this->idFonte);
        $daoFinQddValor->setIdProgramaTrabalho($this->idProgramaTrabalho);
        $daoFinQddValor->despesaQddPorFonteEPrograma($pdo);
        $retorno = '<option value="" >Selecione uma despesa</option>';
        if ($daoFinQddValor->Sucesso()) {
            foreach ($daoFinQddValor->getMsgRetorno() as $v) {
                $retorno .= "<option value='" . $v['id_despesa_elemento'] . "'>" . $v['cd_despesa_elemento'] . "-" . $v['ds_despesa_elemento'] . "</option>";
            }
            echo $retorno;
        }
    }

    public function retornaTipoSolicitacao(PDO $pdo = null) {
        if (empty($pdo)) {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
        }
        $daoFinQddValor = new DaoFinQddValor();
        $daoFinQddValor->retornaContratacao($pdo);
        $retorno = '<option value="" >Selecione um tipo de Solicitação</option>';
        if ($daoFinQddValor->Sucesso()) {
            foreach ($daoFinQddValor->getMsgRetorno() as $v) {
                $retorno .= "<option value='" . $v['id_tipo_solicitacao'] . "'>" . $v['nm_tipo_solicitacao'] . "</option>";
            }
            echo $retorno;
        }
    }

    public function retornaTrDotacaoInicial(PDO $pdo = null) {
        $retorno = "";
        if (empty($pdo)) {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
        }

        $qdd = new Qdd();
        $qdd->setAaQdd($this->ano);
        $qdd->verificaExisteCarregaDados($pdo);
        if (empty($qdd->getIdQdd())) {
            return $retorno;
        }

        $daoFinQddValor = new DaoFinQddValor();
        $daoFinQddValor->setIdQdd($qdd->getIdQdd());
        $daoFinQddValor->retornaDotacaoInicial($pdo);
        $retorno = '';

        if ($daoFinQddValor->Sucesso()) {
            $result = $daoFinQddValor->getMsgRetorno();

            foreach ($result as $v) {

                $retorno .= '<tr>'
                        . '<td>' . $v['cd_programa_trabalho'] . ' ' . $v['ds_programa_trabalho'] . ' </td>'
                        . '<td class="text-center">' . $v['nr_fonte'] . '</td>'
                        . '<td class="text-center">' . $v['cd_despesa_elemento'] . '</td>'
                        . '<td class="text-right">R$ ' . Metodos::ConverteValorBr($v['vl_qdd_inicial'], 2) . '</td>'
                        . '<td class="text-center">'
                        . '<button type="button" class="btn btn-default btn-remover btn-xs" title="Remover" value=' . $v['id_qdd_valor'] . ' >
                            <i class="fa fa-trash fa-lg text-danger" aria-hidden="true"></i>
                        </button>'
                        . '</td>'
                        . '</tr>';
            }
            echo $retorno;
        } else {
            echo $retorno;
        }
    }

    public function carregaDadosQddFonteProgDespesa(PDO $pdo = null) {
        if (empty($pdo)) {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
        }

        $daoFinQddValor = new DaoFinQddValor();
        $daoFinQddValor->setIdQdd($this->idQdd);
        $daoFinQddValor->setIdFonte($this->idFonte);
        $daoFinQddValor->setIdProgramaTrabalho($this->idProgramaTrabalho);
        $daoFinQddValor->setIdDespesaElemento($this->idDespesaElemento);
        $daoFinQddValor->retornaPorQddFonteProgDespesa($pdo);
        if ($daoFinQddValor->Sucesso()) {

            $result = $daoFinQddValor->getMsgRetorno();

            $this->idQddValor = $result['id_qdd_valor'];
            $this->idQdd = $result['id_qdd'];
            $this->idFonte = $result['id_fonte'];
            $this->idProgramaTrabalho = $result['id_programa_trabalho'];
            $this->idDespesaElemento = $result['id_despesa_elemento'];
            $this->vlQddInical = $result['vl_qdd_inicial'];
            $this->vlQddSuplementado = $result['vl_qdd_suplementado'];
            $this->vlQddReduzido = $result['vl_qdd_reduzido'];
            $this->vlEmpenhado = $result['vl_empenhado'];
            $this->vlBloqueado = $result['vl_bloqueado'];
            $this->vlLiberado = $result['vl_liberado'];
            $this->vlAtual = $result["vl_atual"];
            $this->vlSaldo = $result['vl_saldo'];
            $this->fonte = $result['nr_fonte'];
            $this->programaTrabalho = $result['cd_programa_trabalho'] . " - " . $result['ds_programa_trabalho'];
            $this->despesaElemento = $result['cd_despesa_elemento'];
        }
    }

    public function atualizaValoresPorArray(array $ids, PDO $pdo = null) {
        try {

            $this->sucesso = FALSE;

            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }

            $ids = implode(",", $ids);
            $daoFinQddValor = new DaoFinQddValor();

            $daoFinQddValor->atualizaSaldoIN($ids, $pdo);
            if (!$daoFinQddValor->Sucesso()) {
                $this->sucesso = FALSE;
                $this->msgRetorno = $daoFinQddValor->getMsgRetorno();
            } else {
                $this->sucesso = TRUE;
                $this->msgRetorno = $daoFinQddValor->getMsgRetorno();
            }
        } catch (PDOException $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function atualizaValoresEmpenhado(PDO $pdo = null) {
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoFinQddValor = new DaoFinQddValor();
            $daoFinQddValor->setIdQddValor($this->idQddValor);
            $daoFinQddValor->setVlEmpenhado($this->vlEmpenhado);
            $daoFinQddValor->atualizaEmpenhoQdd($pdo);
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function atualizaValoresLiberado(PDO $pdo = null) {
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoFinQddValor = new DaoFinQddValor();
            $daoFinQddValor->setIdQddValor($this->idQddValor);
            $daoFinQddValor->setVlLiberado($this->vlLiberado);
            $daoFinQddValor->atualizaLiberadadoQdd($pdo);
            $this->sucesso = true;
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function retornaQddValorPorId(PDO $pdo = null) {
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoFinQddValor = new DaoFinQddValor();
            $daoFinQddValor->setIdQddValor($this->idQddValor);
            $daoFinQddValor->retorna($pdo);
            $this->sucesso = true;
            if ($daoFinQddValor->Sucesso()) {
                return $daoFinQddValor->getMsgRetorno();
            } else {
                return false;
            }
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }

}
